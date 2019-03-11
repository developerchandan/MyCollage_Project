<?php

/**
* Carousel Element
*
* @since 2.1.0
*
* @params array $options
*/
if ( ! function_exists( 'radium_builder_content_carousel_big_element' )) {
	function radium_builder_content_carousel_big_element( $id, $options, $location  ) {

        global $post, $post_id;

        $output = null;

        $type = isset($options['type']) ? $options['type'] : 'post';
        $categories = $columns = null;

        $title = isset($options['title']) ? $options['title'] : '';
        $subtitle = isset($options['subtitle']) ? $options['subtitle']  : '';
        $limit = isset($options['limit']) ? $options['limit']  : 16;
        $cache_id = $options['cache_id'];
	  	$content_source = isset($options['content_source']) ? $options['content_source'] : false;
		
		$orderby = isset($options['orderby']) ? $options['orderby'] : 'date';
		$order = isset($options['order']) ? $options['order'] : 'DESC';
		$offset = isset($options['offset']) ? $options['offset'] : 0;
		
		$exclude = isset($options['exclude']) ? $options['exclude'] : '';
		$exclude_ids = explode(', ', $exclude);

		$show_author = isset($options['show_author']) ? $options['show_author'] : false;

		if( $type == 'post' || !function_exists('video_central') ) {
	        
	        $args = array(
	            'post_type'      => esc_attr( $type ),
	            'posts_per_page' => esc_attr( $limit ),
	            'orderby'        => $orderby,
	            'order'			=> $order,
	            'post__not_in'  => $exclude_ids,
	            'offset'		=> $offset,
	            'post_status'    => 'publish',
	            'ignore_sticky_posts' => true,
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
		
		} else if( $type == 'video' && function_exists('video_central') ) {
		
		    $args = array(
		    	'posts_per_page' => esc_attr( $limit ),
		    	'meta_key'      => '_video_central_featured_video',
		    	'max_num_pages' => 1,
		    	'orderby'       => 'meta_value_num',
		    	'ignore_sticky_posts' => true,
		    	'post_type'      => video_central_get_video_post_type(), // Narrow query down to videos
		    	'orderby'        => 'meta_value',              // 'meta_value', 'author', 'date', 'title', 'modified', 'parent', rand',
		    	'order'          => 'DESC',                    // 'ASC', 'DESC'
		    	'no_found_rows' => true //pagination off
		    );
		    
		}
		
    	$carousel = Radium_Theme_WP_Query::cache_query( $args, $cache_id );      	
        
        if( $carousel->have_posts() ) :      

            if ( $title ) $output .= '<div class="entry-element-title"><div class="ribbon"></div><h3>' . esc_attr( $title ) . '</h3></div>';

            //$output .= '<div class="horizontal-carousel-container">';

            $output .= '<div id="'. $id .'" class="large-carousel '.$type.'">';

            	$output .= '<div class="container">';

            		$output .= '<div class="carousel-content carousel-transition">';
	
	                $image_size = radium_framework_add_image_sizes();
	                $image_size = $image_size['content_carousel_large'];
	
	                $thumb_w = $image_size['width']; //Define width
	                $thumb_h = $image_size['height'];
	
	                $crop   = true; //resize but retain proportions
	                $single = true; //return array
	
	               while( $carousel->have_posts() ) : $carousel->the_post();
	
	                    $post_id = get_the_ID();
	                    $permalink = get_permalink( get_the_ID() );
	                    $title = get_the_title( get_the_ID() );
	                    $excerpt = strip_tags(wp_trim_words( get_the_excerpt(), '16' ));
	                    $post_type = $post_class = $post_type = $category_name = null;
	                    $post_type = get_post_format();
	                    $post_class = strtolower($post_type);
	                    $terms = get_the_terms( get_the_ID(), 'category' );
	                    $views = radium_theme_get_post_views();
	
	                    $image = get_radium_post_image($post_id, $post_type, $thumb_w, $thumb_h, $crop, $single );
	
	                    if( is_array($terms) ) {
	                        foreach ( $terms as $term ) {
 	                        	
	                        	    // Sanitize the term, since we will be displaying it.
	                        	    $term = sanitize_term( $term, $term->taxonomy );
	                        	    $term_link = get_term_link( $term, $term->taxonomy );
	                        	   
	                        	    // If there was an error, continue to the next term.
	                        	    if ( is_wp_error( $term_link ) ) {
	                        	        continue;
	                        	    }
	                        	
	                        	    $category_name .= '<a href="' . esc_url( $term_link ) . '">' . $term->name . '</a>, ';
	                        }
	                    }
	
	                    $category_name = rtrim( $category_name, ', ' );
	
	                    if ( $post_type == "image" || $post_type == "slideshow" ) {
	                        $icon = 'icon-file-image-o';
	                    } elseif ( $post_type == "audio" ) {
	                        $icon = 'icon-headphones';
	                    } elseif ( $post_type == "video" || $type == 'video' ) {
	                        $icon = 'icon-play';
	                    } else {
	                        $icon = 'icon-file-text-o';
	                    }
	                    
	                     $output .= '<div class="entry-block carousel-item">';
	                     
		                     $output .= '<a class="entry-link" href="' . $permalink  . '">';
		                     
		                      	 $output .= '<div class="image-view entry-content-media">';
		                      	 	
		                      	 	$output .= ( $post_type == "video" || $type == 'video' ) ? '<span class="'. $icon .'"></span>' : '';
		                      	 
		                      	 	$output .= '<div class="entry-meta">';
		                      	 	
		                      	 		$new_meta = ($icon && ( $post_type !== "video" || $type !== 'video') ) ? '<span class="'. $icon .'"></span>' : '';
		                      	 	
		                      	 		$new_meta = apply_filters('radium_large_carousel_meta_before_image', $new_meta);
		                      	 		
		                      	 		$output .= $new_meta;
		                      	 	
		                      	 	$output .= '</div>';
		                      	 	
		                      		$output .= '<div class="background-image" style="background-image:url(' . $image . ');"></div>';
		                		    		                      	 
		                      	 $output .= '</div>';
		                      	 
		                     $output .= '</a>';
		
		                     $output .= '<header class="entry-details">';
		                     
		                     	 $output .= '<div class="inner">';
		                     	 
									 $output .= '<h3 class="entry-title">';
										 $output .= '<a class="entry-link" href="' . $permalink  . '">' . $title . '</a>';
									 $output .= '</h3>';
									 
									 $output .= '<div class="entry-subdetails">';
			                        	 if( $show_author ) $output .= '<a class="entry-author" href="'. get_author_posts_url(get_the_author_meta( 'ID' )) .'">'.ucwords(get_the_author()).'</a>';
			                        	 $output .= '<span class="entry-subheading">'. $category_name .'</span>';
                        				                         				 
			                       $output .= '</div>';
			                       
		                       	$output .= '</div>';
		                       
		                     $output .= '</header>';
		                     
	                     $output .= '</div>';
					
	                	endwhile;
					
	                	$output .= '</div>';
	                
	                $output .= '</div>';

                	$output .= '<a class="arrow-control arrow-control-prev"><span class="arrow-control-btn"><i class="icon-arrow-left"></i></span></a>';
                
                	$output .= '<a class="arrow-control arrow-control-next"><span class="arrow-control-btn"><i class="icon-arrow-right"></i></span></a>';

                $output .= '</div>';

                //$output .= '</div><!-- end .radium-carousel -->';
	         
			endif;
	
			wp_reset_postdata();

        echo $output;
        
        ?><script type="text/javascript">
        	jQuery(document).ready(function($) {
        	
	        	//Horizontal gallery init
	        	jQuery("#<?php echo $id; ?>").radium_post_gallery_h({ 
	        		autoplay: true,
	        		enableKeyboardNavigation: true,
	        		loop: true,
	        		showArrows: true,
	        	});
	        });	
        </script><?php
 	}
}
add_action('radium_builder_content_carousel_big', 'radium_builder_content_carousel_big_element', 10, 3);