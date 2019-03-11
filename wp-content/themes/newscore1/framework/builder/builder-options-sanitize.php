<?php
/* Text */
add_filter( 'radium_opt_sanitize_url', 'radium_opt_sanitize_url' );

/* Textarea */
function radium_opt_sanitize_url($url) {
	
	$output = esc_url_raw($url);
	
	return $output;
}

/* Text */
add_filter( 'radium_opt_sanitize_text', 'radium_opt_sanitize_textarea' );

/* Textarea */
function radium_opt_sanitize_textarea($input) {
	if ( current_user_can( 'unfiltered_html' ) ) {
		$output = $input;
	}
	else {
		global $allowedtags;
		$output = wpautop(wp_kses( $input, $allowedtags));
	}
	return $output;
}

add_filter( 'radium_opt_sanitize_textarea', 'radium_opt_sanitize_textarea' );

/* Select */

add_filter( 'radium_opt_sanitize_select', 'radium_opt_sanitize_enum', 10, 2);

/* Radio */

add_filter( 'radium_opt_sanitize_radio', 'radium_opt_sanitize_enum', 10, 2);
add_filter( 'radium_opt_sanitize_radio_img', 'radium_opt_sanitize_enum', 10, 2);

/* Images */

add_filter( 'radium_opt_sanitize_images', 'radium_opt_sanitize_enum', 10, 2);

/* Checkbox */

function radium_opt_sanitize_checkbox( $input ) {
	if ( $input ) {
		$output = '1';
	} else {
		$output = false;
	}
	return $output;
}
add_filter( 'radium_opt_sanitize_checkbox', 'radium_opt_sanitize_checkbox' );

/* Multicheck */

function radium_opt_sanitize_multicheck( $input, $option ) {
	$output = '';
	if ( is_array( $input ) ) {
		foreach( $option['options'] as $key => $value ) {
			$output[$key] = "0";
		}
		foreach( $input as $key => $value ) {
			if ( array_key_exists( $key, $option['options'] ) && $value ) {
				$output[$key] = "1";
			}
		}
	}
	return $output;
}
add_filter( 'radium_opt_sanitize_multicheck', 'radium_opt_sanitize_multicheck', 10, 2 );

/* Color Picker */

add_filter( 'radium_opt_sanitize_color', 'radium_opt_sanitize_hex' );

/* Uploader */

function radium_opt_sanitize_upload( $input ) {
	$output = '';
	$filetype = wp_check_filetype($input);
	if ( $filetype["ext"] ) {
		$output = $input;
	}
	return $output;
}
add_filter( 'radium_opt_sanitize_upload', 'radium_opt_sanitize_upload' );

/* Editor */

function radium_opt_sanitize_editor($input) {
	if ( current_user_can( 'unfiltered_html' ) ) {
		$output = $input;
	}
	else {
		global $allowedtags;
		$output = wpautop(wp_kses( $input, $allowedtags));
	}
	return $output;
}
add_filter( 'radium_opt_sanitize_editor', 'radium_opt_sanitize_editor' );

/* Allowed Tags */

function radium_opt_sanitize_allowedtags($input) {
	global $allowedtags;
	$output = wpautop(wp_kses( $input, $allowedtags));
	return $output;
}

/* Allowed Post Tags */

function radium_opt_sanitize_allowedposttags($input) {
	global $allowedposttags;
	$output = wpautop(wp_kses( $input, $allowedposttags));
	return $output;
}

add_filter( 'radium_opt_sanitize_info', 'radium_opt_sanitize_allowedposttags' );


/* Check that the key value sent is valid */

function radium_opt_sanitize_enum( $input, $option ) {
	$output = '';
	if ( array_key_exists( $input, $option['options'] ) ) {
		$output = $input;
	}
	return $output;
}

/* Background */

