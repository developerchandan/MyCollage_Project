<?php
add_action( 'admin_init', 'rwmb_register_meta_boxes' );

/**
 * Register meta boxes via a filter
 * Advantages:
 * - prevents incorrect hook
 * - prevents duplicated global variables
 * - allows users to remove/hide registered meta boxes
 *
 * @return void
 */
function rwmb_register_meta_boxes() {

	$meta_boxes = apply_filters( 'rwmb_meta_boxes', array() );
	
	if ( class_exists( 'RW_Meta_Box' ) ) {
		
		foreach ( $meta_boxes as $meta_box ) {
			new RW_Meta_Box( $meta_box );
		}
		
	}
	
}
 