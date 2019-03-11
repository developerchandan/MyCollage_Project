 <?php
    global $post, $product, $woocommerce;
    $attachment_ids = $product->get_gallery_attachment_ids();

?>
<div class="row collapse">

    <div class="large-6 columns">

        <div class="product-slider">
        	<div class="product-gallery">

                <!-- BEGIN #slider- -->
                    <div class="slider-wrapper">
                        <div class="post-slider post-slider-">
                             <div id="slider-<?php echo $product->ID; ?>"  class="loading media-slider">
                    			<ul class="slides" >
                                    <?php if ( has_post_thumbnail() ) : ?>

                                    <li class="slide"><span itemprop="image"><?php echo get_the_post_thumbnail( get_the_ID(), apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) ) ?></span></li>

                                    <?php endif;

                                    if ( $attachment_ids ) {

                                        $columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

                                        foreach ( $attachment_ids as $attachment_id ) {

                                            $image_link = wp_get_attachment_url( $attachment_id );

                                            if ( ! $image_link )
                                                continue;

                                            printf( '<li class="slide"><span itemprop="image">%s</span></li>', wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) ), wp_get_attachment_url( $attachment_id ) );
                                        }

                                    }
                                    ?>
                                </ul>
                            </div><!-- .media-slider -->
                        </div><!-- .post-slider -->
                    </div><!-- .slider-wrapper -->
                    <!-- END #slider- -->

                </div>
    	</div><!-- .product-slider -->
    </div><!-- large-6 -->

    <div class="large-6 columns">
    	<div class="product-info">
    	   <?php
                    /**
                     * woocommerce_single_product_summary hook
                     *
                     * @hooked woocommerce_template_single_title - 5
                     * @hooked woocommerce_template_single_price - 10
                     * @hooked woocommerce_template_single_excerpt - 20
                     * @hooked woocommerce_template_single_add_to_cart - 30
                     * @hooked woocommerce_template_single_meta - 40
                     * @hooked woocommerce_template_single_sharing - 50
                     */
                    do_action( 'woocommerce_single_product_summary' );
                ?>
    	</div><!-- END .product-info -->
    </div><!-- END .large-6 -->

</div><!-- END .row collapse -->