function radium_opt_sanitize_background( $input ) {
	$output = wp_parse_args( $input, array(
		'color' => '',
		'image'  => '',
		'repeat'  => 'repeat',
		'position' => 'top center',
		'attachment' => 'scroll'
	) );

	$output['color'] = apply_filters( 'radium_opt_sanitize_hex', $input['color'] );
	$output['image'] = apply_filters( 'radium_opt_sanitize_upload', $input['image'] );
	$output['repeat'] = apply_filters( 'radium_opt_background_repeat', $input['repeat'] );
	$output['position'] = apply_filters( 'radium_opt_background_position', $input['position'] );
	$output['attachment'] = apply_filters( 'radium_opt_background_attachment', $input['attachment'] );

	return $output;
}
add_filter( 'radium_opt_sanitize_background', 'radium_opt_sanitize_background' );

function radium_opt_sanitize_background_repeat( $value ) {
	$recognized = radium_opt_recognized_background_repeat();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'radium_opt_default_background_repeat', current( $recognized ) );
}
add_filter( 'radium_opt_background_repeat', 'radium_opt_sanitize_background_repeat' );

function radium_opt_sanitize_background_position( $value ) {
	$recognized = radium_opt_recognized_background_position();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'radium_opt_default_background_position', current( $recognized ) );
}
add_filter( 'radium_opt_background_position', 'radium_opt_sanitize_background_position' );

function radium_opt_sanitize_background_attachment( $value ) {
	$recognized = radium_opt_recognized_background_attachment();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'radium_opt_default_background_attachment', current( $recognized ) );
}
add_filter( 'radium_opt_background_attachment', 'radium_opt_sanitize_background_attachment' );


/* Typography */

function radium_opt_sanitize_typography( $input, $option ) {

	$output = wp_parse_args( $input, array(
		'size'  => '',
		'face'  => '',
		'style' => '',
		'color' => ''
	) );

	if ( isset( $option['options']['faces'] ) && isset( $input['face'] ) ) {
		if ( !( array_key_exists( $input['face'], $option['options']['faces'] ) ) ) {
			$output['face'] = '';
		}
	}
	else {
		$output['face']  = apply_filters( 'radium_opt_font_face', $output['face'] );
	}

	$output['size']  = apply_filters( 'radium_opt_font_size', $output['size'] );
	$output['style'] = apply_filters( 'radium_opt_font_style', $output['style'] );
	$output['color'] = apply_filters( 'radium_opt_sanitize_color', $output['color'] );
	return $output;
}
add_filter( 'radium_opt_sanitize_typography', 'radium_opt_sanitize_typography', 10, 2 );

function radium_opt_sanitize_font_size( $value ) {
	$recognized = radium_opt_recognized_font_sizes();
	$value_check = preg_replace('/px/','', $value);
	if ( in_array( (int) $value_check, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'radium_opt_default_font_size', $recognized );
}
add_filter( 'radium_opt_font_size', 'radium_opt_sanitize_font_size' );


function radium_opt_sanitize_font_style( $value ) {
	$recognized = radium_opt_recognized_font_styles();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'radium_opt_default_font_style', current( $recognized ) );
}
add_filter( 'radium_opt_font_style', 'radium_opt_sanitize_font_style' );


function radium_opt_sanitize_font_face( $value ) {
	$recognized = radium_opt_recognized_font_faces();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'radium_opt_default_font_face', current( $recognized ) );
}
add_filter( 'radium_opt_font_face', 'radium_opt_sanitize_font_face' );

/**
 * Get recognized background repeat settings
 *
 * @return   array
 *
 */
function radium_opt_recognized_background_repeat() {
	$default = array(
		'no-repeat' => __('No Repeat', 'radium'),
		'repeat-x'  => __('Repeat Horizontally', 'radium'),
		'repeat-y'  => __('Repeat Vertically', 'radium'),
		'repeat'    => __('Repeat All', 'radium'),
		);
	return apply_filters( 'radium_opt_recognized_background_repeat', $default );
}

/**
 * Get recognized background positions
 *
 * @return   array
 *
 */
function radium_opt_recognized_background_position() {
	$default = array(
		'top left'      => __('Top Left', 'radium'),
		'top center'    => __('Top Center', 'radium'),
		'top right'     => __('Top Right', 'radium'),
		'center left'   => __('Middle Left', 'radium'),
		'center center' => __('Middle Center', 'radium'),
		'center right'  => __('Middle Right', 'radium'),
		'bottom left'   => __('Bottom Left', 'radium'),
		'bottom center' => __('Bottom Center', 'radium'),
		'bottom right'  => __('Bottom Right', 'radium')
		);
	return apply_filters( 'radium_opt_recognized_background_position', $default );
}

