<?php

/**
 * Get all sample layouts.
 *
 * @return array
 */

function radium_builder_newscore_1_home_3_samples( $samples ) {

	$framework = radium_framework();

	$samples['newscore_1_home_3'] = array(

		'name' => 'NewsCore 1 Homepage #3',
		'id' => 'newscore_1_home_3',
		'preview' => $framework->theme_includes_url . '/builder/assets/images/sample-layouts/1-home-3.png',

   		'featured' => array ( 'element_11129916175378eac639ec5' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'content_carousel', 'query_type' => '', 'cache_id' => 'rm_element_11129916175378eac639ec5', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'title' => '', 'limit' => '16', ), ), ),
   		'primary' => array ( 'element_20066879655378eaccb6ed0' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'blog', 'query_type' => '', 'cache_id' => 'rm_element_20066879655378eaccb6ed0', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'title' => 'Articles', 'numberposts' => '8', 'ctp_page_columns' => 'two-columns', ), ), ),

	);

	return $samples;
}

add_filter('radium_sample_layouts', 'radium_builder_newscore_1_home_3_samples');