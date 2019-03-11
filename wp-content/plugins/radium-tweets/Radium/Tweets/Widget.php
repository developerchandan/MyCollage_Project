<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/** Load all of the necessary class files for the plugin */
//spl_autoload_register( 'Radium_Forms::autoload' );

/**
 * Init class for Radium_Tweets.
 *
 * Loads all of the necessary components for the radium tweets plugin.
 *
 * @since 1.0.0
 *
 * @package Radium_Tweets
 * @author  Franklin Gitonga
 */

class Radium_Tweets_Widget extends WP_Widget {

     public $options;

    /*--------------------------------------------------------------------*/
    /*  WIDGET SETUP
    /*--------------------------------------------------------------------*/
    public function __construct() {
        parent::__construct(
            'Radium_tweets', // BASE ID
            'Radium Tweets', // NAME
            array( 'description' => __( 'A widget that displays your most recent tweets with API v1.1', 'radium' ), )
        );

        $this->options = get_option( 'radium_tweets_settings' );

    }

    public function get_tweets()
    {
        $options = $this->options;

        // CHECK SETTINGS & DIE IF NOT SET
        if(empty($options['consumerkey']) || empty($options['consumersecret']) || empty($options['accesstoken']) || empty($options['accesstokensecret']) || ( empty($options['cachetime']) && $options['cachetime'] !== '0' ) || empty($options['username'])){
            return false;
        }

        $settings = array(
            'oauth_access_token' => $options['accesstoken'],
            'oauth_access_token_secret' =>  $options['accesstokensecret'],
            'consumer_key' => $options['consumerkey'] ,
            'consumer_secret' => $options['consumersecret']
        );

        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';

        $getfield = "?screen_name={$options['username']}&count=10";

        $twitter = new Radium_Twitter_API_WordPress($settings);

        $twitter_data = $twitter->set_get_field($getfield)->build_oauth($url, 'GET')->process_request();

        return $twitter_data;
    }

    /*--------------------------------------------------------------------*/
    /*  DISPLAY WIDGET
    /*--------------------------------------------------------------------*/
    public function widget($args, $instance) {

        extract($args);

        if(!empty($instance['title'])){ $title = apply_filters( 'widget_title', $instance['title'] ); }

        $options = $this->options;
        $id = rand(0,999);

        echo $before_widget;

        if ( ! empty( $title ) ){ echo $before_title . $title . $after_title; }

                // CHECK SETTINGS & DIE IF NOT SET
                if(empty($options['consumerkey']) || empty($options['consumersecret']) || empty($options['accesstoken']) || empty($options['accesstokensecret']) || ( empty($options['cachetime']) && $options['cachetime'] !== '0' ) || empty($options['username'])){
                    echo '<div class="alert info"><strong>Please fill all widget settings!</strong></div>' . $after_widget;
                    return;
                }

                $transient_name = 'radium_twitter_plugin_tweets';

                $cache_time = $options['cachetime'] * 3600;

                if ($cache_time == 0) delete_transient($transient_name);

                //  YUP, NEEDS ONE
                if( false === ( $tweets_array = get_transient($transient_name) ) ){

                    $tweets = $this->get_tweets();

                    $tweets = json_decode( $tweets );

                    if( !$tweets ) {

                        echo '<div class="alert error">Couldn\'t retrieve tweets! Wrong username?</div>' . $after_widget;

                        return;

                    }

                    if(!empty($tweets->errors)){

                        if( $tweets->errors[0]->message == 'Invalid or expired token.' ){

                            echo '<div class="alert info"><strong>'.$tweets->errors[0]->message.'</strong><br />You\'ll need to regenerate it <a href="https://dev.twitter.com/apps" target="_blank">here</a>!</div>' . $after_widget;

                        } else {

                            echo '<div class="alert info"><strong>'.$tweets->errors[0]->message.'</strong></div>' . $after_widget;

                        }

                        return;
                    }

                    for($i = 0;$i <= count($tweets); $i++){

                        if(!empty($tweets[$i])){
                            $tweets_array[$i]['created_at'] = $tweets[$i]->created_at;
                            $tweets_array[$i]['text'] = $tweets[$i]->text;
                            $tweets_array[$i]['status_id'] = $tweets[$i]->id_str;
                        }

                    }

                    // SAVE TWEETS USING TRANSIENT API
                    set_transient($transient_name, $tweets_array, $cache_time);

                    echo '<!-- twitter cache has been updated! -->';
                }


                if(!empty($tweets_array)){

                print '<div class="twitter-div">
                        <ul id="twitter-update-list-'.$id.'">';

                        $fctr = '1';

                        foreach($tweets_array as $tweet){

                            print '<li><span>'.Radium_Tweets_Functions::convert_links($tweet['text']).'</span><a class="twitter-time" target="_blank" href="http://twitter.com/'.$options['username'].'/statuses/'.$tweet['status_id'].'">'.Radium_Tweets_Functions::relative_time($tweet['created_at']).'</a></li>';

                            if($fctr == $instance['tweetstoshow']){ break; }

                            $fctr++;
                        }

                        print '</ul>';

                        if($instance['tweettext'] !='') : ?> <a href="http://twitter.com/<?php echo $options['username'] ?>" class="button" target="blank"><?php echo $instance['tweettext'] ?></a><?php endif;

                echo '</div>';

                }

        echo $after_widget;
    }


