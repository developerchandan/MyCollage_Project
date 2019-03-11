<?php

/**
 * Create a blank sample layouts.
 *
 * @return array
 */
 
function radium_builder_blank_samples( $samples ) {

	$framework = radium_framework();
	
	$samples['blank'] = array(
				'name' => 'Blank Slate',
				'id' => 'blank',
				'preview' => $framework->theme_includes_url . '/builder/assets/images/sample-layouts/blank.png',
 	);
		
	return $samples;
}
add_filter('radium_sample_layouts', 'radium_builder_blank_samples');