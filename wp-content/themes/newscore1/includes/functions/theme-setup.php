<?php
/*
 * This file is a part of the RadiumFramework core.
 * Please be extremely cautious editing this file,
 *
 * @category RadiumFramework
 * @package  NewsCore
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 */
/*--------------------------------------------------------------------*/
/*     ADD OUR SCRIPTS
/*--------------------------------------------------------------------*/
if ( !function_exists( 'radium_enqueue_scripts') ) {

    function radium_enqueue_scripts() {

        global $post;

        $post_id = is_object($post) ? $post->ID : 0;

        $bg_array = $page_bg_image = $files = null;

        $framework = radium_framework();

        //detect if in developer mode and load appropriate files
        if ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || $framework->theme_dev_mode  ) :

            $css_suffix     = '.css';
            $js_suffix      = '.min.js';
             $version 		= time();

         else :

            $css_suffix  = '.min.css';
            $js_suffix      = '.min.js';
            $version 		=  $framework->theme_version;

        endif;

        //Detect typography manager
        if ( radium_get_option('theme_default_typeface') !== '1' ) {
            wp_enqueue_style( 'theme-google-fonts', "//fonts.googleapis.com/css?family=Oswald:400,300,700|Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic" );
         }

          wp_enqueue_style( 'framework-style', $framework->theme_css_url . '/style'.$css_suffix, false, $version, 'all');

        if( $framework->theme_supports( 'primary', 'woocommerce' ) )
            wp_enqueue_style( 'main-woocommerce',     $framework->theme_css_url . '/woocommerce'.$css_suffix, false, $version, 'all');

        wp_enqueue_style( 'theme-print', $framework->theme_css_url . '/print'.$css_suffix, false, $version, 'print');

        if ( current_theme_supports( 'radium-responsive-viewport' ) )
            wp_enqueue_style( 'theme-mobile', $framework->theme_css_url . '/mobile'.$css_suffix, false, $version, 'all');

        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-accordion' );
        wp_enqueue_script( 'jquery-ui-tabs' );
        wp_enqueue_script( 'jquery-ui-slider' );

        wp_enqueue_script('modernizr', 				$framework->theme_js_url . '/modernizr.min.js', $version, false);
        wp_enqueue_script('radium-theme-plugin', 	$framework->theme_js_url . '/plugins.min.js', 'jquery', $version, true);
        wp_enqueue_script('radium-theme-main',   	$framework->theme_js_url . '/main.min.js', 'jquery', $version, true);

        $sticky_header     = radium_get_option('sticky_header') ? 'true' : 'false';
        $space_menu_evenly = radium_get_option('space_menu_evenly') ? 'true' : 'false';
        $back_to_top = radium_get_option('back_to_top') ? 'true' : 'false';

        $share_posts = radium_get_option('share_posts') && radium_get_option('share_posts_position', false, 'left') == 'left' ? 'true' : 'false';

        //The radium_framework_globals object contains information and settings about the framework
        wp_localize_script('radium-theme-plugin', 'radium_framework_globals', array(
            'page_bg_images'    => $page_bg_image,
            'js_dir'            => $framework->theme_js_url,
            'ajaxurl'           => admin_url('admin-ajax.php'),
            'sticky_header'     => $sticky_header,
            'space_menu_evenly' => $space_menu_evenly,
            'back_to_top'       => $back_to_top,
            'share_posts_js' 	=> $share_posts,
            'theme_url'         => get_stylesheet_directory_uri(),
            'ajax_error_message' => __('Sorry, unable to load more posts. Please try again.', 'radium'),
            'ajax_error_message2' => __('Sorry, unable to load this post using ajax. Redirecting...', 'radium'),
            'cart_added_message' => __('has been added to the shopping cart.', 'radium'),
        )); //create globals for front-end AJAX calls;

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
            wp_enqueue_script('validation', $framework->theme_js_url . '/jquery.validate.min.js', 'jquery', $version, true);
        }

    }
    add_action( 'wp_enqueue_scripts', 'radium_enqueue_scripts');
}

