<?php

/**
 * Register Blog Element
 * @return array();
 */
function radium_builder_registar_blog_latest_element( $elements ) {

	// Setup array for categories select
	$categories_select = array();
	$categories_select['all'] = __( 'All Categories', 'radium' );
	$categories = get_categories();
	foreach( $categories as $latest )
		$categories_select[$latest->slug] = $latest->name;

	// Setup array for categories group of checkboxes
	$categories_multicheck = $categories_select;
	unset( $categories_multicheck['null'] );
	
	// Post List (lead)
	$element_options = array(

        array(
            'id'        => 'title',
            'name'      => __( 'Category Title', 'radium' ),
            'desc'      => '',
            'type'      => 'text',
            'std'       => __('Latest News', 'radium')
        ),
        
        array(
            'id'        => 'active_tabs',
            'name'      => __( 'Tabs to show', 'radium' ),
            'desc'      => '',
            'type'      => 'multicheck',
            'options'       => array(
            	'latest' => __( 'Latest', 'radium' ),
            	'popular' => __( 'Popular', 'radium' ),
            	'featured' => __( 'Featured', 'radium' ),
             ),
            'std'       => array(
            	'latest' => '1',
            	'popular' => '1',
            	'featured' => '1'
             ),
        ),

	    array(
	    	'id' 		=> 'categories',
			'name'		=> __( 'Categories', 'radium' ),
			'desc'		=> __( 'Select the categories you\'d like to pull posts from. Note that selecting "All Categories" will override any other selections.', 'radium' ),
			'std'		=> array( 'all' => 1 ),
			'type'		=> 'select',
			'options'	=> $categories_multicheck
		),
        
        array(
        	'id' 		=> 'numberposts',
        	'name'		=> __( 'Number of Posts', 'radium' ),
        	'desc'		=> __( 'Enter in the <strong>total number</strong> of posts you\'d like to show. You can enter <em>-1</em> if you\'d like to show all posts.', 'radium' ),
        	'type'		=> 'text',
        	'std'		=> '4'
        ),

        array(
            'id'        => 'load_more',
            'name'      => __( 'Load more items', 'radium'),
            'desc'      => '',
            'type'      => 'checkbox'
        ),

        array(
            'id'        => 'load_more_text',
            'name'      => __( 'Load more button text', 'radium' ),
            'desc'      => '',
            'type'      => 'text',
            'std'       => __( 'Show More News', 'radium' ),
        ),

	);

	$elements['blog_latest'] = array(
			'info' => array(
				'name' 	=> 'Blog Latest',
				'id'	=> 'blog_latest',
                'cache' => true, //set to true to cache
				'desc' 	=> __( 'Blog Category', 'radium' )
			),
			'options' => $element_options,
            'style' => apply_filters( 'radium_builder_element_style_config', array() ),

		);

	return $elements;

}
add_filter('radium_builder_elements', 'radium_builder_registar_blog_latest_element');