<?php

/**
 * Get all sample layouts.
 *
 * @return array
 */
 
function radium_builder_avalon_contact_1_samples( $samples ) {

	$framework = radium_framework();
	
	$samples['newscore_contact_1'] = array(
			'name' => 'Contact Page #1',
			'id' => 'newscore_contact_1',
			'preview' => $framework->theme_includes_url . '/builder/assets/images/sample-layouts/contact.png',
	   		'featured' => array ( ),
	   		
	   		'primary' => array (
	   	
	   		  'element_104597407652728f9ee6c4b' => 
	   		  array (
	   		    'style' => 
	   		    array (
	   		    ),
	   		    'type' => 'contact_7',
	   		    'query_type' => 'none',
	   		    'width' => 'element2-3',
	   		    'options' => 
	   		    array (
	   		      'form_id' => '10694',
	   		    ),
	   		  ),
	   		  'element_963127923525d9315ba866' => 
	   		  array (
	   		    'style' => 
	   		    array (
	   		      'style_info' => '',
	   		      'width' => 'boxed',
	   		      'class' => '',
	   		      'bg_image' => '',
	   		      'bg_style' => 'repeat',
	   		      'bg_color' => '',
	   		      'top_padding' => '',
	   		      'bottom_padding' => '',
	   		      'top_margin' => '',
	   		      'bottom_margin' => '',
	   		    ),
	   		    'type' => 'content',
	   		    'query_type' => 'none',
	   		    'width' => 'element1-3',
	   		    'options' => 
	   		    array (
	   		      'source' => 'raw',
	   		      'page_id' => 'about',
	   		      'raw_content' => '<h3>Reach out to us!</h3>
	   		Want to talk to a human being? Hit the button below to call us on Skype.
	   		<br>
	   		[button url="#" style="orange transparent" size="small" type="square" icon="icon-" target="_self"]&nbsp;+44 (0) 800 123 4567 [/button]
	   		<br><br>
	   		Apple Computer Inc<br>
	   		1 Infinite Loop
	   		Cupertino CA
	   		95014
	   		[hr_invisible]
	   		<h3>Get Social!</h3>
	   		[social-icon link="#" type="twitter"/][social-icon link="#" type="facebook"/][social-icon link="#" type="googleplus"/][social-icon link="#" type="linkedin"/]',
	   		    ),
	   		  ),
	   		),
	 );
 
	return $samples;
}
 
add_filter('radium_sample_layouts', 'radium_builder_avalon_contact_1_samples');