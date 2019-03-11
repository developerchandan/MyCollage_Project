<?php
/**
 * Strings class for Radium_Tweets.
 *
 * @since 1.1.0
 *
 * @package Radium_Tweets
 * @author  Franklin M Gitonga
 */
class Radium_Tweets_Strings {

    /**
     * Holds a copy of the object for easy reference.
     *
     * @since 1.1.0
     *
     * @var object
     */
    private static $instance;

    /**
     * Holds a copy of all the strings used by Radium_Tweets.
     *
     * @since 1.1.0
     *
     * @var array
     */
    public $strings = array();

    /**
     * Constructor. Hooks all interactions to initialize the class.
     *
     * @since 1.1.0
     */
    public function __construct() {

        self::$instance = $this;

        $this->strings = apply_filters( 'radium_tweets_strings', array(
            'http_error'            => __( 'Sorry, but there was an error connecting to the API server. Please try again.', 'radium_tweets' ),
            'loading'               => __( 'Loading...', 'radium_tweets' ),
            'page_title'            => __( 'Radium Tweets Settings', 'radium_tweets' ),
            'select_all'            => __( 'Select All', 'radium_tweets' ),
            'widget_slider'         => __( 'Tweets', 'radium_tweets' ),
            'widget_title'          => __( 'Title', 'radium_tweets' ),
            'menu_title'            => __('Tweets Settings', 'radium_tweets'),
            'settings_page_title'   => __('Tweets Api Settings', 'radium_tweets'),
        ));

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