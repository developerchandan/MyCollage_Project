<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
   
if ( ! class_exists('Radium_Options') ){
	
	$framework = radium_framework();
	
	if(!defined('RADIUM_OPTIONS_URL')){
		define('RADIUM_OPTIONS_URL', $framework->theme_framework_url . '/options/');
	}
	
class Radium_Options {
	
	public $framework = array();
	public $dir = null;
	public $url = null;
	public $upload_dir;
	public $upload_url;
	public $page = '';
	public $sections = array();
	public $extra_tabs = array();
	public $errors = array();
	public $warnings = array();
	public $options = array();
	public $googleArray = array();
	public $typography = null; //values to generate google font CSS
	public $fonts = array(); // Information that needs to be localized
    public $localize_data = array(); // Information that needs to be localized
    public $extensions = array(); // Extensions by type used in the panel
    public $typography_preview = array();

	public static $_dir;
	public static $_url;
	public static $_upload_dir;
	public static $_upload_url;
	public static $wp_content_url;
	public $args = array();
	 
	
	static function init() {
		
		global $wp_filesystem;
		                
        // Windows-proof constants: replace backward by forward slashes. Thanks to: @peterbouwmeester
        self::$_dir           = trailingslashit( self::cleanFilePath( dirname( __FILE__ ) ) );
        $wp_content_dir       = trailingslashit( self::cleanFilePath( WP_CONTENT_DIR ) );
        $wp_content_dir       = trailingslashit( str_replace( '//', '/', $wp_content_dir ) );
        $relative_url         = str_replace( $wp_content_dir, '', self::$_dir );
        self::$wp_content_url = trailingslashit( self::cleanFilePath( ( is_ssl() ? str_replace( 'http://', 'https://', WP_CONTENT_URL ) : WP_CONTENT_URL ) ) );
        self::$_url           = self::$wp_content_url . $relative_url;
 
        // Create our private upload directory
        self::initWpFilesystem();

        self::$_upload_dir = trailingslashit( $wp_filesystem->wp_content_dir() ) . '/radium/';
        self::$_upload_url = trailingslashit( content_url() ) . '/radium/';

        // Ensure it exists
        if ( ! is_dir( self::$_upload_dir ) ) {
            // Create the directory
            $wp_filesystem->mkdir( self::$_upload_dir );
        }
	}
	
	/**
	 * Class Constructor. Defines the args for the theme options class
	 *
	 * @since Radium_Options 2.0
	 *
	 * @param $array $args Arguments. Class constructor arguments.
	*/
	function __construct( $sections = array(), $args = array(), $extra_tabs = array() ){
		
		self::init();
		
		$this->framework = radium_framework();
		 
		$this->url = self::$_url;
		$this->dir = self::$_dir;
		
		$this->images_url = $this->framework->theme_framework_images_url;
		
		$this->upload_url = self::$_upload_url;
		$this->upload_dir = self::$_upload_dir;
		
		//Setup Framework data
		$this->framework_url 		= $this->framework->theme_framework_site_url;
		$this->framework_version 	= $this->framework->theme_framework_version;
		$this->theme_dev_mode 		= $this->framework->theme_dev_mode;
		
		//setup theme data
		$this->theme_version     	= $this->framework->theme_version;
		$this->theme_title 			= $this->framework->theme_title; 
		
		$this->theme_option_name  	= $this->framework->theme_option_name;
		$this->customizer_option_name  	= $this->framework->customizer_option_name;
		
		$defaults = array();
		
		$defaults['opt_name'] = $this->theme_option_name; //must be defined 
		$defaults['opt_customizer_name'] = $this->customizer_option_name; //must be defined 
		$defaults['google_api_key'] = '';//must be defined for use with google webfonts field type
		$defaults['menu_icon'] = $this->images_url .'menu_icon.png';
		$defaults['menu_title'] = __('Options', 'radium');
		$defaults['page_icon'] = 'icon-themes';
		$defaults['page_title'] = __('Options', 'radium');
		$defaults['page_slug'] = '_options';
		$defaults['page_cap'] = 'manage_options';
		$defaults['page_type'] = 'menu';
		$defaults['page_parent'] = '';
		$defaults['page_position'] = 100;
		$defaults['allow_sub_menu'] = true;
		$defaults['output'] = true;
		$defaults['compiler'] = true; // Dynamically generate CSS
		$defaults['show_import_export'] = true;
		$defaults['async_typography']   = false;
		$defaults['dev_mode'] = $this->theme_dev_mode ? true : false;
		$defaults['stylesheet_override'] = false;
		$defaults['footer_credit'] = '<span id="footer-thankyou">The <a href="'.$this->framework_url.'" target="_blank">Radium Framework</a> Version '.$this->framework_version;
		$defaults['help_tabs'] = array();
		$defaults['help_sidebar'] = __('', 'radium');
		$defaults['customizer'] = false;
		
		//get args
		$this->args = apply_filters('radium-opts-args-'.$defaults['opt_name'], wp_parse_args($args, $defaults));
		
		//get sections
		$this->sections = apply_filters('radium-opts-sections-'.$this->args['opt_name'], $sections);
		
		//get extra tabs
		$this->extra_tabs = apply_filters('radium-opts-extra-tabs-'.$this->args['opt_name'], $extra_tabs);
		
		//set option with defaults
		add_action('init', array(&$this, '_set_default_options'));
		
		//options page
		add_action('admin_menu', array(&$this, '_options_page'));
		
		//register setting
		add_action('admin_init', array(&$this, '_register_setting'));
		
		//add the js for the error handling before the form
		add_action('radium-opts-page-before-form-'.$this->args['opt_name'], array(&$this, '_errors_js'), 1);
		
		//add the js for the warning handling before the form
		add_action('radium-opts-page-before-form-'.$this->args['opt_name'], array(&$this, '_warnings_js'), 2);
		
		//hook into the wp feeds for downloading the exported settings
		//add_action('do_feed_radiumopts-'.$this->args['opt_name'], array(&$this, '_download_options'), 1, 1);
		
		//get the options for use later on
		$this->options = get_option($this->args['opt_name']);
		
		// Enqueue dynamic CSS and Google fonts
		add_action( 'wp_enqueue_scripts', array( &$this, '_enqueue_output' ), 150 );
		
		// Register extra extensions
		//$this->_register_extensions();
			               
	}//function
	
	/**
	 * Take a path and return it clean
	 *
	 * @param string $path
	 *
	 * @since    3.1.7
	 */
	public static function cleanFilePath( $path ) {
	    $path = str_replace( '', '', str_replace( array( "\\", "\\\\" ), '/', $path ) );
	    if ( $path[ strlen( $path ) - 1 ] === '/' ) {
	        $path = rtrim( $path, '/' );
	    }
	
	    return $path;
	}
	
	public static function initWpFilesystem() { 
	
		global $wp_filesystem;
		
		if ( empty( $wp_filesystem ) ) {
		    require_once( ABSPATH . '/wp-admin/includes/file.php' );
		    WP_Filesystem();
 		}
		
	}
	
	public static function array_in_array( $needle, $haystack ) {
	    //Make sure $needle is an array for foreach
	    if ( ! is_array( $needle ) ) {
	        $needle = array( $needle );
	    }
	    //For each value in $needle, return TRUE if in $haystack
	    foreach ( $needle as $pin ) //echo 'needle' . $pin;
	    {
	        if ( in_array( $pin, $haystack ) ) {
	            return true;
	        }
	    }
	
	    //Return FALSE if none of the values from $needle are found in $haystack
	    return false;
	}
	
	/**
	 * ->get(); This is used to return and option value from the options array
	 *
	 * @since Radium_Options 2.0.1
	 *
	 * @param $array $args Arguments. Class constructor arguments.
	*/
	function get($opt_name, $default = null){
		return (!empty($this->options[$opt_name])) ? $this->options[$opt_name] : $default;
	}//function
	
	/**
	 * ->set(); This is used to set an arbitrary option in the options array
	 *
	 * @since Radium_Options 2.0.1
	 * 
	 * @param string $opt_name the name of the option being added
	 * @param mixed $value the value of the option being added
	 */
	function set($opt_name = '', $value = '') {
		if($opt_name != ''){
			$this->options[$opt_name] = $value;
			update_option($this->args['opt_name'], $this->options);
		}//if
	}
	
	/**
	 * ->show(); This is used to echo and option value from the options array
	 *
	 * @since Radium_Options 2.0.1
	 *
	 * @param $array $args Arguments. Class constructor arguments.
	*/
	function show($opt_name, $default = ''){
		$option = $this->get($opt_name);
		if(!is_array($option) && $option != ''){
			echo $option;
		}elseif($default != ''){
			echo $default;
		}
	}//function
 	
	
	/**
	 * Get default options into an array suitable for the settings API
	 *
	 * @since Radium_Options 2.0
	 *
	*/
	function _default_values(){
		
		$defaults = array();
		
		foreach($this->sections as $k => $section){
			
			if(isset($section['fields'])){
		
				foreach($section['fields'] as $fieldk => $field){
					
					if(!isset($field['std'])){$field['std'] = '';}
						
						$defaults[$field['id']] = $field['std'];
					
				}//foreach
			
			}//if
			
		}//foreach
		
		//fix for notice on first page load
		$defaults['last_tab'] = 0;

		return $defaults;
		
	}
	
	/**
	 * Get default customizer options into an array suitable for the settings API
	 *
	 * @since Radium_Options 2.0
	 *
	*/
	function _default_customizer_values(){ 
		
		$defaults = array();
 		
 		return $defaults;
	}
 	
	/**
	 * Set default options on admin_init if option doesn't exist (theme activation hook caused problems, so admin_init it is)
	 *
	 * @since Radium_Options 2.0
	 *
	*/
	function _set_default_options(){
		if(!get_option($this->args['opt_name'])){
			add_option($this->args['opt_name'], $this->_default_values());
		}
		$this->options = get_option($this->args['opt_name']);
						
	}//function
	

	
	/**
	 * Class Theme Options Page Function, creates main options page.
	 *
	 * @since Radium_Options 2.0
	*/
	function _options_page(){
		if($this->args['page_type'] == 'submenu'){
			if(!isset($this->args['page_parent']) || empty($this->args['page_parent'])){
				$this->args['page_parent'] = 'themes.php';
			}
			$this->page = add_submenu_page(
							$this->args['page_parent'],
							$this->args['page_title'], 
							$this->args['menu_title'], 
							$this->args['page_cap'], 
							$this->args['page_slug'], 
							array(&$this, '_options_page_html')
						);
		}else{
			$this->page = add_menu_page(
							$this->args['page_title'], 
							$this->args['menu_title'], 
							$this->args['page_cap'], 
							$this->args['page_slug'], 
							array(&$this, '_options_page_html'),
							$this->args['menu_icon'],
							$this->args['page_position']
						);
						
		if(true === $this->args['allow_sub_menu']){
						
			//this is needed to remove the top level menu item from showing in the submenu
			add_submenu_page(
				$this->args['page_slug'],
				$this->args['page_title'],
				'',
				$this->args['page_cap'],
				$this->args['page_slug'],
				create_function( '$a', "return null;" )
			);
						
			foreach($this->sections as $k => $section){
							
				add_submenu_page(
						$this->args['page_slug'],
						$section['title'], 
						$section['title'], 
						$this->args['page_cap'], 
						$this->args['page_slug'].'&tab='.$k, 
						create_function( '$a', "return null;" )
				);
					
			}
			
			if(true === $this->args['show_import_export']){
				
				add_submenu_page(
						$this->args['page_slug'],
						__('Import / Export / Reset', 'radium'), 
						__('Import / Export / Reset', 'radium'), 
						$this->args['page_cap'], 
						$this->args['page_slug'].'&tab=import_export_default', 
						create_function( '$a', "return null;" )
				);
					
			}//if
						
			foreach($this->extra_tabs as $k => $tab){
				
				add_submenu_page(
						$this->args['page_slug'],
						$tab['title'], 
						$tab['title'], 
						$this->args['page_cap'], 
						$this->args['page_slug'].'&tab='.$k, 
						create_function( '$a', "return null;" )
				);
				
			}

			if(true === $this->args['dev_mode']){
						
				add_submenu_page(
						$this->args['page_slug'],
						__('Dev Mode Info', 'radium'), 
						__('Dev Mode Info', 'radium'), 
						$this->args['page_cap'], 
						$this->args['page_slug'].'&tab=dev_mode_default', 
						create_function( '$a', "return null;" )
				);
				
			}//if

		}//if			
						
			
		}//else
		
		// Enqueue the admin page CSS and JS
		if ( isset( $_GET['page'] ) && $_GET['page'] == $this->args['page_slug'] ) {
		    add_action( 'admin_enqueue_scripts', array( $this, '_enqueue' ), 1 );
		}
		
		add_action('load-'.$this->page, array(&$this, '_load_page'));
	}//function	
 	

	/**
	 * enqueue styles/js for theme page
	 *
	 * @since Radium_Options 2.0
	*/
	function _enqueue(){
	
		global $wp_styles;
		 
		wp_register_style(
				'radium-opts-css', 
				$this->url.'assets/css/options.css',
				array('farbtastic'),
				time(),
				'all'
			);
			
		wp_register_style(
			'radium-opts-jquery-ui-css',
			apply_filters('radium-opts-ui-theme', $this->url.'assets/css/jquery-ui-aristo/aristo.css'),
			'',
			time(),
			'all'
		);
			
		if(false === $this->args['stylesheet_override']){
			wp_enqueue_style('radium-opts-css');
		}
		
		wp_enqueue_script(
			'radium-opts-js', 
			$this->url.'assets/js/options.js', 
			array('jquery'),
			time(),
			true
		);

    	// select2 CSS
        wp_enqueue_style( 'select2-css', $this->url . 'assets/js/vendor/select2/select2.css', array(), time(), 'all' );

        // JS
        wp_enqueue_script( 'select2-sortable-js', $this->url . 'assets/js/vendor/select2.sortable.min.js', array( 'jquery' ), time(), true );

        wp_enqueue_script( 'select2-js', $this->url . 'assets/js/vendor/select2/select2.min.js', array( 'jquery', 'select2-sortable-js' ),                 time(), true );
        
        wp_register_style(
            'radium-opts-elusive-icon',
            $this->url . 'assets/css/elusive-icons/elusive-webfont.css',
            array(),
            time(),
            'all'
        );

        wp_register_style(
            'radium-opts-elusive-icon-ie7',
            $this->url . 'assets/css/elusive-icons/elusive-webfont-ie7.css',
            array(),
            time(),
            'all'
        );

        $wp_styles->add_data( 'radium-opts-elusive-icon-ie7', 'conditional', 'lte IE 7' );
		            
		do_action('radium-opts-enqueue-'.$this->args['opt_name']);
		
		foreach($this->sections as $k => $section){
			
			if(isset($section['fields'])){
				
				foreach($section['fields'] as $fieldk => $field){
					
					if(isset($field['type'])){
					
						$field_class = 'Radium_Options_'.$field['type'];
		
						/**
						 * Field class file
						 * filter 'radium_opts_{opt_name}_field_class_{field.type}
						 *
						 * @param       string        field class file path
						 * @param array $field        field config data
						 */
						$class_file = apply_filters( "radium_opts_{$this->args['opt_name']}_field_class_{$field['type']}", $this->dir . "fields/{$field['type']}/field_{$field['type']}.php", $field );
						
						if ( $class_file ) {
						
							if ( ! class_exists( $field_class ) ) {
							    if ( file_exists( $class_file ) ) {
							        require_once( $class_file );
							    }
							}//if
									    
						    if ( ( class_exists($field_class) || method_exists( $field_class, 'enqueue' ) ) || method_exists( $field_class, 'localize' ) ) {
								
								if ( ! isset( $this->options[ $field['id'] ] ) ) {
								    $this->options[ $field['id'] ] = "";
								}
								
								$enqueue = new $field_class( $field, $this->options[ $field['id'] ], $this);
								
								// Move dev_mode check to a new if/then block
	                            if ( ! wp_script_is( 'radium-opts-field-' . $field['type'] . '-js', 'enqueued' ) && class_exists( $field_class ) && method_exists( $field_class, 'enqueue' ) ) {
	
	                                // Checking for extension field AND dev_mode = false OR dev_mode = true
	                                // Since extension fields use 'extension_dir' exclusively, we can detect them here.
	                                // Also checking for dev_mode = true doesn't mess up the JS combinine.
	                                //if ( /*$this->args['dev_mode'] === false && */ isset($enqueue->extension_dir) && (!'' == $theField->extension_dir) /* || ($this->args['dev_mode'] === true) */) {
	                                $enqueue->enqueue();
	                                //}
	                            }
								                                        
							}//if
						
							if ( method_exists( $field_class, 'localize' ) ) {
							    
							    $params = $enqueue->localize( $field );
							    
							    if ( ! isset( $this->localize_data[ $field['type'] ] ) ) {
							        $this->localize_data[ $field['type'] ] = array();
							    }
							    $this->localize_data[ $field['type'] ][ $field['id'] ] = $enqueue->localize( $field );
							    
							}
							
							unset( $enqueue );
							
						}//if class_file
						
					}//if type
					
				}//foreach
			
			}//if fields
			
		}//foreach
		
		$this->localize_data['args']         = array(
		    'save_pending'          => __( 'You have changes that are not saved. Would you like to save them now?', 'radium' ),
		    'reset_confirm'         => __( 'Are you sure? Resetting will lose all custom values.', 'radium' ),
		    'reset_section_confirm' => __( 'Are you sure? Resetting will lose all custom values in this section.', 'radium' ),
		    'preset_confirm'        => __( 'Your current options will be replaced with the values of this preset. Would you like to proceed?', 'radium' ),
		    'please_wait'           => __( 'Please Wait', 'radium' ),
		    'opt_name'              => $this->args['opt_name'],
		    'slug'                  => $this->args['page_slug'],
		);
								
		$this->localize_data['fonts'] = $this->fonts;
                
        if ( isset( $this->font_groups['google'] ) ) {
            $this->localize_data['googlefonts'] = $this->font_groups['google'];
        }

        if ( isset( $this->font_groups['std'] ) ) {
            $this->localize_data['stdfonts'] = $this->font_groups['std'];
        }

        if ( isset( $this->font_groups['customfonts'] ) ) {
            $this->localize_data['customfonts'] = $this->font_groups['customfonts'];
        }
        		
		wp_localize_script( 'radium-opts-js', 'radium_opts', $this->localize_data );
							
		
	}//function
	
    /**
     * Enqueue CSS and Google fonts for front end
     *
     * @since       1.0.0
     * @access      public
     * @return      void
     */
    public function _enqueue_output() {
    
        if ( $this->args['output'] == false && $this->args['compiler'] == false ) {
            return;
        }

        /** @noinspection PhpUnusedLocalVariableInspection */
        foreach ( $this->sections as $k => $section ) {
            if ( isset( $section['type'] ) && ( $section['type'] == 'divide' ) ) {
                continue;
            }

            if ( isset( $section['fields'] ) ) {
                /** @noinspection PhpUnusedLocalVariableInspection */
                foreach ( $section['fields'] as $fieldk => $field ) {
                    if ( isset( $field['type'] ) && $field['type'] != "callback" ) {
                        $field_class = "Radium_Options_{$field['type']}";
                        if ( ! class_exists( $field_class ) ) {

                            if ( ! isset( $field['compiler'] ) ) {
                                $field['compiler'] = "";
                            }

                            /**
                             * Field class file
                             * filter 'redux/{opt_name}/field/class/{field.type}
                             *
                             * @param       string        field class file
                             * @param array $field        field config data
                             */
							$class_file = apply_filters( "radium_opts_{$this->args['opt_name']}_field_class_{$field['type']}", $this->dir . "fields/{$field['type']}/field_{$field['type']}.php", $field );

                            if ( $class_file && file_exists( $class_file ) && ! class_exists( $field_class ) ) {
                                /** @noinspection PhpIncludeInspection */
                                require_once( $class_file );
                            }
                        }

                        if ( ! empty( $this->options[ $field['id'] ] ) && class_exists( $field_class ) && method_exists( $field_class, 'output' ) && $this->_can_output_css( $field ) ) {
                            $field = apply_filters( "radium_opts_field_{$this->args['opt_name']}_output_css", $field );

                            if ( ! empty( $field['output'] ) && ! is_array( $field['output'] ) ) {
                                $field['output'] = array( $field['output'] );
                            }

                            $value   = isset( $this->options[ $field['id'] ] ) ? $this->options[ $field['id'] ] : '';
                            $enqueue = new $field_class( $field, $value, $this );

                            if ( ( ( isset( $field['output'] ) && ! empty( $field['output'] ) ) || ( isset( $field['compiler'] ) && ! empty( $field['compiler'] ) ) || $field['type'] == "typography" || $field['type'] == "icon_select" ) ) {
                                $enqueue->output();
                            }
                        }
                    }
                }
            }
        }
        // For use like in the customizer. Stops the output, but passes the CSS in the variable for the compiler
        if ( isset( $this->no_output ) ) {
            return;
        }

        if ( ! empty( $this->typography ) && ! empty( $this->typography ) && filter_var( $this->args['output'], FILTER_VALIDATE_BOOLEAN ) ) {
            $version    = ! empty( $this->transients['last_save'] ) ? $this->transients['last_save'] : '';
            $typography = new Radium_Options_typography( null, null, $this );

            if ( $this->args['async_typography'] && ! empty( $this->typography ) ) {
                $families = array();
                foreach ( $this->typography as $key => $value ) {
                    $families[] = $key;
                }

                ?>
                <style>.wf-loading *, .wf-inactive * {
                        visibility: hidden;
                    }

                    .wf-active * {
                        visibility: visible;
                    }</style>
                <script>
                    /* You can add more configuration options to webfontloader by previously defining the WebFontConfig with your options */
                    if ( typeof WebFontConfig === "undefined" ) {
                        WebFontConfig = new Object();
                    }
                    WebFontConfig['google'] = {families: [<?php echo $typography->makeGoogleWebfontString( $this->typography )?>]};

                    (function() {
                        var wf = document.createElement( 'script' );
                        wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.5.0/webfont.js';
                        wf.type = 'text/javascript';
                        wf.async = 'true';
                        var s = document.getElementsByTagName( 'script' )[0];
                        s.parentNode.insertBefore( wf, s );
                    })();
                </script>
            <?php
            } else {
                $protocol = ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 ) ? "https:" : "http:";

                //echo '<link rel="stylesheet" id="options-google-fonts" title="" href="'.$protocol.$typography->makeGoogleWebfontLink( $this->typography ).'&amp;v='.$version.'" type="text/css" media="all" />';
                wp_register_style( 'radium-opts-google-fonts', $protocol . $typography->makeGoogleWebfontLink( $this->typography ), '', $version );
                wp_enqueue_style( 'radium-opts-google-fonts' );
            }
        }

    } // _enqueue_output()
    
	/**
	 * Register Extensions for use
	 *
	 * @since       3.0.0
	 * @access      public
	 * @return      void
	 */
	public function _register_extensions() {
	    $path    = $this->dir. 'extensions/';
	    $folders = scandir( $path, 1 );
				
	    /**
	     * action 'radium_opts_extensions_{opt_name}_before'
	     *
	     * @param object $this Radium_Options
	     */
	    do_action( "radium_opts_extensions_{$this->args['opt_name']}_before", $this );
	
	    foreach ( $folders as $folder ) {
	        if ( $folder === '.' || $folder === '..' || ! is_dir( $path . $folder ) || substr( $folder, 0, 1 ) === '.' || substr( $folder, 0, 1 ) === '@' ) {
	            continue;
	        }
	
	        $extension_class = 'Radium_Options_Extension_' . $folder;
	
	        if ( ! class_exists( $extension_class ) ) {
	            /**
	             * filter 'radium-opts-extensionclass-load'
	             *
	             * @deprecated
	             *
	             * @param        string                    extension class file path
	             * @param string $extension_class          extension class name
	             */
	            $class_file = apply_filters( "radium-opts-extensionclass-load", "{$path}{$folder}/extension-{$folder}.php", $extension_class ); // REMOVE LATER
 				
	            /**
	             * filter 'radium_opts_extension_{opt_name}_{folder}'
	             *
	             * @param        string                    extension class file path
	             * @param string $extension_class          extension class name
	             */
	            $class_file = apply_filters( "radium_opts_extension_{$this->args['opt_name']}_$folder", "{$path}/{$folder}/extension-{$folder}.php", $class_file );
					
	            if ( $class_file ) {
	                if ( file_exists( $class_file ) ) {
	                    require_once( $class_file );
	                }
	
	                $this->extensions[ $folder ] = new $extension_class( $this );
	            }
	        }
	
	    }
	
	    /**
	     * action 'radium_opts_register_extensions_{opt_name}'
	     *
	     * @deprecated
	     *
	     * @param object $this Radium_Options
	     */
	    do_action( "radium_opts_register_extensions_{$this->args['opt_name']}", $this ); // REMOVE
	
	    /**
	     * action 'radium_opts_extensions_{opt_name}'
	     *
	     * @param object $this Radium_Options
	     */
	    do_action( "radium_opts_extensions_{$this->args['opt_name']}", $this );
	}
                
    /**
     * Can Output CSS
     * Check if a field meets its requirements before outputting to CSS
     *
     * @param $field
     *
     * @return bool
     */
    public function _can_output_css( $field ) {
        $return = true;

        return $return;
    } // _can_output_css
    
	
	/**
	 * Download the options file, or display it
	 *
	 * @since Radium_Options 2.0.1
	*/
	function _download_options(){
	
		//-'.$this->args['opt_name']
		if(!isset($_GET['secret']) || $_GET['secret'] != md5(AUTH_KEY.SECURE_AUTH_KEY)){wp_die('Invalid Secret for options use');exit;}
		if(!isset($_GET['feed'])){wp_die('No Feed Defined');exit;}
		$backup_options = get_option(str_replace('radiumopts-','',$_GET['feed']));
		$backup_options['radium-opts-backup'] = '1';
		$content = '###'.serialize($backup_options).'###';
		
		
		if(isset($_GET['action']) && $_GET['action'] == 'download_options'){
			header('Content-Description: File Transfer');
			header('Content-type: application/txt');
			header('Content-Disposition: attachment; filename="'.str_replace('radiumopts-','',$_GET['feed']).'_options_'.date('d-m-Y').'.txt"');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			echo $content;
			exit;
		}else{
			echo $content;
			exit;
		}
	}
 
 	
	/**
	 * show page help
	 *
	 * @since Radium_Options 2.0
	*/
	function _load_page(){
		
		//do admin head action for this page
		add_action('admin_head', array(&$this, 'admin_head'));
		
		//do admin footer text hook
		add_filter('admin_footer_text', array(&$this, 'admin_footer_text'));
		
		$screen = get_current_screen();
		
		if(is_array($this->args['help_tabs'])){
			foreach($this->args['help_tabs'] as $tab){
				$screen->add_help_tab($tab);
			}//foreach
		}//if
		
		if($this->args['help_sidebar'] != ''){
			$screen->set_help_sidebar($this->args['help_sidebar']);
		}//if
		
		do_action('radium-opts-load-page-'.$this->args['opt_name'], $screen);
		
	}//function
	
	
	/**
	 * do action radium-opts-admin-head for theme options page
	 *
	 * @since Radium_Options 2.0
	*/
	function admin_head(){
		
		do_action('radium-opts-admin-head-'.$this->args['opt_name'], $this);
		
	}//function
	
	
	function admin_footer_text($footer_text){
		return $this->args['footer_credit'];
	}//function
	

	/**
	 * Register Option for use
	 *
	 * @since Radium_Options 2.0
	*/
	function _register_setting(){
		
		register_setting($this->args['opt_name'].'_group', $this->args['opt_name'], array(&$this,'_validate_options'));
		
		foreach($this->sections as $k => $section){
			
			add_settings_section($k.'_section', $section['title'], array(&$this, '_section_desc'), $k.'_section_group');
			
			if(isset($section['fields'])){
			
				foreach($section['fields'] as $fieldk => $field){
					
					if(isset($field['title'])){
					
						$th = (isset($field['sub_desc']))?$field['title'].'<span class="description">'.$field['sub_desc'].'</span>':$field['title'];
					}else{
						$th = '';
					}
					
					add_settings_field($fieldk.'_field', $th, array(&$this,'_field_input'), $k.'_section_group', $k.'_section', $field); // checkbox
					
				}//foreach
			
			}//if(isset($section['fields'])){
			
		}//foreach
		
		$this->_enqueue_output();
		
		do_action('radium-opts-register-settings-'.$this->args['opt_name']);
		
	}//function
 
  	
	/**
	 * Validate the Options options before insertion
	 *
	 * @since Radium_Options 2.0
	*/
	function _validate_options($plugin_options){
		
		set_transient('radium-opts-saved', '1', 1000 );
		
		if(!empty($plugin_options['import'])){
			
			if($plugin_options['import_code'] != ''){
				$import = $plugin_options['import_code'];
			}elseif($plugin_options['import_link'] != ''){
				$import = wp_remote_retrieve_body( wp_remote_get($plugin_options['import_link']) );
			}
			
			$imported_options = unserialize(trim($import,'###'));
			if(is_array($imported_options) && isset($imported_options['radium-opts-backup']) && $imported_options['radium-opts-backup'] == '1'){
				$imported_options['imported'] = 1;
				return $imported_options;
			}
			
			
		}
		
		if(!empty($plugin_options['defaults'])){
			$plugin_options = $this->_default_values();
			
			if(get_option($this->args['opt_customizer_name'])){
				delete_option($this->args['opt_customizer_name']);
			}
			
			return $plugin_options;
		}//if set defaults

		
		//validate fields (if needed)
		$plugin_options = $this->_validate_values($plugin_options, $this->options);
		
		if($this->errors){
			set_transient('radium-opts-errors-'.$this->args['opt_name'], $this->errors, 1000 );		
		}//if errors
		
		if($this->warnings){
			set_transient('radium-opts-warnings-'.$this->args['opt_name'], $this->warnings, 1000 );		
		}//if errors
		
		do_action('radium-opts-options-validate-'.$this->args['opt_name'], $plugin_options, $this->options);
		
		unset($plugin_options['defaults']);
		unset($plugin_options['import']);
		unset($plugin_options['import_code']);
		unset($plugin_options['import_link']);
		
		return $plugin_options;	
	
	}//function
	 
	 	
	/**
	 * Validate values from options form (used in settings api validate function)
	 * calls the custom validation class for the field so authors can override with custom classes
	 *
	 * @since Radium_Options 2.0
	*/
	function _validate_values($plugin_options, $options){
		foreach($this->sections as $k => $section){
			
			if(isset($section['fields'])){
			
				foreach($section['fields'] as $fieldk => $field){
					$field['section_id'] = $k;
					
					if(isset($field['type']) && $field['type'] == 'multi_text'){continue;}//we cant validate this yet
					
					if(!isset($plugin_options[$field['id']]) || $plugin_options[$field['id']] == ''){
						continue;
					}
					
					//force validate of custom filed types
					
					if(isset($field['type']) && !isset($field['validate'])){
						if($field['type'] == 'color' || $field['type'] == 'color_gradient'){
							$field['validate'] = 'color';
						}elseif($field['type'] == 'date'){
							$field['validate'] = 'date';
						}
					}//if
	
					if(isset($field['validate'])){
						$validate = 'RADIUM_Validation_'.$field['validate'];
						
						if(!class_exists($validate)){
							require_once($this->dir.'validation/'.$field['validate'].'/validation_'.$field['validate'].'.php');
						}//if
						
						if(class_exists($validate)){
							$validation = new $validate($field, $plugin_options[$field['id']], $options[$field['id']]);
							$plugin_options[$field['id']] = $validation->value;
							if(isset($validation->error)){
								$this->errors[] = $validation->error;
							}
							if(isset($validation->warning)){
								$this->warnings[] = $validation->warning;
							}
							continue;
						}//if
					}//if
					
					
					if(isset($field['validate_callback']) && function_exists($field['validate_callback'])){
						
						$callbackvalues = call_user_func($field['validate_callback'], $field, $plugin_options[$field['id']], $options[$field['id']]);
						$plugin_options[$field['id']] = $callbackvalues['value'];
						if(isset($callbackvalues['error'])){
							$this->errors[] = $callbackvalues['error'];
						}//if
						if(isset($callbackvalues['warning'])){
							$this->warnings[] = $callbackvalues['warning'];
						}//if
						
					}//if
					
					
				}//foreach
			
			}//if(isset($section['fields'])){
			
		}//foreach
		return $plugin_options;
	}//function
	
 	
	/**
	 * HTML OUTPUT.
	 *
	 * @since Radium_Options 2.0
	*/
	function _options_page_html(){
				
		echo '<div class="wrap">';
			echo '<div id="'.$this->args['page_icon'].'" class="icon32"><br/></div>';
			echo '<h2 id="radium-opts-heading">'.get_admin_page_title().'</h2>';
			echo (isset($this->args['intro_text']))?$this->args['intro_text']:'';
			
			do_action('radium-opts-page-before-form-'.$this->args['opt_name']);

			echo '<form method="post" action="options.php" enctype="multipart/form-data" id="radium-opts-form-wrapper">';
				settings_fields($this->args['opt_name'].'_group');
				
				$last_tab = isset( $this->options['last_tab'] ) ? $this->options['last_tab'] : '0';
				
				$last_tab = (isset($_GET['tab']) && !get_transient('radium-opts-saved')) ? $_GET['tab'] : $last_tab;
				
				echo '<input type="hidden" id="last_tab" name="'.$this->args['opt_name'].'[last_tab]" value="'.$last_tab.'" />';
				
				echo '<div id="radium-opts-header">';
				echo '<h3 id="radium-opts-theme-heading"><span id="opts-theme-heading">'.$this->theme_title.'</span>';
				echo '<span id="radium-opts-theme-ver">Version: '.$this->theme_version .'</span></h3>';
						
					if(isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' && get_transient('radium-opts-saved') == '1'){
						if(isset($this->options['imported']) && $this->options['imported'] == 1){
							echo '<div id="radium-opts-imported">'.apply_filters('radium-opts-imported-text-'.$this->args['opt_name'], __('<strong>Settings Imported!</strong>', 'radium')).'</div>';
						}else{
							echo '<div id="radium-opts-save">'.apply_filters('radium-opts-saved-text-'.$this->args['opt_name'], __('<strong>Settings Saved!</strong>', 'radium')).'</div>';
						}
						delete_transient('radium-opts-saved');
					}
					echo '<div id="radium-opts-save-warn">'.apply_filters('radium-opts-changed-text-'.$this->args['opt_name'], __('<strong>Settings have changed!, you should save them!</strong>', 'radium')).'</div>';
					echo '<div id="radium-opts-field-errors">'.__('<strong><span></span> error(s) were found!</strong>', 'radium').'</div>';
					
					echo '<div id="radium-opts-field-warnings">'.__('<strong><span></span> warning(s) were found!</strong>', 'radium').'</div>';
									
					submit_button('', 'primary', '', false);

					echo '<div class="clear"></div><!--clearfix-->';
					
				echo '</div>';
				echo '<div class="clear"></div><!--clearfix-->';
				
				echo '<div id="radium-opts-sidebar">';
					echo '<ul id="radium-opts-group-menu">';
					
						foreach($this->sections as $k => $section){
							$icon = (!isset($section['icon']))?'<div class="section-tab-icon"><img src="'.$this->images_url.'/icons/icon-cogwheel.png" /></div>':'<div class="section-tab-icon"><img src="'.$section['icon'].'" /></div> ';
							echo '<li id="'.$k.'_section_group_li" class="radium-opts-group-tab-link-li">';
								echo '<a href="javascript:void(0);" id="'.$k.'_section_group_li_a" class="radium-opts-group-tab-link-a" data-rel="'.$k.'">'.$icon.'<span>'.$section['title'].'</span></a>';
							echo '</li>';
						}
						
						//echo '<li class="divide">&nbsp;</li>';
						
						do_action('radium-opts-after-section-menu-items-'.$this->args['opt_name'], $this);
						
						if(true === $this->args['show_import_export']){
							echo '<li id="import_export_default_section_group_li" class="radium-opts-group-tab-link-li">';
									echo '<a href="javascript:void(0);" id="import_export_default_section_group_li_a" class="radium-opts-group-tab-link-a" data-rel="import_export_default"><img src="'.$this->images_url.'/icons/icon-import.png" /> <span>'.__('Import / Export / Reset', 'radium').'</span></a>';
							echo '</li>';
							//echo '<li class="divide">&nbsp;</li>';
						}//if
						
						
						foreach($this->extra_tabs as $k => $tab){
							$icon = (!isset($tab['icon']))?'<div class="section-tab-icon"><img src="'.$this->images_url.'/icons/icon-cogwheel.png" /></div> ':'<div class="section-tab-icon"><img src="'.$tab['icon'].'" /></div> ';
							echo '<li id="'.$k.'_section_group_li" class="radium-opts-group-tab-link-li">';
								echo '<a href="javascript:void(0);" id="'.$k.'_section_group_li_a" class="radium-opts-group-tab-link-a custom-tab" data-rel="'.$k.'">'.$icon.'<span>'.$tab['title'].'</span></a>';
							echo '</li>';
						}

						
						if(true === $this->args['dev_mode']){
							echo '<li id="dev_mode_default_section_group_li" class="radium-opts-group-tab-link-li">';
									echo '<a href="javascript:void(0);" id="dev_mode_default_section_group_li_a" class="radium-opts-group-tab-link-a custom-tab" data-rel="dev_mode_default"><div class="section-tab-icon"><img src="'.$this->images_url.'/icons/icon-info.png" /></div> <span>'.__('Dev Mode Info', 'radium').'</span></a>';
							echo '</li>';
						}//if
						
					echo '</ul>';
				echo '</div>';
				
				echo '<div id="radium-opts-main">';
				
					foreach($this->sections as $k => $section){
						echo '<div id="'.$k.'_section_group'.'" class="radium-opts-group-tab">';
							do_settings_sections($k.'_section_group');
						echo '</div>';
					}					
					
					
					if(true === $this->args['show_import_export']){
						echo '<div id="import_export_default_section_group'.'" class="radium-opts-group-tab">';
							
							
							echo '<div class="import-header">';
								echo '<h3>'.__('Import / Export & Reset Options', 'radium').'</h3>';
								echo '<div class="radium-opts-section-desc">';
								echo '<p class="description">'.__('Copy & download your current options settings, import a new set, or do a full reset.', 'radium').'</p>';
								echo '</div>';
							echo '</div>';
      
      
							echo '<h4>'.__('Import Theme Options', 'radium').'</h4>';
							echo '<div class="radium-opts-section-desc">';
								echo '<p class="description1">'.apply_filters('radium-opts-backup-description', __('Input your backup file below and hit Import to restore your sites options from a backup. Input the URL to another sites options set and hit Import to load the options from that site.', 'radium')).'</p>';
							echo '</div>';

							echo '<div class="radium-opts-import-warning"><span>'.apply_filters('radium-opts-import-warning', __('WARNING! This will overwrite any existing options, please proceed with extreme caution.', 'radium')).'</span></div>';				
							
							echo '<p><a href="javascript:void(0);" id="radium-opts-import-code-button" class="button-secondary">Open Uploader</a> <a href="javascript:void(0);" id="radium-opts-import-link-button" class="button-secondary">URL Import</a></p>';
							
							echo '<div id="radium-opts-import-code-wrapper">';
								echo '<textarea id="import-code-value" name="'.$this->args['opt_name'].'[import_code]" class="large-text" rows="8"></textarea>';
							echo '</div>';
							
							echo '<div id="radium-opts-import-link-wrapper">';
								echo '<input type="text" id="import-link-value" name="'.$this->args['opt_name'].'[import_link]" class="large-text" value="" />';
							echo '</div>';
							
							echo '<p id="radium-opts-import-action"><input type="submit" id="radium-opts-import" name="'.$this->args['opt_name'].'[import]" class="button-primary" value="'.__('Import Options', 'radium').'"</p>';
							
							echo '<div id="import_divide"></div>';
							
							echo '<h4>'.__('Export Theme Options', 'radium').'</h4>';
							
							echo '<div class="radium-opts-section-desc">';
								echo '<p class="description">'.apply_filters('radium-opts-backup-description', __('Here you can copy/download your themes current option settings. Keep this safe as you can use it as a backup should anything go wrong. Or you can use it to restore your settings on this site (or any other site). You also have the handy option to copy the link to yours sites settings. Which you can then use to duplicate on another site', 'radium')).'</p>';
							echo '</div>';
							
								echo '<p>
								<a href="'.add_query_arg(array('feed' => 'radiumopts-'.$this->args['opt_name'], 'action' => 'download_options', 'secret' => md5(AUTH_KEY.SECURE_AUTH_KEY)), site_url()).'" id="radium-opts-export-code-dl" class="button-primary">Download</a>
								
								<a href="javascript:void(0);" id="radium-opts-export-code-copy" class="button-secondary">Copy</a>
								
								<a href="javascript:void(0);" id="radium-opts-export-link" class="button-secondary">Copy Link</a></p>';

								$backup_options = $this->options;
								$backup_options['radium-opts-backup'] = '1';
								$encoded_options = '###'.serialize($backup_options).'###';
								echo '<textarea class="large-text" id="radium-opts-export-code" rows="8">';print_r($encoded_options);echo '</textarea>';
								echo '<input type="text" class="large-text" id="radium-opts-export-link-value" value="'.add_query_arg(array('feed' => 'radiumopts-'.$this->args['opt_name'], 'secret' => md5(AUTH_KEY.SECURE_AUTH_KEY)), site_url()).'" />';
							
							
							echo '<div id="import_divide"></div>';
							
							echo '<h4>'.__('Theme Options Reset', 'radium').'</h4>';
							
							echo '<div class="radium-opts-section-desc">';
								echo '<p class="description1">'.apply_filters('radium-opts-backup-description', __('Conduct a full reset of your current theme options  and return all settings to their default values.  ', 'radium')).'</p>';
							echo '</div>';
							
							echo '<div class="radium-opts-import-warning"><span>'.apply_filters('radium-opts-import-warning', __('WARNING! This will definitely reset all your theme options settings.', 'radium')).'</span></div>';	
							
							submit_button(__('Reset All Current Options', 'radium'), 'button-primary radium-reset-options', $this->args['opt_name'].'[defaults]', false);
							
							
						
						echo '</div>';
					}
					
					foreach($this->extra_tabs as $k => $tab){
						echo '<div id="'.$k.'_section_group'.'" class="radium-opts-group-tab">';
						echo '<h3>'.$tab['title'].'</h3>';
						echo $tab['content'];
						echo '</div>';
					}

					if(true === $this->args['dev_mode']){
						echo '<div id="dev_mode_default_section_group'.'" class="radium-opts-group-tab">';
							echo '<h3>'.__('Dev Mode Info', 'radium').'</h3>';
							echo '<div class="radium-opts-section-desc">';
							echo '<textarea class="large-text" rows="24">'.print_r($this, true).'</textarea>';
							echo '</div>';
						echo '</div>';
					}
					
					do_action('radium-opts-after-section-items-'.$this->args['opt_name'], $this);
				
					echo '<div class="clear"></div><!--clearfix-->';
				echo '</div>';
				echo '<div class="clear"></div><!--clearfix-->';
				
				echo '<div id="radium-opts-footer">';
				
					if(isset($this->args['share_icons'])){
						echo '<div id="radium-opts-share">';
						foreach($this->args['share_icons'] as $link){
							echo '<a href="'.$link['link'].'" title="'.$link['title'].'" target="_blank"><img src="'.$link['img'].'"/></a>';
						}
						echo '</div>';
					}
					
					submit_button('', 'primary', '', false);
					echo '<div class="clear"></div><!--clearfix-->';
				echo '</div>';
			
			echo '</form>';
			
			do_action('radium-opts-page-after-form-'.$this->args['opt_name']);
			
			echo '<div class="clear"></div><!--clearfix-->';	
		echo '</div><!--wrap-->';

	}//function
	
 	
	/**
	 * JS to display the errors on the page
	 *
	 * @since Radium_Options 2.0
	*/	
	function _errors_js(){
		
		if(isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' && get_transient('radium-opts-errors-'.$this->args['opt_name'])){
				$errors = get_transient('radium-opts-errors-'.$this->args['opt_name']);
				$section_errors = array();
				foreach($errors as $error){
					$section_errors[$error['section_id']] = (isset($section_errors[$error['section_id']]))?$section_errors[$error['section_id']]:0;
					$section_errors[$error['section_id']]++;
				}
				
				
				echo '<script type="text/javascript">';
					echo 'jQuery(document).ready(function(){';
						echo 'jQuery("#radium-opts-field-errors span").html("'.count($errors).'");';
						echo 'jQuery("#radium-opts-field-errors").show();';
						
						foreach($section_errors as $sectionkey => $section_error){
							echo 'jQuery("#'.$sectionkey.'_section_group_li_a").append("<span class=\"radium-opts-menu-error\">'.$section_error.'</span>");';
						}
						
						foreach($errors as $error){
							echo 'jQuery("#'.$error['id'].'").addClass("radium-opts-field-error");';
							echo 'jQuery("#'.$error['id'].'").closest("td").append("<span class=\"radium-opts-th-error\">'.$error['msg'].'</span>");';
						}
					echo '});';
				echo '</script>';
				delete_transient('radium-opts-errors-'.$this->args['opt_name']);
			}
		
	}//function
 	
	
	/**
	 * JS to display the warnings on the page
	 *
	 * @since Radium_Options 2.0
	*/	
	function _warnings_js(){
		
		if(isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' && get_transient('radium-opts-warnings-'.$this->args['opt_name'])){
				$warnings = get_transient('radium-opts-warnings-'.$this->args['opt_name']);
				$section_warnings = array();
				foreach($warnings as $warning){
					$section_warnings[$warning['section_id']] = (isset($section_warnings[$warning['section_id']]))?$section_warnings[$warning['section_id']]:0;
					$section_warnings[$warning['section_id']]++;
				}
				
				
				echo '<script type="text/javascript">';
					echo 'jQuery(document).ready(function(){';
						echo 'jQuery("#radium-opts-field-warnings span").html("'.count($warnings).'");';
						echo 'jQuery("#radium-opts-field-warnings").show();';
						
						foreach($section_warnings as $sectionkey => $section_warning){
							echo 'jQuery("#'.$sectionkey.'_section_group_li_a").append("<span class=\"radium-opts-menu-warning\">'.$section_warning.'</span>");';
						}
						
						foreach($warnings as $warning){
							echo 'jQuery("#'.$warning['id'].'").addClass("radium-opts-field-warning");';
							echo 'jQuery("#'.$warning['id'].'").closest("td").append("<span class=\"radium-opts-th-warning\">'.$warning['msg'].'</span>");';
						}
					echo '});';
				echo '</script>';
				delete_transient('radium-opts-warnings-'.$this->args['opt_name']);
			}
		
	}//function
	
   	
	/**
	 * Section HTML OUTPUT.
	 *
	 * @since Radium_Options 2.0
	*/	
	function _section_desc($section){
		
		$id = rtrim($section['id'], '_section');
		
		if(isset($this->sections[$id]['desc']) && !empty($this->sections[$id]['desc'])) {
			echo '<div class="radium-opts-section-desc">'.$this->sections[$id]['desc'].'</div>';
		}
		
	}//function
	
	
  	/**
	 * Field HTML OUTPUT.
	 *
	 * Gets option from options array, then calls the specific field type class - allows extending by other devs
	 *
	 * @since Radium_Options 2.0
	*/
	function _field_input($field){
	
		$class_string = '';
		$data_string  = '';
		
		if(isset($field['callback']) && function_exists($field['callback'])){
			$value = (isset($this->options[$field['id']]))?$this->options[$field['id']]:'';
			do_action('radium-opts-before-field-'.$this->args['opt_name'], $field, $value);
			call_user_func($field['callback'], $field, $value);
			do_action('radium-opts-after-field-'.$this->args['opt_name'], $field, $value);
			return;
		}
		
		if(isset($field['type'])){
			
			$field_class = 'Radium_Options_'.$field['type'];
			
			if(class_exists($field_class)){
				
				require_once($this->dir.'fields/'.$field['type'].'/field_'.$field['type'].'.php');
			
			}//if
			
			if(class_exists($field_class)){
				$value = (isset($this->options[$field['id']])) ? $this->options[$field['id']] : '';
				do_action('radium-opts-before-field-'.$this->args['opt_name'], $field, $value);
				
				$render = '';
				$render = new $field_class($field, $value, $this);
				
				echo '<fieldset id="' . $this->args['opt_name'] . '-' . $field['id'] . '" class="radium-opts-field-container radium-opts-field radium-opts-field-init radium-opts-container-' . $field['type'] . ' ' . $class_string . '" data-id="' . $field['id'] . '" ' . $data_string . ' data-type="'.$field['type'].'">';
				
				$render->render();
				
				echo '</fieldset>';
				
				do_action('radium-opts-after-field-'.$this->args['opt_name'], $field, $value);
			
			}//if
			
		}//if $field['type']
		
	}//function

	
}//class

    
}//if
 

?>