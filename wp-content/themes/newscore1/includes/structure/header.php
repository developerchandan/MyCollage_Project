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
 * Echo the doctype and opening markup.
 *
 *
 * The default doctype is HTML5
 *
 * @since 2.1.4
 *
 */
function radium_do_doctype() {
    ?><!DOCTYPE html>
    <!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>><![endif]-->
    <!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>><![endif]-->
    <!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>><![endif]-->
    <!--[if gt IE 8]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<head><?php
}
add_action( 'radium_doctype', 'radium_do_doctype' );

/**
 * Header markup
 *
 * @since 2.1.4
 */
function radium_do_meta() { 

global $is_IE;

?><meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php if ( $is_IE ) { ?><meta http-equiv="X-UA-Compatible" content="IE=edge"><?php } ?>
<meta name="description" content="<?php 
	if ( is_single() ) {
        
        $the_post = get_post(get_the_ID() ); //Gets post by ID
        $the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
        $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
        echo trim(substr($the_excerpt, 0, 145));
          
    } else {
        bloginfo('name'); echo " - "; bloginfo('description');
    }
    ?>" /><?php
}
add_action( 'radium_meta', 'radium_do_meta' );

/**
 * Wraps the page title in a `title` element.
 *
 * Only applies, if not currently in admin, or for a feed.
 *
 * @since 1.3.0
 *
 * @param string $title Page title.
 *
 * @return string Plain text or HTML markup
 */
function radium_doctitle() {

    $sep = '|';
    $seplocation = 'right';

    $title = (!defined('WPSEO_VERSION')) ? (wp_title($sep, false, $seplocation).get_bloginfo('name')) : wp_title('', false );

	echo is_feed() || is_admin() ? $title : sprintf( "<title>%s</title>\n", $title );

}

add_action( 'radium_title', 'radium_doctitle' );

/**
 * Optionally output the responsive CSS viewport tag.
 *
 * Child theme needs to support 'radium-responsive-viewport'.
 *
 * @since 2.1.4
 *
 * @return null Return early if child theme does not support viewport.
 */
function radium_responsive_viewport() {

	if ( ! current_theme_supports( 'radium-responsive-viewport' ) ) return; ?><meta name="viewport" content="width=device-width, initial-scale=1" /><?php
}
add_action( 'radium_meta', 'radium_responsive_viewport' );

/**
 * Echo favicon link if one is found.
 *
 * Falls back to Radium theme favicon.
 *
 * URL to favicon is filtered via 'radium_favicon_url' before being echoed.
 *
 * @since 2.1.4
 *
 * @uses radium_framework();
 */
function radium_load_favicon() {

	$framework = radium_framework();

	//* Allow child theme to short-circuit this function
	$pre = apply_filters( 'radium_pre_load_favicon', false );

	$saved_icon =  radium_get_option('favicon');

	if ( $pre !== false )
		$icon = $pre;
	elseif ( $saved_icon )
		$icon = $saved_icon;
	elseif ( file_exists( $framework->child_theme_dir . '/images/favicon.ico' ) )
		$icon = $framework->child_theme_url . '/images/favicon.ico';
	elseif ( file_exists( $framework->child_theme_dir . '/images/favicon.gif' ) )
		$icon = $framework->child_theme_url . '/images/favicon.gif';
	elseif ( file_exists( $framework->child_theme_dir . '/images/favicon.png' ) )
		$icon = $framework->child_theme_url . '/images/favicon.png';
	elseif ( file_exists( $framework->child_theme_dir . '/images/favicon.jpg' ) )
		$icon = $framework->child_theme_url . '/images/favicon.jpg';
	else
		$icon = $framework->theme_images_url . '/favicon.gif';

	$icon = apply_filters( 'radium_favicon_url', $icon );

	if ( $icon )
	echo '<link rel="shortcut icon" href="' . esc_url( $icon ) . '" type="image/x-icon" />' . "\n";
}
add_action( 'wp_head', 'radium_load_favicon' );

/**
 * Echo Apple touch icon link if one is found.
 *
 * URL to favicon is filtered via 'radium_appleicon_url' before being echoed.
 *
 * @since 2.1.4
 *
 * @uses radium_framework();
 */

if ( !function_exists('radium_add_favicon') ) {

	function radium_add_favicon() {

 		$framework = radium_framework();

		$saved_icon =  radium_get_option('appleicon');

		//* Allow child theme to short-circuit this function
		$pre = apply_filters( 'radium_pre_load_appleicon', false );

		if ( $pre !== false )
			$icon = $pre;
		elseif ( $saved_icon )
			$icon = $saved_icon;
		elseif ( file_exists( $framework->child_theme_dir . '/images/apple-touch-icon.png' ) )
			$icon = $framework->child_theme_url . '/images/apple-touch-icon.png';
		else
			$icon = $framework->theme_images_url . '/apple-touch-icon.png';

		$icon = apply_filters( 'radium_appleicon_url', $icon );

		if ( $icon )
		echo '<link rel="apple-touch-icon" href="' . esc_url( $icon ) . '"/>' . "\n";
	}
	add_action('wp_head', 'radium_add_favicon');
}

