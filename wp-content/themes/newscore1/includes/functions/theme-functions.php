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

/* ---------------------------------------------------------------------- */
/*	Sidebar Loader
/* ---------------------------------------------------------------------- */
function radium_sidebar_loader( $_radium_sidebar_location = '' ) {

    $framework = radium_framework();

    $options = $framework->options;

    $radium_sidebar_location = null;

    if ( 'post'== get_post_type() && is_single() && ( get_post_meta (get_the_ID(), '_radium_page_layout', true) == '') ) {

        $radium_sidebar_location = isset($options['single_post_layout']) ? $options['single_post_layout'] : null;

    } elseif ( $_radium_sidebar_location !== '' ) {

        $radium_sidebar_location = $_radium_sidebar_location;

    } elseif ( !is_404() && !is_search() ) {

        //Setup Sidebar (it's also overrides post and archive setting from admin panel)
        $radium_sidebar_location = get_post_meta (get_the_ID(), '_radium_page_layout', true);

    }

    $radium_sidebar_location = apply_filters( 'radium_sidebar_location', $radium_sidebar_location );

    $radium_sidebar_class = $radium_content_class = null;

    if ( $radium_sidebar_location === 'right' ) {

        $radium_sidebar_class = "large-3 columns sidebar-right";
        $radium_content_class = "large-9 columns sidebar-right";
        $sidebar_status = true;

    } elseif ( $radium_sidebar_location === 'left' ) {

        $radium_sidebar_class = "large-3 columns pull-9 sidebar-left";
        $radium_content_class = "large-9 columns push-3 sidebar-left";
        $sidebar_status = true;

    } else {

        $radium_content_class = "large-12 columns";
        $sidebar_status = false;

    }

    $sidebar = array (
        'sidebar_position'  => $radium_sidebar_location,
        'sidebar_class'     => $radium_sidebar_class . ' sidebar-wrapper',
        'content_class'     => $radium_content_class,
        'sidebar_active'    => $sidebar_status,
    );

    $sidebar = apply_filters( __FUNCTION__, $sidebar );

    $framework->sidebar = $sidebar;

    return $sidebar;
}

//*-----------------------------------------------------------------------------------*/
/*  Adds custom classes to the array of body classes.
/*-----------------------------------------------------------------------------------*/
function radium_browser_sidebar_body_class($classes) {

    if ( is_home() && is_front_page() ) {

        $sidebar_position = radium_get_option('post_archives_layout') ? radium_get_option('post_archives_layout') : 'right';

        $sidebar = radium_sidebar_loader( $sidebar_position );

    } elseif ( is_category() ) {

        $options = radium_get_category_option(get_cat_id( single_cat_title("", false) ));

        $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

        $sidebar_position = isset($options['sidebar']) ? $options['sidebar'] : 'right';

        $sidebar = radium_sidebar_loader( $sidebar_position );

    } else {

        $sidebar = radium_sidebar_loader( );
    }

    if ( $sidebar['sidebar_position'] === 'left'  ) {

        $classes[] = 'left-sidebar with-sidebar';

    } elseif ( $sidebar['sidebar_position'] === 'right') {

        $classes[] = 'right-sidebar with-sidebar';

    } else {

        $classes[] = 'no-sidebar';

    }

    return apply_filters( __FUNCTION__, $classes );

}
add_filter('body_class', 'radium_browser_sidebar_body_class');


/*--------------------------------------------------------------------*/
/*  Remove Inline Style added by Multisite in the Signup Form
/*--------------------------------------------------------------------*/
if ( !function_exists('radium_wpmu_signup_stylesheet') ) {
    function radium_wpmu_signup_stylesheet() {
        remove_action( 'wp_head', 'wpmu_signup_stylesheet');
    }
    add_action( 'wp_head', 'radium_wpmu_signup_stylesheet', 1 );
}


/*--------------------------------------------------------------------*/
/*  FIX FOR CATEGORY REL TAG (PRODUCES INVALID HTML5 CODE)
/*--------------------------------------------------------------------*/
if ( !function_exists('radium_add_nofollow_cat') ) {
    function radium_add_nofollow_cat( $text ) {
        $text = str_replace('rel="category tag"', "", $text);

        return apply_filters( __FUNCTION__, $text );

    }
    add_filter( 'the_category', 'radium_add_nofollow_cat' );
}

/*--------------------------------------------------------------------*/
/*  AUTHOR ICONS (ABOUT THE AUTHOR & AUTHOR PROFILE PAGES)
/*--------------------------------------------------------------------*/

