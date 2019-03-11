<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$upsells = $product->get_upsells();

if ( sizeof( $upsells ) === 0 ) {
	return;
}

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->id ),
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;

if ( $products->have_posts() ) : ?>

    <section class="upsells products loading hidden">

        <div class="widget">

            <div class="row">
                <div class="large-12 columns">
                    <h2 class="widget-title"><span><?php _e( 'You may also like', 'radium' ); ?></span></h2>
                </div>
            </div>

            <div class="radium-product-carousel">

                <div class="horizontal-carousel-container">

                        <div class="control prev"></div>

                        <div class="horizontal-carousel">

                            <ul class="products" data-columns="5">

                                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                                    <?php wc_get_template_part( 'content', 'product' ); ?>

                                <?php endwhile; // end of the loop. ?>

                            </ul>

                        </div>

                        <div class="control next"></div>

                    </div>

                </div><!-- end .radium-carousel -->

          </div>

    </section>

<?php endif;

wp_reset_postdata();
