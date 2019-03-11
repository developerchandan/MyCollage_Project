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
 * Initializes the builder ajax
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'Radium_Builder_Ajax' ) ) :

class Radium_Builder_Ajax {

	public function __construct(){

		$this->action();
	}

	public function action() {

		add_action( 'wp_ajax_radium_builder_add_layout',	array( &$this, 'add_layout' ) );
		add_action( 'wp_ajax_radium_builder_save_layout', 	array( &$this, 'save_layout' ) );
		add_action( 'wp_ajax_radium_builder_add_element', 	array( &$this, 'add_element' ) );
		add_action( 'wp_ajax_radium_builder_update_table', 	array( &$this, 'update_table' ) );
		add_action( 'wp_ajax_radium_builder_delete_layout', array( &$this, 'delete_layout' ) );
		add_action( 'wp_ajax_radium_builder_edit_layout', 	array( &$this, 'edit_layout' ) );

	}

	/**
	* Add new layout
	*/
	public function add_layout() {

		// Verify Request
		check_ajax_referer( 'radium_panel_opt_new_builder', 'security' );

		// Handle form data
		parse_str( $_POST['data'], $config );

		// Setup arguments for new 'layout' post
		$args = array(
			'post_type'			=> 'radium_layout',
			'post_title'		=> $config['options']['layout_name'],
			'post_status' 		=> 'publish',
			'comment_status'	=> 'closed',
			'ping_status'		=> 'closed'
		);

		// Create new post
		$post_id = wp_insert_post( $args );

		// Setup meta
		if( $config['options']['layout_start'] ) {

			// Configure meta for sample layout
			$samples = radium_builder_samples();

			$current_sample = $samples[$config['options']['layout_start']];
			
			$elements = array(
				'featured' 	=> $current_sample['featured'],
				'primary' 	=> $current_sample['primary']
 			);

			$settings = array( 'settings' => $current_sample['settings']  );

		} else {

			// Configure meta for blank layout
			$elements = array();
			$settings = array();
		}

		// Update even if they're empty
		update_post_meta( $post_id, 'elements', $elements );
		update_post_meta( $post_id, 'settings', $settings );

		// Respond with edit page for the new layout and ID
		echo $post_id.'[(=>)]';

		$builder_interface = new Radium_Builder_Interface;

		$builder_interface->edit_layout(  $post_id  );

		die();
	}

