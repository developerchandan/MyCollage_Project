<?php
 	
/** 
 * Register revolution slider into the layout builder.
 * @return array();
 * Added with priority of 11, 
 */
function radium_builder_registar_rev_slider_element( $elements ) {
	
	//Select Slider
	$slider_select = array();
 
	$sliders = new RevSlider();
	$arrSliders = $sliders->getArrSliders();

	if( ! empty( $sliders ) ) {
		foreach( $arrSliders as $slider ) {
			
			$slider_alias = $slider->getAlias();
			$slider_select[$slider_alias] = $slider->getTitle();
  			
		}
	} else {
		$alias['null'] = __( 'You haven\'t created any slider yet.', 'radium' );
	}
	
	// Slider
	$element_slider = array(
	    array(
	    	'id' 		=> 'slider_alias',
	    	'name'		=> __( 'Select Slider', 'radium' ),
	    	'desc'		=> __( 'Choose the slider you\'d like to display.', 'radium' ),
	    	'type'		=> 'select',
	    	'options'	=> $slider_select,
	    	'class'		=> 'slider-content'
	    )
	);
	
	$elements['rev_slider'] = array(
		'info' => array(
			'name' 	=> 'Revolution Slider',
			'id'	=> 'rev_slider',
			'query'	=> 'none',
			'hook'	=> 'radium_rev_slider_block',
			'shortcode'	=> '[rev_slider]',
			'desc' 	=> __( 'Revolution Slider', 'radium' )
		),
		'options' => $element_slider
	);
	
	return $elements;
	
}
add_filter('radium_builder_elements', 'radium_builder_registar_rev_slider_element', 11);	

/**
 * Integrate revolution slider into the layout builder.
 *
 * @since 2.1.0
 *
 * @param string $slider Slug of custom-built slider to use
 */

if( ! function_exists( 'radium_builder_rev_slider_element' ) ) {
	function radium_builder_rev_slider_element(  $id, $settings, $location ) {
	
		// Die if there's no slider
		if( $settings['slider_alias'] ) { ?>
			
			<div class="loading radium_slider_wrapper_outer">
			
				<?php echo do_shortcode('[rev_slider '.$settings['slider_alias'].']'); ?>
			
			</div>
			
		<?php } else {
 			
 			echo '<div class="messageBox warning">'.__( 'Oops! You have not selected a slider to display yet.', 'radium' ).'</div>';
 			
 			return;
		}
		
	}
}

add_action('radium_builder_rev_slider', 'radium_builder_rev_slider_element', 10, 3);