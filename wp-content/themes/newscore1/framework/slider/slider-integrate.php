<?php

/** 
 * Register Columns Element
 * @return array();
 */
function radium_builder_registar_slider_element( $elements ) {
	
	//Select Slider
	$sliders_select = array();
	
	$slider = get_posts( 'post_type=slider&numberposts=-1' );
	if( ! empty( $slider ) )
		foreach( $slider as $k )
			$sliders_select[$k->post_name] = $k->post_title;
	else
		$sliders_select['null'] = __( 'You haven\'t created any slider yet.', 'radium' );
					
	// Slider
	$element_slider = array(
	    array(
	    	'id' 		=> 'slider_id',
	    	'name'		=> __( 'Select Slider', 'radium' ),
	    	'desc'		=> __( 'Choose the slider you\'d like to show.', 'radium' ),
	    	'type'		=> 'select',
	    	'options'	=> $sliders_select,
	    	'class'		=> 'slider-content'
	    )
	);
	
	$elements['slider'] = array(
		'info' => array(
			'name' 	=> 'Slider',
			'id'	=> 'slider',
			'query'	=> 'none',
			'hook'	=> 'radium_slider_block',
			'shortcode'	=> '[slider]',
			'desc' 	=> __( 'Slider', 'radium' )
		),
		'options' => $element_slider,
		'style' => apply_filters( 'radium_builder_element_style_config', array() ),
		
	);
	
	return $elements;
	
}
add_filter('radium_builder_elements', 'radium_builder_registar_slider_element');	

/**
 * Display slider.
 *
 * @since 2.1.0
 *
 * @param string $slider Slug of custom-built slider to use
 */

if( ! function_exists( 'radium_builder_slider_element' ) ) {
	function radium_builder_slider_element(  $id, $settings, $location ) {
	
		// Die if there's no slider
		if( $settings['slider_id'] ) {
			
			echo do_shortcode('[slider id="'.$settings['slider_id'].'"]');
			
		} else {
 			
 			echo '<div class="messageBox warning">'.__( 'Oops! You have not selected a slider in your layout.', 'radium' ).'</div>';
 			
 			return;
		}
		
	}
}

add_action('radium_builder_slider', 'radium_builder_slider_element', 10, 3);