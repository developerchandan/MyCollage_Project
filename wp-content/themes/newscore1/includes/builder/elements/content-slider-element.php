<?php

/**
* content slider Element
*
* @since 2.1.0
*
* @params array $options
*/
if ( ! function_exists( 'radium_builder_content_slider_element' )) {
	function radium_builder_content_slider_element( $id, $options, $location  ) {
        
        $categories = $columns = $wrapper_class = null;
        
        $instance = $options;

        $title = ( $options['title'] ) ? $options['title'] : __('Title', 'radium');
		
		if ( $options['title'] == '_') $title = false;
		
        
        $number 	= isset($instance['limit']) 	? $instance['limit'] 	: 10;
        $interval 	= isset($instance['interval']) 	? $instance['interval'] : 0;
	  	$content_source = isset($options['content_source']) ? $options['content_source'] : false;
		$type = 'post';
		
		$orderby = isset($options['orderby']) ? $options['orderby'] : 'date';
		$order = isset($options['order']) ? $options['order'] : 'DESC';
		$offset = isset($options['offset']) ? $options['offset'] : 0;
		
		$exclude = isset($options['exclude']) ? $options['exclude'] : '';
		$exclude_ids = explode(', ', $exclude);

		$slider_nav = isset($options['slider_nav']) ? $options['slider_nav'] : false;
				
		if ( !empty($slider_nav) && $slider_nav !== 'none' ) {
			$wrapper_class .= 'has-slider-nav';
		}
 		
		$sidebar = radium_sidebar_loader();
		
		$image_size = radium_framework_add_image_sizes();
		
		if ( $location['location'] == 'featured' ) {
			
			$image_size = $image_size['content_slider_large'];	
		
		} elseif ( $sidebar['sidebar_active'] && is_page_template('page-templates/page-home.php') ) {
			
			$image_size = $image_size['content_slider_medium'];	
		
		} else {
		
			$image_size = $image_size['content_slider_large'];	
		
		}
    	
    	//queries args	 
    	$args = array(
    	    'post_type'      => esc_attr( $type ),
    	    'posts_per_page' => esc_attr( $number ),
    	    'post_status'    => 'publish',
    	    'ignore_sticky_posts' => true,
    	    'orderby' 		=> $orderby,
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
	    	 		'key' => '_thumbnail_id',
	    	 	),
	    	     array(
	    	         'key' => '_radium_carousel_slider',
	    	         'value' => '1',
	    	         'compare' => '='
	    	     )
	    	 );
    	
    	} elseif ( $content_source == 'category' ) {
    		
    	  	$categories_array = isset($options['categories']) ? $options['categories'] : '';
    		
    		if ( isset($categories_array['all'])) 
    			unset( $categories_array['all'] );	
    			
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
    			$args = array_merge( $args, array( 'category_name' => esc_attr( $categories ) ) );
    		} 
    	
    	}
    	        
        $args = apply_filters( __FUNCTION__.'_post_args', $args );
	                
        $content = Radium_Theme_WP_Query::cache_query( $args, $options['cache_id'] );
       	
       	ob_start();
        
        if ( $content->have_posts() ) : 
        	        	
        	$i = 0; //Detect first post

           	if ( $title ) { ?><div class="entry-element-title"><div class="ribbon"></div><h3><?php echo $title; ?></h3></div><?php } ?>

            <!-- BEGIN #slider-<?php echo $id; ?> -->
     		<div class="slider-wrapper <?php if ( !$title ) { ?>no-element-title<?php } ?> <?php if ( !$slider_nav ) { echo $wrapper_class; } ?>">

     			<div class="post-slider post-slider-<?php echo $id; ?>">

     				 <div id="slider-<?php echo $id; ?>"  class="loading media-slider">

     			     	<ul class="slides">

						<?php

		                $thumb_w = $image_size['width']; //Define width
						$aspect_ratio = 1.77777777778;
						$thumb_h = round($thumb_w/$aspect_ratio);
						
		                $crop   = true; //resize but retain proportions
		                $single = true; //return array

						global $post;

						$i = 0;
						
                		while( $content->have_posts() ) : $content->the_post();

							$active = '';
							if( $i == 0 ){ $active = 'active'; $i++; }

							?>

							<li itemscope>

								<article <?php post_class(); ?>>
									
									<?php do_action('radium_before_content_slider'); ?>
									
									<a title="<?php printf(__('Permanent Link to %s', 'radium'), get_the_title()); ?>" href="<?php the_permalink(); ?>" style="height: <?php echo $thumb_h; ?>px; width: <?php echo $thumb_w; ?>px;">
									
										<?php if( has_post_thumbnail( get_the_ID() ) ) { ?>
	
											<div class="entry-thumbnail">
												
												<?php do_action('radium_before_post_slider_image'); ?>
	
												<?php //Check if post has a featured image set else get the first image from the gallery and use it. If both statements are false display fallback image.
				                                if ( has_post_thumbnail() ) {
	
				                                    //get featured image
				                                    $thumb      = get_post_thumbnail_id();
				                                    $img_url    = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the image is too big)
				                                    $image      = radium_resize($img_url, $thumb_w, $thumb_h, $crop, $single);
				                                    $grid_class = 'has-thumb ' . get_post_format();
	
				                                }
	
				                                //add thumbnail fallback
				                                if( empty($image) || !has_post_thumbnail() ) {
				                                    $image      = get_radium_first_post_image(true);
				                                    $grid_class = 'no-thumb ' . get_post_format();
				                                }
	
								   				if( $image) { ?>
								   					<div class="entry-content-media">
									   					<div class="post-thumb preload image-loading zoom-img-in">
									   						<img height="<?php echo $thumb_h; ?>" width="<?php echo $thumb_w; ?>" src="<?php echo $image ?>" alt="<?php the_title();?>" style="height:<?php echo $thumb_h; ?>px; width:<?php echo $thumb_w; ?>px;"/>
									   					</div>
								   					</div>
								   				<?php } //image ?>
												
												<?php do_action('radium_after_post_slider_image'); ?>
	
											</div>
	
										<?php } ?>
	
										<header class="entry-header">
	
											<?php do_action('radium_before_post_slider_title'); ?>
 
											<h2 class="entry-title"><?php the_title() ?></h2>

											<?php do_action('radium_after_post_slider_title'); ?>

										</header>
									
									</a>
									
									<?php do_action('radium_after_content_slider'); ?>
									
								</article>

							</li>

	                        <?php endwhile; wp_reset_postdata(); ?>

           				</ul><!-- END .slides -->

            	    </div><!-- END #slider-<?php echo $id; ?> -->

				</div><!-- END .post-slider -->

			</div><!-- END .slider-wrapper -->

        <?php

        // Reset the global $the_post as this query will have stomped on it
       

        $output = ob_get_flush();

        return $output;

        endif;

    }

}
add_action('radium_builder_content_slider', 'radium_builder_content_slider_element', 10, 3);
