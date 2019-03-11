<?php
/*
 * This file is a part of the RadiumFramework core.
 * Please be extremely cautious editing this file,
 *
 * @category RadiumFramework
 * @package  Carlton
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 */

/**
 * radium_footer_before_widgets Wrapper for the footer
 *
 * @since 2.1.4
 *
 * @return null
 */
if ( !function_exists('radium_footer_before') ) :

	function radium_footer_before() { ?><footer id="bottom-footer" class="bottom-footer" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter"><?php }

endif;

add_action('radium_before_footer', 'radium_footer_before');

/**
 * radium_footer_after Wrapper for the footer
 *
 * @since 2.1.4
 *
 * @return null
 */
if ( !function_exists('radium_footer_after') ) :

	function radium_footer_after() { ?></footer><?php }

endif;

add_action('radium_after_footer', 'radium_footer_after');

/**
 * Echo the markup necessary to facilitate the footer widget areas.
 *
 * @since 2.1.4
 *
 * @return null Return early if number of widget areas could not be determined, or nothing is added to the first widget area.
 */
if ( !function_exists('radium_footer_widgets') ) :

	function radium_footer_widgets() {

	if(!radium_get_option('footer_layout') ) return; ?>
	
	<div class="inner">

		<aside id="footer-widgets" class="clearfix">

			<div class="widget_row">
			  <?php
				// Footer widgetized area
				$footer_widget_count = null;
		 		$footer_layout = radium_get_option('footer_layout');

				 if ( $footer_layout ) {

					switch ( $footer_layout ) {

						case '100':
							$footer_widget_count = 1;
							break;

						case '50-50':
							$footer_widget_count = 2;
							break;

						case '33-33-33':
							$footer_widget_count = 3;
							break;

						case '25-25-25-25':
							$footer_widget_count = 4;
							break;

						default:
							break;

					}

					for($i = 1; $i<= $footer_widget_count; $i++) {
				       echo '<div class="widget-area widget_'.$footer_widget_count.'">';
				           if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widgets '.$i) ) : endif;
				       echo '</div><!-- END div.widget_'.$footer_widget_count.' -->';
					}

					} ?>
				</div>

			</aside>

		</div><!-- END .inner --><?php
 	}

endif;

add_action('radium_footer', 'radium_footer_widgets');

 
/**
 * Add Site Navigation
 *
 * @since 2.0.0
 *
 * @uses genesis_html5() Check for HTML5 support.
 *
 * @param  $menu Menu output.
 *
 * @return string $menu Modified menu output.
 */
function radium_footer_menu( ) { 
	
	if ( has_nav_menu('footer-menu') ) { ?>
	<!-- Footer Navigation -->
	<nav class="nav-footer" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" role="navigation">
		<div class="container">
		 	<?php $args = array(
					'sort_column' 		=> 'menu_order',
					'theme_location' 	=> 'footer-menu',
					'fallback_cb' 		=> 'none',
					'container' 		=> 'ul',
					'menu_class' 		=> 'foot-menu',
					'depth' 			=> '1',
					'echo'            	=> true
				);

				wp_nav_menu( apply_filters( 'radium_footer_menu_args', $args ) );
			?>
		</div>
	</nav>
	<!-- /End Main Menu -->
<?php }
	
}
add_action( 'radium_footer_navigation', 'radium_footer_menu' );

/**
 * Echo the contents of the footer.
 *
 * Applies 'radium_footer_backtotop_text', 'radium_footer_creds_text' and 'radium_footer_output' filters.
 *
 * For HTML5 themes, only the credits text is used (back-to-top link is dropped).
 *
 * @since 2.1.4
 *
 *
 */
function radium_do_footer() {
	
	$framework = radium_framework();
	
	//* Build the text strings.
	$backtotop_text = '<a href="#theme-wrapper" rel="nofollow">' . __('Back to top', 'radium') . '</a>';
	
	$creds_text     = radium_get_option('footer_copyright_text') ? radium_get_option('footer_copyright_text') : '&copy; '. date("Y") .' '. $framework->theme_title .' '. __('All Rights Reverved. Theme designed by', 'radium') . ' <a href="'. $framework->theme_main_site_url . '" target="_blank">RadiumThemes</a>.';

	//* Filter the text strings
	$backtotop_text = apply_filters( 'radium_footer_backtotop_text', $backtotop_text );
	$creds_text     = apply_filters( 'radium_footer_creds_text', $creds_text );

	$backtotop = $backtotop_text && radium_get_option('back_to_top') ? sprintf( '<div id="gototop">%s</div>', $backtotop_text ) : '';
	$creds     = $creds_text ? sprintf( '<div id="colophon" class="creds" role="contentinfo"><div id="theme-credits">%s</div></div>', $creds_text ) : '';

	$output = $backtotop . $creds;

	echo apply_filters( 'radium_footer_output', $output, $backtotop_text, $creds_text );

}
add_action( 'radium_footer', 'radium_do_footer' );


/**
 * Echo the footer scripts, defined in Theme Settings.
 *
 * Applies the 'radium_footer_scripts' filter to the value returns from the footer_scripts option.
 *
 * @since 1.6.0
 *
 * @uses radium_get_option() Get theme setting value.
 */
function radium_footer_scripts() {

	?><script><?php echo apply_filters( 'radium_footer_scripts', radium_get_option( 'footer_scripts' ) ); ?></script><?php

}

add_filter( 'radium_footer_scripts', 'do_shortcode' );
add_action( 'wp_footer', 'radium_footer_scripts' );