// ADD FIELDS TO ADMIN USER PROFILE
function radium_author_fields( $contactmethods ) {

    $contactmethods['twitter'] = 'Twitter Username';
    $contactmethods['dribbble'] = 'Dribbble URL';
    $contactmethods['facebook'] = 'Facebook URL';
    $contactmethods['instagram'] = 'Instagram URL';
    $contactmethods['google_plus'] = 'Google Plus URL';

    return apply_filters( __FUNCTION__, $contactmethods );

}
add_filter('user_contactmethods','radium_author_fields', 10, 1);


/*--------------------------------------------------------------------*/
/*  REDIRECT TO SEARCH RESULT, IF ONLY ONE RESULT IS FOUND
/*--------------------------------------------------------------------*/
function radium_single_search_result() {

    if (is_search()) {

        global $wp_query;

        if ($wp_query->post_count == 1)
            wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );

    }
}

add_action('template_redirect', 'radium_single_search_result');


/*--------------------------------------------------------------------*/
/*  GET WORDPRESS COMMENTS COUNT
/*--------------------------------------------------------------------*/

function get_radium_comment_count() {

     global $post_id;

    $queried_post = get_post($post_id);

    $count = $queried_post->comment_count;

    if ( $count == 0 ) :

        $count = null;

    elseif( $count > 1 ) :

        $count = $count.' '.__('Comments', 'radium');

    else :

        $count = $count.' '.__('Comment', 'radium');

    endif;

    return apply_filters( __FUNCTION__, $count);

}

/**
 * Radium Build Cart Menu
 *
 * @return String
 *
 * @since 2.1.5
 */
function radium_get_woocommerce_cart() {

    $output = null;

    // Check if WooCommerce is active
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

        global $woocommerce;

        $cart_total = is_object($woocommerce) ? $woocommerce->cart->get_cart_total() : 0;

        $cart_count = is_object($woocommerce) ? $woocommerce->cart->cart_contents_count : 0;

        $output .= '<a class="cart-contents" href="'.$woocommerce->cart->get_cart_url().'" title="'.__("View your shopping cart", "radium").'">';

        $output .= $cart_total;

        $output .= '</a>';

        $output .= '<ul class="sub-menu">';

        $output .= '<li>';

        $output .= '<div class="shopping-bag">';

        if ( sizeof( $woocommerce->cart->cart_contents ) > 0 ) {

            $output .= '<div class="bag-header">'.sprintf(_n('1 item in the shopping bag', '%d items in the shopping bag', $woocommerce->cart->cart_contents_count, 'radium'), $woocommerce->cart->cart_contents_count).'</div>';

            $output .= '<div class="bag-contents">';

            foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item) {

                $bag_product = $cart_item['data'];

                $product_title = $bag_product->get_title();

                $product_short_title = (strlen($product_title) > 25) ? substr($product_title, 0, 22) . '...' : $product_title;

                if ( $bag_product->exists() && $cart_item['quantity'] > 0 ) {

                    $output .= '<div class="bag-product clearfix">';

                      $output .= '<figure><a class="bag-product-img" href="'.get_permalink($cart_item['product_id']).'">'.$bag_product->get_image().'</a></figure>';

                    $output .= '<div class="bag-product-details">';

                    $output .= '<div class="bag-product-title"><a href="'.get_permalink($cart_item['product_id']).'">' . apply_filters('woocommerce_cart_widget_product_title', $product_short_title, $bag_product) . '</a></div>';

                    $output .= '<div class="bag-product-price">'.__("Unit Price:", "radium").' '.woocommerce_price($bag_product->get_price()).'</div>';

                    $output .= '<div class="bag-product-quantity">'.__('Quantity:', 'radium').' '.$cart_item['quantity'].'</div>';

                    $output .= '</div>';

                    $output .= apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', 'radium') ), $cart_item_key );

                    $output .= '</div>';
                }
            }

            $output .= '<div class="cart-subtotal clearfix">';

            $output .= '<span class="desc">'.__('Subtotal', 'radium').'</span>';

            $output .= $woocommerce->cart->get_cart_total();

            $output .= '</div>';

            $output .= '</div>';

            $output .= '<div class="bag-buttons">';

            $output .= '<a class="button transparent orange bag-button center" href="'.esc_url( $woocommerce->cart->get_cart_url() ).'"><span>'.__('View shopping bag', 'radium').'</span></a>';

            $output .= '<a class="button transparent orange header-checkout-button center" href="'.esc_url( $woocommerce->cart->get_checkout_url() ).'"><span >'.__('Proceed to checkout', 'radium').'</span></a>';

               $output .= '</div>';

        } else {

               $output .= '<div class="bag-header">'.__("0 items in the shopping bag", "radium").'</div>';

               $output .= '<div class="bag-empty">'.__('Unfortunately, your shopping bag is empty.','radium').'</div>';

            $shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );

            $output .= '<div class="bag-buttons">';

            $output .= '<a class="button transparent orange center" href="'.esc_url( $shop_page_url ).'"><span>'.__('Go to the shop', 'radium').'</span></a>';

            $output .= '</div>';

        }

        $output .= '</div>';

        $output .= '</li>';

        $output .= '</ul>';

    }

    return apply_filters( __FUNCTION__, $output);

}

