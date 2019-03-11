<?php

if ( ! defined( 'ABSPATH' ) ) exit;

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

class Radium_Tweets_Integrate {

    public $options;

    /**
     * Holds a copy of the object for easy reference.
     *
     * @since 1.0.0
     *
     * @var object
     */
    private static $instance;

    /**
     * Constructor. Hooks all interactions to initialize the class.
     *
     * @since 1.0.0
     */
    public function __construct() {

        self::$instance = $this;

        /** Register hooks */
        add_filter('radium_builder_elements', array(&$this, 'builder_element_settings'), 11);
        add_action('radium_builder_tweets', array(&$this, 'builder_frontend_element'), 11, 3);

        $this->options = get_option( 'radium_tweets_settings' );

    }

    /**
     * Register Pricing Element
     * @return array();
     *
     * @since 1.0.0
     */
    public function builder_element_settings( $elements ) {

        $element_options = array(

            array(
                'id'        => 'tweetstoshow',
                'name'      => __( 'Tweets', 'radium' ),
                'desc'      => __( 'Number of tweets to show. Maximum 10', 'radium' ),
                'type'      => 'text',
                'class'     => 'tweets',
                'std'=> '5'
            )
        );

        $elements['tweets'] = array(
            'info' => array(
                'name'  => 'Tweets',
                'id'    => 'tweets',
                'query' => 'none',
                'hook'  => 'radium_tweets_block',
                'shortcode' => '[radium_tweets]',
                'desc'  => __( 'Tweets', 'radium' )
            ),
            'options' => $element_options,
            'style' => apply_filters( 'radium_builder_element_style_config', array() ),

        );

        return $elements;

    }


    /**
     * Display Element in the Frontend.
     *
     * @since 2.1.0
     *
     * @param string
     */

    public function builder_frontend_element(  $id, $settings, $location ) {

        $builder_settings = $settings;

        $instance = $this->options;

        if(empty($instance['consumerkey']) || empty($instance['consumersecret']) || empty($instance['accesstoken']) || empty($instance['accesstokensecret']) || empty($instance['cachetime']) || empty($instance['username'])){
            echo '<div class="alert warning">Please fill all settings for the tweets plugin!</div>';
            return;
        }

        // CHECK IF CACHE NEEDS UPDATING
        $radium_twitter_plugin_last_cache_time = get_option('radium_twitter_plugin_last_cache_time');
        $diff = time() - $radium_twitter_plugin_last_cache_time;
        $crt = $instance['cachetime'] * 3600;

        //  YUP, NEEDS ONE
        if($diff >= $crt || empty($radium_twitter_plugin_last_cache_time)){

            $connection = Radium_Tweets_Functions::getConnectionWithAccessToken($instance['consumerkey'], $instance['consumersecret'], $instance['accesstoken'], $instance['accesstokensecret']);
            $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$instance['username']."&count=10") or die('Couldn\'t retrieve tweets! Wrong username?');

            if(!empty($tweets->errors)){

                if($tweets->errors[0]->message == 'Invalid or expired token'){

                    echo '<div class="alert warning">'.$tweets->errors[0]->message.'!<br />You\'ll need to regenerate it <a href="https://dev.twitter.com/apps" target="_blank">here</a>!</div>';

                } else {

                    echo '<<div class="alert warning">'.$tweets->errors[0]->message.'</div>';

                }

                return;

            }

            for( $i = 0;$i <= count($tweets); $i++ ) {

                if(!empty($tweets[$i])){

                    $tweets_array[$i]['created_at'] = $tweets[$i]->created_at;

                    $tweets_array[$i]['text'] = $tweets[$i]->text;

                    $tweets_array[$i]['status_id'] = $tweets[$i]->id_str;

                }

            }

            // SAVE TWEETS TO WP OPTION
            update_option('radium_twitter_plugin_tweets', serialize($tweets_array));

            update_option('radium_twitter_plugin_last_cache_time', time() );

            echo '<!-- twitter cache has been updated! -->';
        }

        $radium_twitter_plugin_tweets = maybe_unserialize(get_option('radium_twitter_plugin_tweets'));

        if(!empty($radium_twitter_plugin_tweets)) {

            echo '<div class="twitter_feed">';

                $fctr = '1';

                foreach($radium_twitter_plugin_tweets as $tweet){

                    echo '<div class="tweet_text"><span class="icon-twitter"></span><span>'.Radium_Tweets_Functions::convert_links($tweet['text']).'</span><a class="twitter_time" target="_blank" href="http://twitter.com/'.$instance['username'].'/statuses/'.$tweet['status_id'].'">'.Radium_Tweets_Functions::relative_time($tweet['created_at']).'</a></div>';

                    if( $fctr == $builder_settings['tweetstoshow'] ) break;

                    $fctr++;

                }

            echo '</div>';

        }


    }

}