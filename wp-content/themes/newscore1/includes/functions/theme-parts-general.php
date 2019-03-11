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


/*--------------------------------------------------------------------*/
/*  THEME HEADER
/*--------------------------------------------------------------------*/
if ( !function_exists( 'radium_theme_header') ) {

function radium_theme_header() {

    $class = radium_get_option('header_news') ? 'has-news' : null;
    $class .= radium_get_option('header_search') ? ' has-search' : null;
    $class .= radium_get_option('header_random') ? ' has-random' : null;
    $class .= radium_get_option('header_trending') ? ' has-trending' : null;

    $header_tools_items = radium_get_option('header_tools_items');

    $woocart    = isset($header_tools_items['woocart'])     ? $header_tools_items['woocart']    : false;
    $whishlist  = isset($header_tools_items['whishlist'])   ? $header_tools_items['whishlist']  : false;
    $lang   	= isset($header_tools_items['lang']) 		? $header_tools_items['lang']   	: false;
    $login      = isset($header_tools_items['login'])       ? $header_tools_items['login']      : false;

    $logo_position = radium_get_option('logo_position') ? radium_get_option('logo_position') : 'left';

    ?><div id="handheld-menu-holder"></div><!-- hidden --><header id="header" class="<?php echo $class; ?> logo-<?php echo $logo_position; ?>" role="banner" itemscope="itemscope" itemtype="http://schema.org/WPHeader">

        <?php do_action( 'radium_site_header_message_bar' ); ?>

        <?php if( has_nav_menu( 'top-menu' ) || $woocart || $whishlist || $lang || $login ){ ?>

        <div class="site-header-toolbar">

            <div class="row">

                <div class="large-12 columns">

                    <?php do_action( 'radium_site_header_toolbar' ); ?>

                </div><!-- END .large-12 .columns -->

            </div><!-- END .row -->

        </div><!-- .site-header-toolbar -->

        <?php } ?>

        <div class="row">

            <div class="large-12 columns">

                <div class="site-id mobile-four clearfix">

                    <?php do_action( 'radium_site_title' ); ?>

                    <?php do_action( 'radium_site_description' ); ?>

                </div><!-- END .site-id -->

                <?php if( radium_get_option( 'header_banner_enable' ) ){ ?>

                <div class="site-header-banner mobile-four clearfix">

                    <?php do_action( 'radium_site_header_banner' ); ?>

                </div><!-- END .site-header-banner -->

                <?php } ?>

            </div><!-- END .large-12 .columns -->

        </div><!-- END .row -->

        <div class="site-navigation mobile-four">

            <div class="row">

                <div class="large-12 columns">

                    <?php do_action( 'radium_site_navigation' ); ?>

                </div><!-- END .large-12 .columns -->

            </div><!-- END .row -->

        </div><!-- END .site-navigation -->

    </header><!-- END #header --><?php

}
add_action('radium_header', 'radium_theme_header');

}

/*--------------------------------------------------------------------*/
/*  Header Tools
/*--------------------------------------------------------------------*/

/**
 * radium_site_header_toolbar_menu
 *
 * @since 1.0.0
 *
 * @return void
 */
if ( !function_exists( 'radium_site_header_toolbar_menu') ) {

    function radium_site_header_toolbar_menu() {

        if ( !has_nav_menu( 'top-menu' )) return;

        $args = array(
            'sort_column'       => 'menu_order',
            'theme_location'    => 'top-menu',
            'fallback_cb'       => 'none',
            'container'         => 'ul',
            'menu_class'        => 'top-menu',
            'depth'             => '1'
        );

        wp_nav_menu(apply_filters('radium_top_menu_args', $args));

    }
    add_action('radium_site_header_toolbar', 'radium_site_header_toolbar_menu');

}

 /**
  * [radium_site_header_toolbar_tools description]
  *
  * @since  1.0.0
  *
  * @return void
  */
