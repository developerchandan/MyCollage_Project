<?php

/**
 * Get all sample layouts.
 *
 * @return array
 */

function radium_builder_newscore_1_home_1_samples( $samples ) {

	$framework = radium_framework();

	$samples['newscore_1_home_1'] = array(
	
	'name' => 'NewsCore 1 Homepage #1',
	'id' => 'newscore_1_home_1',
	'preview' => $framework->theme_includes_url . '/builder/assets/images/sample-layouts/1-home-1.png',

	'featured' => array ( 'element_5818779985399a53e26b65' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'content_grid_slider', 'query_type' => '', 'cache_id' => 'rm_element_5818779985399a53e26b65', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'content_type' => 'post', 'title' => '', 'limit' => '16', 'carousel' => '1', ), ), ),

  'primary' => array ( 'element_123188302052ff3498c9040' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'blog_latest', 'query_type' => '', 'cache_id' => 'rm_element_123188302052ff3498c9040', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'title' => 'Entertainment', 'categories' => 'entertainment', 'numberposts' => '4', 'load_more' => '1', 'load_more_text' => 'Show More News', ), ), 'element_1357821974530894b46d972' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'content_slider', 'query_type' => '', 'cache_id' => 'rm_element_1357821974530894b46d972', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'content_type' => 'post', 'title' => 'Featured Gallery Post', 'limit' => '16', ), ), 'element_1334119280530b5fe696fe3' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'blog_review', 'query_type' => '', 'cache_id' => 'rm_element_1334119280530b5fe696fe3', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'title' => 'Latest Reviews', 'numberposts' => '6', ), ), 'element_21391374185308aae69f73d' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => 'black', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'radium_video', 'query_type' => 'none', 'cache_id' => '', 'cache' => '', 'width' => 'element1-1', 'options' => array ( ), ), 'element_1998356908530a3359c6aa0' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'blog_category_small', 'query_type' => '', 'cache_id' => 'rm_element_1998356908530a3359c6aa0', 'cache' => '1', 'width' => 'element1-2', 'options' => array ( 'title' => 'Tech', 'categories' => 'technology', 'numberposts' => '4', ), ), 'element_1833183593530a335d4cc15' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'blog_category_small', 'query_type' => '', 'cache_id' => 'rm_element_1833183593530a335d4cc15', 'cache' => '1', 'width' => 'element1-2', 'options' => array ( 'title' => 'Games', 'categories' => 'games', 'numberposts' => '4', ), ), )
  
);

	return $samples;
}

add_filter('radium_sample_layouts', 'radium_builder_newscore_1_home_1_samples');