<?php
/**
 * Register content_slider Element
 * @return array();
 */
function radium_builder_registar_content_slider_element( $elements ) {
	
	// Setup array for categories select
	$categories_select = array();
	$categories_select['all'] = __( 'All Categories', 'radium' );
	$categories = get_categories();
	foreach( $categories as $category )
		$categories_select[$category->slug] = $category->name;

	// Setup array for categories group of checkboxes
	$categories_multicheck = $categories_select;
	unset( $categories_multicheck['null'] );

	//Carousel
	$element_options = array(

		array(
			'id'		=> 'content_type',
			'name'		=> __( 'Select Post Type', 'radium' ),
			'desc'		=> __( '' , 'radium' ),
			'std'		=> 'post',
			'type'		=> 'select',
			'options'	=> array(
		        'post'		=> __( 'Posts', 'radium' ),
 			)
		),
		array(
			'id' 		=> 'title',
			'name'		=> __( 'Title', 'radium' ),
			'desc'		=> __( '', 'radium' ),
			'std'		=> '',
			'type'		=> 'text'
		),
		array(
			'id' 		=> 'content_source',
			'name'		=> __( 'Posts Source', 'radium' ),
			'desc'		=> __( 'Select where this element should get content from.', 'radium' ),
			'type'		=> 'select',
			'options'		=> array(
				'category' 	=> __( 'Category', 'radium' ),
				'featured' 	=> __( 'Featured Posts', 'radium' ),
				'carousel' 	=> __( 'Posts assigned to Carousel', 'radium' )
			) 
		),
		
		'subgroup_start_1' => array(
			'type'		=> 'subgroup_start',
			'class'		=> 'show-toggle'
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
			'id' 		=> 'limit',
			'name'		=> __( 'How many items to show', 'radium' ),
			'desc'		=> __( '', 'radium' ),
			'std'		=> 16,
			'type'		=> 'text'
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
			'id' 		=> 'offset',
			'name'		=> __( 'Offset', 'radium' ),
			'desc'		=> __( 'Enter the number of posts you\'d like to offset the query by. In most cases, you will just leave this at <em>0</em>. Utilizing this option could be useful, for example, if you wanted to have the first post in an element above this one, and then you could offset this set by <em>1</em> so the posts start after that post in the previous element. If that makes no sense, just ignore this option and leave it at <em>0</em>!', 'radium' ),
			'type'		=> 'text',
			'std'		=> '0',
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
		
		/* array(
			'id' 		=> 'slider_nav',
			'name'		=> __( 'Slider Nav', 'radium' ),
			'desc'		=> __( 'How to display the slider navigation', 'radium' ),
			'type'		=> 'select',
			'options'		=> array(
				'none' 		=> __( 'None', 'radium' ),
				'left' 		=> __( 'Left', 'radium' ),
				'right' 	=> __( 'Right', 'radium' ),
				'bottom' 	=> __( 'Bottom', 'radium' )
			),
			'std' => 'none'
		), */

	);

	$elements['content_slider'] = array(
		'info' => array(
			'name' 	=> 'Content Slider',
			'id'	=> 'content_slider',
            'cache' => true,
			'desc' 	=> __( 'Sliding content', 'radium' )
		),
		'options' => $element_options,
		'style' => apply_filters( 'radium_builder_element_style_config', array() ),

	);

	return $elements;

}
add_filter('radium_builder_elements', 'radium_builder_registar_content_slider_element');