/**
 * Radium Build Wish-list Menu
 *
 * @return String
 *
 * @since 2.1.5
 */
function radium_get_woocommerce_wishlist() {

    global $wpdb, $yith_wcwl, $woocommerce;

    $output = null;
    $wishlist = array();

    if ( is_user_logged_in() )
        $user_id = get_current_user_id();

    $output .= '<a class="wishlist-link" href="'.$yith_wcwl->get_wishlist_url().'" title="'.__("View your wishlist", "radium").'"><i class="icon-star"></i><span>'.radium_get_wishlist_count().'</span></a>';

    $output .= '<ul class="sub-menu">';

    $output .= '<li>';

    $output .= '<div class="wishlist-bag">';

    $current_page = 1;

    $limit_sql = '';

    //$count_limit = 0;

    if( is_user_logged_in() ) {

        $table_name = YITH_WCWL_TABLE;

        if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name )
          $wishlist = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `" . YITH_WCWL_TABLE . "` WHERE `user_id` = %s" . $limit_sql, $user_id ), ARRAY_A );

    } elseif( yith_usecookies() ) {

        $wishlist = yith_getcookie( 'yith_wcwl_products' );

    } else {

        $wishlist = isset( $_SESSION['yith_wcwl_products'] ) ? $_SESSION['yith_wcwl_products'] : array();

    }

    do_action( 'yith_wcwl_before_wishlist_title' );

    $wishlist_title = get_option( 'yith_wcwl_wishlist_title' );

    if( !empty( $wishlist_title ) )
        $output .= '<div class="bag-header">'.$wishlist_title.'</div>';

    $output .= '<div class="bag-contents" data-count="'. radium_get_wishlist_count() .'">';

    $output .= do_action( 'yith_wcwl_before_wishlist' );

    if ( count( $wishlist ) > 0 ) :

           foreach( $wishlist as $values ) :

            //if ($count_limit < 10) {

                if( !is_user_logged_in() ) {

                    if( isset( $values['add-to-wishlist'] ) && is_numeric( $values['add-to-wishlist'] ) ) {

                        $values['prod_id'] = $values['add-to-wishlist'];
                        $values['ID'] = $values['add-to-wishlist'];

                    } else {

                        $values['prod_id'] = $values['product_id'];
                        $values['ID'] = $values['product_id'];

                    }

                }

                $product_obj = get_product( $values['prod_id'] );

                if( $product_obj !== false && $product_obj->exists() ) :

                $output .= '<div id="wishlist-'.$values['ID'].'" class="bag-product clearfix">';

                if ( has_post_thumbnail($product_obj->id) ) {

                    $image_link 	= wp_get_attachment_url( get_post_thumbnail_id($product_obj->id) );
                    $image 			= radium_resize( $image_link, 70, 70, true, false);

                    if ($image)
                        $output .= '<figure><a class="bag-product-img" href="'.esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $values['prod_id'] ) ) ).'"><img itemprop="image" src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" /></a></figure>';

                }

                $output .= '<div class="bag-product-details">';

                $output .= '<div class="bag-product-title"><a href="'.esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $values['prod_id'] ) ) ).'">'. apply_filters( 'woocommerce_in_cartproduct_obj_title', $product_obj->get_title(), $product_obj ) .'</a></div>';

                if ( get_option( 'woocommerce_display_cart_prices_excluding_tax' ) == 'yes' ) {

                    $output .= '<div class="bag-product-price">'.apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_obj->get_price_excluding_tax() ), $values, '' ).'</div>';

                   } else {

                       $output .= '<div class="bag-product-price">'.apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_obj->get_price() ), $values, '' ).'</div>';

                }

                $output .= '</div>';
                $output .= '</div>';

                endif;

                // $count_limit++;
            //}

        endforeach;

    else :

        $output .= '<div class="wishlist-empty">'. __( 'Your wish-list is currently empty.', 'radium' ) .'</div>';

    endif;

    $output .= '</div>';

    $output .= '<div class="bag-buttons">';

    $output .= '<a class="button transparent orange center" href="'.$yith_wcwl->get_wishlist_url().'"><span>'.__('Go to your wish-list', 'radium').'</span></a>';

    $output .= '</div>';

    do_action( 'yith_wcwl_after_wishlist' );

    $output .= '</div>';

    $output .= '</li>';

    $output .= '</ul>';

    return apply_filters( __FUNCTION__, $output);
}