if ( !function_exists('radium_site_header_toolbar_tools') ) {

    function radium_site_header_toolbar_tools() {

        $framework = radium_framework();

        $header_tools_items = radium_get_option('header_tools_items');

        if ( !$header_tools_items )
            return;

        $woocart    = isset($header_tools_items['woocart'])     ? $header_tools_items['woocart']    : false;
        $whishlist  = isset($header_tools_items['whishlist'])   ? $header_tools_items['whishlist']  : false;
        $wpml   	= isset($header_tools_items['wpml']) 		? $header_tools_items['wpml']   	: false;
        $login      = isset($header_tools_items['login'])       ? $header_tools_items['login']      : false;

    ?>
    <div class="header-tools">
        <?php do_action('radium_site_header_before_toolbar_tools'); ?>
        <ul class="menu right">
            <?php if ( $framework->is_plugin_active ('sitepress-multilingual-cms/sitepress.php') && $wpml) { ?>
            <li class="parent wpml-item"><?php echo radium_languages_menu(); ?></li>
            <?php } ?>
            <?php if ( $framework->is_plugin_active ('woocommerce/woocommerce.php') && $woocart) { ?>
            <li class="parent shopping-bag-item"><?php echo radium_get_woocommerce_cart(); ?></li>
            <?php } ?>
            <?php if ( $framework->is_plugin_active ('yith-woocommerce-wishlist/init.php') && $framework->is_plugin_active ('woocommerce/woocommerce.php') && $whishlist ) { ?>
            <li class="parent wishlist-item"><?php echo radium_get_woocommerce_wishlist(); ?></li>
            <?php } ?>
            <?php if ( $framework->is_plugin_active ('sidebar-login/sidebar-login.php') && $login) { ?>
            <li class="parent account-item"><?php echo radium_get_account_details(); ?></li>
            <?php } ?>
        </ul>
        <?php do_action('radium_site_header_after_toolbar_tools'); ?>
    </div><!-- END .entry-meta -->
    <?php

    }
    add_action('radium_site_header_toolbar','radium_site_header_toolbar_tools');
}

/**
 * radium_site_header_banner
 *
 * @since  1.0.0
 *
 * @return void
 */
if ( !function_exists('radium_site_header_banner') ) {

    function radium_site_header_banner() {

        $framework = radium_framework();

        if( !radium_get_option( 'header_banner_enable' ) ) return;


           $header_banner_ad_code = radium_get_option( 'header_banner_ad_code') ? radium_get_option( 'header_banner_ad_code') : false;

        if ( $header_banner_ad_code ) {

               echo do_shortcode($header_banner_ad_code);

        } else {

            $banner = radium_get_option( 'header_banner') ? radium_get_option( 'header_banner') : $framework->theme_images_url.'/banner-728x90.jpg';
            $banner_dimensions =  radium_get_option( "banner-dimensions" );
            $banner_width =  !isset( $banner_dimensions['width']) || $banner_dimensions['width'] == '' ? 728 : $banner_dimensions['width'];
            $banner_height = !isset( $banner_dimensions['height']) || $banner_dimensions['height'] == ''? 90 : $banner_dimensions['height'];

            if( $banner ) echo '<a href="'.radium_get_option( 'header_banner_link').'" rel="nofollow"><img src="'.$banner.'" alt="banner"  width="'.$banner_width .'" height="'.$banner_height.'" /></a>';

        }

    }
    add_action('radium_site_header_banner', 'radium_site_header_banner');
}

/**
 * [radium_site_header_nav_extras description]
 * @return [type] [description]
 */
function radium_site_header_nav_extras(){

    if( radium_get_option( 'header_search') || radium_get_option( 'header_random' ) ) { ?>

    <div id="header-nav-extras">

        <?php do_action( __FUNCTION__ ); ?>

        <div class="ribbon-shadow-right bg-ribbon-shadow-right"></div>

    </div><!-- .header-nav-extras -->

   <?php }

}
add_action('radium_site_navigation', 'radium_site_header_nav_extras');


/**
 * [radium_site_header_search description]
 * @return [type] [description]
 */
function radium_site_header_search(){

    if( radium_get_option( 'header_search') ) {
       $header_search_title = radium_get_option( 'header_search_title') ? radium_get_option( 'header_search_title') : __('Search', 'radium');
        ?>

        <div id="header-search" class="bg-icon-search-white">
            <a class="search-remove" href="#" title="<?php echo $header_search_title; ?>"></a>
        </div><!-- .header-search -->

   <?php }

}
add_action('radium_site_header_nav_extras', 'radium_site_header_search');

/**
 * [radium_site_header_search_form description]
 * @return [type] [description]
 */
