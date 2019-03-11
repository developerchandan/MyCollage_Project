<?php
// Remove each style one by one
add_filter( 'woocommerce_enqueue_styles', 'radium_dequeue_styles' );
function radium_dequeue_styles( $enqueue_styles ) {
    unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
    unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
    unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
    return $enqueue_styles;
}

// Or just remove them all in one line
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

/*
 * Add Woocommerce Support to framework
 *
 * @return array
 */
add_theme_support( 'woocommerce' );

$framework = radium_framework();
function radium_add_wocommerce_support($args) {
    $args['primary']['woocommerce'] = true;

     return $args;
}

//Hide Page title
//add_filter( 'woocommerce_show_page_title', '__return_false' );

if( $framework->is_plugin_active('woocommerce/woocommerce.php') )
    add_filter( 'radium_theme_config_args', 'radium_add_wocommerce_support' );

// Disable WooCommerce styles
function radium_dequeue_css_from_woocommerce()  {
    wp_dequeue_style( "woocommerce-smallscreen" );
    wp_dequeue_style( "woocommerce-layout" );
    wp_dequeue_style( "woocommerce-general" );
}
add_action('wp_print_styles', 'radium_dequeue_css_from_woocommerce', 100);


// Change columns in related products output to 3
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

// Change columns in product loop to 3
function radium_loop_columns() {
    return 4;
}

add_filter('loop_shop_columns', 'radium_loop_columns');

// Display 12 products per page
add_filter('loop_shop_per_page', create_function('$cols', 'return 12;'));

// Fix sidebar on shop page
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

// Adjust the star rating in the sidebar
add_filter('woocommerce_star_rating_size_sidebar', 'woostore_star_sidebar');

function woostore_star_sidebar() {
    return 12;
}

// Adjust the star rating in the recent reviews
add_filter('woocommerce_star_rating_size_recent_reviews', 'radium_star_reviews');

function radium_star_reviews() {
    return 12;
}

/**
 * Get the shop sidebar template.
 *
 * @access public
 * @return void
 */
function woocommerce_get_sidebar() {
    woocommerce_get_template( 'shop/sidebar.php' );
}

/**
 * Get the shop sidebar template.
 *
 * @access public
 * @return void
 */
function radium_woocommerce_footer_widgets() {

    if(!radium_get_option('woocommerce_footer_layout') ) return;

    if (is_shop()) : ?>
      <aside id="woocommerce-footer-widgets" class="woocommerce-footer-widgets even clearfix">
          <div class="inner">
             <div class="widget_row clearfix">
               <?php
                 // Footer widgetized area
                 $footer_widget_count = null;
                   $footer_layout = radium_get_option('woocommerce_footer_layout');

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
                           if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Shop Footer Widgets '.$i) ) : endif;
                       echo '</div><!-- END div.widget_'.$footer_widget_count.' -->';
                    }

                     } ?>
                 </div>
             </div>
        </aside>
     <?php
    endif;
}
add_action( 'radium_before_footer', 'radium_woocommerce_footer_widgets' );


/**
 * Output the related products.
 *
 * @access public
 * @subpackage	Product
 * @return void
 */
function woocommerce_output_related_products() {
    $args = array(
        'posts_per_page' => 20,
    );

    woocommerce_related_products( $args );
}

/**
 * [radium_change_breadcrumb_delimiter description]
 * @param  [type] $defaults [description]
 * @return [type]           [description]
 */
function radium_change_breadcrumb_delimiter( $defaults ) {
    // Change the breadcrumb delimeter from '/' to '>'
    $defaults['delimiter'] = ' / ';
    return $defaults;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'radium_change_breadcrumb_delimiter' );

///remove ordering
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

//remove count
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

//remove rating from title
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

//remove breadcrumbs
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

/* NEXT / PREV NAV ON PRODUCT PAGES */
/**
 * [radium_next_post_link_product description]
 * @param  string  $format              [description]
 * @param  string  $link                [description]
 * @param  boolean $in_same_cat         [description]
 * @param  string  $excluded_categories [description]
 * @return [type]                       [description]
 */
function radium_next_post_link_product($format='%link &raquo;', $link='%title', $in_same_cat = false, $excluded_categories = '') {
    radium_adjacent_post_link_product($format, $link, $in_same_cat, $excluded_categories, false);
}

