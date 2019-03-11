<?php

// ADD FUNTION TO WIDGETS_INIT
add_action( 'widgets_init', 'reg_radium_social_fans' );

// REGISTER WIDGET
function reg_radium_social_fans() {
    register_widget( 'Radium_Social_Fans_Widget' );
}

// WIDGET CLASS
class Radium_Social_Fans_Widget extends WP_Widget {

    /*--------------------------------------------------------------------*/
    /*  WIDGET SETUP
    /*--------------------------------------------------------------------*/
    public function __construct() {
        parent::__construct(
            'radium_social_fans', // BASE ID
            'Radium Social Fans', // NAME
            array( 'description' => __( 'Show Social fans count', 'radium' ), )
        );
    }


    /*--------------------------------------------------------------------*/
    /*  DISPLAY WIDGET
    /*--------------------------------------------------------------------*/
    function widget( $args, $instance ) {

        extract( $args );

        $matches = null;

        $title 		= $instance['title'];
        $total 		= isset($instance['total']) 	? true : false;
        $rss_text 	= isset($instance['rss_text']) 	? $instance['rss_text'] : 0;
        $rss_link 	= isset($instance['rss_link']) 	? $instance['rss_link'] : '';
        $twitter 	= isset($instance['twitter']) 	? true : false;
        $facebook 	= isset($instance['facebook']) 	? true : false;
        $googlep 	= isset($instance['googlep']) 	? true : false;
        $dribbble 	= isset($instance['dribbble']) 	? true : false;
        $youtube 	= isset($instance['youtube']) 	? true : false;
        $vimeo 		= isset($instance['vimeo']) 	? true : false;
        $soundcloud = isset($instance['soundcloud'])? true : false;
        $instagram 	= isset($instance['instagram']) ? true : false;
        $behance 	= isset($instance['behance']) 	? true : false;
        $pinterest 	= isset($instance['pinterest']) ? true : false;
        $members 	= isset($instance['members']) 	? true : false;

        if ( empty($rss_link) || $rss_link == '') {
            $rss_link = get_bloginfo('rss2_url');
        }

         if( $rss_text ) {
            preg_match_all('!\d+!', $rss_text, $rss_text_count);
        }

        $rss_followers = $rss_text ? intval($rss_text_count[0][0]) : 0;
        $twitter_followers = $twitter ? intval(radium_get_twitter_followers( radium_get_option('twitter_username') )) : 0;
        $facebook_followers = $facebook ? intval(radium_get_facebook_likes( radium_get_option('facebook_page_url'), radium_get_option('facebook_page_access_token'), radium_get_option('facebook_page_access_secret') )) : 0;
        $google_followers = $googlep ? intval(radium_gplus_count( radium_get_option('googleplus_page_url') )) : 0;
        $instagram_followers = $instagram ? intval(radium_get_total_instagram_followers(radium_get_option('instagram_username'))) : 0;
        $pinterest_followers = $pinterest ? intval(radium_get_total_pinterest_followers(radium_get_option('pinterest_username'))) : 0;
        $youtube_subscribers = $youtube ? intval(radium_get_total_youtube_subscribers(radium_get_option('youtube_channel_id'), radium_get_option('youtube_api_key'))) : 0;
        $vimeo_followers 	= $vimeo ? intval(radium_get_total_vimeo_followers(radium_get_option('vimeo_username'))) : 0;
        $dribbble_followers = $dribbble ? intval(radium_get_total_dribbble_followers(radium_get_option('dribbble_username'), radium_get_option('dribbble_access_token'))) : 0;
        $soundcloud_fans = $soundcloud ? intval(radium_get_total_soundcloud_fans(radium_get_option('soundcloud_username'))) : 0;
        $behance_followers = $behance ? intval(radium_get_total_behance_followers(radium_get_option('behance_username'))) : 0;
        $users = $members ? count_users() : 0;

        $getResult = apply_filters('radium_social_fans_total', number_format(
            $rss_followers +
            $twitter_followers +
            $facebook_followers +
            $instagram_followers +
            $pinterest_followers +
            $youtube_subscribers +
            $vimeo_followers +
            $dribbble_followers +
            $behance_followers +
            $soundcloud_fans +
            intval($users['total_users']) +
            $google_followers,

            0, '.', ','), $this->id_base);

        // Before widget (defined by theme functions file)
        echo $before_widget;

        /* Display the widget title if one was input (before and after defined by themes). */
            $twitter_followers  = radium_number_with_suffix( $twitter_followers, 0, '.', ',');
            $facebook_likes     = radium_number_with_suffix( $facebook_followers, 0, '.', ',');
            $gplus_followers    = radium_number_with_suffix( $google_followers, 0, '.', ',');
            $instagram_followers = radium_number_with_suffix( $instagram_followers, 0, '.', ',');
            $pinterest_followers = radium_number_with_suffix( $pinterest_followers, 0, '.', ',');
            $youtube_subscribers = radium_number_with_suffix( $youtube_subscribers, 0, '.', ',');
            $vimeo_followers = radium_number_with_suffix( $vimeo_followers, 0, '.', ',');
            $dribbble_followers = radium_number_with_suffix( $dribbble_followers, 0, '.', ',');
            $behance_followers = radium_number_with_suffix( $behance_followers, 0, '.', ',');
            $soundcloud_fans = radium_number_with_suffix( $soundcloud_fans, 0, '.', ',');

            $users 				= radium_number_with_suffix(intval($users['total_users']), 0, '.', ',');
            ?>
            <div class="fans-home clearfix">

                <?php if ( $total == 'on') { ?>

                    <div class="fans-home-number">
                        <span><?php echo $getResult; ?></span>
                        <p><?php echo $title; ?></p>
                    </div><!--/fans-home-number-->

                <?php } ?>

                <?php do_action('before_radium_social_fans_icons'); ?>

                <?php if (radium_get_option('twitter_username') && $twitter == 'on' ) { ?>
                    <div class="fans-twitter"><a href="http://twitter.com/<?php echo radium_get_option('twitter_username'); ?>" target="_blank"><span class="icon-twitter"></span><p data-text="<?php echo $twitter_followers; ?>"><span><?php echo $twitter_followers; ?></span></p></a></div>
                <?php } ?>

                <?php if (radium_get_option('facebook_page_url') && $facebook == 'on' ) { ?>
                    <div class="fans-fb"><a href="http://facebook.com/<?php echo radium_get_option('facebook_page_url'); ?>" target="_blank"><span class="social-icon facebook"></span><p data-text="<?php echo $facebook_likes; ?>"><span><?php echo $facebook_likes; ?></span></p></a></div>
                <?php } ?>

                <?php if (radium_get_option('googleplus_page_url') && $googlep == 'on') { ?>
                    <div class="fans-g"><a href="https://plus.google.com/<?php echo radium_get_option('googleplus_page_url'); ?>" target="_blank"><span class="social-icon googleplus"></span><p data-text="<?php echo $gplus_followers; ?>"><span><?php echo $gplus_followers; ?></span></p></a></div>
                <?php } ?>
                <?php if ( radium_get_option('instagram_username') && $instagram == 'on') { ?>
                    <div class="fans-instagram"><a href="<?php echo radium_get_total_instagram_followers(radium_get_option('instagram_username'), 'link'); ?>" target="_blank"><span class="icon-instagram"></span><p data-text="<?php echo $instagram_followers; ?>"><span><?php echo $instagram_followers; ?></span></p></a></div>
                <?php } ?>
                <?php if ( radium_get_option('pinterest_username') && $instagram == 'on') { ?>
                    <div class="fans-pinterest"><a href="<?php echo radium_get_option('pinterest_username'); ?>" target="_blank"><span class="social-icon pinterest"></span><p data-text="<?php echo $pinterest_followers; ?>"><span><?php echo $pinterest_followers; ?></span></p></a></div>
                <?php } ?>
                <?php if ( radium_get_option('youtube_channel_id') && $youtube == 'on') { ?>
                    <div class="fans-youtube"><a href="<?php echo radium_get_total_youtube_subscribers(radium_get_option('youtube_channel_id'), '', 'link'); ?>" target="_blank"><span class="social-icon youtube"></span><p data-text="<?php echo $youtube_subscribers; ?>"><span><?php echo $youtube_subscribers; ?></span></p></a></div>
                <?php } ?>

                <?php if ( radium_get_option('vimeo_username') && $vimeo == 'on') { ?>
                    <div class="fans-vimeo"><a href="<?php echo radium_get_total_vimeo_followers(radium_get_option('vimeo_username'), 'link'); ?>" target="_blank"><span class="social-icon vimeo"></span><p data-text="<?php echo $vimeo_followers; ?>"><span><?php echo $vimeo_followers; ?></span></p></a></div>
                <?php } ?>
                <?php if ( radium_get_option('dribbble_username') && $dribbble == 'on') { ?>
                    <div class="fans-dribbble"><a href="<?php echo radium_get_total_dribbble_followers(radium_get_option('dribbble_username'), '', 'link'); ?>" target="_blank"><span class="icon-dribbble"></span><p data-text="<?php echo $dribbble_followers; ?>"><span><?php echo $dribbble_followers; ?></span></p></a></div>
                <?php } ?>
                <?php if ( radium_get_option('soundcloud_username') && $soundcloud == 'on') { ?>
                    <div class="fans-soundcloud"><a href="<?php echo radium_get_total_soundcloud_fans(radium_get_option('soundcloud_username'), 'link'); ?>" target="_blank"><span class="social-icon soundcloud"></span><p data-text="<?php echo $soundcloud_fans; ?>"><span><?php echo $soundcloud_fans; ?></span></p></a></div>
                <?php } ?>
                <?php if ( radium_get_option('behance_username') && $behance == 'on') { ?>
                    <div class="fans-behance"><a href="<?php echo radium_get_total_behance_followers(radium_get_option('behance_username'), 'link'); ?>" target="_blank"><span class="social-icon behance"></span><p data-text="<?php echo $behance_followers; ?>"><span><?php echo $behance_followers; ?></span></p></a></div>
                <?php } ?>

                <?php if ( !empty($rss_text)) { ?>
                    <div class="fans-rss"><a href="<?php echo $rss_link; ?>" target="_blank"><span class="icon-rss"></span><p data-text="<?php echo $rss_text; ?>"><span><?php echo $rss_text; ?></span></p></a></div>
                <?php } ?>

                 <?php if ( $members == 'on') { ?>
                    <div class="fans-count-users"><a href="#"><span class="icon-user"></span><p data-text="<?php echo $users; ?>"><span><?php echo $users; ?></span></p></a></div>
                <?php } ?>

                <?php do_action('after_radium_social_fans_icons'); ?>

            </div><!--/fans-home-->
        <?php

        // AFTER WIDGET
        echo $after_widget;
    }

