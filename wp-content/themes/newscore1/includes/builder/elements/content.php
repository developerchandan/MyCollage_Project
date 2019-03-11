<?php
/** 
 * Register Columns Element
 * @return array();
 */
function radium_builder_registar_content_element( $elements ) {

	// Setup array for pages select
	$pages_select = array();
	$pages = get_pages();
	if( ! empty( $pages ) )
		foreach( $pages as $page )
			$pages_select[$page->post_name] = $page->post_title;
	else
		$pages_select['null'] = __( 'No pages exist.', 'radium' );

 	// Content
	$element_content = array(
	    array(
	    	'type'		=> 'subgroup_start'
	    ),
	    array(
	    	'id' 		=> 'source',
			'name'		=> __( 'Content Source', 'radium' ),
			'desc'		=> __( 'Choose where you\'d like to have content pulled from. The content can either be from the current page you\'re applying this layout to, an external page or custom content.', 'radium' ),
			'type'		=> 'select',
			'options'	=> array(
				'current' 	=> __( 'Content from current page', 'radium' ),
		        'external' 	=> __( 'Content from another page', 'radium' ),
		        'raw'		=> __( 'Custom content', 'radium' )
			),
			'class'		=> 'custom-content-types'
		),
		array(
	    	'id' 		=> 'page_id',
			'name'		=> __( 'External Page', 'radium' ),
			'desc'		=> __( 'Choose the external page you\'d like to pull content from.', 'radium' ),
			'type'		=> 'select',
			'options'	=> $pages_select,
			'class'		=> 'hide page-content'
		),
		array(
	    	'id' 		=> 'raw_content',
			'name'		=> __( 'Custom Content', 'radium' ),
			'desc'		=> __( 'Enter in the content you\'d like to show. You may use basic HTML, and most shortcode.', 'radium' ),
			'type'		=> 'textarea',
			'class'		=> 'hide raw-content',
 			
		),
		array(
	    	'type'		=> 'subgroup_end'
	    )
	);
	
	$elements['content'] = array(
			'info' => array(
			'name' 	=> 'Content',
			'id'	=> 'content',
			'query'	=> 'none',
			'hook'	=> null,
			'shortcode'	=> false,
			'desc' 	=> __( 'Content from external page or current page', 'radium' )
		),
		'options' => $element_content,
		'style' => apply_filters( 'radium_builder_element_style_config', array() ),
	);
	
	return $elements;
	
}
add_filter('radium_builder_elements', 'radium_builder_registar_content_element');	