/**
 * Get recognized background attachment
 *
 * @return   array
 *
 */
function radium_opt_recognized_background_attachment() {
	$default = array(
		'scroll' => __('Scroll Normally', 'radium'),
		'fixed'  => __('Fixed in Place', 'radium')
		);
	return apply_filters( 'radium_opt_recognized_background_attachment', $default );
}

/**
 * Sanitize a color represented in hexidecimal notation.
 *
 * @param    string    Color in hexidecimal notation. "#" may or may not be prepended to the string.
 * @param    string    The value that this function should return if it cannot be recognized as a color.
 * @return   string
 *
 */

function radium_opt_sanitize_hex( $hex, $default = '' ) {
	if ( radium_opt_validate_hex( $hex ) ) {
		return $hex;
	}
	return $default;
}

/**
 * Get recognized font sizes.
 *
 * Returns an indexed array of all recognized font sizes.
 * Values are integers and represent a range of sizes from
 * smallest to largest.
 *
 * @return   array
 */

function radium_opt_recognized_font_sizes() {
	$sizes = range( 9, 71 );
	$sizes = apply_filters( 'radium_opt_recognized_font_sizes', $sizes );
	$sizes = array_map( 'absint', $sizes );
	return $sizes;
}

/**
 * Get recognized font faces.
 *
 * Returns an array of all recognized font faces.
 * Keys are intended to be stored in the database
 * while values are ready for display in in html.
 *
 * @return   array
 *
 */
function radium_opt_recognized_font_faces() {
	$default = array(
		'arial'     => 'Arial',
		'verdana'   => 'Verdana, Geneva',
		'trebuchet' => 'Trebuchet',
		'georgia'   => 'Georgia',
		'times'     => 'Times New Roman',
		'tahoma'    => 'Tahoma, Geneva',
		'palatino'  => 'Palatino',
		'helvetica' => 'Helvetica*'
		);
	return apply_filters( 'radium_opt_recognized_font_faces', $default );
}

/**
 * Get recognized font styles.
 *
 * Returns an array of all recognized font styles.
 * Keys are intended to be stored in the database
 * while values are ready for display in in html.
 *
 * @return   array
 *
 */
function radium_opt_recognized_font_styles() {
	$default = array(
		'normal'      => __('Normal', 'radium'),
		'italic'      => __('Italic', 'radium'),
		'bold'        => __('Bold', 'radium'),
		'bold italic' => __('Bold Italic', 'radium')
		);
	return apply_filters( 'radium_opt_recognized_font_styles', $default );
}

/**
 * Is a given string a color formatted in hexidecimal notation?
 *
 * @param    string    Color in hexidecimal notation. "#" may or may not be prepended to the string.
 * @return   bool
 *
 */

function radium_opt_validate_hex( $hex ) {
	$hex = trim( $hex );
	/* Strip recognized prefixes. */
	if ( 0 === strpos( $hex, '#' ) ) {
		$hex = substr( $hex, 1 );
	}
	elseif ( 0 === strpos( $hex, '%23' ) ) {
		$hex = substr( $hex, 3 );
	}
	/* Regex match. */
	if ( 0 === preg_match( '/^[0-9a-fA-F]{6}$/', $hex ) ) {
		return false;
	}
	else {
		return true;
	}
}


/* Dynamic Content */

function radium_opt_sanitize_content( $input ) {
	if ( current_user_can( 'unfiltered_html' ) ) {
		$output = $input;
	}
	else {
		global $allowedtags;
		$output = wpautop(wp_kses( $input, $allowedtags));
	}	
}

add_filter( 'radium_opt_sanitize_content', 'radium_opt_sanitize_content' );

/* Info */
add_filter( 'radium_opt_sanitize_info', 'radium_opt_sanitize_allowedtags' );

/* Widget Areas */
function radium_opt_sanitize_widget_areas( $input ) {
	return $input;	
}
add_filter( 'radium_opt_sanitize_widget_areas', 'radium_opt_sanitize_widget_areas');
 