function radium_site_header_search_form(){

    if( radium_get_option( 'header_search' ) ) {

     $header_search_placeholder = radium_get_option( 'header_search_placeholder') ? radium_get_option( 'header_search_placeholder') : __('START TYPING..', 'radium');

    ?>
        <!--animated search form -->
        <div class="search-form">
            <div class="row-background full-width"></div>
            <div class="container">
                <form method="get" class="form-search" action="<?php echo get_home_url(); ?>">
                    <button class="submit" name="submit" id="searchsubmit"><?php _e('Search','radium');  ?><i></i></button>
                    <div class="search-query-wrapper"><input type="text" class="field search-query" name="s" value="" id="s" placeholder="<?php echo $header_search_placeholder; ?>" autocomplete="off" />
                    </div>
                </form>
            </div>
        </div>
        <!-- End search form -->
    <?php }

}
add_action('radium_site_navigation', 'radium_site_header_search_form');

/**
 * [radium_site_header_random_article description]
 * @return [type] [description]
 */
function radium_site_header_random_article(){

    if( radium_get_option( 'header_random' ) ) {

        $header_random_title = radium_get_option( 'header_random_title') ? radium_get_option( 'header_random_title') : __('Random', 'radium');

    ?><div id="header-random" class="bg-icon-random-white">
            <a href="<?php echo home_url(); ?>/?random=1" class="random-article icon-shuffle ttip" title="<?php echo $header_random_title; ?>"></a>
        </div><!-- .header-random -->
   <?php }

}
add_action('radium_site_header_nav_extras', 'radium_site_header_random_article');

/*-----------------------------------------------------------------------------------*/
# Random article
/*-----------------------------------------------------------------------------------*/

add_action('init', 'radium_random_add_rewrite');
/**
 * Add random posts rewrite
 *
 * @since 1.9.3
 *
 */
function radium_random_add_rewrite() {

    global $wp;
    $wp->add_query_var('random');
    add_rewrite_rule('random/?$', 'index.php?random=1', 'top');

}

add_action('template_redirect', 'radium_random_post');
/**
 * Random template redirect
 *
 * @since 1.9.3
 *
 * @return [type] [description]
 */
function radium_random_post(){

    if( !radium_get_option( 'header_random' ) ) return;

    if ( get_query_var('random') == 1 ) {

        $posts = get_posts('post_type=post&orderby=rand&numberposts=1');

        foreach($posts as $post) {
            $link = get_permalink($post);
        }

        wp_redirect($link, 307);

        exit;
    }

}

/*------------------------------------------------------------------------------------
// Load the Radium Breadcrumbs
 -------------------------------------------------------------------------------------*/
if ( !function_exists('radium_breadcrumbs_init') ) {

function radium_breadcrumbs_init() {

if( function_exists( 'radium_breadcrumb_trail' ) ) { ?>
    <div class="breadcrumb">
        <?php
          $header_breadcrumb_title = radium_get_option( 'header_breadcrumb_title') ? radium_get_option( 'header_breadcrumb_title') : __('You Are Here:', 'radium');
        $header_breadcrumb_home_title = radium_get_option( 'header_breadcrumb_home_title') ? radium_get_option( 'header_breadcrumb_home_title') : __('Home', 'radium');

        radium_breadcrumb_trail( array(
            'labels' => array(
                'title' => $header_breadcrumb_title . ' ',
                'home' => $header_breadcrumb_home_title,
            ),
            'max_length' => 60,  //How long title should be in chars
            'trail' => '',
        ) );
        ?>
    </div>
<?php }

}
add_action('radium_header_breadcrumb', 'radium_breadcrumbs_init');
//add_action('radium_before_post_title', 'radium_breadcrumbs_init');

}

/*--------------------------------------------------------------------*/
/*  BLOG POST META
/*--------------------------------------------------------------------*/
if ( !function_exists('radium_post_meta') ) {

    function radium_post_meta() { ?>
        <div class="entry-meta clearfix">

            <?php do_action('radium_before_post_meta'); ?>

            <?php if ( is_singular('post') ) {

                radium_get_single_post_author();

                echo radium_get_single_post_date();

            } else {

                do_action('radium_post_grid_date');

            }

            do_action('radium_after_post_meta');

            ?>

        </div><!-- END .entry-meta -->
    <?php }
    add_action('radium_after_post_title', 			'radium_post_meta');
    add_action('radium_after_post_list_title', 		'radium_post_meta');
    add_action('radium_before_post_list_big_title', 'radium_post_meta');
    add_action('radium_before_post_slider_title', 	'radium_post_meta');
    add_action('radium_before_post_review_title', 	'radium_post_meta');
    add_action('radium_before_grid_slider_post_title', 'radium_post_meta');
    add_action('radium_post_grid_extras', 'radium_post_meta');

}

