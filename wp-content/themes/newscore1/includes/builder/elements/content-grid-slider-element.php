<?php

/**
* Content Slider Types => grid
*
* @since 2.1.0
*
* @params array $options
*/
if ( ! function_exists( 'radium_builder_content_grid_slider_element' )) {
	function radium_builder_content_grid_slider_element( $id, $options, $location  ) {

		global $post; // required

		$framework = radium_framework();

		$categories = null;

		$title 			= ( $options['title'] ) 			? $options['title'] 			: __('Title', 'radium');
		$carousel 		= !empty( $options['carousel'] ) && $options['carousel'] ? true 	: false;
		$number 		= isset( $options['limit'] ) 		? $options['limit'] 			: 17;
		$number 		= $carousel 						? $number 						: 5;
		$interval 		= isset($options['interval']) 		? $options['interval'] 		: 0;
		$content_source = isset($options['content_source']) ? $options['content_source'] 	: false;
		$orderby 		= isset($options['orderby']) 		? $options['orderby'] 			: 'date';
		$order 			= isset($options['order']) 			? $options['order'] 			: 'DESC';
		$offset 		= isset($options['offset']) 		? $options['offset'] 			: 0;
		$exclude 		= isset($options['exclude']) 		? $options['exclude'] 			: '';

		$exclude_ids 	= explode(', ', $exclude);

		if ( $options['title'] == '_') $title = false;

        ob_start();

       	$args = array(
	        'posts_per_page' => $number,
            'ignore_sticky_posts' => true,
            'orderby'          => $orderby,
            'order'			=> $order,
            'post__not_in'  => $exclude_ids,
            'offset'		=> $offset,
            'no_found_rows' => true //pagination off
       );

	   if ( $content_source == 'featured' ) {

		   $featured_args = array(
		        'meta_key' 		=> '_radium_featured',
	   			'meta_query' => array(
					array(
						'key' => '_thumbnail_id',
					),
					array(
						'key' => '_radium_featured',
						'value' => '1',
					),
				)
	        );

       	    $args = array_merge( $args, $featured_args );

       } elseif ( $content_source == 'carousel' ) {

           $args['meta_query'] = array(
               array(
                   'key' => '_radium_carousel_slider',
                   'value' => '1',
                   'compare' => '='
               )
           );

       } elseif ( $content_source == 'category' ) {

	        $categories_array = isset($options['categories']) ? $options['categories'] : '';

			if ( isset($categories_array['all'])) unset( $categories_array['all'] );

	    	if ( is_array($categories_array) ) {

	    		foreach ( $categories_array as $key => $value ) {

	    			if ( $value ) {
	    				$categories .= sprintf('%s,', $key);
	    			}

	    		}

	    		if($categories) $categories = radium_remove_trailing_char( $categories, ',' );

	    	}

	        $all_categories = isset($options['categories']) && $options['categories']['all'] ? true : false;

	        if( $categories !== 'all' && $categories && !$all_categories) {
	        	$args = array_merge( $args, array( 'cat' => esc_attr( $categories ) ) );
	        }

        }

        $args = apply_filters( __FUNCTION__.'_post_args', $args );

		$content_slider_type = 'grid';

		if( $content_slider_type == 'grid' ) :

			if( $carousel ){

				$type = array(

					1 => array(
						0 => 'wide',
						1 => 'wide',
						2 => 'wide'
					),

					2 => array(
						0 => 'big',
						1 => 'wide',
					),

					3 => array(
						0 => 'wide',
						1 => 'wide',
						2 => 'wide',
					),

					4 => array(
						0 => 'wide',
						1 => 'big'
					 ),

					5 => array(
						0 => 'big',
						1 => 'wide'
					),

					6 => array(
						0 => 'wide',
						1 => 'big'
					),

					7 => array(
						0 => 'wide',
						1 => 'wide',
						2 => 'wide',
					)
				);

			} else {

				$type = array(
					1 => array(
						0 => 'super-big',
					),

					2 => array(
						0 => 'wider',
						1 => 'wider',
					),

					3 => array(
						0 => 'wider',
						1 => 'wider',
					),

				);

			}

			// Overwrite if mobile
			if( radium_is_mobile() && !radium_is_tablet() ) {

				$type = array(

					1 => array(
						0 => 'mobile',
						1 => 'mobile',
						2 => 'mobile',
					),

				);

			}

			$class = $carousel ? 'subfeatured-articles' : 'grid-posts';

			?>

		<section class="<?php echo $class; ?>">

			<div class="horizontal-carousel-container">

				<?php if ( $carousel) { ?><div class="control bg-arrow-carousel-big-prev prev"></div><?php } ?>

				<div class="horizontal-carousel post">

					<div class="content-carousel">
						<ul>
						<?php

						$image_size = radium_framework_add_image_sizes();

						$type_counter = 0;
						$which_type = 1;

						$custom_posts = Radium_Theme_WP_Query::get_posts_cached( $args, $options['cache_id'] );

						if( !empty($custom_posts) ) :

							foreach($custom_posts as $post) : setup_postdata($post);

								if( radium_is_mobile()  && !radium_is_tablet() ) {

					 				$thumb_w = $image_size['content_grid_slider_mobile']['width'];
					 				$thumb_h = $image_size['content_grid_slider_mobile']['height'];

								} else {

						 			if ( $type[$which_type][$type_counter] == 'wide' ) {

						 				$thumb_w = $image_size['content_grid_slider_wide']['width'];
						 				$thumb_h = $image_size['content_grid_slider_wide']['height'];
						 			}

						 			if ( $type[$which_type][$type_counter] == 'big' ) {

						 				$thumb_w = $image_size['content_grid_slider_big']['width'];
						 				$thumb_h = $image_size['content_grid_slider_big']['height'];

						 			}

						 			if ( $type[$which_type][$type_counter] == 'super-big' ) {

						 				$thumb_w = $image_size['content_grid_slider_super_big']['width'];
						 				$thumb_h = $image_size['content_grid_slider_super_big']['height'];

						 			}

						 			if ( $type[$which_type][$type_counter] == 'wider' ) {

						 				$thumb_w = $image_size['content_grid_slider_wider']['width'];
						 				$thumb_h = $image_size['content_grid_slider_wider']['height'];

						 			}

					 			}

						 		if ( $type_counter % count($type[$which_type]) == 0 ) { ?>

						 		<li class="content-carousel-<?php echo $type[$which_type][$type_counter]; ?>" itemscope>

						 		<?php }

						 			$element_class = $type[$which_type][$type_counter]; ?>

						 			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark" class="content-carousel-element content-carousel-inner-<?php echo $element_class; ?>">

					 				<?php

									//Check if post has a featured image set else get the first image from the gallery and use it. If both statements are false display fallback image.
								    if ( has_post_thumbnail() ) {

								    	//get featured image
								        $thumb = get_post_thumbnail_id();
								        $img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the image is too big)

								    } else {

								    	$attachments = get_children(
								            array(
								            	'post_parent' => get_the_ID(),
								            	'post_type' => 'attachment',
								            	'post_mime_type' => 'image',
								            	'orderby' => 'menu_order'
								            )
								        );

								        if ( ! is_array($attachments) ) continue;
								        	$count = count($attachments);
								        	$first_attachment = array_shift($attachments);

								         $img_url = $first_attachment ? wp_get_attachment_url( $first_attachment->ID, 'full' ) : false; //get full URL to image (use "large" or "medium" if the image is too big)

								    }

								    $crop = true; //resize but retain proportions
								    $single = true; //return array

								    if ( empty($img_url) ) {

								    	$image = get_radium_first_post_image(true);

								    } else {

										$image = radium_resize($img_url, $thumb_w, $thumb_h, $crop, $single);

									}

						 			?>
					 				<div class="entry-content-media">

					 					<div class="post-thumb preload zoom-img-in">

					 						<?php do_action('radium_before_grid_slider_post_thumb'); ?>

											<img src="<?php echo $image ?>" alt="<?php the_title();?>" style="display: block; <?php if ( $type[$which_type][$type_counter] == 'super-big' ) { ?>max-height:<?php echo $thumb_h; ?>px;<?php } else { ?>height: <?php echo $thumb_h; ?>px; <?php } ?> width: <?php echo $thumb_w; ?>px;" height= "<?php echo $thumb_h; ?>" width= "<?php echo $thumb_w; ?>"/>

					 						<?php do_action('radium_after_grid_slider_post_thumb'); ?>

								 		</div>

							 		</div>

							 		<header class="entry-header">

					 					<?php do_action('radium_before_grid_slider_post_title'); ?>

					 					<h2 class="entry-title">
					 						<?php the_title(); ?>
					 		            </h2><!-- END .entry-title -->

					 					<?php do_action('radium_after_grid_slider_post_title'); ?>

					 				</header><!-- .entry-summary -->

						 		</a>

							 	<?php if ( $type_counter % count($type[$which_type]) == count($type[$which_type]) - 1 ) { ?> </li><?php }

								$type_counter++;

								if ( $type_counter == count($type[$which_type]) ) {
									$which_type++;
									$type_counter = 0;
								}

								if ( $which_type == 8 ) {
									$which_type = 1;
								} elseif( radium_is_mobile() && !radium_is_tablet() && $which_type == 2 ) {
									$which_type = 1;
								}

						  		endforeach;

						  		wp_reset_postdata();

					  		endif;

				 	  		?>

				 		</ul>

					</div>

				</div>

				<?php if ( $carousel) { ?><div class="control bg-arrow-carousel-big-next next"></div><?php } ?>

			</div>

		</section>

		<?php

        $output = ob_get_flush();

        return $output;

        endif;

    }

}
add_action('radium_builder_content_grid_slider', 'radium_builder_content_grid_slider_element', 10, 3);