/**
 * Radium Build Wish-list Count
 *
 * @return String
 *
 * @since 2.1.5
 */
function radium_get_wishlist_count() {

    global $wpdb, $yith_wcwl;

    if ( is_user_logged_in() )
        $user_id = get_current_user_id();

    $count = array();

    if( is_user_logged_in() ) {

        $table_name = YITH_WCWL_TABLE;

        if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name )
            $count = $wpdb->get_results( $wpdb->prepare( 'SELECT COUNT(*) as `cnt` FROM `' . YITH_WCWL_TABLE . '` WHERE `user_id` = %d', $user_id  ), ARRAY_A );

    } elseif( yith_usecookies() ) {

        $count[0]['cnt'] = count( yith_getcookie( 'yith_wcwl_products' ) );

    } else {

        $count[0]['cnt'] = count( $_SESSION['yith_wcwl_products'] );

    }

    $count = isset($count[0]['cnt']) ? $count[0]['cnt'] : 0;

    return $count;
}

//Restore woocommerce check if it doesn't exist
if ( !function_exists('is_shop')) : function is_shop() { return false; } endif;

/**
 * radium_get_account_details
 *
 * @since 2.1.6
 *
 * @return string
 */
function radium_get_account_details() {

    $output = null;

    $output .= is_user_logged_in() ? '<a href="'. wp_logout_url( get_permalink() )  .'"><i class="icon-sign-out"></i> '. __('Sign Out', 'radium'). '</a>': '<a href="'. wp_login_url( get_permalink() )  .'"><i class="icon-sign-in"></i> '. __('Sign In', 'radium').'</a>';

    $output .= '<ul class="sub-menu"><li><div class="inner widget_wp_sidebarlogin">';

    if ( is_user_logged_in() ) {

        global $current_user;

        $user_ID = get_current_user_id();

        $output .= '<div class="user-info-details clearfix">';

        $output .= '<div class="avatar_container">' . get_avatar( $user_ID, apply_filters( 'radium_header_login_avatar_size', 50 ) ) . '</div>';

        $output .= '<div class="username_container">';

        $output .=  '<span class="display_name">' . __('Welcome', 'radium') . ' '.$current_user->display_name . '</span>';

        $output .=  '<span class="user_login">' .$current_user->user_login . '</span>';

        $output .=  '<span class="user_email">' .$current_user->user_email . '</span>';

        $output .= '</div>';

        $output .= '</div>';

    } else {

        $output .= radium_login_form();

    }

    $output .= '<div class="clearfix"></div>';

    $output .= radium_user_info_menu();

    $output .= radium_user_info_links();

    $output .= '</div></li></ul>';

    return apply_filters( __FUNCTION__, $output);
}

/**
 * radium_login_form
 *
 * @since  2.1.6
 *
 * @return string
 */
function radium_login_form () {

    $args = array (
        'logged_out_title' => '<h3>Login <span><i class="icon-lock"></i></span></h3>',
        'logged_out_links' => '',
        'show_lost_password_link' => '1',
        'show_register_link' => '1',
        'login_redirect_url' => '',
        'logged_in_title' => ' ',
        'logged_in_links' => 'Dashboard | %admin_url% Profile | %admin_url%/profile.php Logout | %logout_url%',
        'show_avatar' => '0',
        'logout_redirect_url' => '',
        'radium_widget_class' => 'header-login',
    );

    $args = apply_filters( 'radium_login_form_args', $args );

    return radium_load_widget( 'Sidebar_Login_Widget', $args);
}
add_action('radium_login_form', 'radium_login_form');

/**
 * [radium_login_menu description]
 *
 * @since 2.1.6
 *
 * @return [type] [description]
 */
function radium_user_info_menu() {

    if ( !is_user_logged_in() ) return;

    $output = null;

    if ( has_nav_menu( 'account' ) ) :

        $output .= '<div class="user-info-nav-primary">';

        $args = array(
            'sort_column'       => 'menu_order',
            'theme_location'    => 'account',
            'fallback_cb'       => 'none',
            'container'         => 'ul',
            'menu_class'        => 'account-menu',
            'depth'             => '1',
            'echo'              => false,
        );

        $output .= wp_nav_menu(apply_filters('radium_footer_menu_args', $args));

        $output .= '</div>';

    endif;

    return apply_filters( __FUNCTION__, $output);
}