/* Related posts meta details */
if ( !function_exists('radium_related_post_meta') ) {

    function radium_related_post_meta() { ?>
        <div class="entry-meta clearfix">
            <?php do_action('radium_before_post_meta'); ?>
            <?php do_action('radium_post_grid_date'); ?>
            <?php do_action('radium_after_post_meta'); ?>
        </div><!-- END .entry-meta -->
    <?php }
    add_action('radium_before_related_post_title', 	'radium_related_post_meta');

}

/** Post Excerpt */
if ( !function_exists('radium_post_excerpt') ) {

    function radium_post_excerpt() {
        $excerpt_length = apply_filters('radium_post_excerpt_length', 75);
    ?>
        <div class="entry-excerpt"><?php echo substr(get_the_excerpt(), 0, $excerpt_length); ?></div><!-- END .entry-excerpt -->
    <?php }
    add_action('radium_after_post_list_big_title', 		'radium_post_excerpt');
    add_action('radium_after_related_post_title', 		'radium_post_excerpt');
    add_action('radium_after_post_slider_title', 		'radium_post_excerpt');
    add_action('radium_after_post_review_title', 		'radium_post_excerpt');
    add_action('radium_after_grid_slider_post_title', 	'radium_post_excerpt');
}

/**
 * radium_post_meta_cats Display a list of categories
 * @return [type] [description]
 */
if ( !function_exists('radium_post_meta_cats') ) {

    function radium_post_meta_cats() {

        if( !is_singular() ) return;

        if ( radium_get_option( 'show_cats' ) == true && has_category() ) { ?>
            <div class="categories clearfix"><strong><?php echo __('Posted In: ', 'radium'); ?></strong><?php the_category('', '', ''); ?></div>
        <?php }

    }
    add_action('radium_post_footer', 'radium_post_meta_cats');

}

if ( !function_exists('radium_post_meta_tags') ) {

    /**
     * [radium_post_meta_tags description]
     * @return [type] [description]
     */
    function radium_post_meta_tags() {

        if( !is_singular() ) return;

        if ( radium_get_option( 'show_tags' ) == true && has_tag() ) { ?>
            <div class="tags clearfix"><strong><?php echo __('Tagged: ', 'radium'); ?></strong><?php the_tags('', '', ''); ?></div>
        <?php }

    }
    add_action('radium_post_footer', 'radium_post_meta_tags');

}

if ( !function_exists('radium_post_meta_source') ) {

    /**
     * [radium_post_meta_source description]
     * @return [type] [description]
     */
    function radium_post_meta_source() {

        if( !is_singular() ) return;

        if ( get_post_meta( get_the_ID(), '_radium_source_title', true ) ) { ?>
            <div class="source clearfix"><strong><?php echo __('Source: ', 'radium'); ?></strong><a href="<?php echo get_post_meta( get_the_ID(), '_radium_source_url', true ); ?>"><?php echo get_post_meta( get_the_ID(), '_radium_source_title', true ); ?></a></div>
        <?php }

    }
    add_action('radium_post_footer', 'radium_post_meta_source');

}

/**
 * [radium_post_meta description]
 * @return [type] [description]
 */
if ( !function_exists('radium_post_meta') ) {

    function radium_post_meta() {

        $framework = radium_framework();

    ?>
    <div class="entry-meta">

        <?php if ( comments_open() && !post_password_required() && $framework->theme_supports( 'comments', 'post' ) ) : ?>

            <div class="comments-link">

                <span class="icon"><span class="icon-comment"></span></span>

                <?php comments_popup_link( '<span class="leave-reply">' . __( 'Reply', 'radium' ) . '</span>', _x( '1 Comment', 'comments number', 'radium' ), _x( '% Comments', 'comments number', 'radium' ) ); ?>

            </div>

        <?php endif; ?>

        <div class="edit"><?php edit_post_link( __( '[Edit]', 'radium' )); ?></div>

    </div><!-- END .entry-meta -->
    <?php
     }

    add_action('radium_after_single_post_content', 'radium_post_meta');
}

