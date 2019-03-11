<?php

/**
 * Display divider.
 *
 * @since 2.1.0
 *
 * @param array $type style of divider
 * @return string $output HTML output for divider
 */

if( ! function_exists( 'radium_builder_divider_element' ) ) {
	function radium_builder_divider_element( $id, $settings, $location ) {
		if ( $settings['type'] == 'hidden') {
			
			$output = '<div class="hr_invisible"></div>';
			
		} else {
		
			$output = '<div class="divider hr divider-'.$settings['type'].'"></div>';
		
		}
		
		echo $output;
		
	}
}
add_action('radium_builder_divider', 'radium_builder_divider_element', 10, 3);