/**
 * [radium_previous_post_link_product description]
 * @param  string  $format              [description]
 * @param  string  $link                [description]
 * @param  boolean $in_same_cat         [description]
 * @param  string  $excluded_categories [description]
 * @return [type]                       [description]
 */
function radium_previous_post_link_product($format='&laquo; %link', $link='%title', $in_same_cat = false, $excluded_categories = '') {
    radium_adjacent_post_link_product($format, $link, $in_same_cat, $excluded_categories, true);
}

/**
 * [radium_adjacent_post_link_product description]
 * @param  [type]  $format              [description]
 * @param  [type]  $link                [description]
 * @param  boolean $in_same_cat         [description]
 * @param  string  $excluded_categories [description]
 * @param  boolean $previous            [description]
 * @return [type]                       [description]
 */
function radium_adjacent_post_link_product( $format, $link, $in_same_cat = false, $excluded_categories = '', $previous = true ) {

    if ( $previous && is_attachment() )
        $post = get_post( get_post()->post_parent );
    else
        $post = radium_get_adjacent_post_product( $in_same_cat, $excluded_categories, $previous );

    if ( ! $post ) {

        $output = '';

    } else {

        $title = $post->post_title;

        if ( empty( $post->post_title ) )
            $title = $previous ? __( 'Previous Post', 'radium' ) : __( 'Next Post', 'radium' );

        $title = apply_filters( 'the_title', $title, $post->ID );

        $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID) );

        $image = null;
        $date = mysql2date( get_option( 'date_format' ), $post->post_date );
        $rel = $previous ? 'prev' : 'next';

        $string = '<div class="prod-dropdown"><a href="' . get_permalink( $post ) . '" rel="'.$rel.'" class="';
        $inlink = str_replace( '%title', $title, $link );
        $inlink = $string . $inlink . '"></a><div class="nav-dropdown"><a href="' . get_permalink( $post ) . '">'.get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) ).'</a></div></div>';
        $output = str_replace( '%link', $inlink, $format );
    }

    $adjacent = $previous ? __('previous', 'radium') : __('next', 'radium');

    echo apply_filters( "{$adjacent}_post_link", $output, $format, $link, $post );
}

/**
 * [radium_get_adjacent_post_product description]
 * @param  boolean $in_same_cat         [description]
 * @param  string  $excluded_categories [description]
 * @param  boolean $previous            [description]
 * @return [type]                       [description]
 */
function radium_get_adjacent_post_product( $in_same_cat = false, $excluded_categories = '', $previous = true ) {
    global $wpdb;

    if ( ! $post = get_post() )
        return null;

    $current_post_date = $post->post_date;
    $join = '';
    $posts_in_ex_cats_sql = '';
    if ( $in_same_cat || ! empty( $excluded_categories ) ) {
        $join = " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";

        if ( $in_same_cat ) {
            if ( ! is_object_in_taxonomy( $post->post_type, 'product_cat' ) )
                return '';
            $cat_array = wp_get_object_terms($post->ID, 'product_cat', array('fields' => 'ids'));
            if ( ! $cat_array || is_wp_error( $cat_array ) )
                return '';
            $join .= " AND tt.taxonomy = 'product_cat' AND tt.term_id IN (" . implode(',', $cat_array) . ")";
        }

        $posts_in_ex_cats_sql = "AND tt.taxonomy = 'product_cat'";
        if ( ! empty( $excluded_categories ) ) {
            if ( ! is_array( $excluded_categories ) ) {
                // back-compat, $excluded_categories used to be IDs separated by " and "
                if ( strpos( $excluded_categories, ' and ' ) !== false ) {
                    _deprecated_argument( __FUNCTION__, '3.3', sprintf( __( 'Use commas instead of %s to separate excluded categories.', 'radium' ), "'and'" ) );
                    $excluded_categories = explode( ' and ', $excluded_categories );
                } else {
                    $excluded_categories = explode( ',', $excluded_categories );
                }
            }

            $excluded_categories = array_map( 'intval', $excluded_categories );

            if ( ! empty( $cat_array ) ) {
                $excluded_categories = array_diff($excluded_categories, $cat_array);
                $posts_in_ex_cats_sql = '';
            }

            if ( !empty($excluded_categories) ) {
                $posts_in_ex_cats_sql = " AND tt.taxonomy = 'product_cat' AND tt.term_id NOT IN (" . implode($excluded_categories, ',') . ')';
            }
        }
    }

    $adjacent = $previous ? 'previous' : 'next';
    $op = $previous ? '<' : '>';
    $order = $previous ? 'DESC' : 'ASC';

    $join  = apply_filters( "get_{$adjacent}_post_join", $join, $in_same_cat, $excluded_categories );
    $where = apply_filters( "get_{$adjacent}_post_where", $wpdb->prepare("WHERE p.post_date $op %s AND p.post_type = %s AND p.post_status = 'publish' $posts_in_ex_cats_sql", $current_post_date, $post->post_type), $in_same_cat, $excluded_categories );
    $sort  = apply_filters( "get_{$adjacent}_post_sort", "ORDER BY p.post_date $order LIMIT 1" );

    $query = "SELECT p.id FROM $wpdb->posts AS p $join $where $sort";
    $query_key = 'adjacent_post_' . md5($query);
    $result = wp_cache_get($query_key, 'counts');
    if ( false !== $result ) {
        if ( $result )
            $result = get_post( $result );
        return $result;
    }

    $result = $wpdb->get_var( $query );
    if ( null === $result )
        $result = '';

    wp_cache_set($query_key, $result, 'counts');

    if ( $result )
        $result = get_post( $result );

    return $result;
}