/**
 * [radium_post_meta_tags description]
 * @return [type] [description]
 */
if ( !function_exists('radium_post_meta_tax') ) {

    function radium_post_footer() {

        if( !is_singular() || is_attachment() ) return; ?>

        <footer class="meta clearfix">
            <?php do_action('radium_post_footer');  ?>
        </footer><!-- END .entry-meta -->

    <?php

    }
    add_action('radium_after_single_post_content', 'radium_post_footer');

}

function radium_post_grid_after_header() {
    ?><div class="entry-meta clearfix">

        <?php do_action('radium_posted_on'); ?>

        <div class="by-author">
            <i class="icon-user "></i>
            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                <?php printf( __( 'By %s', 'radium' ), get_the_author() ); ?>
            </a>
        </div><!-- #author-link -->

    </div><!-- END .entry-meta --><?php
}
//add_action('radium_post_grid_after_header', 'radium_post_grid_after_header');


/**
 * [radium_post_grid_share_button description]
 * @return [type] [description]
 */
function radium_post_grid_share_button() {

    if ( !radium_get_option('share_posts') ) return;

    $total = radium_single_get_tweets() + radium_single_get_facebook_likes() + radium_single_get_plusones() + radium_single_get_linkedin_shares();
    ?>
    <div class="post-grid-share" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-excerpt="<?php the_excerpt(); ?>" data-image="" data-size="small">
        <span class="icon share"><?php echo $total; ?></span>
    </div>
    <?php
}
//add_action('radium_post_grid_extras', 'radium_post_grid_share_button');

/**
 * Post Format Icons
 *
 */
function radium_post_grid_post_format_icons() {

    $format = get_post_format();
    $format = $format ? $format : 'standard';
?>
<a href="<?php echo get_permalink() ?>" title="<?php echo sprintf( esc_attr__( 'Permalink to %s', 'radium' ), the_title_attribute( 'echo=0' ) ) ?>" rel="bookmark"><span class="post-format <?php echo $format; ?>"><?php echo __('Permalink', 'radium') ?></span></a>
<?php
}
add_action('radium_post_grid_extras', 'radium_post_grid_post_format_icons');

/**
 * [radium_post_grid_share_button description]
 * @return [type] [description]
 */
function radium_post_grid_comments() {

    if ( comments_open() ): ?>
        <a class="post-grid-comments" href="<?php comments_link(); ?>">
            <span><i class="icon icon-comments"></i><?php echo get_radium_comment_count(); ?></span>
        </a>
    <?php endif;
}
//add_action('radium_post_grid_comments', 'radium_post_grid_comments');

/**
 * [radium_post_grid_cat description]
 * @return [type] [description]
 */
function radium_post_grid_extras() { ?>

    <div class="entry-extras">

        <?php do_action('radium_post_home_grid_extras'); ?>

    </div>

<?php
}
add_action('radium_post_grid_extras',        		'radium_post_grid_extras');
add_action('radium_before_post_thumb',              'radium_post_grid_extras');
add_action('radium_before_post_list_big',     		'radium_post_grid_extras');
add_action('radium_before_recent_post_title',       'radium_post_grid_extras');
add_action('radium_before_content_slider',       	'radium_post_grid_extras');

if ( is_single() )
    add_action('radium_before_post_title',          'radium_post_grid_cat');

/*
 * Content Slider Element meta
 *
 */
function radium_content_slider_meta() {
    if( isset( $instance['meta'] ) && $instance['meta'] ) { ?>
    <div class="entry-meta">
        <?php if( isset( $instance['date'] ) && $instance['date'] ) radium_human_time();

        if( isset( $instance['author'] ) && $instance['author'] ) { ?>by <?php echo get_the_author(); ?>
        <?php }

        if( isset( $instance['cat'] ) && $instance['cat'] ) {
            $categories_list = get_the_category_list( __( ', ', 'radium' ) );

            if ( $categories_list && radium_categorized_blog() ) : ?>
            <span class="cat-links"><?php printf( __( '<span> on </span>%1$s', 'radium' ), $categories_list ); ?></span>
            <?php endif;
        }
        ?>
    </div>
    <?php }
}