    /*--------------------------------------------------------------------*/
    /*  UPDATE WIDGET
    /*--------------------------------------------------------------------*/
    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        // STRIP TAGS TO REMOVE HTML - IMPORTANT FOR TEXT IMPUTS
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['total'] = $new_instance['total'];
        $instance['rss_text'] = $new_instance['rss_text'];
        $instance['rss_link'] = $new_instance['rss_link'];
        $instance['twitter'] = $new_instance['twitter'];
        $instance['facebook'] = $new_instance['facebook'];
        $instance['googlep'] = $new_instance['googlep'];
        $instance['dribbble'] = $new_instance['dribbble'];
        $instance['youtube'] = $new_instance['youtube'];
        $instance['vimeo'] = $new_instance['vimeo'];
        $instance['soundcloud'] = $new_instance['soundcloud'];
        $instance['instagram'] = $new_instance['instagram'];
        $instance['behance'] = $new_instance['behance'];
        $instance['pinterest'] = $new_instance['pinterest'];
        $instance['members'] = $new_instance['members'];

        return $instance;
    }


    /*--------------------------------------------------------------------*/
    /*  WIDGET SETTINGS (FRONT END PANEL)
    /*--------------------------------------------------------------------*/
    function form( $instance ) {

        // WIDGET DEFAULTS
        $defaults = array(
            'title' => __('Followers / Fans / Circle / Members', 'radium'),
            'total' => 'on',
            'rss_text' => '1000+',
            'rss_link' => '',
            'twitter' => 'on',
            'facebook' => 'on',
            'googlep' => 'on',
            'dribbble' => 'on',
            'youtube' => 'on',
            'vimeo' => 'on',
            'soundcloud' => 'on',
            'instagram' => 'on',
            'behance' => 'on',
            'pinterest' => 'on',
            'members' => 'on',
            'cache_time' => 600,
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

       ?>
       <div class="radium_widgets_meta_note">
           <p><?php _e("Before adding this widget you must make sure you fill all your social accounts data in theme options ->", "radium"); ?> <a target='_blank' href='<?php echo admin_url('themes.php?page=radium_theme_options'); ?>'><?php _e("Social Accounts", "radium"); ?></a></p>
       </div>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('title:', 'radium'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['total'], 'on'); ?> id="<?php echo $this->get_field_id('total'); ?>" name="<?php echo $this->get_field_name('total'); ?>" />
            <label for="<?php echo $this->get_field_id('total'); ?>"><?php _e('Total Social Count', 'radium'); ?></label>
        </p>

        <hr>

        <p>
            <label for="<?php echo $this->get_field_id( 'rss_text' ); ?>"><?php _e('rss number or text', 'radium'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'rss_text' ); ?>" name="<?php echo $this->get_field_name( 'rss_text' ); ?>" value="<?php echo $instance['rss_text']; ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'rss_link' ); ?>"><?php _e('RSS Link (leave empty to use default rss link)', 'radium'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'rss_link' ); ?>" name="<?php echo $this->get_field_name( 'rss_link' ); ?>" value="<?php echo $instance['rss_link']; ?>" class="widefat" />
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['twitter'], 'on'); ?> id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" />
            <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter', 'radium'); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['facebook'], 'on'); ?> id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" />
            <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook', 'radium'); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['googlep'], 'on'); ?> id="<?php echo $this->get_field_id('googlep'); ?>" name="<?php echo $this->get_field_name('googlep'); ?>" />
            <label for="<?php echo $this->get_field_id('googlep'); ?>"><?php _e('Google+', 'radium'); ?></label>
        </p>

           <p>
               <input class="checkbox" type="checkbox" <?php checked($instance['dribbble'], 'on'); ?> id="<?php echo $this->get_field_id('dribbble'); ?>" name="<?php echo $this->get_field_name('dribbble'); ?>" />
               <label for="<?php echo $this->get_field_id('dribbble'); ?>"><?php _e('Dribbble', 'radium'); ?></label>
           </p>

          <p>
              <input class="checkbox" type="checkbox" <?php checked($instance['youtube'], 'on'); ?> id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" />
              <label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('Youtube', 'radium'); ?></label>
          </p>

          <p>
              <input class="checkbox" type="checkbox" <?php checked($instance['vimeo'], 'on'); ?> id="<?php echo $this->get_field_id('vimeo'); ?>" name="<?php echo $this->get_field_name('vimeo'); ?>" />
              <label for="<?php echo $this->get_field_id('vimeo'); ?>"><?php _e('Vimeo', 'radium'); ?></label>
          </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['pinterest'], 'on'); ?> id="<?php echo $this->get_field_id('pinterest'); ?>" name="<?php echo $this->get_field_name('pinterest'); ?>" />
            <label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php _e('Pinterest', 'radium'); ?></label>
        </p>

         <p>
             <input class="checkbox" type="checkbox" <?php checked($instance['instagram'], 'on'); ?> id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" />
             <label for="<?php echo $this->get_field_id('instagram'); ?>"><?php _e('Instagram', 'radium'); ?></label>
         </p>

         <p>
             <input class="checkbox" type="checkbox" <?php checked($instance['soundcloud'], 'on'); ?> id="<?php echo $this->get_field_id('soundcloud'); ?>" name="<?php echo $this->get_field_name('soundcloud'); ?>" />
             <label for="<?php echo $this->get_field_id('soundcloud'); ?>"><?php _e('Soundcloud', 'radium'); ?></label>
         </p>

           <p>
               <input class="checkbox" type="checkbox" <?php checked($instance['behance'], 'on'); ?> id="<?php echo $this->get_field_id('behance'); ?>" name="<?php echo $this->get_field_name('behance'); ?>" />
               <label for="<?php echo $this->get_field_id('behance'); ?>"><?php _e('Behance', 'radium'); ?></label>
           </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['members'], 'on'); ?> id="<?php echo $this->get_field_id('members'); ?>" name="<?php echo $this->get_field_name('members'); ?>" />
            <label for="<?php echo $this->get_field_id('members'); ?>"><?php _e('Members', 'radium'); ?></label>
        </p>

        <p><a href="#" class="button delete-social-fans-cache"><?php _e('Delete cache', 'radium'); ?></a><span></span><br><small><?php _e('The socials followers count is saved in the cache each hour. If you want delete the cache now click on this button.', 'radium'); ?></small></p>
        <?php

    } // END FORM

} // END CLASS

