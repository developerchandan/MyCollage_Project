<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

?>
<div class="row woocommerce-cart-empty">
<div class="large-7 columns large-centered">
<h1><span class="icon-shopping-cart"></span></h1>
<h3><?php _e( 'Your cart is currently empty.', 'radium' ) ?></h3>

<?php do_action('woocommerce_cart_is_empty'); ?>

<p  class="return-to-shop"><a class="button transparent red wc-backward" href="<?php echo get_permalink(wc_get_page_id('shop')); ?>"><?php _e( '&larr; Return To Shop', 'radium' ) ?></a></p>
</div>

</div>
