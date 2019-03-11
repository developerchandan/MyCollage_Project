<?php

/**
 * Get all sample layouts.
 *
 * @return array
 */

function radium_builder_newscore_3_home_1_samples( $samples ) {

	$framework = radium_framework();

	$samples['newscore_3_home_1'] = array(

		'name' => 'NewsCore 3 Homepage #1',
		'id' => 'newscore_3_home_1',
		'preview' => $framework->theme_includes_url . '/builder/assets/images/sample-layouts/3-home-1.png',

   		'featured' => array ( 'element_172212657953d6bede64e7f' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '15px', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'content_grid_slider', 'query_type' => '', 'cache_id' => 'rm_element_172212657953d6bede64e7f', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'content_type' => 'post', 'title' => '', 'limit' => '16', 'carousel' => false, ), ), ),
   		'primary' => array ( 'element_128432799353b340bb33fd7' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'blog', 'query_type' => '', 'cache_id' => 'rm_element_128432799353b340bb33fd7', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'title' => 'Articles', 'numberposts' => '12', 'ctp_page_columns' => 'three-columns', ), ), ),

	);

	return $samples;
}

add_filter('radium_sample_layouts', 'radium_builder_newscore_3_home_1_samples');