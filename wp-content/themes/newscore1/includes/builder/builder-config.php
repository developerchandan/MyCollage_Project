<?php
/**
 * Register Thene Specific Builder JS
 * @return null
 */
function radium_theme_builder_js() {

 	$framework = radium_framework(); //Get framework globals

 	wp_enqueue_script( 'radium-builder-theme-script', $framework->theme_includes_url .'/builder/assets/admin/js/builder.js', 	array('jquery') );

}
add_action( 'admin_enqueue_scripts', 'radium_theme_builder_js' );

/**
 * Register Builder Elements Configuration Functions
 * Add Elements Filter to allow customization
 * @return array
 */
function radium_builder_elements() {

	$elements = apply_filters( 'radium_builder_elements', array() );

	return $elements;
}

/**
 * Include Elements
 * loaded on init in Radium_Builder class
 */
function radium_builder_load_elements() {

    include('elements/blog.php');
    include('elements/blog-category-small.php');
    include('elements/blog-latest.php');
    include('elements/blog-review.php');
	include('elements/content.php');
	include('elements/content-grid-slider.php');
    include('elements/content-slider.php');
    include('elements/content-carousel.php');
    include('elements/content-carousel-big.php');
	include('elements/divider.php');
    include('elements/video-central.php');
	include('elements/widget-areas.php');
    include('elements/events.php');
    
}

/**
 * Register Builder Sample Layouts.
 * Add Sample Filter to allow customization
 * @return array
 */

function radium_builder_samples() {

	$samples = array();

	return apply_filters( 'radium_sample_layouts', $samples );
}

/**
 * Include Sample Layouts
 * loaded on init in Radium_Builder class
 */
function radium_builder_load_samples() {

	include('sample-layouts/blank.php'); //blank slate
	include('sample-layouts/newscore-1-home-1.php');
	include('sample-layouts/newscore-1-home-2.php');
	include('sample-layouts/newscore-1-home-3.php');
	include('sample-layouts/newscore-1-home-4.php');
	include('sample-layouts/newscore-2-home-1.php');
	include('sample-layouts/newscore-2-home-2.php');
	include('sample-layouts/newscore-2-home-3.php');
	include('sample-layouts/newscore-3-home-1.php');
	include('sample-layouts/newscore-3-home-2.php');
	include('sample-layouts/newscore-3-home-3.php');
	include('sample-layouts/contact-1.php');

}

/**
 * Register Builder ELement Style fields.
 * Add Sample Filter to allow customization
 * @return array
 */

function radium_builder_element_style_config() {

	$style_config = array(

		array(
			'id' 		=> 'style_info',
			'name' 		=> __( '', 'radium'),
			'desc'		=> __( 'The styling of first item will be used to configure the row.', 'radium'),
			'type'		=> 'info',
 		),

		array(
			'id' 		=> 'width',
			'name'		=> __( 'Choose row layout', 'radium' ),
			'desc'		=> __( 'This applies to fullwidth elements', 'radium' ),
			'type'		=> 'select',
			'options'	=> array(
 		        'boxed' 	=> __( 'Box Content In', 'radium' ),
		        'fullwidth' => __( 'Fullwidth', 'radium' )
			),
		),

		array(
			'name' => __('Classs(es)', 'radium'),
			'desc' => __('Space separated classes. These can be used for additional styling.', 'radium'),
			'id' => 'class',
			'std' => '',
			'type' => 'text',
		),
 		array(
			'name' => __('Background Image:', 'radium'),
			'desc' => __('Full image url', 'radium'),
			'id' => 'bg_image',
			'std' => '',
			'type' => 'upload',
		),
		array(
			'id' 		=> 'bg_style',
			'name'		=> __( 'Background Image Settings', 'radium' ),
			'desc'		=> __( '', 'radium' ),
			'type'		=> 'select',
			'options'	=> array(
				'repeat' 	=> __( 'repeat', 'radium' ),
		        'no-repeat' 	=> __( 'no repeat', 'radium' ),
		        'fullwidth'		=> __( 'fullwidth', 'radium' )
			),
		),
		array(
			'name' => __('Background Color', 'radium'),
			'desc' => __('Use color name, color hex value or rgba value eg #fefefe, blue or rgba(255, 255, 255, 1)', 'radium'),
			'id' => 'bg_color',
			'std' => '',
			'type' => 'text',
		),
		array(
			'name' => __('Top Padding', 'radium'),
			'desc' => __('In pixel eg 20px', 'radium'),
			'id' => 'top_padding',
			'std' => '',
			'type' => 'text',
		),
		array(
			'name' => __('Bottom Padding', 'radium'),
			'desc' => __('In pixel eg 20px', 'radium'),
			'id' => 'bottom_padding',
			'std' => '',
			'type' => 'text',
		),
		array(
			'name' => __('Top Margin', 'radium'),
			'desc' => __('In pixel eg 20px', 'radium'),
			'id' => 'top_margin',
			'std' => '',
			'type' => 'text',
		),
		array(
			'name' => __('Bottom Margin', 'radium'),
			'desc' => __('In pixel eg 20px', 'radium'),
			'id' => 'bottom_margin',
			'std' => '',
			'type' => 'text',
		),

	);

	return $style_config;
}

add_filter( 'radium_builder_element_style_config', 'radium_builder_element_style_config' );
