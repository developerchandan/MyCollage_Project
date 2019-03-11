<?php
/*-----------------------------------------------------------------------------------
	Pagination - Thanks to Kriesi for this code - http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
-----------------------------------------------------------------------------------*/
if(!function_exists('radium_get_pagination')) {

	/**
	* Displays a page pagination if more posts are available than can be displayed on one page
	* @param string $pages pass the number of pages instead of letting the script check the global paged var
	* @param string $theme_pagination_type pass the pagination type to override global pagination setting (numeric or ajax)
	* @return string $output returns the pagination html code
	*/
	function radium_get_pagination ( ) {

		global $paged;

		$framework = radium_framework();

		$output = null;

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		$output = paginate_links( array(
			'base' 		=> str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
			'format' 	=> '?paged=%#%',
			'current' 	=> max( 1, get_query_var('paged') ),
			'total' 	=> $framework->post_query->max_num_pages,
			'prev_text' => '<i class="icon-angle-left"></i>',
			'next_text' => '<i class="icon-angle-right"></i>',
			'mid_size'	=> 3,
			'end_size'	=> 1,
			'type' 		=> 'list',
		));

		return $output;

	}

}

/**
 * Echo Theme Pagination
 *
 * @uses radium_get_pagination()
 * @since 2.1.4
 */

function radium_pagination() {

	echo '<div class="radium-theme-pagination">' .radium_get_pagination() .'</div>';

}
add_action('radium_pagination', 'radium_pagination');

/**
 * Post Pagination
 *
 * @uses wp_link_pages
 *
 * @since 2.1.4
 */
function radium_get_post_pagination( $args = array() ) {

    $defaults = array(
        'before'      => '<div class="clearfix"></div><div class="radium-theme-pagination"><ul class="page-numbers">',
        'after'       => '</ul></div>',
        'link_before' => '',
        'link_after'  => '',
        'next_or_number'   => 'number',
        'separator'        => ' ',
        'nextpagelink'     => __( 'Next page', 'radium' ),
        'previouspagelink' => __( 'Previous page', 'radium' ),
        'pagelink'         => '%',
        'echo' => false,
    );

    $args = wp_parse_args($args, $defaults);

    return wp_link_pages( apply_filters( __FUNCTION__, $args ));
}

function radium_post_pagination( $args = array() ) {
    echo radium_get_post_pagination($args);
}

add_action( 'radium_after_post_content', 'radium_post_pagination');
add_action( 'radium_after_page_content', 'radium_post_pagination');

function radium_post_pagination_link( $link ) {
   return '<li>'.$link.'</li>';
}

add_filter( 'wp_link_pages_link', 'radium_post_pagination_link');

