<?php
/*-----------------------------------------------------------------------------------*/
/* General Front-end Functions
/*-----------------------------------------------------------------------------------*/

/**
 * Initiate Front-end
 *
 * @since 2.1.0
 */

if( ! function_exists( 'radium_frontend_init' ) ) {

	function radium_frontend_init( $custom_layout_id = null ) {

		global $post;

        $layout_name = $layout_post_id = null;

        $featured = array();

		/*------------------------------------------------------*/
		/* Caller Post ID
		/*------------------------------------------------------*/
		$caller_post_id = is_object( $post ) ? $post->ID : null;

		/*------------------------------------------------------*/
		/* Builder (ID of custom layout or false)
		/*------------------------------------------------------*/
        if ( $custom_layout_id ) {

            $layout_post_id = $custom_layout_id;

        } else {

            $layout_name = get_post_meta( $caller_post_id, '_radium_custom_layout', true );

            $layout_post_id = radium_post_id_by_name( $layout_name, 'radium_layout' );

        }

		if( $layout_post_id ) {

            $elements = get_post_meta( $layout_post_id, 'elements', true );

            /* Featured Area */
            // Set classes for featured area
            if( is_array( $elements ) && isset( $elements['featured'] ) && ! empty( $elements['featured'] ) ){
                $featured[] = 'has_builder';
                foreach( $elements['featured'] as $element )
                    $featured[] = $element['type'];
            }

		}

		/*------------------------------------------------------*/
		/* Finalize Frontend Configuration
		/*------------------------------------------------------*/
    	$config = array(
    		'id'				=> $caller_post_id,		// global $post->ID of page calling the layout
    		'fake_conditional'	=> radium_get_fake_conditional(), // Fake conditional tag
    		'builder'			=> $layout_post_id,		// ID of current custom layout if not false
    		'featured'			=> $featured,			// Classes for featured areas, if empty featured area won't show
            'layout_id'         => $layout_post_id,     // Layout ID
    	);
    	$config = apply_filters( 'radium_frontend_config', $config );

    	return $config;
	}

}

/**
 * Add framework css classes to body_class()
 *
 * @since 2.0.2
 *
 * @param array $classes Current WordPress body classes
 * @return array $classes Modified body classes
 */

if( ! function_exists( 'radium_builder_body_class' ) ) {
	function radium_builder_body_class( $classes ) {

		// Featured Area
		if( radium_builder_config( 'featured' ) )
			$classes[] = 'show-featured-area';
		else
			$classes[] = 'hide-featured-area';

		// Custom Layout
		$custom_layout = radium_builder_config( 'builder' );
		if( $custom_layout )
			$classes[] = 'custom-layout-'.$custom_layout;

		return $classes;
	}
}

/**
 * Set fake conditional.
 *
 * Because query_posts alters the current global $wp_query
 * conditional, this function is called before query_posts
 * and assigns a variable to act as a fake conditional if
 * needed after query_posts.
 *
 * @since 2.1.0
 *
 * @return string $fake_condtional HTML to output thumbnail
 */

if( ! function_exists( 'radium_get_fake_conditional' ) ) {
	function radium_get_fake_conditional() {

		$fake_conditional = '';

		if( is_home() )
			$fake_conditional = 'home';

		else if( is_page_template( 'page-templates/page-builder.php' ))
			$fake_conditional = 'page-templates/page-builder.php';

		else if( is_page_template( 'page-builder.php' ) || is_page_template( 'page-templates/page-builder.php' ))
			$fake_conditional = 'page-builder.php';

		else if( is_single() )
			$fake_conditional = 'single';

		else if( is_search() )
			$fake_conditional = 'search';

		else if ( is_archive() )
			$fake_conditional = 'archive';

		return $fake_conditional;
	}
}

/**
 * This function is used from within the theme's template
 * files to return the values setup in the previous init function.
 *
 * @since 2.1.0
 *
 * @param $key string $key to retrieve from $config
 * @return $value mixed value from $config
 */

function radium_builder_config( $key, $seconday = null, $layout_id = null ) {

	$config = radium_frontend_init( $layout_id );

	$value = null;

	if( $seconday ) {

		if( isset( $config[$key][$seconday] ) ) $value = $config[$key][$seconday];

	} else {

		if( isset( $config[$key] ) ) $value = $config[$key];

	}

	return $value;
}


/**
 * Display custom layout within page-builder.php
 * page template.
 *
 * @since 2.1.0
 *
 * @param string $layout Post slug for layout
 * @param string $location Location of elements, featured or primary
 */