/**
 * [radium_get_single_post_date description]
 * @return [type] [description]
 */
function radium_get_single_post_date() {

    $post_meta_elements = radium_get_option('single_post_meta_elements');
    $single_show_date 	= isset($post_meta_elements['date']) ? true : false;

    $extra = null;

    if( $single_show_date ) {

        $extra .= '<div class="date">';

            $extra .= radium_get_human_time();

            $extra .= '</div>';

        return $extra;

    } else {

        return '';
    }

}

/**
 * [radium_get_single_post_author description]
 * @return [type] [description]
 */
function radium_get_single_post_author() {

    $post_meta_elements = radium_get_option('single_post_meta_elements');
    $single_show_author 	= isset($post_meta_elements['author']) ? true : false;

    if( $single_show_author ) { ?>

        <div class="author-link">
            <?php echo get_avatar( get_the_author_meta('user_email'), 24 ); ?>
            <a class="author-name author" href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" title="<?php _e('View all posts by', 'radium'); ?> <?php the_author(); ?>" rel="author"><?php the_author(); ?></a>
        </div>

    <?php }

}

/**
 * [radium_post_grid_cat Show the first category of an item
 * @return string the div with the category
 */
function radium_get_post_grid_cat( $extra = '') {

    $post_meta_elements = radium_get_option('post_meta_elements');
    $show_category = isset($post_meta_elements['category']) ? true : false;

    $category = get_the_category();

    $category_id = isset($category[0]) ? $category[0]->cat_ID : false;

    $cat_style = get_option(  'radium_category_option_'.$category_id, array( 'style' => 'none', ));

    $classes = $cat_style['style'];

    if( isset($category[0]) && $show_category) {

        $extra .= '<div class="entry-category '. $classes .'">';

            $extra .= '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';

            $extra .= '</div>';

            return $extra;

    } else {

        return '';

    }

}

function radium_post_grid_cat() {
    echo radium_get_post_grid_cat();
}

add_action('radium_post_home_grid_extras', 'radium_post_grid_cat');

/**
 * [radium_post_grid_date description]
 * @return [type] [description]
 */
function radium_get_post_grid_date( $extra = '') {

    $post_meta_elements = radium_get_option('post_meta_elements');
    $show_date = isset($post_meta_elements['date']) ? true : false;
    if( $show_date ) {

        $extra .= '<div class="date">';

            $extra .= radium_get_human_time();

            $extra .= '</div>';

            return $extra;

    } else {

        return '';
    }

}
 if ( !function_exists('radium_post_grid_date') ) {

function radium_post_grid_date() {
    echo radium_get_post_grid_date();
}
add_action('radium_post_grid_date', 'radium_post_grid_date');

}


/**
 * [radium_post_grid_featured description]
 * @return [type] [description]
 */
 if ( !function_exists('radium_post_grid_featured') ) {

    function radium_get_post_grid_featured( $extra = '' ) {

        global $post;

        $post_id = $post ? $post->ID : 0;

        $featured = get_post_meta($post_id, '_radium_featured', true);
        $post_meta_elements = radium_get_option('post_meta_elements');

        $show_featured = isset($post_meta_elements['featured']) ? true : false;

        if ( !$featured || !$show_featured ) return '';

        $extra .= '<div class="entry-featured">'.__('Featured', 'radium').'</div>';

        return $extra;

    }
    add_filter('radium_megamenu_post_grid_extras', 'radium_get_post_grid_featured');
    add_filter('radium_top_news_post_grid_extras', 'radium_get_post_grid_featured');

}

if ( !function_exists('radium_post_grid_featured') ) {

function radium_post_grid_featured() {

    echo radium_get_post_grid_featured();
}

add_action('radium_post_home_grid_extras', 'radium_post_grid_featured');
}

