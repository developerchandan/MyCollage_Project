<?php

/**
 * Posts Element
 *
 * @since 2.1.0
 *
 * @params array $options
 * @param string $current_location Current location of element, featured or primary
 */
if ( ! function_exists( 'radium_builder_blog_element' )) {
	function radium_builder_blog_element( $id, $options, $location ) {

		// Setup and extract $args
		$defaults = array(
			'numberposts'		=> 6,					// Posts per page (list only)
			'orderby'			=> 'date',				// Orderby param for posts query
			'order'				=> 'DESC',				// Order param for posts query
			'offset'            => '',
            'exclude'			=> '',					// exclude posts by id
			'readmore' 			=> '1',
			'show_excerpt' 			=> '1',
			'ctp_page_columns' 	=> '',
			'categories' 		=> 'all'
		);

		$args = wp_parse_args( $options, $defaults );
		extract( $args, EXTR_OVERWRITE );

        $title = ( $options['title'] && $options['title'] !== '_' ) ? $options['title'] : __('Title', 'radium');
		if ( $options['title'] == '_') $title = false;

        if( $title ) { ?><div class="entry-element-title"><div class="ribbon"></div><h3><?php echo $title; ?></h3></div><?php }

		$lang 			= get_query_var('lang');

		$sidebar = radium_sidebar_loader();

		if ( is_page_template('page-templates/page-home.php') && $sidebar['sidebar_active'] ) {

			$sidebars = 2;

		} elseif( is_page_template('page-templates/page-home.php') && !$sidebar['sidebar_active'] || $sidebar['sidebar_active'] ) {

			$sidebars = 1;

		} else {

			$sidebars = 0;

		}

		echo radium_builder_get_blog_element_content( false, $numberposts, $orderby, $order, $exclude, $offset, 1, $ctp_page_columns, true, $sidebars, $readmore, $categories, $show_excerpt, $lang, $options );

 	}
}
add_action('radium_builder_blog', 'radium_builder_blog_element', 10, 3);