	/* Save layout */
	public function save_layout () {

		// Verify Request
		check_ajax_referer( 'radium_panel_opt_save_builder', 'security' );

		// Handle form data
		parse_str( $_POST['data'], $data );

		// Layout ID
		$layout_id = $data['layout_id'];

		// Setup elements
		$location = 'featured';
		$elements = array();

		if( isset( $data['elements'] ) ) {

			// Get default element options
			$default_element_options = radium_builder_elements();

			// Loop through setting items in 'featured' location
			// until we arrive at the divider line, and then
			// continue putting them into the 'primary' area.
			foreach ( $data['elements'] as $id => $element ) {

                if( isset($element['cache']) && $element['cache'] ) delete_transient( 'rm_'.$id );

				if( $id == 'divider' ) {

					$location = 'primary';

				} else {

					// Sanitize element's options
					$clean = array();
					$clean_style = array();

					foreach( $default_element_options[$element['type']]['options'] as $option ){

						if ( ! isset( $option['id'] ) )
							continue;

						if ( ! isset( $option['type'] ) )
							continue;

						$option_id = $option['id'];

						// Set checkbox to false if it wasn't sent in the $_POST
						if ( 'checkbox' == $option['type'] ) {

							$element['options'][$option_id]  = isset( $element['options'][$option_id] ) ? '1' : '0';

						}
						

						// Set each item in the multicheck to false if it wasn't sent in the $_POST
						if ( 'multicheck' == $option['type'] ){

							if( ! isset( $element['options'][$option_id] ) )
								$element['options'][$option_id] = array();

						}

						// For a value to be submitted to database it must pass through a sanitization filter
						if ( has_filter( 'radium_opt_sanitize_' . $option['type'] ) ) {
							$clean[$option_id] = apply_filters( 'radium_opt_sanitize_' . $option['type'], $element['options'][$option_id], $option );
 						}
 						
 						/* Adding a new slide code
 						// Register slide URL to translations
 						if (function_exists('icl_register_string')) {
 						
 							$slide_id = $this->slide->ID;
 							$url = icl_register_string('Slider', 'Slide_ID_' . $this->slide->ID, $fields['url']);
 						
 							$this->add_or_update_or_delete_meta($this->slide->ID, ‘url’, $url);
 						
 						} else {
 							$this->add_or_update_or_delete_meta($this->slide->ID, ‘url’, $fields['url']);
 						} */
 						
					}

					if( isset( $default_element_options[$element['type']]['style'] ) ) {

						foreach( $default_element_options[$element['type']]['style'] as $option ){

							if ( ! isset( $option['id'] ) )
								continue;

							if ( ! isset( $option['type'] ) )
								continue;

							$option_id = $option['id'];

							// Set checkbox to false if it wasn't sent in the $_POST
							if ( 'checkbox' == $option['type'] ) {

								$element['style'][$option_id]  = isset( $element['style'][$option_id] ) ? '1' : '0';

							}

							// Set each item in the multicheck to false if it wasn't sent in the $_POST
							if ( 'multicheck' == $option['type'] ){

								if( ! isset( $element['style'][$option_id] ) )
									$element['style'][$option_id] = array();

							}

							// For a value to be submitted to database it must pass through a sanitization filter
							if ( has_filter( 'radium_opt_sanitize_' . $option['type'] ) && isset( $element['style'][$option_id] ) ) {
   							
								$clean_style[$option_id] = apply_filters( 'radium_opt_sanitize_' . $option['type'], $element['style'][$option_id], $option );
							
							}

						}

					} //end if

					$element['options'] = $clean;
					$element['style'] = $clean_style;
					$elements[$location][$id] = $element;
 				}
			}
		}

		// Setup options
		$options =  isset( $data['options'] ) ? $options = $data['options'] : null;

		// Update even if they're empty
		update_post_meta( $layout_id, 'elements', $elements );
 		update_post_meta( $layout_id, 'settings', $options );

		// Display update message
		echo '<div id="setting-error-save_options" class="updated fade settings-error ajax-update">';
		echo '<p><strong>'.__( 'Layout saved.', 'radium' ).'</strong></p>';
		echo '</div>';
		die();
	}

	/* Add new element */

	public function add_element() {

		$builder_interface = new Radium_Builder_Interface;

		$element_type = $_POST['data'];
		$element_id = uniqid( 'element_'.rand() );

		$builder_interface->edit_element( $element_type, $element_id );

		die();
	}

	/* Update layout manager table */

	public function update_table() {

		$builder_interface = new Radium_Builder_Interface;

		$builder_interface->manage_layout();

		die();
	}

	/* Delete layout */

	public function delete_layout() {

		// Verify Request
		check_ajax_referer( 'radium_panel_opt_manage_builder', 'security' );

		// Handle data
		parse_str( $_POST['data'], $data );

		// Only run if user selected some layouts to delete
		if( isset( $data['posts'] ) ) {

			// Delete layout
			foreach( $data['posts'] as $id ) {

				// Can still be recovered from trash
				// if post type's admin UI is turned on.
				wp_delete_post( $id );

			}

			// Send back number of layouts
			$posts = get_posts( array( 'post_type' => 'radium_layout', 'numberposts' => -1 ) );
			echo sprintf( _n( '1 Layout', '%s Layouts', count($posts), 'radium' ), number_format_i18n( count($posts) ) ).'[(=>)]';

			// Display update message
			echo '<div id="setting-error-delete_layout" class="updated fade settings-error ajax-update">';
			echo '	<p><strong>'.__( 'Layout(s) deleted.', 'radium' ).'</strong></p>';
			echo '</div>';

		}

		die();
	}

	/* Edit a layout */
	public function edit_layout() {

		$builder_interface = new Radium_Builder_Interface;

		$layout_id = $_POST['data'];
		echo $layout_id.'[(=>)]';
		$builder_interface->edit_layout( $layout_id );
		die();
	}

}

endif;