// CONTENT PULLED BY ABOUT THE AUTHOR & PROFILE PAGE
if ( !function_exists('radium_author_icons') ) {

    function radium_author_icons() { ?>

    <ul class="author-links">

        <?php

        if (get_the_author_meta('user_url')) { ?>

            <li><a target="_blank" href="<?php the_author_meta('user_url'); ?>" ><span class="social-icon www"></span></a></li>

        <?php } if (get_the_author_meta('twitter')) { ?>

            <li><a target="_blank" href="http://www.twitter.com/<?php the_author_meta('twitter'); ?>" class="" title="<?php the_author_meta('display_name'); ?> on Twitter"><span class="social-icon twitter"></span></a></li>

        <?php } if (get_the_author_meta('facebook')) { ?>

            <li><a target="_blank" href="<?php the_author_meta('facebook'); ?>" title="<?php the_author_meta('display_name'); ?> on Facebook"><span class="social-icon facebook"></span></a></li>

        <?php } if (get_the_author_meta('dribbble')) { ?>

            <li><a target="_blank" href="<?php the_author_meta('dribbble'); ?>" title="<?php the_author_meta('display_name'); ?> on Dribbble"><span class="social-icon dribble"></span></a></li>

        <?php } if (get_the_author_meta('instagram')) { ?>

            <li><a target="_blank" href="<?php the_author_meta('instagram'); ?>" title="<?php the_author_meta('display_name'); ?> on Instagram"><span class="social-icon instagram"></span></a></li>

        <?php } if (get_the_author_meta('google_plus')) { ?>

            <li><a target="_blank" href="<?php the_author_meta('google_plus'); ?>" title="<?php the_author_meta('display_name'); ?> on Google+"><span class="social-icon googleplus"></span></a></li>

        <?php } if (get_the_author_meta('email')) { ?>

            <li><a target="_blank" href="mailto:<?php the_author_meta('email'); ?>" title="Email <?php the_author_meta('display_name'); ?>"><span class="social-icon email"></span></a></li>

        <?php } ?>

    </ul><!-- END .author-links -->

    <?php }

    add_action('radium_author_icons', 'radium_author_icons');

}

/*------------------------------------------------------------------------------------
// Load the Radium Author Info
 -------------------------------------------------------------------------------------*/
if( !function_exists('radium_post_author_info') ) {

    function radium_post_author_info(){

        if ( post_password_required() ) return;

        if( radium_get_option( 'author_info' ) == true)
            get_template_part( 'includes/content/content', 'about-author' );

    }

    add_action('radium_after_single_post_content', 'radium_post_author_info');

}

/*--------------------------------------------------------------------*/
/*  POST PAGINATION
/*--------------------------------------------------------------------*/
if( !function_exists('radium_post_nav') ) {

    function radium_post_nav() { ?>

        <?php if ( is_single() && get_post_type() == 'post' ) {

                $header_tag = (radium_get_option('story_navigation') == 'sidebar') ? 'h6' : 'h4';

            ?>

            <div class="post-nav <?php radium_option('story_navigation' ); ?>">
                <nav class="story-navigation clearfix">
                    <ul>
                        <li class="previous">
                             <?php previous_post_link('%link', '<i class="icon icon-chevron-left"></i><'.$header_tag.'>'.__('Previous story', 'radium').'</'.$header_tag.'> <span>%title</span>'); ?>
                        </li>
                        <li class="next">
                            <?php next_post_link('%link', '<'.$header_tag.'>'.__('Next story', 'radium').' <i class="icon icon-chevron-right"></i></'.$header_tag.'><span>%title</span>'); ?>
                        </li>
                    </ul>
                </nav>
            </div>

            <?php }

    }

    if ( radium_get_option('story_navigation') == 'sidebar' ) {

        add_action('radium_before_sidebar', 'radium_post_nav');

    } elseif( radium_get_option('story_navigation' ) == 'below-post') {

        add_action('radium_after_single_post_content', 'radium_post_nav');

    }

}


if( !function_exists('radium_single_recent_posts') ) {

    /**
     * radium_single_recent_posts Recent Posts for Single posts
     *
     * @return [type] [description]
     */
    function radium_single_recent_posts(){

        if ( post_password_required() || !is_singular('post') ) return;

        $framework = radium_framework();

        include( $framework->theme_includes_dir . '/extensions/recent-posts.php');

    }
    add_action('radium_before_page', 'radium_single_recent_posts');

}

/*------------------------------------------------------------------------------------
// Load the Radium Related Posts
 -------------------------------------------------------------------------------------*/

