<?php

/*
 * This file is a part of the RadiumFramework core.
 * Please be extremely cautious editing this file,
 *
 * @category RadiumFramework
 * @package  Carlton WP
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 */

/*
 * Initializes the framework by doing some basic things like defining constants
 * and loading framework components from the /includes directory.
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'Radium_Builder' ) ) :

    class Radium_Builder {

        /** Magic *****************************************************************/

        /**
         * The Radium Framework uses many variables and functions, most of which can be filtered to customize
         * the way that it works. To prevent unauthorized access, these variables
         * are stored in a private array that is magically updated using PHP 5.2+
         * methods. This is to prevent third party plugins from tampering with
         * essential information indirectly, which would cause issues later.
         *
         * @see Radium_Builder::builder_setup_globals()
         * @var array
         */

        private $data;

        /**
        * radium_builder Instance
        *
        * @since 2.1.0
        * @staticvar array $instance
        * @uses Radium_Builder::builder_setup_globals() Setup the globals needed
        * @uses Radium_Builder::builder_includes() Include the required files
        * @uses Radium_Builder::builder_action() Setup the hooks and actions
        * @return null
        */
        public function __construct() {

            $this->builder_setup_globals(); //setup builder data
            $this->builder_includes(); //load builder files
            $this->builder_action(); //builder actions

            if( is_admin() && current_user_can( 'edit_theme_options' ) )
                new Radium_Builder_Ajax; //load builder ajax

        }

        /** Private Methods *******************************************************/

        /**
         * Set some smart defaults to class variables. Allow some of them to be
         * filtered to allow for early overriding.
         *
         * @since 2.1.0
         * @access private
         * @uses radium_framework() To get framework data
         * @uses apply_filters() Calls various filters
         */

        private function builder_setup_globals() {

            $this->framework = radium_framework(); //Get framework globals

              $this->theme_builder_dir 			= apply_filters( 'radium_theme_builder_dir_path',  		$this->framework->theme_framework_dir ."/builder" );
            $this->theme_builder_url 			= apply_filters( 'radium_theme_builder_dir_url',   		$this->framework->theme_framework_url ."/builder" );
            $this->theme_builder_assets_url 	= apply_filters( 'radium_theme_builder_assets_url', 	$this->framework->theme_framework_url ."/builder/assets" );

            $this->theme_builder_frontend_dir 	= apply_filters( 'radium_theme_builder_frontend_dir_path', $this->framework->theme_includes_dir ."/builder" );

        }

        /**
         * Loads all the framework files and features.
         *
         * The radium_pre_framework action hook is called before any of the files are
         * required().
         *
         * @since 2.1.0
         */
        public function builder_includes() {

            if( is_admin() ) {

                if ( current_user_can( 'edit_theme_options' ) ) {

                    require_once $this->theme_builder_dir . '/builder-options.php';
                    require_once $this->theme_builder_dir . '/builder-options-sanitize.php';

                     require_once $this->theme_builder_dir . '/builder-ajax.php';
                    require_once $this->theme_builder_dir . '/builder-interface.php';

                    require_once $this->theme_builder_frontend_dir . '/builder-config.php';

                }

            } else { //frontend stuff

                require_once $this->theme_builder_frontend_dir . '/builder-functions.php';

            }

        }

        /**
        * builder action
        *
        * @since 2.1.0
        */
        public function builder_action() {

            if( is_admin() ) {

                if ( current_user_can( 'edit_theme_options' ) ) {

                    add_action( 'admin_menu', 		array( &$this, 'builder_add_page' ));

                    add_action( 'admin_enqueue_scripts', array( &$this, 'builder_non_modular_assets' ) );
                    add_action( 'after_setup_theme', 	array( &$this, 	'builder_register_posts' ) );

                    add_action( 'init', 	'radium_builder_load_elements' ); //load elements
                    add_action( 'init', 	'radium_builder_load_samples' ); //sample layouts

                     add_action( 'admin_menu', array( &$this, 	'builder_hijack_page_atts') );
                     add_action( 'save_post',  array( &$this, 	'builder_save_page_atts' ) );

                 }

            } else {

                add_action( 'after_setup_theme', 	array( &$this, 'builder_register_posts' ) );

                add_filter( 'body_class', 			'radium_builder_body_class' );
                add_action( 'template_redirect', 	'radium_frontend_init', 5 ); // This needs to run before any plugins hook into it

            }

        }

        /* Add a menu page for Builder */

        public function builder_add_page() {

            $builder_interface = new Radium_Builder_Interface;

            $icon 			= $this->theme_builder_assets_url . '/images/icon-builder.png';
            $builder_page 	= add_menu_page( __('Layout Builder', 'radium'), __('Builder', 'radium'), 'administrator', 'radium_builder', array(&$builder_interface, 'page'), $icon, 30 );

            // Adds actions to hook in the required css and javascript
            add_action( "admin_print_scripts-$builder_page", 	array( &$this, 'builder_load_scripts') );
            add_action( "admin_print_styles-$builder_page", 	array( &$this, 'builder_load_styles') );

        }

        /* Loads the CSS */

        public function builder_load_styles() {

            // Enqueued styles
            wp_enqueue_style( 'radium-opts-css',  		$this->framework->theme_framework_url 	.'/options/assets/css/options.css', array('farbtastic'), time(), 'all' );
            wp_enqueue_style( 'builderframework-style', 	$this->theme_builder_assets_url 		.'/css/builder-style.css');
            wp_enqueue_style( 'thickbox' );
            wp_enqueue_style('farbtastic');

        }

        /* Loads the javascript */

        public function builder_load_scripts() {

            // Enqueued scripts
            wp_enqueue_script( 'jquery-ui-core');
            wp_enqueue_script( 'jquery-ui-sortable');

            wp_enqueue_script( 'builder-general-scripts', 	$this->theme_builder_assets_url 	.'/js/general-custom.js', 	array('jquery') );
            wp_enqueue_script( 'builder-framework-scripts', $this->theme_builder_assets_url 	.'/js/builder-custom.js', 	array('jquery' , 'farbtastic') );

            wp_enqueue_media();
            wp_enqueue_script( 'custom-header' );

            wp_localize_script( 'builder-general-scripts', 'radium', $this->get_admin_locals( 'js' ) );
            wp_enqueue_script( 'radium-opts-tooltip-js', RADIUM_OPTIONS_URL.'assets/js/bootstrap-tooltip.js', array('jquery'), time(), true );

        }


        /**
         * Non-modular Admin Assets
         *
         * @since 2.1.0
         */

        public function builder_non_modular_assets() {
            global $pagenow;
            if( $pagenow == 'post-new.php' || $pagenow == 'post.php' )
                wp_enqueue_script( 'radium_meta_box-scripts', $this->theme_builder_assets_url . '/js/meta-box.js', array('jquery') );
        }


        /**
         * Hijack and modify default WP's "Page Attributes"
         * meta box.
         *
         * @since 2.1.0
         */

        public function builder_hijack_page_atts() {
            remove_meta_box( 'pageparentdiv', 'page', 'side' );
            add_meta_box( 'radium_pageparentdiv', __( 'Page Attributes', 'radium' ), array( &$this, 'page_attributes_meta_box'), 'page', 'side', 'core' );
        }

        /**
         * Saved data from Hi-jacked "Page Attributes"
         * meta box.
         *
         * @since 2.1.0
         */

        public function builder_save_page_atts( $post_id ) {
              // Save custom layout
            if( isset( $_POST['_radium_custom_layout'] ) )
                update_post_meta( $post_id, '_radium_custom_layout', $_POST['_radium_custom_layout'] );
        }


        /**
         * Register any post types used with framework.
         *
         * @since 2.1.0
         */

        public function builder_register_posts() {
                // Custom Layouts
                $args = array(
                    'labels' 			=> array(
                                            'name' => 'Layouts',
                                            'singular_name' => 'Layout'
                                        ),
                    'public'			=> false,
                    'show_ui' 			=> false,
                    'query_var' 		=> true,
                    'capability_type' 	=> 'post',
                    'hierarchical' 		=> true,
                    'rewrite' 			=> false,
                    'supports' 			=> array( 'title', 'custom-fields' ),
                    'can_export'		=> true
                );
                register_post_type( 'radium_layout', $args );
        }



        /**
         * Return user read text strings.
         *
         * @since 2.1.0
         *
         * @param string $type type of set, js or frontend
         * @return array $locals filtered array of localized text strings
         */

        public function get_admin_locals( $type ) {

            $locals = array();
            switch( $type ) {
                // Javascript strings
                case ( 'js' ) :
                    $locals = array (
                        'edit_layout'		=> __( 'Edit Layout', 'radium' ),
                         'no_name'			=> __( 'Oops! You forgot to enter a layout name.', 'radium' ),
                        'invalid_name'		=> __( 'Oops! The name you entered is either taken or too close to another name you\'ve already used.', 'radium' ),
                        'layout_created'	=> __( 'Layout created!', 'radium' ),
                        'primary_query'		=> __( 'Oops! You can only have one primary query element per layout. A paginated post list or paginated post grid would be examples of primary query elements.', 'radium' ),
                        'delete_layout'		=> __( 'Are you sure you want to delete this layout?', 'radium' )
                    );
                    break;
            }
            return apply_filters( 'radium_locals_'.$type, $locals );
        }

        /**
         * Option for selecting a custom layout that gets
         * inserted into out Hi-jacked "Page Attributes"
         * meta box.
         *
         * @since 2.1.0
         *
         * @param $layout string current custom layout
         * @param $output string HTML to output
         */

        public function custom_layout_dropdown( $layout = null ) {

            $custom_layouts = get_posts('post_type=radium_layout&numberposts=-1');
            $output = '<p><strong>'.__( 'Custom Layout', 'radium' ).'</strong></p>';

            if( ! empty( $custom_layouts ) ) {

                $output .= '<select name="_radium_custom_layout">';

                foreach( $custom_layouts as $custom_layout )
                    $output .= '<option value="'.$custom_layout->post_name.'" '.selected( $custom_layout->post_name, $layout, false ).'>'.$custom_layout->post_title.'</option>';

                $output .= '</select>';

            } else {

                $output .='<em>'.__( 'You haven\'t created any custom layouts in the Layout builder yet.', 'radium' ).'</em>';

            }

            return $output;

        }

         /**
         * Hijack and modify default Page Attributes meta box.
         *
         * @since 2.1.0
         *
         * @param object $post
         */
        public function page_attributes_meta_box($post) {

            $post_type_object = get_post_type_object($post->post_type);

            if ( $post_type_object->hierarchical ) {

                $dropdown_args = array(
                    'post_type'        => $post->post_type,
                    'exclude_tree'     => $post->ID,
                    'selected'         => $post->post_parent,
                    'name'             => 'parent_id',
                    'show_option_none' => __('(no parent)', 'radium'),
                    'sort_column'      => 'menu_order, post_title',
                    'echo'             => 0,
                );

                $dropdown_args = apply_filters( 'page_attributes_dropdown_pages_args', $dropdown_args, $post );

                $pages = wp_dropdown_pages( $dropdown_args );

                if ( ! empty($pages) ) { ?>
                    <p><strong><?php _e('Parent', 'radium') ?></strong></p>
                    <label class="screen-reader-text" for="parent_id"><?php _e('Parent', 'radium') ?></label>
                    <?php echo $pages; ?>
                    <?php
                } // end empty pages check
            } // end hierarchical check.

            if ( 'page' == $post->post_type && 0 != count( get_page_templates() ) ) {
                $template = !empty($post->page_template) ? $post->page_template : false;
                ?>
                <p><strong><?php _e('Template', 'radium') ?></strong></p>
                <label class="screen-reader-text" for="page_template"><?php _e('Page Template', 'radium') ?></label><select name="page_template" id="page_template">
                <option value='default'><?php _e('Default Template', 'radium'); ?></option>
                <?php page_template_dropdown($template); ?>
                </select>
                <?php
            }

                $custom_layout = get_post_meta( $post->ID, '_radium_custom_layout', true );
                echo $this->custom_layout_dropdown( $custom_layout );

            ?>
                <p><strong><?php _e('Order', 'radium') ?></strong></p>
                <p><label class="screen-reader-text" for="menu_order"><?php _e('Order', 'radium') ?></label><input name="menu_order" type="text" size="4" id="menu_order" value="<?php echo esc_attr($post->menu_order) ?>" /></p>
                <p><?php if ( 'page' == $post->post_type ) _e( 'Need help? Use the Help tab in the upper right of your screen.', 'radium' ); ?></p>
        <?php
        }

}

new Radium_Builder();

endif;
