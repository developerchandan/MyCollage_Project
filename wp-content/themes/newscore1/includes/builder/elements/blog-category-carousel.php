<?php

/**
 * Register Blog Element
 *
 * @since 2.2.2
 *
 * @return array();
 */
function radium_builder_registar_blog_category_carousel_element( $elements ) {

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
            'id'        => 'title',
            'name'      => __( 'Category Title', 'radium' ),
            'desc'      => '',
            'type'      => 'text',
            'std'       => __('review News', 'radium')
        ),
 
        array(
            'id'        => 'numberposts',
            'name'      => __( 'Number of Posts', 'radium' ),
            'desc'      => __( 'Enter in the <strong>total number</strong> of posts you\'d like to show. You can enter <em>-1</em> if you\'d like to show all posts from the categories you\'ve selected.', 'radium' ),
            'type'      => 'text',
            'std'       => '6'
        ),

    );

    $elements['blog_review'] = array(
            'info' => array(
                'name'  => __('Blog Category Carousel', 'radium' ),
                'id'    => 'blog_category_carousel',
                'cache' => true, //set to true to cache
                'desc'  => __( 'Blog Category Carousel', 'radium' )
            ),
            'options' => $element_options,
            'style' => apply_filters( 'radium_builder_element_style_config', array() ),

        );

    return $elements;

}
add_filter('radium_builder_elements', 'radium_builder_registar_blog_category_carousel_element');