/**
 * Adds the pingback meta tag to the head so that other sites can know how to send a pingback to our site.
 *
 * @since 2.1.4
 */
function radium_do_meta_pingback() {

	if ( 'open' === get_option( 'default_ping_status' ) )
		echo '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '" />' . "\n";

}

add_action( 'wp_head', 'radium_do_meta_pingback' );


/**
 * Echo the site title into the header.
 *
 * Applies the 'radium_title' filter before echoing.
 *
 * @since 2.1.4
 *
 */
function radium_site_header_title() {
	
	$framework = radium_framework();
		
	$logo 		= apply_filters('radium_site_header_logo_url', 			radium_get_option('logo'));
	$dimensions = apply_filters('radium_site_header_logo_dimensions', 	radium_get_option('logo-dimensions'));
	$width 		= isset($dimensions['width']) ? $dimensions['width'] : null;
	$height 	= isset($dimensions['height']) ? $dimensions['height'] : null;
		
	//* Build the title
	$output = '<div class="site-title-wrapper" itemprop="headline">';
	
	if( is_front_page() ) 
		$output .= '<h1 class="site-title">';
	
	$output .= '<a href="'.trailingslashit( home_url() ).'" title="'.esc_attr( get_bloginfo( 'name' ) ).'" rel="home">';
	
	if ( $logo ) {
		
		$output  .= '<img src="'.$logo.'" class="logo" alt="logo" width="'. intval($width) .'"  height="'.intval($height).'"  />';
				
		if ( !$width || !$height || $width == 0 || $height == 0 ) {
			echo "<span class='alert error'>". __('Please setup the logo dimensions accurately in the theme options', 'radium') ."</span>";
		}

	} else {
			
		$output .= get_bloginfo( 'name' );
		
	}
	
	$output  .= '</a>';
	
	if( is_front_page() ) 
		$output .= '</h1>';
	
	$output .= '</div>';
		
	echo $output;

}
add_action( 'radium_site_title', 'radium_site_header_title' );

/**
 * Echo the site description into the header.
 *
 * Depending on the SEO option set by the user, this will either be wrapped in an 'h1' or 'p' element.
 *
 * Applies the 'radium_seo_description' filter before echoing.
 *
 * @since 2.1.4
 *
 */
function radium_site_header_description() {

	$show_description =  radium_get_option('site_description');

	if ( !$show_description ) return;

	//* Set what goes inside the wrapping tags
	$inside = esc_html( get_bloginfo( 'description' ) );

	$description  = '<p class="site-description" itemprop="description">'. $inside . '</p>';

	//* Output (filtered)
	$output = $inside ? $description : '';

	echo $output;

}
add_action( 'radium_site_description', 'radium_site_header_description' );

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
function radium_main_menu( ) {

	$framework = radium_framework();

	if ( !$framework->theme_supports( 'primary', 'megamenu') || !function_exists('radium_mega_menu')) return; ?>

		<!-- Main Navigation -->
		<nav class="nav-primary" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" role="navigation">
			<div id="main-menu" class="main_menu clearfix">
				<button class="menu-trigger show-on-small"><?php _e('Open Menu', 'radium'); ?></button>
				<?php
				/* Main menu */
				$args = array(
				    'container' 	=> '',
					'menu_class' 	=> 'radium_mega menu dl-menu',
				    'fallback_cb' 	=> 'radium_fallback_menu',
				    'depth' 		=> 5,
					'theme_location'=> 'primary',
                    'echo' => 0,
				    'walker' 		=> new Radium_Walker()
				);

				echo radium_mega_menu( apply_filters( 'radium_main_menu_args', $args ) );
			 ?>
			</div>
 		</nav>
		<!-- /End Main Menu -->

<?php
}
add_action( 'radium_site_navigation', 'radium_main_menu' );

/**
 * Echo the header scripts, defined in Theme Settings.
 *
 * Applies the 'radium_header_scripts' filter to the value returns from the header_scripts option.
 *
 * @since 1.6.0
 *
 * @uses radium_get_option() Get theme setting value.
 */
function radium_header_scripts() { 
?><script><?php echo apply_filters( 'radium_header_scripts', radium_get_option( 'header_scripts' ) ); ?></script><?php

}
add_filter( 'radium_header_scripts', 'do_shortcode' );
add_action( 'wp_head', 'radium_header_scripts' );