//dequeue css from plugins
function radium_dequeue_css_from_plugins()  {
    wp_dequeue_style( "pretty_photo" );
    wp_dequeue_style( "radium-gallery-styles" );
    wp_dequeue_style( "video-central-font-awesome" );
    wp_dequeue_style( "video-central-grid" );
    wp_dequeue_style( "radium-fitvid" );
    wp_dequeue_style( "yith-wcwl-font-awesome" );

    wp_deregister_style( "open-sans" );
    wp_register_style( "open-sans", false );

}
add_action('wp_print_styles', 'radium_dequeue_css_from_plugins', 100);

//dequeue js from plugins
function radium_dequeue_js_from_plugins()  {
    wp_dequeue_script( "radium-galleries" );
    wp_dequeue_script( 'dtheme-ajax-js');
}
add_action('wp_print_scripts', 'radium_dequeue_js_from_plugins', 100);

/**
 * Set the page progress loader
 * We don't use the natural wp_enqueue_scripts method here due to how this script works. Sorry WP police :(
 */
function radium_pace_loader() {
    $framework = radium_framework();

    if ( !radium_get_option('loading_bar', false, false) ) return;
?>
    <script type="text/javascript">window.paceOptions = { elements: { selectors: ['#header' ] } }</script>
    <script src="<?php echo $framework->theme_js_url ?>/pace.min.js"></script><?php
 }
 add_action('wp_head', 'radium_pace_loader', 10);


//*-----------------------------------------------------------------------------------*/
/*	Adds the Theme Style form options panel
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'radium_load_theme_style') ) {

    function radium_load_theme_style() {

        $framework = radium_framework();

          $skin = radium_get_option('theme_style', false, 'default');

        //detect if in developer mode and load appropriate files
        if ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ( defined( 'WP_DEBUG' ) && WP_DEBUG )  || $framework->theme_dev_mode ) :

            $css_suffix = '.css';
             $version = time();

         else :

            $css_suffix = '.min.css';
             $version =  $framework->theme_version;

        endif;

        if( $skin !== 'default' && $skin !== '')
            wp_enqueue_style( 'radium-'.$skin, $framework->theme_css_url.'/skins/'.$skin.$css_suffix, false, $version, 'all');

        if( is_archive() ) {

            $style = null;
            $options = radium_get_category_option(get_query_var( 'cat' ));
            $style = isset( $options['style'] ) && $options['style'] != 'none' ? $options['style'] : false;

            // If have parent and not have style, get style of parent
            if( !$style ) {

                $cat = get_category( get_query_var( 'cat' ) );

                if( !is_wp_error($cat) && $cat->parent ) {
                    $options = radium_get_category_option( $cat->parent );
                    $style = isset( $options['style'] ) && $options['style'] != 'none' ? $options['style'] : false;
                } //$cat->parent

            } //$style

            if( $style ) {

                $url = '/colors/'.$style.'/style.css';
                if( file_exists($framework->theme_css_dir . $url) )
                    wp_enqueue_style( 'radium_category_style', $framework->theme_css_url . $url );

            } //$style

        } //is_archive()

    }
    add_action('wp_enqueue_scripts', 'radium_load_theme_style');
}

//*-----------------------------------------------------------------------------------*/
/*	Adds the skin classes to the body class array.
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'radium_skin_body_class') ) {

    function radium_skin_body_class($classes) {

        $layout_type = radium_get_option('layout_type', false, 'boxed');

        $classes[] = $layout_type;

        $classes[] = radium_get_option('theme_style') ? 'skin-' . radium_get_option('theme_style') : null;

        $classes[] = radium_get_option('header_style') ? 'header-style-' . radium_get_option('header_style') : 'header-style-default';

        $bg_image = radium_get_option( 'main_bg');

        if ( $layout_type == 'boxed' && is_array($bg_image) ) $classes[] = 'custom-bg';

        return $classes;
    }
    add_filter('body_class', 'radium_skin_body_class');
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
$content_width = 1200; /* pixels */

