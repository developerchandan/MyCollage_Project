<?php

/**
 * Display content.
 *
 * @since 2.1.0
 *
 * @param array $options Options for content
 * @return string $output HTML output for content
 */

if( ! function_exists( 'radium_builder_content_element' ) ) {
	function radium_builder_content_element( $id, $settings, $location  ) {
		switch( $settings['source'] ) {
			case 'current' :
				$page_id = radium_builder_config('id');
				$page = get_page( $page_id );
				$output = apply_filters( 'the_content', $page->post_content );
				break;
			case 'external' :
				$page_id = radium_post_id_by_name( $settings['page_id'], 'page' );
				$page = get_page( $page_id );
				$output = apply_filters( 'the_content', $page->post_content );
				break;
			case 'raw' :
				$output = apply_filters( 'the_content', stripslashes( $settings['raw_content'] ) );
				break;
		}
		echo do_shortcode( $output );
	}
}
add_action('radium_builder_content', 'radium_builder_content_element', 10, 3);