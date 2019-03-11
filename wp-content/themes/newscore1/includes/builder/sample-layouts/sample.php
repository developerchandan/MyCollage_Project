<?php

/**
 * Get all sample layouts.
 *
 * @return array
 */

function radium_builder_layout_name_samples( $samples ) {

	$framework = radium_framework();

	$samples['layout_name'] = array(

		'name' => 'Landing page',
		'id' => 'newscore_home_0',
		'preview' => $framework->theme_includes_url . '/builder/assets/images/sample-layouts/home-0.png',

   		'featured' => array(),
   		'primary' => array(),

	);

	return $samples;
}

add_filter('radium_sample_layouts', 'radium_builder_layout_name_samples');