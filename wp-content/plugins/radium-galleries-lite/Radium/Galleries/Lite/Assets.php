<?php
/**
 * Assets class for Radium_Galleries.
 *
 *
 * @since 1.0.1
 *
 * @package	Radium_PriceTables
 * @author	Franklin M Gitonga
 */
class Radium_Galleries_Lite_Assets {

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

		/** Register scripts and styles */
		add_action('admin_enqueue_scripts', array( $this, 'admin_scripts'));

		add_action('wp_enqueue_scripts', 	array( $this, 'frontend_scripts'));

	}

	public function frontend_scripts() {

        /**
        * Frontend shortcodes style depending on the current theme
        * Fallback to default if the style for current theme is not found
        */

        // GET THEME CSS PATH
        $current_theme = get_template();

        $theme_css_path = dirname(__FILE__) . '/themes/' . $current_theme . '/assets/css/radium-galleries-lite.css';

        if (file_exists($theme_css_path))
            wp_enqueue_style( 'radium-gallery-'.$current_theme.'-styles', get_template_directory_uri() . '/assets/css/radium-galleries-lite.css', false, '1.0.1', 'all' );
        else
		  wp_enqueue_style('radium-gallery-styles',  Radium_Gallerie_Lite::get_url() . '/assets/frontend/css/style.css', array(), '1.0.1');

		// http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/#!prettyPhoto
		wp_enqueue_style('pretty_photo',  Radium_Gallerie_Lite::get_url() . '/assets/frontend/prettyphoto/css/prettyPhoto.css' );
        wp_enqueue_script('prettyphoto',  Radium_Gallerie_Lite::get_url() . '/assets/frontend/prettyphoto/js/jquery.prettyPhoto.js', array('jquery'), '', true);

 		wp_enqueue_style('gallery_plus',  Radium_Gallerie_Lite::get_url() . '/assets/frontend/galleria/themes/classic/galleria.classic.css');
        wp_enqueue_style('fancybox',  Radium_Gallerie_Lite::get_url() . '/assets/frontend/css/jquery.fancybox.css');
        wp_enqueue_style('fancyboxthumbs',  Radium_Gallerie_Lite::get_url() . '/assets/frontend/css/jquery.fancybox-thumbs.css');

 		wp_enqueue_script('galleria',  Radium_Gallerie_Lite::get_url() . '/assets/frontend/galleria/galleria.min.js', array('jquery'), '', true);
 		wp_enqueue_script( 'galleria_theme',  Radium_Gallerie_Lite::get_url() . '/assets/frontend/galleria/themes/classic/galleria.classic.min.js', array('galleria'), '', true);

        wp_enqueue_script('fancybox',  Radium_Gallerie_Lite::get_url() . '/assets/frontend/js/jquery.fancybox.js');
        wp_enqueue_script('fancyboxthumbs',  Radium_Gallerie_Lite::get_url() . '/assets/frontend/js/jquery.fancybox-thumbs.js');

		wp_enqueue_script('radium-galleries',  Radium_Gallerie_Lite::get_url() . '/assets/frontend/js/gallery.js', array('jquery'),'', true);

	}

	public function  admin_scripts() {

	}

}