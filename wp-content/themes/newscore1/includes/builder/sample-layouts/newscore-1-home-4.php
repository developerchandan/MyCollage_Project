<?php

/**
 * Get all sample layouts.
 *
 * @return array
 */

function radium_builder_newscore_1_home_4_samples( $samples ) {

	$framework = radium_framework();

	$samples['newscore_1_home_4'] = array(

		'name' => 'NewsCore 1 Homepage #4',
		'id' => 'newscore_1_home_4',
		'preview' => $framework->theme_includes_url . '/builder/assets/images/sample-layouts/1-home-4.png',

   		'featured' => array ( 'element_177887624553dc07b23c15a' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'content_grid_slider', 'query_type' => '', 'cache_id' => 'rm_element_177887624553dc07b23c15a', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'content_type' => 'post', 'title' => '', 'limit' => '16', 'carousel' => false, ), ), ),
   		'primary' => array ( 'element_166421327553dc08e82c4dc' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'blog_latest', 'query_type' => '', 'cache_id' => 'rm_element_166421327553dc08e82c4dc', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'title' => 'Latest News', 'categories' => 'all', 'numberposts' => '5', 'load_more' => '1', 'load_more_text' => 'Show More News', ), ), 'element_117870932453dc07bdb25d8' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'blog_category_small', 'query_type' => '', 'cache_id' => 'rm_element_117870932453dc07bdb25d8', 'cache' => '1', 'width' => 'element1-2', 'options' => array ( 'title' => 'Entertainment Category', 'categories' => 'entertainment', 'numberposts' => '5', ), ), 'element_194080332353dc07c7be734' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'blog_category_small', 'query_type' => '', 'cache_id' => 'rm_element_194080332353dc07c7be734', 'cache' => '1', 'width' => 'element1-2', 'options' => array ( 'title' => 'Food Category', 'categories' => 'food', 'numberposts' => '5', ), ), 'element_167534412653dc095745121' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'blog_category_small', 'query_type' => '', 'cache_id' => 'rm_element_167534412653dc095745121', 'cache' => '1', 'width' => 'element1-2', 'options' => array ( 'title' => 'TECH CATEGORY', 'categories' => 'technology', 'numberposts' => '5', ), ), 'element_98004986953dc0968c01c8' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'blog_category_small', 'query_type' => '', 'cache_id' => 'rm_element_98004986953dc0968c01c8', 'cache' => '1', 'width' => 'element1-2', 'options' => array ( 'title' => 'Games CATEGORY', 'categories' => 'games', 'numberposts' => '5', ), ), ),

	);

	return $samples;
}

add_filter('radium_sample_layouts', 'radium_builder_newscore_1_home_4_samples');