<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
 
 	$layout_type = radium_get_option('layout_type', false, 'boxed');
 
 	if ( $layout_type == 'narrow' ) {
 		
 		$class = 'large-block-grid-3';
 		
 	} else {
 		
 		$class = 'large-block-grid-4';
 	}
?>
<div class="row">
    <div class="large-12 columns">
	   <ul class="products small-block-grid-2 <?php echo $class; ?>">


