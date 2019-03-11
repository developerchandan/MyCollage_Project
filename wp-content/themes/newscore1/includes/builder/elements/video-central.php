<?php
/**
 * Register Columns Element
 * @return array();
 */
function radium_builder_registar_radium_video_element( $elements ) {

	// bg_video
	$element_options = array(
		
		array(
			'id' 		=> 'popular_tab_title',
			'name'		=> __( 'Popular Videos Tab Title', 'radium' ),
			'desc'		=> __( '', 'radium' ),
			'std'		=> __( 'Popular Videos', 'radium'),
			'type'		=> 'text'
		),
		
		array(
			'id' 		=> 'latest_tab_title',
			'name'		=> __( 'Latest Videos Tab Title', 'radium' ),
			'desc'		=> __( '', 'radium' ),
			'std'		=> __( 'Recent Videos', 'radium'),
			'type'		=> 'text'
		),
		
	);

	$elements['radium_video'] = array(
		'info' => array(
			'name' 	=> 'Video Central',
			'id'	=> 'radium_video',
			'query'	=> 'none',
			'hook'	=> 'radium_radium_video_block',
			'shortcode'	=> '[radium_video]',
			'desc' 	=> __( 'radium video with optional button', 'radium' )
		),
		'options' => $element_options,
		'style' => apply_filters( 'radium_builder_element_style_config', array() ),
	);

	return $elements;

}
add_filter('radium_builder_elements', 'radium_builder_registar_radium_video_element');