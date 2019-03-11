<?php
/**
 * Admin class for Radium_Tweets.
 *
 * @since 1.1.0
 *
 * @package Radium_Tweets
 * @author  Franklin M Gitonga
 */
class Radium_Tweets_Admin {

    /**
     * Holds a copy of the object for easy reference.
     *
     * @since 1.1.0
     *
     * @var object
     */
    private static $instance;

    /**
     * Holds the values to be used in the fields callbacks
     *
     * @var array
     *
     * @since 1.1.0
     */
    private $options;

    /**
     * Constructor. Hooks all interactions to initialize the class.
     *
     * @since 1.1.0
     */
    public function __construct() {

        self::$instance = $this;

        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );

    }

    /**
     * Adds a menu item to the Soliloquy post type.
     *
     * @since 1.1.0
     */
    public function admin_menu() {

        add_options_page( Radium_Tweets_Strings::get_instance()->strings['settings_page_title'], Radium_Tweets_Strings::get_instance()->strings['menu_title'], apply_filters( 'radium_tweets_settings_cap', 'manage_options' ), 'tweets-settings', array( &$this, 'create_admin_page' ) );

    }

    /**
     * Options page callback
     *
     * * @since 1.1.0
     */
    public function create_admin_page() {

        // Set class property
        $this->options = get_option( 'radium_tweets_settings' );

        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Radium Tweets Settings</h2>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'radium_tweets_options_group' );
                do_settings_sections( 'radium-tweets-setting-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     *
     * @uses register_setting()
     * @uses add_settings_section()
     * @uses add_settings_field()
     *
     * @since 1.1.0
     */
    public function page_init() {

        register_setting(
            'radium_tweets_options_group', // Option group
            'radium_tweets_settings', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            __('Twitter Api Key.', 'radium-tweets'), // Title
            array( $this, 'print_section_info' ), // Callback
            'radium-tweets-setting-admin' // Page
        );

        add_settings_field(
            'consumerkey', // ID
            __('Consumer Key', 'radium-tweets'), // Title
            array( $this, 'consumerkey_callback' ), // Callback
            'radium-tweets-setting-admin', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'consumersecret',
            __('Consumer Secret', 'radium-tweets'),
            array( $this, 'consumersecret_callback' ),
            'radium-tweets-setting-admin',
            'setting_section_id'
        );

         add_settings_field(
            'accesstoken',
            __('Access Token', 'radium-tweets'),
            array( $this, 'accesstoken_callback' ),
            'radium-tweets-setting-admin',
            'setting_section_id'
        );

        add_settings_field(
            'accesstokensecret',
            __('Access Token Secret', 'radium-tweets'),
            array( $this, 'accesstokensecret_callback' ),
            'radium-tweets-setting-admin',
            'setting_section_id'
        );

        add_settings_field(
            'username',
            __('Twitter Username', 'radium-tweets'),
            array( $this, 'username_callback' ),
            'radium-tweets-setting-admin',
            'setting_section_id'
        );

        add_settings_field(
            'cachetime',
            __('Cache Time (Hours). <br><small>Disable caching by using 0</small>', 'radium-tweets'),
            array( $this, 'cachetime_callback' ),
            'radium-tweets-setting-admin',
            'setting_section_id'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     *
     * @since 1.1.0
     */
    public function sanitize( $input ) {

        if( !is_numeric( $input['cachetime'] ) )
            $input['cachetime'] = '';

        if( !empty( $input['username'] ) )
            $input['username'] = sanitize_text_field( $input['username'] );

        if( !empty( $input['accesstokensecret'] ) )
            $input['accesstokensecret'] = sanitize_text_field( $input['accesstokensecret'] );

        if( !empty( $input['accesstoken'] ) )
            $input['accesstoken'] = sanitize_text_field( $input['accesstoken'] );

        if( !empty( $input['consumersecret'] ) )
            $input['consumersecret'] = sanitize_text_field( $input['consumersecret'] );

        if( !empty( $input['consumerkey'] ) )
            $input['consumerkey'] = sanitize_text_field( $input['consumerkey'] );

        return $input;
    }

    /**
     * Print the Section text
     *
     * @since 1.1.0
     */
    public function print_section_info() {
        _e('Enter API settings below:<br> <small>Visit <a href="https://dev.twitter.com/apps">https://dev.twitter.com/apps</a></small> to register and get an api key.', 'radium-tweets');
    }

    /**
     * Get the settings option array and print one of its values
     *
     * @since 1.1.0
     */
    public function consumerkey_callback() {
        printf( '<input type="text" id="id_number" name="radium_tweets_settings[consumerkey]" value="%s" />', esc_attr( $this->options['consumerkey']) );
    }

    /**
     * Get the settings option array and print one of its values
     *
     * @since 1.1.0
     */
    public function consumersecret_callback() {
        printf('<input type="text" id="title" name="radium_tweets_settings[consumersecret]" value="%s" />', esc_attr( $this->options['consumersecret']) );
    }

    /**
     * Get the settings option array and print one of its values
     *
     * @since 1.1.0
     */
    public function accesstoken_callback() {
        printf( '<input type="text" id="id_number" name="radium_tweets_settings[accesstoken]" value="%s" />', esc_attr( $this->options['accesstoken']) );
    }

    /**
     * Get the settings option array and print one of its values
     *
     * @since 1.1.0
     */
    public function accesstokensecret_callback() {
        printf('<input type="text" id="title" name="radium_tweets_settings[accesstokensecret]" value="%s" />', esc_attr( $this->options['accesstokensecret']) );
    }

    /**
     * Get the settings option array and print one of its values
     *
     * @since 1.1.0
     */
    public function username_callback() {
        printf( '<input type="text" id="id_number" name="radium_tweets_settings[username]" value="%s" />', esc_attr( $this->options['username']) );
    }

    /**
     * Get the settings option array and print one of its values
     *
     * @since 1.1.0
     */
    public function cachetime_callback() {
        printf('<input type="text" id="title" name="radium_tweets_settings[cachetime]" value="%s" />', esc_attr( $this->options['cachetime']) );
    }

    /**
     * Admin Notices
     *
     * @since 1.1.0
     */
    public function notices() {

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