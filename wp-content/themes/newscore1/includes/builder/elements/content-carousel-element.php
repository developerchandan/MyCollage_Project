<?php

/**
* Carousel Element
*
* @since 2.1.0
*
* @params array $options
*/
if ( ! function_exists( 'radium_builder_content_carousel_element' )) {
	function radium_builder_content_carousel_element( $id, $options, $location  ) {

        global $post, $post_id;

        $output = null;

        $id = $post_id;
        $type = 'post';
        $categories = $columns = null;

        $title = isset($options['title']) ? $options['title']   : '';
        $subtitle = isset($options['subtitle']) ? $options['subtitle']  : '';
        $limit = isset($options['limit']) ? $options['limit']  : 16;
  		$content_source = isset($options['content_source']) ? $options['content_source'] : false;
		$orderby = isset($options['orderby']) ? $options['orderby'] : 'date';
		$order = isset($options['order']) ? $options['order'] : 'DESC';
		$offset = isset($options['offset']) ? $options['offset'] : 0;
		
		$exclude = isset($options['exclude']) ? $options['exclude'] : '';
		$exclude_ids = explode(', ', $exclude);
		
        $args = array(
            'post_type'      => esc_attr( $type ),
            'posts_per_page' => esc_attr( $limit ),
            'post_status'    => 'publish',
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
				
		$carousel = Radium_Theme_WP_Query::cache_query( $args, $options['cache_id'] );

        if( $carousel->have_posts() ) :

            if ( $title ) $output .= '<div class="entry-element-title"><div class="ribbon"></div><h3>' . esc_attr( $title ) . '</h3></div>';

            $output .= '<div class="subfeatured-articles">';

            $output .= '<div class="horizontal-carousel-container">';

            $output .= '<div class="control bg-arrow-carousel-big-prev prev"></div>';

            $output .= '<div class="horizontal-carousel '.$type.'">';

            $output .= '<ul>';

                $image_size = radium_framework_add_image_sizes();
                $image_size = $image_size['carousel_large'];

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
                            $category_name .= '<span>'.$term->name.'</span>';
                        }
                    }

                    //$category_name = rtrim( $category_name, '' );

                    if ( $post_type == "image" || $post_type == "slideshow" ) {
                        $icon = 'icon-picture';
                    } elseif ( $post_type == "audio" ) {
                        $icon = 'icon-headphones';
                    } elseif ( $post_type == "video" ) {
                        $icon = 'icon-play-circle';
                    } else {
                        $icon = 'icon-file-alt';
                    }

                    $output .= '<li itemscope>';

                        $output .= '<article class="teaser teaser-medium ' . esc_attr( $type ) . ' '.$post_type.'">';

                        $output .= '<div class="inner">';

                        $output .= '<div class="teaser-info">';

                        $output .= '<a class="section-link" href="' . $permalink  . '">'. $category_name .'</a>';

                        $output .= '<h3 class="teaser-title">' . $title . '</h3>';

                        $output .= '<div class="by-line">By '. get_the_author_link() .'</div>';

                        $output .= '</div>';

                        $output .= '<div class="teaser-overlay"></div>';

                        $output .= '<a class="link-article teaser-link" title="' . $title . '" href="' . $permalink  . '"></a>';

                        $output .= '<img src="' . $image . '" alt="' . $title . '" class="teaser-image" width="'. $thumb_w . '" height="'. $thumb_h .'"/>';

                        $output .= '<ul class="stats stats-sub-header stats-show-1">';

                        $output .='<li class="stat"><span class="stat-num">'. $views .' </span><span class="stat-type">' . __('Views', 'radium') . '</span></li>';

                        $output .= '</ul>';

                        $output .= '</div><!-- .inner -->';

                        $output .= '</article>';

                    $output .= '</li>';

                endwhile;

                $output .= '</ul>';
                $output .= '</div>';
                $output .= '<div class="control bg-arrow-carousel-big-next next"></div>';
                $output .= '</div></div><!-- end .radium-carousel -->';

            endif;

        wp_reset_postdata();

        echo $output;
 	}
}
add_action('radium_builder_content_carousel', 'radium_builder_content_carousel_element', 10, 3);