/**
 * radium_user_info_links
 *
 * @since 2.1.6
 *
 * @return $output
 */
function radium_user_info_links() {

    if ( !is_user_logged_in() ) return;

    $dashboard_url = apply_filters('radium_user_info_dashboard_url', get_admin_url().'/profile.php');

    $output = null;

    $output .= '<div class="user-info-extra-links clearfix">';

    $output .= '<a href="'.$dashboard_url.'" title="dashboard" class="menu-dashboard"><span class="icon-edit"></span> '. __('Edit Profile', 'radium').'</a>';

    $output .= '<a href="'.wp_logout_url( get_permalink() ).'" title="logout" class="menu-logout">'. __('Logout', 'radium').' <span class="icon-off"></span></a>';

    $output .= '</div>';

    return apply_filters( __FUNCTION__, $output);
}

/**
 * radium_languages_menu
 *
 * @since 2.1.6
 *
 * @return $output
 */
function radium_languages_menu() {

    $output = null;
    $framework = radium_framework();

    $wpml = radium_get_option('header_tools_items', 'wpml', false);

    if ( $framework->is_plugin_active ('sitepress-multilingual-cms/sitepress.php') && $wpml ) {

        $output .= '<a class="radium-lang-link" href="#" title="'.__("Languages", "radium").'"><i class="icon-flag"></i><span>'.__("Languages", "radium").'</span></a>';

        $output .= '<ul class="sub-menu">';

        $output .= do_action('radium_lang_before_menu');

        $languages = icl_get_languages('skip_missing=0&orderby=code');

        if(!empty($languages)){

            foreach($languages as $l){
                 $output .= '<li><div class="language-link-wrapper">';
                if($l['country_flag_url']){
                    if(!$l['active'])  $output .= '<a href="'.$l['url'].'">';
                     $output .= '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
                    if(!$l['active'])  $output .= '</a>';
                }
                if(!$l['active'])  $output .= '<a href="'.$l['url'].'">';
                $output .= icl_disp_language($l['native_name'], $l['translated_name']);
                if(!$l['active'])  $output .= '</a>';
                $output .= '</div></li>';
            }
            }

        $output .= do_action( 'radium_lang_after_menu' );;

        $output .= '</ul>';

    }

    return apply_filters( __FUNCTION__, $output);

}

/**
 * radium_page_header_content get page header
 *
 * @since  2.1.7
 *
 * @return null
 */