if ( ! function_exists( 'radium_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function radium_theme_setup() {

    $framework = radium_framework();

    /**
     * Enable support for Post Thumbnails on posts and pages
     *
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     */
    add_theme_support( 'post-thumbnails', array( 'post', 'product', 'tribe_events') );

    set_post_thumbnail_size( 140, 140, true );

    /**
     * Add default posts and comments RSS feed links to head
     */
    add_theme_support( 'automatic-feed-links' );

    /**
     * Add Editor Style
     */
    add_editor_style( 'custom-editor-style.css' );

    /*  Register Theme menus
    /*------------------------------------------------------------------*/
    // Adds Header menu
    register_nav_menu( 'top-menu', __( 'Top Header Navigation', 'radium' ) );

    // Adds Footer menu
    register_nav_menu( 'footer-menu', __( 'Footer Navigation', 'radium' ) );

    // Adds Header menu
    register_nav_menu( 'primary', __( 'Main Navigation', 'radium' ) );

    // adds user account menu
    register_nav_menu( 'account', __( 'Account Details Navigation', 'radium' ) );

    /**
     * Enable support for Post Formats
     */
    add_theme_support( 'post-formats', array( 'gallery', 'image', 'quote', 'video', 'audio' ) );

    //* Turn on HTML5, responsive viewport
    add_theme_support( 'html5', array( 'gallery', 'caption' ) );
    add_theme_support( 'radium-responsive-viewport' );
    add_theme_support( 'woocommerce' );

    // BuddyPress Support
    add_theme_support('buddypress');

    $locale = get_locale();                                          // Get the user's locale.
    $locale = apply_filters( 'radium_locale', $locale );            // radium_framework specific locale filter
    $mofile = sprintf( '%s.mo', $locale );                   // Get mo file name

    // Setup paths to current locale file
    $mofile_local  = $framework->lang_dir . $mofile;

    // Look in local /wp-content/themes/newscore/includes/languages/ folder
    if ( is_readable( $mofile_local ) ) {
         return load_textdomain( $framework->domain, $mofile_local );
    }

}
endif; // radium_setup
add_action( 'after_setup_theme', 'radium_theme_setup' );

/*-----------------------------------------------------------------------------------*/
/* Radium Theme Image Sizes
/*-----------------------------------------------------------------------------------*/
function radium_image_sizes( $sizes ) {

    $layout_type = radium_get_option('layout_type', false, 'boxed');

    if ( $layout_type == 'narrow' ) {

        $sizes['blog_grid_mini_0']['width'] = 222;
        $sizes['blog_grid_small_0']['width'] = 560;
        $sizes['blog_grid_small_thumbs_0']['width'] = 311;
        $sizes['blog_grid_small_big_0']['width'] = 700;
         $sizes['blog_grid_two_columns_0']['width'] = 497;

        $sizes['blog_grid_mini_1']['width'] = 222;
        $sizes['blog_grid_small_1']['width'] = 415;
        $sizes['blog_grid_small_thumbs_1']['width'] = 311;
        $sizes['blog_grid_small_big_1']['width'] = 700;
        $sizes['blog_grid_two_columns_1']['width'] = 338;

        $sizes['single_blog_large']['width'] = 1275;
        $sizes['single_blog_large']['height'] = 445;
        $sizes['single_blog_large']['crop'] = true;

        $sizes['single_blog_small']['width'] = 454;
        $sizes['single_blog_small']['height'] = 242;
        $sizes['single_blog_small']['crop'] = true;

        $sizes['single_related_large']['width'] = 450;
        $sizes['single_related_large']['height'] = 250;
        $sizes['single_related_large']['crop'] = true;

        $sizes['single_related_small']['width'] = 450;
        $sizes['single_related_small']['height'] = 350;
        $sizes['single_related_small']['crop'] = true;

        $sizes['content_list_large_0']['width'] = 338;
        $sizes['content_list_large_0']['height'] = 210;
        $sizes['content_list_large_0']['crop'] = true;

        $sizes['content_list_large_1']['width'] = 338;
        $sizes['content_list_large_1']['height'] = 210;
        $sizes['content_list_large_1']['crop'] = true;

        $sizes['content_list_large_2']['width'] = 528;
        $sizes['content_list_large_2']['height'] = 250;
        $sizes['content_list_large_2']['crop'] = true;

        $sizes['content_list_small']['width'] = 55;
        $sizes['content_list_small']['height'] = 55;
        $sizes['content_list_small']['crop'] = true;

        $sizes['content_slider_medium']['width'] = 498;
        $sizes['content_slider_large']['width'] = 676;

        $sizes['content_carousel_large']['width'] = 827;
        $sizes['content_carousel_large']['height'] = 430;
        $sizes['content_carousel_large']['crop'] = true;

        $sizes['carousel_large']['width'] = 347;
        $sizes['carousel_large']['height'] = 267;
        $sizes['carousel_large']['crop'] = true;

        $sizes['carousel_small']['width'] = 406;
        $sizes['carousel_small']['height'] = 280;
        $sizes['carousel_small']['crop'] = true;

        $sizes['content_teaser_small']['width'] = 80;
        $sizes['content_teaser_small']['height'] = 80;
        $sizes['content_teaser_small']['crop'] = true;

        $sizes['review_carousel_small']['width'] = 223;
        $sizes['review_carousel_small']['height'] = 267;
        $sizes['review_carousel_small']['crop'] = true;

        $sizes['single_get_the_author_meta']['width'] = 120;
        $sizes['single_get_the_author_meta']['height'] = 120;
        $sizes['single_get_the_author_meta']['crop'] = true;

        ///Content grid slider
        $sizes['content_grid_slider_wide']['width'] = 341;
        $sizes['content_grid_slider_wide']['height'] = 158;
        $sizes['content_grid_slider_big']['width'] = 341;
        $sizes['content_grid_slider_big']['height'] = 318;
        $sizes['content_grid_slider_super_big']['width'] = 684;
        $sizes['content_grid_slider_super_big']['height'] = 600;

        $sizes['content_grid_slider_wider']['width'] = 339;
        $sizes['content_grid_slider_wider']['height'] = 241;

        ///Megamenu
        $sizes['megamenu_cat_thumb_larger']['width'] = 198;
        $sizes['megamenu_cat_thumb_larger']['height'] = 111;
        $sizes['megamenu_cat_thumb_larger']['crop'] = true;

        $sizes['megamenu_cat_thumb_smaller']['width'] = 166;
        $sizes['megamenu_cat_thumb_smaller']['height'] = 93;
        $sizes['megamenu_cat_thumb_smaller']['crop'] = true;

        $sizes['top_news_thumb']['width'] = 230;
        $sizes['top_news_thumb']['height'] = 140;
        $sizes['top_news_thumb']['crop'] = true;

        ///Blog Builder Element
        $sizes['blog_element_small_thumbs_0']['width'] = 457;
        $sizes['blog_element_two_columns_0']['width'] = 497;
        $sizes['blog_element_three_columns_0']['width'] = 331;

        $sizes['blog_element_small_thumbs_1']['width'] = 310;
        $sizes['blog_element_two_columns_1']['width'] = 337;
        $sizes['blog_element_three_columns_1']['width'] = 223;

        $sizes['blog_element_small_thumbs_2']['width'] = 229;
        $sizes['blog_element_two_columns_2']['width'] = 249;
        $sizes['blog_element_three_columns_2']['width'] = 151;

        $sizes['attachment_size']['width'] = 900;
        $sizes['attachment_size']['height'] = 900;

    } else {

        $sizes['blog_grid_mini_0']['width'] = 222;
        $sizes['blog_grid_small_0']['width'] = 560;
        $sizes['blog_grid_small_thumbs_0']['width'] = 310;
        $sizes['blog_grid_small_big_0']['width'] = 700;
        $sizes['blog_grid_two_columns_0']['width'] = 605;

        $sizes['blog_grid_mini_1']['width'] = 222;
        $sizes['blog_grid_small_1']['width'] = 415;
        $sizes['blog_grid_small_thumbs_1']['width'] = 404;
        $sizes['blog_grid_small_big_1']['width'] = 700;
        $sizes['blog_grid_two_columns_1']['width'] = 450;

        $sizes['single_blog_large']['width'] = 1275;
        $sizes['single_blog_large']['height'] = 445;
        $sizes['single_blog_large']['crop'] = true;

        $sizes['single_blog_small']['width'] = 454;
        $sizes['single_blog_small']['height'] = 242;
        $sizes['single_blog_small']['crop'] = true;

        $sizes['single_related_large']['width'] = 450;
        $sizes['single_related_large']['height'] = 250;
        $sizes['single_related_large']['crop'] = true;

        $sizes['single_related_small']['width'] = 450;
        $sizes['single_related_small']['height'] = 350;
        $sizes['single_related_small']['crop'] = true;

         $sizes['content_list_large_0']['width'] = 620;
         $sizes['content_list_large_0']['height'] = 315;
         $sizes['content_list_large_0']['crop'] = true;

        $sizes['content_list_large_1']['width'] = 440;
        $sizes['content_list_large_1']['height'] = 273;
        $sizes['content_list_large_1']['crop'] = true;

        $sizes['content_list_large_2']['width'] = 325;
        $sizes['content_list_large_2']['height'] = 200;
        $sizes['content_list_large_2']['crop'] = true;

        $sizes['content_list_small']['width'] = 55;
        $sizes['content_list_small']['height'] = 55;
        $sizes['content_list_small']['crop'] = true;

        $sizes['content_slider_medium']['width'] = 650;
        $sizes['content_slider_large']['width'] = 878;

        $sizes['content_carousel_large']['width'] = 827;
        $sizes['content_carousel_large']['height'] = 430;
        $sizes['content_carousel_large']['crop'] = true;

        $sizes['carousel_large']['width'] = 413;
        $sizes['carousel_large']['height'] = 280;
        $sizes['carousel_large']['crop'] = true;

        $sizes['carousel_small']['width'] = 406;
        $sizes['carousel_small']['height'] = 280;
        $sizes['carousel_small']['crop'] = true;

        $sizes['content_teaser_small']['width'] = 80;
        $sizes['content_teaser_small']['height'] = 80;
        $sizes['content_teaser_small']['crop'] = true;

        $sizes['review_carousel_small']['width'] = 223;
        $sizes['review_carousel_small']['height'] = 267;
        $sizes['review_carousel_small']['crop'] = true;

        $sizes['single_get_the_author_meta']['width'] = 120;
        $sizes['single_get_the_author_meta']['height'] = 120;
        $sizes['single_get_the_author_meta']['crop'] = true;

        ///Content grid slider
        $sizes['content_grid_slider_wide']['width'] = 312;
        $sizes['content_grid_slider_wide']['height'] = 158;
        $sizes['content_grid_slider_big']['width'] = 312;
        $sizes['content_grid_slider_big']['height'] = 318;
        $sizes['content_grid_slider_super_big']['width'] = 560;
        $sizes['content_grid_slider_super_big']['height'] = 600;
        $sizes['content_grid_slider_wider']['width'] = 339;
        $sizes['content_grid_slider_wider']['height'] = 241;

        $sizes['content_grid_slider_mobile']['width'] = 350;
        $sizes['content_grid_slider_mobile']['height'] = 115;

        ///Megamenu
        $sizes['megamenu_cat_thumb_larger']['width'] = 250;
        $sizes['megamenu_cat_thumb_larger']['height'] = 140;
        $sizes['megamenu_cat_thumb_larger']['crop'] = true;

        $sizes['megamenu_cat_thumb_smaller']['width'] = 250;
        $sizes['megamenu_cat_thumb_smaller']['height'] = 140;
        $sizes['megamenu_cat_thumb_smaller']['crop'] = true;

        $sizes['top_news_thumb']['width'] = 230;
        $sizes['top_news_thumb']['height'] = 140;
        $sizes['top_news_thumb']['crop'] = true;

        ///Blog Builder Element
        $sizes['blog_element_small_thumbs_0']['width'] = 560;
        $sizes['blog_element_two_columns_0']['width'] = 680;
        $sizes['blog_element_three_columns_0']['width'] = 400;

        $sizes['blog_element_small_thumbs_1']['width'] = 404;
        $sizes['blog_element_two_columns_1']['width'] = 439;
        $sizes['blog_element_three_columns_1']['width'] = 293;

        $sizes['blog_element_small_thumbs_2']['width'] = 310;
        $sizes['blog_element_two_columns_2']['width'] = 325;
        $sizes['blog_element_three_columns_2']['width'] = 215;

        $sizes['attachment_size']['width'] = 1200;
        $sizes['attachment_size']['height'] = 1200;

    }

    /* Mobile Sizes */

    /*Content grid slider
    $sizes['content_grid_slider_wide']['width'] = 150;
    $sizes['content_grid_slider_wide']['height'] = 150;
    $sizes['content_grid_slider_big']['width'] = 150;
    $sizes['content_grid_slider_big']['height'] = 150;
    $sizes['content_grid_slider_super_big']['width'] = 150;
    $sizes['content_grid_slider_super_big']['height'] = 150;
    $sizes['content_grid_slider_wider']['width'] = 150;
    $sizes['content_grid_slider_wider']['height'] = 150; */

    return $sizes;
}
add_filter( 'radium_framework_image_sizes', 'radium_image_sizes' );

/*--------------------------------------------------------------------*/
/*
/* TGM PLUGIN ACTIVATION
/*
/* REGISTER THE REQUIRED PLUGINS FOR THE THEME. THIS FUNCTION IS HOOKED
/* INTO tgmpa_init ,WHICH IS FIRED WITHIN THE TGM_Plugin_Activation CONSTRUCTOR.
/*
/*--------------------------------------------------------------------*/
function radium_register_required_plugins() {

    //PLUGIN ARRAY
    $plugins = array(

        array(
            'name'                  => 'Radium NewsCore Shortcodes',
            'slug'                  => 'radium-newscore-shortcodes', //FOLDER NAME
            'source'                => get_stylesheet_directory() . '/includes/plugins/radium-newscore-shortcodes.zip',
            'required'              => false, //RECOMMENDED - NOT REQUIRED
            'version'               => '1.1.2',
            'force_activation'      => false,
            'force_deactivation'    => false,
        ),

        array(
            'name'                  => 'Radium Tweets',
            'slug'                  => 'radium-tweets', //FOLDER NAME
            'source'                => get_stylesheet_directory() . '/includes/plugins/radium-tweets.zip',
            'required'              => false, //RECOMMENDED - NOT REQUIRED
            'version'               => '',
            'force_activation'      => false,
            'force_deactivation'    => false,
        ),

        array(
            'name'                  => 'Radium HTML5 Media',
            'slug'                  => 'radium-html5-media', //FOLDER NAME
            'source'                => get_stylesheet_directory() . '/includes/plugins/radium-html5-media.zip',
            'required'              => false, //RECOMMENDED - NOT REQUIRED
            'version'               => '',
            'force_activation'      => false,
            'force_deactivation'    => false,
        ),

        array(
            'name'                  => 'Radium Galleries Lite',
            'slug'                  => 'radium-galleries-lite', //FOLDER NAME
            'source'                => get_stylesheet_directory() . '/includes/plugins/radium-galleries-lite.zip',
            'required'              => false, //RECOMMENDED - NOT REQUIRED
            'version'               => '1.0.3',
            'force_activation'      => false,
            'force_deactivation'    => false,
        ),

        array(
            'name' 		=> 'Video Central',
            'slug' 		=> 'video-central', //FOLDER NAME
            'required' 	=> false, //RECOMMENDED - NOT REQUIRED
            'version' 	=> '1.0.0',
        ),

        array(
            'name' 		=> 'Woosidebars',
            'slug' 		=> 'woosidebars',
            'required' 	=> false, //RECOMMENDED - NOT REQUIRED
            'version'   => '1.3.1',
        ),

        array(
            'name' 		=> 'BBPress',
            'slug' 		=> 'bbpress',
            'required' 	=> false, //RECOMMENDED - NOT REQUIRED
            'version'   => '2.5.3',
        ),

        array(
            'name' 		=> 'BuddyPress',
            'slug' 		=> 'buddypress',
            'required' 	=> false, //RECOMMENDED - NOT REQUIRED
            'version'   => '1.9.2',
        ),

        array(
            'name' 		=> 'Woocommerce',
            'slug' 		=> 'woocommerce',
            'required' 	=> false, //RECOMMENDED - NOT REQUIRED
            'version'   => '2.1.7',
        ),

        array(
            'name' 		=> 'Contact Form 7',
            'slug' 		=> 'contact-form-7',
            'required' 	=> false, //RECOMMENDED - NOT REQUIRED
            'version'   => '',
        ),

        array(
            'name'      => 'Sidebar Login',
            'slug'      => 'sidebar-login',
            'required'  => false, //RECOMMENDED - NOT REQUIRED
            'version'   => '',
        ),

         //New in Version 1.4.2
        array(
            'name'      => 'Envato Wordpress Toolkit',
            'slug'      => 'envato-wordpress-toolkit',
            'required'  => false, //RECOMMENDED - NOT REQUIRED
            'version'   => '',
            'source'    => get_stylesheet_directory() . '/includes/plugins/envato-wordpress-toolkit.zip',
        ),

         //New in Version 1.6.0
        array(
            'name'      => 'YITH WooCommerce Wishlist',
            'slug'      => 'yith-woocommerce-wishlist',
            'required'  => false, //RECOMMENDED - NOT REQUIRED
            'version'   => '1.1.5',
        ),

    );

    $config = array(
        'default_path'      => '',
        'menu'              => 'install-required-plugins',
        'has_notices'       => true,
        'is_automatic'      => false,
        'message'           => '<br/>Please install the following plugins in order to take advantage of the built in features provided by this theme. First click "Activate", then "Install" upon returning to this page.<br/><br/>',
        'strings'           => array(
        'page_title'                                => __( 'Install Included Radium Plugins', 'radium' ),
        'menu_title'                                => __( 'Install Radium Plugins', 'radium' ),
        'installing'                                => __( 'Installing Plugin: %s', 'radium' ), // %1$s = plugin name
        'oops'                                      => __( 'Something went wrong with the plugin API.', 'radium' ),
        'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'radium' ),
        'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'radium' ),
        'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'radium' ),
        'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'radium' ),
        'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'radium' ),
        'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'radium' ),
        'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'radium' ), // %1$s = plugin name(s)
        'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'radium' ),
        'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'radium' ),
        'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'radium' ),
        'return'                                    => __( 'Return to Radium Plugins Installer', 'radium' ),
        'plugin_activated'                          => __( 'Plugin activated successfully.', 'radium' ),
        'complete'                                  => __( 'All plugins installed and activated successfully. %s', 'radium' )
        )
    );

    tgmpa( $plugins, $config );

}

add_action( 'tgmpa_register', 'radium_register_required_plugins' );
