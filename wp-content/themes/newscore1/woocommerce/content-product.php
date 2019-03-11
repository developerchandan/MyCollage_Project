<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$attachment_ids = $product->get_gallery_attachment_ids();

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

?>

<li class="product-small">

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<a href="<?php the_permalink(); ?>">

		<div class="product-image">

			<div class="front-image">

				<?php echo get_the_post_thumbnail( get_the_ID(), 'shop_catalog') ?>

			</div>

			<?php

			if ( $attachment_ids ) {

				$loop = 0;

				foreach ( $attachment_ids as $attachment_id ) {

					$image_link = wp_get_attachment_url( $attachment_id );

					if ( ! $image_link )
						continue;

					$loop++;

					printf( '<div class="back-image back">%s</div>', wp_get_attachment_image( $attachment_id, 'shop_catalog' ) );

					if ($loop == 1) break;

				}

			} else { ?>

				<div class="back-image"><?php echo get_the_post_thumbnail( get_the_ID(), 'shop_catalog') ?></div>

			<?php } ?>

			<div class="quick-view" data-prod="<?php echo get_the_ID(); ?>">+ <?php _e('Quick View', 'radium'); ?></div><!-- end zoom -->

		</div><!-- end product-image -->

		<div class="entry-summary">

			<?php $product_cats = strip_tags($product->get_categories('|', '', '')); ?>

			<h3 class="category"><?php list($firstpart) = explode('|', $product_cats); echo $firstpart; ?></h3>

			<div class="tx-div small"></div>

			<p class="name"><?php the_title(); ?></p>

			<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>

		<?php if ( in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>

			<?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>

		<?php } ?>

		</div><!-- end info -->

	</a>

	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

</li>