function radium_page_header_content( $header ) {

    global $post;

    $post_id = $post ? $post->ID : 0;

    $framework = radium_framework();

    $header_title_state = $header_subtitle_state = null;

    $header_title_state = get_post_meta( $post_id, '_radium_title', true );
    $header_subtitle = get_post_meta( $post_id, '_radium_subtitle', true );
    $subtitle = null;

    if (is_archive()) { // A few checks for archives

        if( is_tag() ) {

            $header_title = sprintf( __( 'Tag: %s', 'radium' ), '<span>' . single_tag_title( '', false ) . '</span>' );

            $tag_description = tag_description();

            if ( ! empty( $tag_description ) )
                $header_subtitle = apply_filters( 'tag_archive_meta', '<div class="tag-archive-meta">' . $tag_description . '</div>' );

        } elseif ( is_category() ) {

            $header_title = sprintf( '%s', '<span>' . single_cat_title( '', false ) . '</span>' );

            $category_description = category_description();

            if ( ! empty( $category_description ) )
                    $header_subtitle = apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );

        } elseif ( is_day() ) {

            $header_title = sprintf( __( 'Daily: %s', 'radium' ), '<span>' . get_the_date() . '</span>' );

        } elseif ( is_month() ) {

            $header_title = sprintf( __( 'Monthly: %s', 'radium' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'radium' ) ) . '</span>' );

        } elseif ( is_year() ) {

            $header_title = sprintf( __( 'Yearly: %s', 'radium' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'radium' ) ) . '</span>' );

        } elseif ( is_author() ) {

            $header_title =  __( 'Author: ', 'radium' ) . get_the_author();

        } elseif ( function_exists('video_central') && video_central_is_video_category() ) {

            $header_title = sprintf( __( 'Video Category: %s', 'radium' ), '<span>' . video_central_get_video_category_name() . '</span>' );

        } elseif ( function_exists('video_central') && video_central_is_video_tag() ) {

            $header_title = sprintf( __( 'Video Tag: %s', 'radium' ), '<span>' . video_central_get_video_tag_name() . '</span>' );

        } elseif ( $framework->theme_supports( 'plugin', 'bbpress' ) && bbp_is_topic_tag() ) {

            $header_title = sprintf( __( 'Topic Tag: %s', 'radium' ), '<span>' . bbp_get_topic_tag_name() . '</span>' );

        } elseif ( $framework->theme_supports( 'plugin', 'bbpress' ) && bbp_is_forum_archive() ) {

            $header_title = __( 'Forums', 'radium');

        } else {

            $header_title = sprintf(  __( 'Archive', 'radium' ) );

        }

    } elseif( is_search() ) {

        $s = null;

        $header_title = sprintf( __('Search Results for: &ldquo;%s&rdquo;', 'radium'), get_search_query());

        $my_search = new WP_Query("s=$s&showposts=-1");

        $number_of_results = $my_search->post_count;

        $header_subtitle .= __( "Found&nbsp;", "radium" );

        $header_subtitle .= $number_of_results;

        $header_subtitle .= __(' results', 'radium');

    } elseif( function_exists('video_central') && video_central_is_search() ) {

        $header_title = video_central_get_search_title();

    } elseif( function_exists('is_buddypress') && is_buddypress() ) {

        $header_title = radium_bp_modify_page_title('');

    } elseif ( 'post'== get_post_type() ) {

        //Get Blog Post Page ID, extract and show the title
        $blog = get_post(get_option('page_for_posts'));

        $header_title = $blog->post_title;

    } elseif ( 'page'== get_post_type() && is_front_page()) {

        //Get Frontpage Page ID, extract and show the title
        $frontpage = get_post(get_option('page_on_front'));

        $header_title = $frontpage->post_title;

    } else {

        $header_title = get_the_title($post_id);

    }

    $header_title_state     = apply_filters( 'radium_header_title_state', $header_title_state );
    $header_subtitle_state = apply_filters( 'radium_header_subtitle_state', true );

    if( !$header_title_state ) $title = apply_filters( 'radium_header_page_title', $header_title );
    if( !$header_subtitle_state ) $subtitle = apply_filters( 'radium_header_page_subtitle', $header_subtitle );

    $header = array(
        'title'      => $title ,
        'subtitle'   => $subtitle
    );

    return $header;
}
add_filter('radium_header_content' , 'radium_page_header_content', 10, 1);


/**
 * Filter the page title for BuddyPress pages.
 *
 * @since NewsCore 1.5.0
 *
 * @global object $bp BuddyPress global settings.
 *
 * @param string $title Original page title.
 * @param string $sep How to separate the various items within the page title.
 * @return string New page title.
 */
function radium_bp_modify_page_title( $title, $sep = '-' ) {

    global $bp;

    // Displayed user
    if ( bp_get_displayed_user_fullname() && !is_404() ) {

        // Get the component's ID to try and get it's name
        $component_id = $component_name = bp_current_component();

        // Use the actual component name
        if ( !empty( $bp->{$component_id}->name ) ) {
            $component_name = $bp->{$component_id}->name;

        // Fall back on the component ID (probably same as current_component)
        } elseif ( !empty( $bp->{$component_id}->id ) ) {
            $component_name = $bp->{$component_id}->id;
        }

        // Construct the page title. 1 = user name, 2 = seperator, 3 = component name
        $title = strip_tags( sprintf( _x( '%1$s %3$s %2$s', 'Construct the page title. 1 = user name, 2 = component name, 3 = seperator', 'radium' ), bp_get_displayed_user_fullname(), ucwords( $component_name ), $sep ) );

    // A single group
    } elseif ( bp_is_active( 'groups' ) && !empty( $bp->groups->current_group ) && !empty( $bp->bp_options_nav[$bp->groups->current_group->slug] ) ) {

        // translators: "group name | group nav section name"
        $title = sprintf( __( 'Group %2$s %1$s', 'radium' ), $bp->bp_options_title, $sep );

    // A single item from a component other than groups
    } elseif ( bp_is_single_item() ) {

        // translators: "component item name | component nav section name | root component name"
        $title = sprintf( __( '%1$s - %2$s - %3$s', 'radium' ), $bp->bp_options_title, $bp->bp_options_nav[bp_current_item()][bp_current_action()]['name'], bp_get_name_from_root_slug( bp_get_root_slug() ) );

    // An index or directory
    } elseif ( bp_is_directory() ) {

        $current_component = bp_current_component();

        // No current component (when does this happen?)
        if ( empty( $current_component ) ) {
            $title = _x( 'Directory', 'component directory title', 'radium' );
        } else {
            $title = bp_get_directory_title( $current_component );
        }

    // Sign up page
    } elseif ( bp_is_register_page() ) {
        $title = __( 'Create an Account', 'radium' );

    // Activation page
    } elseif ( bp_is_activation_page() ) {
        $title = __( 'Activate your Account', 'radium' );

    // Group creation page
    } elseif ( bp_is_group_create() ) {
        $title = __( 'Create a Group', 'radium' );

    // Blog creation page
    } elseif ( bp_is_create_blog() ) {
        $title = __( 'Create a Site', 'radium' );
    }

    // Some BP nav items contain item counts. Remove them
    $title = preg_replace( '|<span>[0-9]+</span>|', '', $title );

    return apply_filters( 'radium_bp_modify_page_title', $title, $sep );
}

