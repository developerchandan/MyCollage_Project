<?php
/**
 *
 * Add Dynamic widgets support to layout builder
 *
 * @since 2.1.0
 *
 * @uses dynamic_sidebar()
 * @return void
 */
function radium_builder_widget_block( $id, $settings, $location  ){
	?>
	<div class="widget">
		<ul><?php dynamic_sidebar( $settings['widget_areas'] ); ?></ul>
	</div>
	<?php
	// Die if there's no slider
	if( ! $settings['widget_areas'] ) {
		echo '<div class="messageBox warning">'.__( 'Oops! You have not selected a widget area in your layout.', 'radium' ).'</div>';
		return;
	}
}
add_action('radium_builder_widgets', 'radium_builder_widget_block', 10, 3);