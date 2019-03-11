<?php

/**
 * Get all sample layouts.
 *
 * @return array
 */

function radium_builder_newscore_2_home_1_samples( $samples ) {

	$framework = radium_framework();

	$samples['newscore_2_home_1'] = array(

		'name' => 'NewsCore 2 Homepage #1',
		'id' => 'newscore_2_home_1',
		'preview' => $framework->theme_includes_url . '/builder/assets/images/sample-layouts/2-home-1.png',

   		'featured' => array ( 'element_200728823453b34134f2ffc' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'content_carousel_big', 'query_type' => '', 'cache_id' => 'rm_element_200728823453b34134f2ffc', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'title' => '', 'limit' => '16', ), ), ),
   		'primary' => array ( 'element_1334119280530b5fe696fe3' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'blog_review', 'query_type' => '', 'cache_id' => 'rm_element_1334119280530b5fe696fe3', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'title' => 'Latest Reviews', 'numberposts' => '6', ), ), 'element_21391374185308aae69f73d' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => 'black', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'radium_video', 'query_type' => 'none', 'cache_id' => '', 'cache' => '', 'width' => 'element1-1', 'options' => array ( ), ), 'element_128432799353b340bb33fd7' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'blog', 'query_type' => '', 'cache_id' => 'rm_element_128432799353b340bb33fd7', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'title' => 'More Articles', 'numberposts' => '6', 'ctp_page_columns' => 'small-thumbs', ), ), ),

	);

	return $samples;
}

add_filter('radium_sample_layouts', 'radium_builder_newscore_2_home_1_samples');