if( !function_exists( 'radium_builder_elements' ) ) {
	function radium_builder_elements( $layout, $location, $layout_id = null ) {

		$counter = 1;
		$primary_query = false;
		$layout_id = $layout_id ? $layout_id : radium_post_id_by_name( $layout, 'radium_layout' );

		//Die if no Layout ID is found
		if( !$layout_id ) {
			__( 'No Layout found for this page.', 'radium' );
			return;
		}

		$elements = get_post_meta( $layout_id, 'elements', true );

		if( is_array( $elements ) && isset( $elements[$location] ) && ! empty( $elements[$location] ) ) {

			$elements = $elements[$location];
			$num_elements = count($elements);

		} else {

			return;

        }

		$group_by = 12;
		$row_closed = $row_open = null;
		$row_columns = 0;

		//useful for creating sample layouts
		//var_export($elements);

		// Loop through elements
		foreach( $elements as $id => $element ) {

			//translate width data into a usable format
			$element_width = isset($element['width']) ? $element['width'] : null;

			switch ( $element_width ) {
				case 'element1-1':
					$element_width = 'large-12 columns';
					break;
				case 'element1-2':
					$element_width = 'large-6 columns';
					break;
				case 'element1-3':
					$element_width = 'large-4 columns';
					break;
				case 'element1-4':
					$element_width = 'large-3 columns';
					break;
				case 'element2-3':
					$element_width = 'large-8 columns';
					break;
				case 'element3-4':
					$element_width = 'large-9 columns';
					break;
				default:
					$element_width = 'large-12 columns';
					break;
			}

			$styles = null;

			//row styling
			if ( isset( $element['style'] ) ) {

 				//SETUP VARIABLES
 				$bg_image 		= isset($element['style']['bg_image']) 			? $element['style']['bg_image'] 		: null;
 				$bg_color 		= isset($element['style']['bg_color']) 			? $element['style']['bg_color'] 		: null;
 				$bg_style 		= isset($element['style']['bg_style']) 			? $element['style']['bg_style'] 		: null;

 				$padding_top 	= isset($element['style']['top_padding']) 		? $element['style']['top_padding'] 		: null;
 				$padding_bottom = isset($element['style']['bottom_padding']) 	? $element['style']['bottom_padding'] 	: null;

 				$margin_top 	= isset($element['style']['top_margin']) 		? $element['style']['top_margin'] 		: null;
 				$margin_bottom 	= isset($element['style']['bottom_margin']) 	? $element['style']['bottom_margin'] 	: null;

 				$classes = isset($element['style']['class']) ? $element['style']['class'] : null;

				$styles = ( $bg_image || $bg_color || $padding_top || $padding_bottom || $margin_top || $margin_bottom ) ? 'style="' : null;

				$styles .= $bg_image ? 'background-image:url('.$bg_image.');' : null;
	 			$styles .= $bg_color ? 'background-color:'.$bg_color.';' : null;
	 			$styles .= $bg_style !== 'fullwidth' && $bg_image ? 'background-repeat:'.$bg_style.';' : null;
	 			$styles .= $bg_style == 'fullwidth' && $bg_image ? 'background-size: cover;' : null;

				$styles .= $padding_top ? 'padding-top:'.$padding_top.';' : null;
				$styles .= $padding_bottom ? 'padding-bottom:'.$padding_bottom.';' : null;

	 			$styles .= $margin_top ? 'margin-top:'.$margin_top.';' : null;
	 			$styles .= $margin_bottom ? 'margin-bottom:'.$margin_bottom.';' : null;

	 			$styles .= ( $bg_image || $bg_color || $padding_top || $padding_bottom || $margin_top || $margin_bottom ) ? '"' : null;

 			}

			$row_wrapper_classes = 'element-'.$element['type'].'';
			if ( isset( $element['style'] ) ) $row_wrapper_classes .= $classes ? ' '.$classes : null;

			// classes
			$classes = 'element '.$location.'-element-'.$counter.' element-'.$element['type'];

			if( $counter == 1 ) {
				$classes .= ' first-element';
			}

			if( $num_elements == $counter ) {
				$classes .= ' last-element';
			}

			if( $element['type'] == 'slider' ) {
				$slider_id = radium_post_id_by_name( $element['options']['slider_id'], 'slider' );
				$type = radium_get_custom_field('_radium_slider_type', $slider_id );
				$classes .= ' element-slider-'.$type;
			}

 			$row_column = preg_replace("/\D/","", $element_width);

			$context = array(
				'location' => $location,
				'columns' => $row_column
			);

            $classes = apply_filters( 'radium_builder_element_classes', $classes, $element, $context );

			if ( $row_column == 12 && $row_open ) {

				echo "</div></div>";

				$row_open = false;

 			}

			if ( $row_column == 12 || $row_closed || $counter == 1) { //new group start

 				echo "<div class='row-wrapper ".$row_wrapper_classes."' ".$styles."><div class='row'>";

  				$row_open = true;

			}

            // Eject Cache id into options
            if( $element['cache'] ) {
                $element['options']['cache_id'] = $element['cache_id'];
            }

 			// Start output
			echo '<div class="'.$classes . ' ' . $element_width .' '.$row_open.'">';
			//// do some magic and close the row it total element columns is = to 12

			//element blocks are added here
			do_action( 'radium_builder_'.$element['type'], $id, $element['options'], $context );

			echo '<div class="clearfix"></div>';
			echo '</div><!-- .element  -->';

			if ( $row_column == 12) {//new group start

				$row_closed = true;

			} else {

  				$row_closed = false;

				//calculate total row columns
				$row_columns += $row_column;

  				if ( $row_columns == 12 || $row_columns % 12 == 0 ) {//new group start

     				$row_closed = true;

  				}

			}

			if ( ( $row_closed && $row_open ) ||  $num_elements == $counter ) { //new group start

 				echo "</div></div>";

 				$row_open = false;

 			} //there you go. //had to sleep on this one

			$counter++;

		}

	}
}

include('elements/blog-element.php');
include('elements/blog-category-small-element.php');
include('elements/blog-latest-element.php');
include('elements/blog-review-element.php');
include('elements/content-element.php');
include('elements/content-carousel-element.php');
include('elements/content-carousel-big-element.php');
include('elements/content-grid-slider-element.php');
include('elements/content-slider-element.php');
include('elements/divider-element.php');
include('elements/video-central-element.php');
include('elements/widget-element.php');
include('elements/events-elements.php');
