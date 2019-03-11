<?php

/**
 * Get all sample layouts.
 *
 * @return array
 */

function radium_builder_newscore_3_home_3_samples( $samples ) {

	$framework = radium_framework();

	$samples['newscore_3_home_3'] = array(

		'name' => 'NewsCore 3 Homepage #3',
		'id' => 'newscore_3_home_3',
		'preview' => $framework->theme_includes_url . '/builder/assets/images/sample-layouts/3-home-3.png',

   		'featured' => array ( 'element_138101677153d6d47932dc1' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '15px', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'content_carousel_big', 'query_type' => '', 'cache_id' => 'rm_element_138101677153d6d47932dc1', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'title' => '', 'limit' => '16', ), ), ),
   		'primary' => array ( 'element_167760453353d02211ba51b' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'blog', 'query_type' => '', 'cache_id' => 'rm_element_167760453353d02211ba51b', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'title' => 'Articles', 'numberposts' => '12', 'ctp_page_columns' => 'three-columns', ), ), ),

	);

	return $samples;
}

add_filter('radium_sample_layouts', 'radium_builder_newscore_3_home_3_samples');