/**
 * Returns true if a blog has more than 1 category
 *
 * @since Spotgrid 1.0
 */
function radium_categorized_blog() {

    if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {

        // Create an array of all the categories that are attached to posts
        $all_the_cool_cats = get_categories( array(
            'hide_empty' => 1,
        ) );

        // Count the number of categories that are attached to the posts
        $all_the_cool_cats = count( $all_the_cool_cats );

        set_transient( 'all_the_cool_cats', $all_the_cool_cats );

    }

    if ( '1' != $all_the_cool_cats ) {

        // This blog has more than 1 category so radium_categorized_blog should return true
        $output = true;

    } else {

        // This blog has only 1 category so radium_categorized_blog should return false
        $output = false;

    }

    return apply_filters( __FUNCTION__, $output);

}

/**
 * Flush out the transients used in radium_categorized_blog
 *
 * @since Spotgrid 1.0
 */
function radium_category_transient_flusher() {
    delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'radium_category_transient_flusher' );
add_action( 'save_post', 'radium_category_transient_flusher' );

/**
 * [radium_builder_blog_category_element_classes Blog Category Element Styling]
 * @param  [type] $classes  [description]
 * @param  [type] $element  [description]
 * @param  [type] $location [description]
 * @return [type]           [description]
 */
function radium_builder_blog_category_element_classes( $classes, $element, $location ) {

    if( $element['type'] == 'blog_category') {

        $options = $element['options'];

        if( $options['categories'] !== 'all') {

            $category = $options['categories'];

            $cat_ID = get_cat_ID( $category );

            $cat_style = get_option(  'radium_category_option_'.$cat_ID, array( 'style' => 'none', ));

            $classes = $classes. ' blog-cat-color ' .$cat_style['style'];

            return apply_filters( __FUNCTION__, $classes);

        }

    }

}
add_filter( 'radium_builder_element_classes', 'radium_builder_blog_category_element_classes', 10, 3 );

/**
 * radium_number_with_suffix Convert number to 1K, 2M etc
 *
 * @param  integer $input number
 * @return string formated number eg 10k,
 */
function radium_number_with_suffix( $n, $precision = 3 ) {

    if ($n < 1000) {

        // Anything less than a thousand
        $n_format = number_format($n);

    } else if ($n >= 1000 && $n < 1000000000 ) {

        // Anything less than a thousand
        $n_format = number_format($n / 1000). 'K';

    } else if ($n < 1000000000) {

        // Anything less than a billion
        $n_format = number_format($n / 1000000, $precision) . 'M';

    } else {

        // At least a billion
        $n_format = number_format($n / 1000000000, $precision) . 'B';

    }

    return apply_filters( __FUNCTION__, $n_format);

}

if ( !function_exists('radium_posted_on') ) {
    /**
     * [radium_posted_on description]
     * @return [type] [description]
     */
    function radium_posted_on() {

        printf( __( '<div class="date"><i class="icon-calendar"></i> <time class="entry-date" datetime="%3$s">%4$s</time></div>', 'radium' ),
            esc_url( get_permalink() ),
            esc_attr( get_the_time() ),
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() ),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_attr( sprintf( __( 'View all posts by %s', 'radium' ), get_the_author() ) ),
            get_the_author()
        );
    }
}
add_action( 'radium_posted_on', 'radium_posted_on');

if ( !function_exists('radium_post_format_icon') ) {

    /* Show Post Format Icon */
    function radium_post_format_icon() { ?>
        <i class="icon-calendar"></i>
        <a href="<?php echo get_permalink() ?>" title="<?php echo sprintf( esc_attr__( 'Permalink to %s', 'radium' ), the_title_attribute( 'echo=0' ) ) ?>" rel="bookmark"><span class="post-format <?php echo get_post_format() ?>"><?php echo __('Permalink', 'radium') ?></span></a>
    <?php
    }

}
add_action( 'radium_post_format_icon', 'radium_post_format_icon' );

