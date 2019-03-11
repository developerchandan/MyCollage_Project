<?php

/**
 * Get all sample layouts.
 *
 * @return array
 */

function radium_builder_newscore_2_home_2_samples( $samples ) {

	$framework = radium_framework();

	$samples['newscore_2_home_2'] = array(

		'name' => 'NewsCore 2 Homepage #2',
		'id' => 'newscore_2_home_2',
		'preview' => $framework->theme_includes_url . '/builder/assets/images/sample-layouts/2-home-2.png',

   		'featured' => array ( 'element_105687681553dc0f39f11b9' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'content_grid_slider', 'query_type' => '', 'cache_id' => 'rm_element_105687681553dc0f39f11b9', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'content_type' => 'post', 'title' => '', 'limit' => '16', 'carousel' => false, ), ), ),
   		'primary' => array ( 'element_4439224445378e8eac9fe5' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'radium_video', 'query_type' => 'none', 'cache_id' => '', 'cache' => '', 'width' => 'element1-1', 'options' => array ( ), ), 'element_9772202305378e8eed6531' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'blog_review', 'query_type' => '', 'cache_id' => 'rm_element_9772202305378e8eed6531', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'title' => 'review News', 'numberposts' => '6', ), ), 'element_13118659765378e8f22d903' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'blog', 'query_type' => '', 'cache_id' => 'rm_element_13118659765378e8f22d903', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'title' => 'Articles', 'numberposts' => '8', 'ctp_page_columns' => 'two-columns', ), ), ),

	);

	return $samples;
}

add_filter('radium_sample_layouts', 'radium_builder_newscore_2_home_2_samples');