if( !function_exists('radium_related_posts') ) {

    function radium_related_posts(){

        if ( post_password_required() ) return;

        $framework = radium_framework();

        $related_posts = radium_get_option('related_posts');

        if ( $related_posts )
            include( $framework->theme_includes_dir . '/extensions/related-posts.php');

    }
    add_action('radium_after_single_post_content', 'radium_related_posts');

}

/*--------------------------------------------------------------------*/
/*  THEME TOP FOOTER WIDGET
/*--------------------------------------------------------------------*/

if( !function_exists('radium_footer_top_widgets') ) {

    /* Footer Widgets */
    function radium_footer_top_widgets(){

        get_template_part( 'includes/content/content', 'global-widgets' );

    }
    add_action('radium_after_page', 'radium_footer_top_widgets');

}

/*--------------------------------------------------------------------*/
/* ADMIN FOOTER CREDITS
/*--------------------------------------------------------------------*/
if ( !function_exists('radium_footer_admin') ) {

    function radium_footer_admin () {
        echo 'Thank you for theming with <a href="http://radiumthemes.com" target="blank">Radium Themes</a>.';
    }
    add_filter('admin_footer_text', 'radium_footer_admin');

}

/*--------------------------------------------------------------------*/
/* Global Markup Used by ajax alerts
/*--------------------------------------------------------------------*/
if ( !function_exists('radium_before_markup_globals') ) :

    function radium_before_markup_globals() { ?>
    <div id="global-loading" class="loading-dots">
        <span class="dot-1"></span>
        <span class="dot-2"></span>
        <span class="dot-3"></span>
    </div>
    <div id="global-alert" class="alert alert-message"></div>
<?php }
add_action('radium_before_footer', 'radium_before_markup_globals');

endif;


/*--------------------------------------------------------------------*/
/* THEME FOOTER SECTION
/*--------------------------------------------------------------------*/

if( !function_exists('radium_footer_navigation') ) :

    function radium_footer_navigation() {

        if ( has_nav_menu( 'footer-menu' ) ) : ?>

                <div class="large-12 columns">

                    <div id="footer-menu">

                        <?php do_action('radium_footer_navigation'); ?>

                    </div><!--End #Footer-menu -->

                </div><!-- END .large-12 columns -->

            <?php endif;

    }
    add_action('radium_footer', 'radium_footer_navigation');

endif;

/*--------------------------------------------------------------------*/
/*  CUSTOM LOGIN LOGO
/*--------------------------------------------------------------------*/
if ( !function_exists('radium_custom_login') ) {
    function radium_custom_login() {

      $framework = radium_framework();

      if( radium_get_option( 'login_logo' ) ) {

          $login_logo = radium_get_option( 'login_logo');

      } else {

          $login_logo = $framework->theme_images_url.'/login-logo.png';

      }

    $dimensions = @getimagesize( $login_logo );
    echo '<style>' . "\n" . 'body.login #login h1 a { background: url("' . $login_logo . '") no-repeat scroll center top transparent; height: ' . $dimensions[1] . 'px; background-size: auto !important; width: auto; }' . "\n.login #nav {text-align: center}.login #backtoblog { display:none }" . '</style>' . "\n";

    }
    add_filter('login_head', 'radium_custom_login');
}

if ( !function_exists('radium_login_url') ) {
    function radium_login_url($url) {
        $login_url = home_url();
        return $login_url;
    }
    add_filter('login_headerurl', 'radium_login_url');
}

if ( !function_exists('radium_login_title') ) {
    function radium_login_title($title) {
        $title_text = get_bloginfo('name').' - Log In';
        return $title_text;
    }
    add_filter('login_headertitle', 'radium_login_title');
}

 /**
  * Radium Image Lightbox Icon
  *
  *  @since 2.1.4
  */
if ( !function_exists('radium_image_sc_icon') ) :

    function radium_image_sc_icon( $icon) {

        $icon = '<span class="icon-resize-full"></span>';

        return $icon;
    }

endif;
add_filter('radium_image_sc_after_image', 'radium_image_sc_icon');

add_action('radium_single_post_meta', 'radium_single_post_image_meta');
/**
 * Add image rich snippet to single blog posts
 *
 * @since 1.9.1
 *
 */
function radium_single_post_image_meta() {

    if( !is_single() ) return;

    $img_url = get_radium_first_post_image(false);

    echo '<meta itemprop="image" content="'. $img_url .'"/>';


}