/**
 * radium_woocommerce_quickview
 *
 * @since 2.1.6
 *
 * @return void
 */
function radium_woocommerce_quickview() {

    global $post, $product, $woocommerce;

    $product_id =  $_POST["product_id"];
    $post = get_post($product_id);
    $product = get_product($product_id);

    ob_start();

    woocommerce_get_template( 'content-single-product-lightbox.php');

    $output = ob_get_contents();

    ob_end_clean();

    echo $output;

    die();
}
add_action('wp_ajax_radium_woocommerce_quickview', 'radium_woocommerce_quickview');
add_action('wp_ajax_nopriv_radium_woocommerce_quickview', 'radium_woocommerce_quickview');

// Add to cart in product loop
//add_action('woocommerce_before_shop_loop_item', 'woocommerce_template_single_add_to_cart');

/**
 * Move Loop Sale flashes
 *
 * @see woocommerce_show_product_loop_sale_flash()
 * @see woocommerce_show_product_sale_flash()
 */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_show_product_loop_sale_flash', 10 );


/*
 * Hook in on activation
 *
 */
add_action( 'switch_theme', 'radium_woocommerce_image_dimensions' );

/**
 * Define image sizes
 */
function radium_woocommerce_image_dimensions() {
      $catalog = array(
        'width' 	=> '270',	// px
        'height'	=> '300',	// px
        'crop'		=> 1 		// true
    );

    $single = array(
        'width' 	=> '600',	// px
        'height'	=> '600',	// px
        'crop'		=> 1 		// true
    );

    $thumbnail = array(
        'width' 	=> '200',	// px
        'height'	=> '200',	// px
        'crop'		=> 0 		// false
    );

    // Image sizes
    update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
    update_option( 'shop_single_image_size', $single ); 		// Single product image
    update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}

// Move the woocommerce site wide message
remove_action( 'wp_footer', 'woocommerce_demo_store' );

add_action( 'radium_site_header_message_bar', 'radium_woocommerce_demo_store' );

/*
 * Customize Site wide message markup
 *
 **/
if ( ! function_exists( 'radium_woocommerce_demo_store' ) ) {

    /**
     * Adds a demo store banner to the site if enabled
     *
     * @access public
     * @return void
     */
    function radium_woocommerce_demo_store() {
        if ( !is_store_notice_showing() )
            return;

        $notice = get_option( 'woocommerce_demo_store_notice' );
        if ( empty( $notice ) )
            $notice = __( 'This is a demo site. No orders shall be fulfilled.', 'radium' );

        echo apply_filters( 'woocommerce_demo_store', '<div class="woocommerce-global alert note"><p class="demo_store">' . $notice . '</p></div>'  );
    }
}