if ('widgets.php' == basename($_SERVER['PHP_SELF'])) {
        add_action( 'admin_enqueue_scripts', 'radium_social_counter_widget_admin_script');
}
function radium_social_counter_widget_admin_script(){
        wp_enqueue_script( 'social-counter-widget', get_template_directory_uri() . '/includes/widgets/js/social-fans.js', array('jquery'));
        wp_localize_script( 'social-counter-widget', 'radium_framework_social_fans', array(
            'nonce' => wp_create_nonce( 'ajax-nonce' ),
        )
    );
}

// ajax Action
add_action( 'wp_ajax_radium_social_followers_delete_cache', 'radium_social_followers_delete_cache' );

function radium_social_followers_delete_cache () {

    $nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )

    die ( __('Error flushing social followers cache!', 'radium') );

        delete_transient('radium_overall_twitter_followers');
        delete_transient('radium_overall_facebook_followers');
        delete_transient('radium_overall_facebook_page_url');
        delete_transient('radium_overall_googleplus_followers');
        delete_transient('radium_overall_googleplus_page_url');
        delete_transient('radium_overall_dribbble_followers');
        delete_transient('radium_overall_dribbble_page_url');
        delete_transient('radium_overall_youtube_followers');
        delete_transient('radium_overall_youtube_page_url');
        delete_transient('radium_overall_vimeo_followers');
        delete_transient('radium_overall_vimeo_page_url');
        delete_transient('radium_overall_soundcloud_followers');
        delete_transient('radium_overall_soundcloud_page_url');
        delete_transient('radium_overall_behance_followers');
        delete_transient('radium_overall_behance_page_url');
        delete_transient('radium_overall_instagram_followers');
        delete_transient('radium_overall_instagram_page_url');
        delete_transient('radium_overall_pinterest_followers');
        echo __('Success', 'radium');

    exit();
}
