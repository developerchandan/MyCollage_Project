<?php
/**
 * load metabox scripts
 *
 *  @since 2.0.0
 *
 *  return void
 */

function radium_load_metabox_conditional_js() {

	$framework = radium_framework();

	wp_enqueue_script( 'radium-meta-post-formats', $framework->theme_includes_url . '/metaboxes/js/post-formats.js', 'jquery', $framework->theme_version, true );
	wp_enqueue_script( 'radium-meta-page-templates', $framework->theme_includes_url . '/metaboxes/js/page-templates.js', 'jquery', $framework->theme_version, true );
	
	wp_enqueue_script( 'radium-meta-ratings-options', $framework->theme_includes_url . '/metaboxes/js/ratings-options.js', 'jquery', $framework->theme_version, true );

}
add_action( 'admin_enqueue_scripts', 'radium_load_metabox_conditional_js');
