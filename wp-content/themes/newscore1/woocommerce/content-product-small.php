<?php
/**
 * The template for displaying small product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $product, $woocommerce_loop;

$attachment_ids = $product->get_gallery_attachment_ids();

?>         
	
<li class="product small">
<a href="<?php the_permalink(); ?>">
      <div class="product-image tip-top"  data-tip="<?php the_title(); ?>">
        <?php echo get_the_post_thumbnail(get_the_ID(), apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' )) ?>
        <?php woocommerce_get_template( 'loop/sale-flash.php' ); ?>
      </div><!-- end product-image -->
</a>
</li><!-- end product -->