/* Add animation classes to layout builder elements*/
function radium_builder_animation_classes( $classes, $element, $context ) {

    if ( $context['location'] == 'primary' ) $classes .= ' fly-in animated-content';

    return $classes;

}
//add_filter('radium_builder_element_classes', 'radium_builder_animation_classes', 10, 3);


function radium_create_custom_css ( $selector, $value ) {

     $units = 'px';

    $color  = isset($value['color']) ? $value['color']: null;
       $fontfamily  = isset($value['font-family']) ? $value['font-family']: null;
       $fontsize  = isset($value['font-size']) ? $value['font-size'] . $units: null;
       $fontstyle  = isset($value['font-style']) ? $value['font-style']: null;
       $fontweight  = isset($value['font-weight']) ? $value['font-weight']: null;
       $lineheight = isset($value['line-height']) ? $value['line-height'] . $units : null;
       $texttransform = isset($value['text-transform']) ? $value['text-transform'] : null;
       $fontweight = isset($value['font-weight']) ? $value['font-weight'] : null;
       $textdecoration = isset($value['text-decoration']) ? $value['text-decoration'] : null;
       $textshadow = isset($value['text-shadow']) ? $value['text-shadow'] : null;
       $letterspacing = isset($value['letter-spacing']) ? $value['letter-spacing'] . $units : null;
       $wordspacing = isset($value['word-spacing']) ? $value['word-spacing'] . $units : null;
       $customize = isset($value['customize-options']) ? $value['customize-options'] : null;

    $enable_color = isset($customize['color']) ? true : false;
       $enable_font_family = isset($customize['font-family']) ? true : false;
       $enable_font_size = isset($customize['font-size']) ? true : false;
       $enable_font_style = isset($customize['font-style']) ? true : false;
       $enable_letter_spacing = isset($customize['letter-spacing']) ? true : false;
       $enable_line_height = isset($customize['line-height']) ? true : false;
       $text_transform = isset($customize['text-transform']) ? true : false;
       $enbale_font_weight = isset($customize['font-weight']) ? true : false;
       $enable_text_shadow = isset($customize['text-shadow']) ? true : false;
       $enable_word_spacing = isset($customize['word-spacing']) ? true : false;

        echo $selector; ?> {<?php if ( $color && $enable_color ) { ?>color:<?php echo $color; ?>;<?php }
            if ( $fontfamily && $enable_font_family ) { ?>font-family:<?php echo $fontfamily; ?>;<?php }
            if ( $fontsize && $enable_font_size ) { ?>font-size: <?php echo $fontsize; ?>;<?php }
            if ( $fontstyle && $enable_font_style ) { ?>font-style: <?php echo $fontstyle; ?>;<?php }
            if ( $letterspacing && $enable_letter_spacing ) { ?>letter-spacing: <?php echo $letterspacing;?>;<?php }
            if ( $lineheight && $enable_line_height ) { ?>line-height:<?php echo $lineheight;?>;<?php }
            if ( $texttransform && $text_transform ) { ?>text-transform:<?php echo $texttransform;?>;<?php }
            if ( $textdecoration && $customize['text-decoration'] ) { ?>text-decoration:<?php echo $textdecoration;?>;<?php }
            if ( $fontweight && $enbale_font_weight ) { ?>font-weight:<?php echo $fontweight;?>;<?php }
            if ( $textshadow && $enable_text_shadow ) { ?>text-shadow:<?php echo $textshadow; ?>;<?php }
            if ( $textshadow && $cenable_text_shadow ) { ?>-moz-text-shadow:<?php echo $textshadow; ?>;<?php }
            if ( $textshadow && $enable_text_shadow ) { ?>-webkit-text-shadow:<?php echo $textshadow; ?>;<?php }
            if ( $textshadow && $enable_text_shadow ) { ?>-webkit-text-shadow:<?php echo $textshadow; ?>;<?php }
            if ( $wordspacing && $enable_word_spacing ) { ?>word-spacing:<?php echo $wordspacing; ?>;<?php }

        ?>}<?php

}

/*
 *
 * Custom function for filtering the args array given by theme, good for child themes to override or add to the args array.
 *
 */
function change_radium_framework_args($args){

    $args['footer_credit'] = '';

    return $args;

}//function
add_filter('radium-opts-args-newscore_options', 'change_radium_framework_args');
