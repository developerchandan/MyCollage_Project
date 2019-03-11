<?php
/**
 * Generates the options fields that are used in the form.
 */

function radium_panel_opt_fields( $option_name, $options, $settings, $close = true ) {

    $counter = 0;
	$menu = $output = $val = null;
	$value = array();
	
	foreach ($options as $value) {

		$counter++;
		$val = '';
		$select_value = '';
		$checked = '';
		$class = '';

		// Sub Groups
		// This allows for a wrapping div around groups of elements.
		// The primary reason for this is to help link certain options
		// together in order to apply custom javascript for certain
		// common groups.
	   	if( $value['type'] == 'subgroup_start' ) {
	   		if( isset( $value['class'] ) ) $class = ' '.$value['class'];
	   		if( isset( $value['clone'] ) ) {
	   			$will_be_cloned = true;
	   			$clone_name = $value['name'] ;
	   			$class .= ' clone-group';
	   		}
	   		$output .= '<div class="subgroup'.$class.'" data-element-group="1">';
            if( isset($value['desc']) ) $output .= '<div class="section-description subgroup-description">'.$value['desc'].'</div>';

	   		continue;
	   	}
	   	if( $value['type'] == 'subgroup_end' ) {
	   		$output .= '</div><!-- .subgroup  -->';
	   		if( isset($will_be_cloned) ) $output .= '<a id="clone-element-section" class="button-primary">+ Add New '. $clone_name .'</a>';

	   		continue;
	   	}

	   	// Name Grouping
	   	// This allows certain options to be grouped together in the
	   	// final saved options array by adding a common prefix to their
	   	// name form attributes.
	   	if( isset( $value['group'] ) )
	   		$option_name .= '['.$value['group'].']';

	   	// Sections
		// This allows for a wrapping div around certain sections. This
		// is meant to create visual dividing styles between sections,
		// opposed to sub groups, which are used to section off the code
		// for hidden purposes.
	   	if( $value['type'] == 'section_start' ) {
	   		if( isset( $value['class'] ) ) $class = ' '.$value['class'];

	   		$output .= '<div class="postbox inner-section'.$class.'">';
	   		$output .= '<h3>' . esc_html( $value['name'] ) . '</h3>';
	   		if( isset($value['desc']) ) $output .= '<div class="section-description">'.$value['desc'].'</div>';
	   		continue;
	   	}

	   	if( $value['type'] == 'section_end' ) {
	   		$output .= '</div><!-- .inner-section  -->';
	   		continue;
	   	}

		// Wrap all options
		if ( ( $value['type'] != "heading" ) && ( $value['type'] != "info" ) ) {

			// Keep all ids lowercase with no spaces
			$value['id'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($value['id']) );

			$id = 'section-' . $value['id'];

			$class = 'section ';
			if ( isset( $value['type'] ) ) {
				$class .= ' section-' . $value['type'];
			}
			if ( isset( $value['class'] ) ) {
				$class .= ' ' . $value['class'];
			}

			if ( isset( $value['clone-group'] ) ) { $group = " clone-group='{$value['clone-group']}'"; } else { $group =  null; }

			$output .= '<div id="' . esc_attr( $id ) .'" class="' . esc_attr( $class ) . '" '.$group.'>'."\n";
			if ( isset( $value['name'] ) ) {
				$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
			}
			if ( $value['type'] != 'editor' ) {
				$output .= '<div class="option">' . "\n" . '<div class="controls">' . "\n";
			}
			else {
				$output .= '<div class="option">' . "\n" . '<div>' . "\n";
			}
		}

		// Set default value to $val
		if ( isset( $value['std'] ) )
			$val = $value['std'];

		// If the option is already saved, override $val (Modified by radium to check for grouping)
		if ( ($value['type'] != 'heading') && ($value['type'] != 'info')) {
			if( isset( $value['group'] ) ) {
				// Set grouped value
				if ( isset($settings[($value['group'])][($value['id'])]) ) {
					$val = $settings[($value['group'])][($value['id'])];
					// Striping slashes of non-array options
					if (!is_array($val)) {
						$val = stripslashes($val);
					}
				}
			} else {
				// Set non-grouped value
				if ( isset($settings[($value['id'])]) ) {
					$val = $settings[($value['id'])];
					// Striping slashes of non-array options
					if (!is_array($val)) {
						$val = stripslashes($val);
					}
				}
			}
		}

		if ( ( $value['type'] != "heading" ) && ( $value['type'] != "info" ) ) {

				$explain_value = '';
				if ( isset( $value['desc'] ) ) {
					$explain_value = $value['desc'];
				}

				$output .= '<div class="radium-opts-builder-desc">' . $explain_value. '</div>';

				$output .= '<div class="radium-opts-builder">';
			}



	switch ( $value['type'] ) {

		// Add Layout text input
		case 'add_layout':
			$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '" />';
			$output .= '<input type="submit" class="button-primary button" name="update" value="'. __( 'Add New Layout', 'radium' ).'">';
			$output .= '<img src="'. esc_url( admin_url( 'images/wpspin_light.gif' ) ) .'" class="ajax-loading" id="ajax-loading">';
			$output .= '<div class="clear"></div>';
		break;

		// Basic text input
		case 'text':

			// Cloneable fields
			if ( isset($value['clone']) ) {

				$val = (array) $val;

				$i = 0;

				$output .= '<div class="rwmb-label"><label for="'.$value['id'].'">'.$value['name'].'</label></div>';
				$output .= '<div class="rwmb-input">';

				foreach ( $val as $k ) {

					$output .= "<div class='rwmb-clone'>";
					$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="of-input " name="' . esc_attr( $option_name . '[' . $value['id'] . ']['.$i.']' ) . '" type="text" value="' . esc_attr( $val[$i] ) . '" />';
					$output .= '<a href="#" class="rwmb-button button remove-clone">' . __( '&#8211;', 'radium' ) . '</a>';
					$output .= "</div>";

					$i++;

				}

				$output .= '<a href="#" class="rwmb-button button-primary add-clone">' . __( '+', 'radium' ) . '</a>';
				$output .= "</div>";

			} else {

				$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '" />';

			}

			break;

		// Basic text input
		case 'url':

			// Cloneable fields
			if ( isset($value['clone']) ) {

				$val = (array) $val;

				$i = 0;

				$output .= '<div class="rwmb-label"><label for="'.$value['id'].'">'.$value['name'].'</label></div>';
				$output .= '<div class="rwmb-input">';

				foreach ( $val as $k ) {

					$output .= "<div class='rwmb-clone'>";
					$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="of-input " name="' . esc_attr( $option_name . '[' . $value['id'] . ']['.$i.']' ) . '" type="text" value="' . esc_attr( $val[$i] ) . '" />';
					$output .= '<a href="#" class="rwmb-button button remove-clone">' . __( '&#8211;', 'radium' ) . '</a>';
					$output .= "</div>";

					$i++;

				}

				$output .= '<a href="#" class="rwmb-button button-primary add-clone">' . __( '+', 'radium' ) . '</a>';
				$output .= "</div>";

			} else {

				$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '" />';

			}

			break;

		// Textarea
		case 'textarea':

			if ( isset($value['clone']) ) {

					$val = (array) $val;

					$i = 0;

					$output .= '<div class="rwmb-label"><label for="'.$value['id'].'">'.$value['name'].'</label></div>';
					$output .= '<div class="rwmb-input">';

					foreach ( $val as $k ) {

						$output .= "<div class='rwmb-clone'>";
						$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="of-input " name="' . esc_attr( $option_name . '[' . $value['id'] . ']['.$i.']' ) . '" type="text" value="' . esc_attr( $val[$i] ) . '" />';
						$output .= '<a href="#" class="rwmb-button button remove-clone">' . __( '&#8211;', 'radium' ) . '</a>';
						$output .= "</div>";

						$i++;

					}

					$output .= '<a href="#" class="rwmb-button button-primary add-clone">' . __( '+', 'radium' ) . '</a>';
					$output .= "</div>";

			} else {

				$cols = '8';
				$ta_value = '';

				if(isset($value['options'])){
					$ta_options = $value['options'];
					if(isset($ta_options['cols'])){
						$cols = $ta_options['cols'];
					} else { $cols = '8'; }
				}

				$val = stripslashes( $val );

				$output .= '<textarea id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" cols="'. esc_attr( $cols ) . '" rows="8">' . esc_textarea( $val ) . '</textarea>';
			}

		break;

		// Select Box
		case ($value['type'] == 'select'):
			$output .= '<select class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '">';

			foreach ($value['options'] as $key => $option ) {
				$selected = '';
				 if( $val != '' ) {
					 if ( $val == $key) { $selected = ' selected="selected"';}
			     }
				 $output .= '<option'. $selected .' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
			 }
			 $output .= '</select>';

		break;


		// Radio Box
		case "radio":
			$name = $option_name .'['. $value['id'] .']';
			foreach ($value['options'] as $key => $option) {
				$id = $option_name . '-' . $value['id'] .'-'. $key;
				$output .= '<input class="of-input of-radio" type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="'. esc_attr( $key ) . '" '. checked( $val, $key, false) .' /><label for="' . esc_attr( $id ) . '">' . esc_html( $option ) . '</label>';
			}
		break;


		// Radio Image Box
		case "radio_img":

			$name = $option_name .'['. $value['id'] .']';
			foreach ( $value['options'] as $key => $option ) {
				$selected = '';
				$checked = '';
				if ( $val != '' ) {
					if ( $val == $key ) {
						$selected = ' of-radio-img-selected';
						$checked = ' checked="checked"';
					}
				}
				$output .= '<div class="radio_img">';
				$output .= '<input type="radio" id="' . esc_attr( $value['id'] .'_'. $key) . '" class="of-radio-img-radio" value="' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" '. $checked .' />';
				$output .= '<div class="of-radio-img-label">' . esc_html( $key ) . '</div>';
				$output .= '<img src="' . esc_url( $option[1] ) . '" alt="' . esc_attr($option[0] ) .'" title="' . esc_attr($option[0] ) .' '. __('sample layout','radium').'" class="of-radio-img-img' . $selected .'" onclick="document.getElementById(\''. esc_attr($value['id'] .'_'. $key) .'\').checked=true;" title="' . esc_html( $key ) . '" rel="tooltip" data-animation="true"/>';
				//$output .= '<div class="layout-title">'.$option[0] .'</div>';
				$output .= '</div>';
			}

		break;

		// Checkbox
		case "checkbox":
			$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" '. checked( $val, 1, false) .' />';
		break;

		// Multicheck
		case "multicheck":
			foreach ($value['options'] as $key => $option) {
				$checked = '';
				$label = $option;
				$option = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($key));

				$id = $option_name . '-' . $value['id'] . '-'. $option;
				$name = $option_name . '[' . $value['id'] . '][' . $key .']';
			    if ( isset($val[$key]) ) {
					$checked = checked($val[$key], 1, false);
				}
				$output .= '<label class="checkbox of-input" for="' . esc_attr( $id ) . '"><input id="' . esc_attr( $id ) . '" type="checkbox" name="' . esc_attr( $name ) . '" ' . $checked . ' />' . $label . '</label>';
			}
			break;

		// Color picker
		case "color":
			$default_color = '';
			if ( isset($value['std']) ) {
				if ( $val !=  $value['std'] )
					$default_color = ' data-default-color="' .$value['std'] . '" ';
			}
			$output .= '<input name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '" class="of-color"  type="text" value="' . esc_attr( $val ) . '"' . $default_color .' />';

			break;

		// Uploader
		case "upload":
			$text = isset($value['text']) ? $value['text']: __('Upload', 'radium');
			$output .= '<input type="text" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" class="rwmb-text of-input uploaded-image" value="' . esc_attr( $val ) . '">';
			$output .= '<input type="button" name="upload-image" class="upload-image button" value="' . $text. '">';
			break;

		// Editor
		case 'editor':
			//$output .= '<div class="explain">' . wp_kses( $explain_value, $allowedtags) . '</div>'."\n";
			//echo $output;
			$textarea_name = esc_attr( $option_name . '[' . $value['id'] . ']' );

			$default_editor_settings = array(
				'textarea_name' => $textarea_name,
				'media_buttons' => false,
				'tinymce' => array( 'plugins' => 'wordpress' )
			);

			$editor_settings = array();
			if ( isset( $value['settings'] ) ) {
				$editor_settings = $value['settings'];
			}

			$editor_settings = array_merge($editor_settings, $default_editor_settings);

			wp_editor( $val, $value['id'], $editor_settings );

			$output = '';
			break;

		// Info
		case "info":
			$class = 'section';
			if ( isset( $value['type'] ) ) {
				$class .= ' section-' . $value['type'];
			}
			if ( isset( $value['class'] ) ) {
				$class .= ' ' . $value['class'];
			}

			$output .= '<div class="' . esc_attr( $class ) . '">' . "\n";
			if ( isset($value['name']) ) {
				$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
			}
			if ( isset( $value['desc'] ) ) {
				$output .= apply_filters('radium_opt_sanitize_info', $value['desc'] ) . "\n";
			}
			$output .= '<div class="clear"></div></div>' . "\n";
		break;

		// Content
 		case "content":

			$id 		= $value['id'];
			$name 		= $option_name;
			$options 	= $value['options'];

			// Setup content types to choose from
			$sources = array(
				'null' 		=> __( '- Select Content Type -', 'radium' ),
			);

			if( in_array ( 'page', $options ) )
				$sources['page'] = __( 'External Page', 'radium' );

			if( in_array ( 'raw', $options ) )
				$sources['raw'] = __( 'Custom Content', 'radium' );

			// Set default value
			if( is_array( $val ) && isset( $val['type'] ) )
				$current_value = $val['type'];
			else
				$current_value = null;

			// Build <select>
			$select_type = '<select class="select-type" name= "'.esc_attr( $name.'['.$id.'][type]' ).'">';
			foreach( $sources as $key => $value ) {
				$select_type .= '<option value="'.$key.'" '.selected( $current_value, $key, false ).'>'.$value.'</option>';
			}
			$select_type .= '</select>';


			/*------------------------------------------------------*/
			/* Build <select> for external page
			/*------------------------------------------------------*/

			if( in_array ( 'page', $options ) ) {

				// Set default value
				if( is_array( $val ) && isset( $val['page'] ) )
					$current_value = $val['page'];
				else
					$current_value = null;

				// Get all pages from WP database
				$pages_select = array();
				$pages = get_pages();
				if( ! empty( $pages ) )
					foreach( $pages as $page )
						$pages_select[$page->post_name] = $page->post_title;
				else
					$pages_select['null'] = __( 'No pages exist.', 'radium' );
				break;

				// Build <select>
				if( ! empty( $pages_select ) ) {
					$select_page = '<select name= "'.esc_attr( $name.'['.$id.'][page]' ).'">';
					foreach( $pages_select as $key => $value ) {
						$select_page .= '<option value="'.$key.'" '.selected( $current_value, $key, false ).'>'.$value.'</option>';
					}
					$select_page .= '</select>';
				} else {
					$select_page = '<p class="warning">'.__( 'You haven\'t created any pages.', 'radium' ).'</p>';
				}

			}

			/*------------------------------------------------------*/
			/* Build raw content input
			/*------------------------------------------------------*/

			if( in_array ( 'raw', $options ) ) {

				// Set default value
				if( is_array( $val ) && isset( $val['raw'] ) )
					$current_value = stripslashes( $val['raw'] );
				else
					$current_value = null;

				$raw_content = '<textarea name="'.esc_attr( $name.'['.$id.'][raw]' ).'" class="of-input" cols="8" rows="8">'.$current_value.'</textarea>';

			}

			/*------------------------------------------------------*/
			/* Primary Output
			/*------------------------------------------------------*/

			$output = '<div class="column-content-types">';
			$output .= $select_type;

			if( in_array ( 'page', $options ) ) {
				$output .= '<div class="column-content-type column-content-type-page">';
				$output .= $select_page;
				$output .= '<p class="note">'.__( 'Select an external page to pull content from.', 'radium' ).'</p>';
				$output .= '</div>';
			}

			if( in_array ( 'raw', $options ) ) {
				$output .= '<div class="column-content-type column-content-type-raw">';
				$output .= $raw_content;
				$output .= '<p class="note">'.__( 'You can use basic HTML here, and most shortcodes.', 'radium' ).'</p>';
				$output .= '</div>';
			}

			$output .= '</div><!-- .column-content-types  -->';
		break;

		// Widgets
		case "widget_areas":

			global $wp_registered_sidebars;

			$output .= '<select class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '">';

			if ( is_array( $wp_registered_sidebars ) && ( count( $wp_registered_sidebars ) > 0 ) ) {

				foreach ( $wp_registered_sidebars as $sidebar => $registered_sidebar ) {
					$selected = '';
					 if( $val != '' ) {
						if ( $val ==  $registered_sidebar['id']) { $selected = ' selected="selected"';}
				 	}

					if ( false !== strpos( $registered_sidebar['class'], 'inactive-sidebar' ) || 'orphaned_widgets' == substr( $sidebar, 0, 16 ) )
						continue;

						$output .= '<option'. $selected .' value="' . esc_attr(  $registered_sidebar['id'] ) . '">' . esc_html( $registered_sidebar['name'] ) . '</option>';

				}
			}

			 $output .= '</select>';

		break;

		// Heading for Navigation
		case "heading":
			if ($counter >= 2) {
				$output .= '</div>'."\n";
			}
			$jquery_click_hook = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($value['name']) );
			$jquery_click_hook = "of-option-" . $jquery_click_hook . $counter;
			$menu .= '<a id="'.  esc_attr( $jquery_click_hook ) . '-tab" class="nav-tab" title="' . esc_attr( $value['name'] ) . '" href="' . esc_attr( '#'.  $jquery_click_hook ) . '">' . esc_html( $value['name'] ) . '</a>';
			$output .= '<div class="group" id="' . esc_attr( $jquery_click_hook ) . '">';
			$output .= '<h3>' . esc_html( $value['name'] ) . '</h3>' . "\n";
			break;

		}

		if ( ( $value['type'] != "heading" ) && ( $value['type'] != "info" ) ) {

			$output .= '</div></div><div class="clear"></div></div></div>'."\n";
		}
	}

	$output = apply_filters( 'radium_builder_option_type', $output, $value, $option_name, $val );

    if( $close )
    	$output .= '</div>';
    return array( $output, $menu );
}
