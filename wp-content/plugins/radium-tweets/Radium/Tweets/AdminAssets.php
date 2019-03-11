<?php
/**
 * AdminAseets class for Radium_Tweets.
 *
 * @since 1.1.0
 *
 * @package Radium_Tweets
 * @author  Franklin Gitonga
 */
class Radium_Tweets_AdminAssets {

    /**
     * Holds a copy of the object for easy reference.
     *
     * @since 1.1.0
     *
     * @var object
     */
    private static $instance;

    /**
     * Constructor. Hooks all interactions to initialize the class.
     *
     * @since 1.1.0
     */
    public function __construct() {

        self::$instance = $this;

        $dev = null;

        /** Register scripts and styles */
        wp_register_script( 'radium-tweets-admin', Radium_Tweets::get_url() . '/assets/admin/js/settings-admin' . $dev . '.js', array( 'jquery' ), Radium_Tweets::get_instance()->version, true );
        wp_register_style( 'radium-tweets-admin', Radium_Tweets::get_url() . '/assets/admin/css/settings-admin' . $dev . '.css', array(), Radium_Tweets::get_instance()->version );

        /** Load assets */
        add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );

    }

    /**
     * Enqueue custom scripts and styles for the Radium_Tweets post type.
     *
     * @since 1.1.0
     *
     * @global int $id The current post ID
     * @global object $post The current post object
     */
    public function load_assets() {

        /** Load for any Radium_Tweets screen */
        wp_enqueue_style( 'radium-tweets-admin' );

        /** Store script arguments in an array */
        $args = apply_filters( 'radium_tweets_object_args', array( ) );

        wp_enqueue_script( 'radium-tweets-admin' );
        wp_localize_script( 'radium-tweets-admin', 'radium_tweets', $args );


    }

    /**
     * Getter method for retrieving the object instance.
     *
     * @since 1.1.0
     */
    public static function get_instance() {

        return self::$instance;

    }

}