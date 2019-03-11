<?php
/**
 * Show error messages
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! $errors ) return;
?>
<div class="row">
<div class="large-12 columns">
<div class="alert-box alert animated fadeIn">
	<ul class="error-messages">
		<?php foreach ( $errors as $error ) : ?>
			<li><?php echo wp_kses_post( $error ); ?></li>
		<?php endforeach; ?>
	</ul>
</div><!-- .alert-box -->
</div><!-- .large-12 -->
</div><!-- .row -->