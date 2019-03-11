<?php
 	
/** 
 * Register revolution slider into the layout builder.
 * @return array();
 * Added with priority of 11, 
 */
function radium_builder_registar_contact_7_element( $elements ) {
	
	//Select Slider
	$form_select = array();
 
	$form = get_posts( 'post_type=wpcf7_contact_form&numberposts=-1' );
		
	if( ! empty( $form ) )
		foreach( $form as $k )
			$form_select[$k->ID] = $k->post_title;
	else
		$form_select['null'] = __( 'You haven\'t created any slider yet.', 'radium' );
		
	// Slider
	$element_config = array(
	    array(
	    	'id' 		=> 'form_id',
	    	'name'		=> __( 'Select Form', 'radium' ),
	    	'desc'		=> __( 'Choose a contact form to display', 'radium' ),
	    	'type'		=> 'select',
	    	'options'	=> $form_select,
 	    )
	);
	
	$elements['contact_7'] = array(
		'info' => array(
			'name' 	=> 'Contact 7 Forms',
			'id'	=> 'contact_7',
			'query'	=> 'none',
			'hook'	=> 'radium_contact_7_block',
			'shortcode'	=> '[contact_7]',
			'desc' 	=> __( 'Contact 7 Forms', 'radium' )
		),
		'options' => $element_config
	);
	
	return $elements;
	
}
add_filter('radium_builder_elements', 'radium_builder_registar_contact_7_element');	

/**
 * Integrate revolution slider into the layout builder.
 *
 * @since 2.1.0
 *
 * @param string $slider Slug of custom-built slider to use
 */

if( ! function_exists( 'radium_builder_contact_7_element' ) ) {
	function radium_builder_contact_7_element(  $id, $settings, $location ) {
	
		// Die if there's no slider
		if( $settings['form_id'] ) {
			
			echo do_shortcode('[contact-form-7 id="'.$settings['form_id'].'" title="'.get_the_title($settings['form_id']).'" ]');
			
		} else {
 			
 			echo '<div class="messageBox warning">'.__( 'Oops! You have not selected a slider in your layout.', 'radium' ).'</div>';
 			
 			return;
		}
		
	}
}

add_action('radium_builder_contact_7', 'radium_builder_contact_7_element', 10, 3);