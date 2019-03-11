<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );

do_action('radium_before_page');

?>
<div class="shop-content">
	<main id="main" role="main">
		
		<div class="woocommerce-before-content" itemscope>
			<?php
				/**
				 * woocommerce_before_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
				 * @hooked woocommerce_breadcrumb - 20
				 */
				do_action('woocommerce_before_main_content');
			?>
		</div>
		
	 	<div class="woocommerce-content">
	
			<?php while ( have_posts() ) : the_post(); ?>
	
				<?php wc_get_template_part( 'content', 'single-product' ); ?>
	
			<?php endwhile; // end of the loop. ?>
			
		</div>
		
		<div class="woocommerce-after-content" itemscope>
	
			<?php
				/**
				 * woocommerce_after_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
				 */
				do_action('woocommerce_after_main_content');
			?>
			
		</div>
		<?php
			/**
			 * woocommerce_sidebar hook
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			do_action('woocommerce_sidebar');
		?>
	</main>
</div>
<?php 

do_action('radium_after_page');

get_footer('shop'); ?>
