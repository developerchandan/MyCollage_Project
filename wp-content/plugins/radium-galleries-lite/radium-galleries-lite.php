<?php

/*
Plugin Name: Radium Galleries Lite
Description: Create better galleries in Wordpress
Plugin URI: http://radiumthemes.com/
AUthor: RadiumThemes.
Author URI: http://radiumthemes.com/
Version: 1.0.3
License: GPLv2 or later
*/

/** Load all of the necessary class files for the plugin */
spl_autoload_register( 'Radium_Gallerie_Lite::autoload' );

/**
 * Init class for Radium_PriceTables.
 *
 * Loads all of the necessary components for the radium sliders plugin.
 *
 * @since 1.0.0
 *
 * @package	Radium_PriceTables
 * @author	Franklin Gitonga
 */
class Radium_Gallerie_Lite {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Current version of the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = '1.0.1';

	/**
	 * Holds a copy of the main plugin filepath.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	private static $file = __FILE__;

	/**
	 * Constructor. Hooks all interactions into correct areas to start
	 * the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		self::$instance = $this;

		/** Run a hook before the slider is loaded and pass the object */
		do_action_ref_array( 'radium_galleries_init', array( $this ) );

		/** Run activation hook and make sure the WordPress version supports the plugin */
		register_activation_hook( __FILE__, array( $this, 'activation' ) );

		/** Load the plugin */
		add_action( 'widgets_init', array( $this, 'widget' ) );
		add_action( 'init', array( $this, 'init' ) );

	}

	/**
 	 * Registers a plugin activation hook to make sure the current WordPress
 	 * version is suitable (>= 3.3.1) for use.
 	 *
 	 * @since 1.0.0
 	 *
 	 * @global int $wp_version The current version of this particular WP instance
 	 */
	public function activation() {

		global $wp_version;

		if ( version_compare( $wp_version, '3.3.1', '<' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( printf( __( 'Sorry, but your version of WordPress, <strong>%s</strong>, does not meet the Radium Galleries\'s required version of <strong>3.3.1</strong> to run properly. The plugin has been deactivated. <a href="%s">Click here to return to the Dashboard</a>', 'radium_galleries' ), $wp_version, admin_url() ) );
		}

	}

	/**
 	 * Registers the widget with WordPress.
 	 *
 	 * @since 1.0.0
 	 */
	public function widget() {

		//register_widget( 'Radium_PriceTables_Widget' );

	}

	/**
	 * Loads the plugin upgrader, registers the post type and
	 * loads all the actions and filters for the class.
	 *
	 * @since 1.0.0
	 */
	public function init() {

 		/** Load the plugin textdomain for internationalizing strings */
		load_plugin_textdomain( 'radium_galleries', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		/** Instantiate all the necessary components of the plugin */
 		$radium_galleries_assets		= new Radium_Galleries_Lite_Assets;
 		$radium_galleries_shortcode		= new Radium_Galleries_Lite_Shortcodes;

 	}

	/**
	 * PSR-0 compliant autoloader to load classes as needed.
	 *
	 * @since 1.0.0
	 *
	 * @param string $classname The name of the class
	 * @return null Return early if the class name does not start with the correct prefix
	 */
	public static function autoload( $classname ) {

		if ( 'Radium' !== mb_substr( $classname, 0, 6 ) )
			return;

		$filename = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . str_replace( '_', DIRECTORY_SEPARATOR, $classname ) . '.php';
		if ( file_exists( $filename ) )
			require $filename;
	}

	/**
	 * Getter method for retrieving the object instance.
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {

		return self::$instance;

	}

    /**
     * Getter method for retrieving the url.
     *
     * @since 1.0.0
     */
    public static function get_url() {

        return plugins_url('', __FILE__);;

    }

    /**
     * Getter method for retrieving the url.
     *
     * @since 1.0.0
     */
    public static function get_dir() {

        return plugin_dir_path(__FILE__);;

    }

	/**
	 * Getter method for retrieving the main plugin filepath.
	 *
	 * @since 1.0.0
	 */
	public static function get_file() {

		return self::$file;

	}

}

/** Instantiate the init class */
new Radium_Gallerie_Lite;