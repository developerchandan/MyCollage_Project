<?php

/**
 * Register Woocommerce Shop Archive Element
 * @return array();
 * @since 2.1.0
 */
function radium_builder_registar_woocommerce_shop_archive_element( $elements ) {

	$element_options = array(
 		array(
			'id' 		=> 'type',
			'name'		=> __( 'Select Woocommerce element type', 'radium' ),
			'desc'		=> __( 'Choose the woocommerce content you\'d like to show.', 'radium' ),
			'type'		=> 'select',
			'options'	=> array(
				'featured_products' => 'Featured Products',
				'recent_products' => 'Recent Products',
				'product_category' => 'Product Categories',
 			),
  		),

        array(
            'id'        => 'title',
            'name'      => __( 'Title', 'radium' ),
            'desc'      => __( '', 'radium' ),
            'type'      => 'text',
        ),

  		array(
  			'id' 		=> 'per_page',
  			'name'		=> __( 'Items per Page', 'radium' ),
  			'desc'		=> __( '', 'radium' ),
  			'type'		=> 'text',
  		),
	);

	$elements['woocommerce_shop_archive'] = array(
			'info' => array(
				'name' 	=> 'Woocommerce Shop',
				'id'	=> 'woocommerce_shop_archive',
				'query'	=> 'none',
				'hook'	=> null,
				'shortcode'	=> false,
				'desc' 	=> __( 'Woocommerce Shop', 'radium' )
			),
			'options' => $element_options,
			'style' => apply_filters( 'radium_builder_element_style_config', array() ),
	);

	return $elements;

}
add_filter('radium_builder_elements', 'radium_builder_registar_woocommerce_shop_archive_element');


/**
 * Woocommerce Shop Element
 *
 * @since 2.1.0
 *
 * @params array $options
 * @param string $current_location Current location of element, featured or primary
 */
if ( ! function_exists( 'radium_builder_woocommerce_shop_archive_element' )) :
	function radium_builder_woocommerce_shop_archive_element( $id, $options, $location  ) {

		$shortcode = null;
		$per_page = $options['per_page'] ? $options['per_page'] : 12;
        $carousel = $options['carousel'] ? $options['carousel'] : false;

        if ( $options['type'] == 'featured_products' ) {

			$shortcode = '[featured_products per_page="'.$per_page.'" columns="4" orderby="date" order="desc"]';

		} elseif ( $options['type'] == 'recent_products' ) {

			$shortcode = '[recent_products per_page="'.$per_page.'" columns="4" orderby="date" order="desc"]';

		} elseif ( $options['type'] == 'product_category' ) {

			$shortcode = '[product_categories number="'.$per_page.'"]';

		} else {

			echo "<div class='alert error'>Please select products source type in the layout builder</div>";
		}
		
		$title = isset($options['title']) ? $options['title'] : '';
		if ( $options['title'] == '_') $title = false;
		
       	?>
        <?php if ( $title ) { ?><div class="entry-element-title"><div class="ribbon"></div><h3><?php echo esc_attr( $title); ?></h3></div><?php } ?>
        <section class="related products product-carousel-element"><?php if ( $shortcode ) echo do_shortcode( $shortcode ); ?></section>
        <?php
	}

endif;

add_action('radium_builder_woocommerce_shop_archive', 'radium_builder_woocommerce_shop_archive_element', 11, 3);