<?php
/**
 * Register Widgets Element
 * @return array();
 */
function radium_builder_registar_widgets_element( $elements ) {

	//Widgets
	$element_widgets = array(
		array(
			'name' 		=> 'Widget Area',
	    	'type'		=> 'subgroup_start',
	    	'class'		=> 'widgets',
 	    ),

		array(
			'id' 		=> 'widget_areas',
			'name'		=> __( 'Widget Areas', 'radium' ),
            'desc'      => __( 'You can use a predefided widget area (sidebar)  of create a new one just for this element in <strong>Appearance > Widget Areas </strong>', 'radium' ),
 			'type'		=> 'widget_areas',
 		),

		array(
	    	'type'		=> 'subgroup_end'
	    )
	);

	$elements['widgets'] = array(
		'info' => array(
			'name' 	=> 'Widget Area',
			'id'	=> 'widgets',
			'query'	=> 'none',
			'hook'	=> 'radium_widgets',
			'shortcode'	=> null,
			'desc' 	=> __( 'Set of tabbed content', 'radium' )
		),
		'options' => $element_widgets,
		'style' => apply_filters( 'radium_builder_element_style_config', array() ),
	);

	return $elements;

}
add_filter('radium_builder_elements', 'radium_builder_registar_widgets_element');
