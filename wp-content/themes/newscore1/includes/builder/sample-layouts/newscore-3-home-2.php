<?php

/**
 * Get all sample layouts.
 *
 * @return array
 */

function radium_builder_newscore_3_home_2_samples( $samples ) {

	$framework = radium_framework();

	$samples['newscore_3_home_2'] = array(

		'name' => 'NewsCore 3 Homepage #2',
		'id' => 'newscore_3_home_2',
		'preview' => $framework->theme_includes_url . '/builder/assets/images/sample-layouts/3-home-2.png',

   		'featured' => array ( 'element_136861546053cf902981a20' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '15px', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'content_carousel', 'query_type' => '', 'cache_id' => 'rm_element_136861546053cf902981a20', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'title' => '', 'limit' => '16', ), ), ),
   		'primary' => array ( 'element_196496626753cf901e34074' => array ( 'style' => array ( 'style_info' => '', 'width' => 'boxed', 'class' => '', 'bg_image' => '', 'bg_style' => 'repeat', 'bg_color' => '', 'top_padding' => '', 'bottom_padding' => '', 'top_margin' => '', 'bottom_margin' => '', ), 'type' => 'blog', 'query_type' => '', 'cache_id' => 'rm_element_196496626753cf901e34074', 'cache' => '1', 'width' => 'element1-1', 'options' => array ( 'title' => 'Articles', 'numberposts' => '12', 'ctp_page_columns' => 'three-columns', ), ), ),

	);

	return $samples;
}

add_filter('radium_sample_layouts', 'radium_builder_newscore_3_home_2_samples');