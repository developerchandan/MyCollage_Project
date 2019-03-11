<?php
/** 
 * Register Columns Element
 * @return array();
 */
function radium_builder_registar_divider_element( $elements ) {

	// Divider
	$element_divider = array(
	    array(
	    	'id' 		=> 'type',
			'name'		=> __( 'Divider Type', 'radium' ),
			'desc'		=> __( 'Select which style of divider you\'d like to use here.', 'radium' ),
			'type'		=> 'select',
			'options'		=> array(
				'' 	=> __( 'Default Line', 'radium' ),
		        'dashed' 	=> __( 'Dashed Line', 'radium' ),
 				'solid' 	=> __( 'Solid Line', 'radium' ),
 				'hidden' 	=> __( 'Hidden Divider', 'radium' )
 				
			) 
		)
	);
	
	$elements['divider'] = array(
		'info' => array(
			'name' 	=> 'Divider',
			'id'	=> 'divider',
			'query'	=> 'none',
			'hook'	=> 'radium_divider',
			'shortcode'	=> '[divider]',
			'desc' 	=> __( 'Simple divider line to break up content', 'radium' )
		),
		'options' => $element_divider,
		'style' => apply_filters( 'radium_builder_element_style_config', array() ),
		
	);
	
	return $elements;
	
}
add_filter('radium_builder_elements', 'radium_builder_registar_divider_element');	