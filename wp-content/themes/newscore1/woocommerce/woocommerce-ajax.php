<?php

/*
 * Ajaxify Shopping cart
 *
 * @return array
 */
function radium_woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
	<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart' , 'radium' ); ?>"><?php echo $woocommerce->cart->get_cart_total(); ?></a>
	<?php

	$fragments['a.cart-contents' ] = ob_get_clean();

	return $fragments;

}
add_filter('add_to_cart_fragments', 'radium_woocommerce_header_add_to_cart_fragment' );

/**
 * Woocommerce Shopping Cart Content Ajax
 *
 * @since 2.2.1
 */

if ( !function_exists('radium_woocommerce_cart_ajax') ) :

	add_action('wp_ajax_nopriv_radium_woocommerce_cart_ajax', 'radium_woocommerce_cart_ajax');
	add_action('wp_ajax_radium_woocommerce_cart_ajax', 'radium_woocommerce_cart_ajax');

	/**
	 * radium_woocommerce_cart_ajax  Load Cart with ajax
	 * @echo json object                  [description]
	 */
	function radium_woocommerce_cart_ajax(){

	    if ( !isset($_REQUEST) ) return;

	    $output = radium_woocommerce_cart_ajax_content();

	    $output = json_encode($output);

	    echo $output;

	    die;

	}

endif;

/**
 * Woocommerce Shopping Cart Content
 *
 * @since 2.2.2
 *
 * @params array $options
 * @param string $current_location Current location of element, featured or primary
 */
if ( ! function_exists( 'radium_woocommerce_cart_ajax_content' )) :
	
	function radium_woocommerce_cart_ajax_content( ) {
				
		ob_start();
		
		echo radium_get_woocommerce_cart();
		
		return ob_get_clean();
	}

endif;

/**
 * Woocommerce Wishlist Count Ajax
 *
 * @since 2.2.1
 */

if ( !function_exists('radium_woocommerce_wishlist_count_ajax') ) :

	add_action('wp_ajax_nopriv_radium_woocommerce_wishlist_count_ajax', 'radium_woocommerce_wishlist_count_ajax');
	add_action('wp_ajax_radium_woocommerce_wishlist_count_ajax', 'radium_woocommerce_wishlist_count_ajax');

	/**
	 * radium_woocommerce_wishlist_ajax  Load Cart with ajax
	 * @echo json object                  [description]
	 */
	function radium_woocommerce_wishlist_count_ajax(){

	    if ( !isset($_REQUEST) ) return;

	    $output = radium_get_wishlist_count();

	    $output = json_encode($output);

	    echo $output;

	    die;

	}

endif;

/**
 * Woocommerce Wishlist Content Ajax
 *
 * @since 2.2.1
 */

if ( !function_exists('radium_woocommerce_wishlist_ajax') ) :

	add_action('wp_ajax_nopriv_radium_woocommerce_wishlist_ajax', 'radium_woocommerce_wishlist_ajax');
	add_action('wp_ajax_radium_woocommerce_wishlist_ajax', 'radium_woocommerce_wishlist_ajax');

	/**
	 * radium_woocommerce_wishlist_ajax  Load Cart with ajax
	 * @echo json object                  [description]
	 */
	function radium_woocommerce_wishlist_ajax(){

	    if ( !isset($_REQUEST) ) return;

	    $output = radium_woocommerce_wishlist_ajax_content();

	    $output = json_encode($output);

	    echo $output;

	    die;

	}

endif;

/**
 * Woocommerce Wishlist Content
 *
 * @since 2.2.2
 *
 * @params array $options
 * @param string $current_location Current location of element, featured or primary
 */
if ( ! function_exists( 'radium_woocommerce_wishlist_ajax_content' )) :
	
	function radium_woocommerce_wishlist_ajax_content( ) {
				
		ob_start();
		
		echo radium_get_woocommerce_wishlist();
		
		return ob_get_clean();
	}

endif;