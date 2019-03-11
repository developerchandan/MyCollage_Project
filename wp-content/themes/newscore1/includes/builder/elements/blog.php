<?php

/**
 * Register Blog Element
 * @return array();
 */
function radium_builider_registar_blog_element( $elements ) {

	// Setup array for categories select
	$categories_select = array();
	$categories_select['all'] = __( 'All Categories', 'radium' );
	$categories = get_categories();
	foreach( $categories as $category )
		$categories_select[$category->slug] = $category->name;

	// Setup array for categories group of checkboxes
	$categories_multicheck = $categories_select;
	unset( $categories_multicheck['null'] );

	// Post List (lead)
	$element_options = array(
		array(
			'id' 		=> 'title',
			'name'		=> __( 'Title', 'radium' ),
			'desc'		=> __( '', 'radium' ),
			'std'		=> '',
			'type'		=> 'text'
		),

 		'subgroup_start_1' => array(
 			'type'		=> 'subgroup_start',
 			'class'		=> 'show--toggle'
 		),
 		array(
 			'id' 		=> 'categories',
 			'name'		=> __( 'Categories', 'radium' ),
 			'desc'		=> __( 'Select the categories you\'d like to pull posts from. Note that selecting "All Categories" will override any other selections.', 'radium' ),
 			'std'		=> array( 'all' => 1 ),
 			'type'		=> 'multicheck',
 			'options'	=> $categories_multicheck
 		),
		array(
	    	'id' 		=> 'numberposts',
			'name'		=> __( 'Number of Posts', 'radium' ),
			'desc'		=> __( 'Enter in the <strong>total number</strong> of posts you\'d like to show. You can enter <em>-1</em> if you\'d like to show all posts.', 'radium' ),
			'type'		=> 'text',
			'std'		=> '6'
		),
		array(
			'id' 		=> 'orderby',
			'name'		=> __( 'Order By', 'radium' ),
			'desc'		=> __( 'Select what attribute you\'d like the posts ordered by.', 'radium' ),
			'type'		=> 'select',
			'std'		=> 'date',
			'options'	=> array(
		        'date' 			=> __( 'Publish Date', 'radium' ),
		        'title' 		=> __( 'Post Title', 'radium' ),
		        'comment_count' => __( 'Number of Comments', 'radium' ),
		        'rand' 			=> __( 'Random', 'radium' )
			),
		),
		array(
			'id' 		=> 'order',
			'name'		=> __( 'Order', 'radium' ),
			'desc'		=> __( 'Select the order in which you\'d like the posts displayed based on the previous orderby parameter.<br><br><em>Note that a traditional WordPress setup would have posts ordered by <strong>Publish Date</strong> and be ordered <strong>Descending</strong>.</em>', 'radium' ),
			'type'		=> 'select',
			'std'		=> 'DESC',
			'options'	=> array(
		        'DESC' 	=> __( 'Descending (highest to lowest)', 'radium' ),
		        'ASC' 	=> __( 'Ascending (lowest to highest)', 'radium' )
			),
		),
        array(
            'id'        => 'offset',
            'name'      => __( 'Offset', 'radium' ),
            'desc'      => __( 'Enter the number of posts you\'d like to offset the query by. In most cases, you will just leave this at <em>0</em>. Utilizing this option could be useful, for example, if you wanted to have the first post in an element above this one, and then you could offset this set by <em>1</em> so the posts start after that post in the previous element. If that makes no sense, just ignore this option and leave it at <em>0</em>!', 'radium' ),
            'type'      => 'text',
            'std'       => '0',
        ),
		array(
			'id' 		=> 'exclude',
			'name'		=> __( 'Exclude', 'radium' ),
			'desc'		=> __( 'Enter the ids of posts you would like to exclude from this query. Comma Separated eg: 1, 2, 3, 4', 'radium' ),
			'type'		=> 'text',
			'std'		=> '',
		),
		'subgroup_end_1' => array(
			'type'		=> 'subgroup_end'
		),

	 	array(
	 		'id'		=> 'ctp_page_columns',
	 		'name'		=> __( 'Number of columns ', 'radium' ),
	 		'desc'		=> __( '' , 'radium' ),
	 		'std'		=> 'three-columns',
	 		'type'		=> 'select',
	 		'options'			=> array(
	 	       //'modern-grid' => 'Modern Grid',
	 	       'two-columns' => 'Two Columns',
	 	       'three-columns' => 'Three Columns',
	 	       //'one-column' => 'One Column',
	 	       'small-thumbs' => 'One Column with small thumbs',
	 		)
	 	),

	 	array(
	 		'id' 		=> 'show_excerpt',
	 		'name'		=> __( 'Enable Excerpt', 'radium' ),
	 		'desc'		=> '',
	 		'std'		=> 1,
	 		'type'		=> 'checkbox'
	 	),

	 	array(
	 		'id' 		=> 'readmore',
	 		'name'		=> __( 'Enable "load more" button', 'radium' ),
	 		'desc'		=> '',
	 		'std'		=> 1,
	 		'type'		=> 'checkbox'
	 	),

        array(
            'id'        => 'load_more_text',
            'name'      => __( 'Load more button text', 'radium' ),
            'desc'      => '',
            'type'      => 'text',
            'std'       => __( 'Load More Posts', 'radium' ),
        ),

	);


	$elements['blog'] = array(
			'info' => array(
				'name' 	=> 'Blog',
				'id'	=> 'blog',
				'cache'	=> true,
				'desc' 	=> __( 'Blog content', 'radium' )
			),
			'options' => $element_options,
            'style' => apply_filters( 'radium_builder_element_style_config', array() ),

		);

	return $elements;

}
add_filter('radium_builder_elements', 'radium_builider_registar_blog_element');