    /*--------------------------------------------------------------------*/
    /*  UPDATE WIDGET
    /*--------------------------------------------------------------------*/
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['tweetstoshow'] = strip_tags( $new_instance['tweetstoshow'] );
        $instance['tweettext'] = strip_tags( $new_instance['tweettext'] );

        return $instance;
    }


    /*--------------------------------------------------------------------*/
    /*  WIDGET SETTINGS (FRONT END PANEL)
    /*--------------------------------------------------------------------*/
    public function form($instance) {
        $defaults = array( 'title' => 'Radium Tweets Plugin', 'consumerkey' => '', 'consumersecret' => '', 'accesstoken' => '', 'accesstokensecret' => '', 'cachetime' => '2', 'username' => '', 'tweetstoshow' => '', 'tweettext' => '', );
        $instance = wp_parse_args( (array) $instance, $defaults );

        echo '
        <p><label>'. __("Title:", "radium-tweets") .'</label>
            <input type="text" name="'.$this->get_field_name( 'title' ).'" id="'.$this->get_field_id( 'title' ).'" value="'.esc_attr($instance['title']).'" class="widefat" /></p>
        <p style="margin-bottom: 15px;"><label>Number of Tweets:</label>
            <select type="text" name="'.$this->get_field_name( 'tweetstoshow' ).'" id="'.$this->get_field_id( 'tweetstoshow' ).'">';
            $i = 1;
            for(i; $i <= 10; $i++){
                echo '<option value="'.$i.'"'; if($instance['tweetstoshow'] == $i){ echo ' selected="selected"'; } echo '>'.$i.'</option>';
            }
            echo '
            </select>
        </p>
        <p><label>'. __("Button Text", "radium-tweets") .'</label>
        <input type="text" name="'.$this->get_field_name( 'tweettext' ).'" id="'.$this->get_field_id( 'tweettext' ).'" value="'.esc_attr($instance['tweettext']).'" class="widefat" /></p>'; ?>

        <p><a href="#" class="button delete-radium-tweets-cache"><?php _e('Delete cache', 'radium'); ?></a><span></span><br><small><?php _e('If you want delete the cache now click on this button.', 'radium'); ?></small></p> <?php
    }

}


if ('widgets.php' == basename($_SERVER['PHP_SELF'])) {
        add_action( 'admin_enqueue_scripts', 'radium_tweets_widget_admin_script');
}
function radium_tweets_widget_admin_script(){
        wp_enqueue_script( 'radium-tweets-widget-ajax', Radium_Tweets::get_url() . '/assets/admin/js/widget-ajax.js', array('jquery'));
        wp_localize_script( 'radium-tweets-widget-ajax', 'radium_tweets_widget_ajax', array(
            'nonce' => wp_create_nonce( 'radium-tweets-ajax-nonce' ),
        )
    );
}

// ajax Action
add_action( 'wp_ajax_radium_tweets_widget_delete_cache', 'radium_tweets_widget_delete_cache' );

function radium_tweets_widget_delete_cache () {

    $nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'radium-tweets-ajax-nonce' ) )

    die ( __('Error flushing tweets cache!', 'radium') );

        delete_transient('radium_twitter_plugin_tweets');

        echo __('Success', 'radium');

    exit();
}
