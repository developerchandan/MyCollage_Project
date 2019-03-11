<?php

/**
 * radium_site_header_trending_headlines
 *
 * @since  1.0.0
 *
 * @return void
 */
if ( !function_exists('radium_site_header_trending_headlines') ) {

	function radium_site_header_trending_headlines() {

		$number = apply_filters('radium_site_header_trending_headlines_count', radium_get_option( 'header_items_ticker_number', false, 10));
		$interval =  5;
		$tax_query = array();
		$category = null;
		$i = 0; //Detect first post
		$cache_id = 'rm_hder_trng_hdlns';
		$breaking_title = radium_get_option( 'header_items_ticker_title') ? radium_get_option( 'header_items_ticker_title') : __('Breaking', 'radium');

	 	if ( radium_get_option('header_trending') || radium_get_option('header_news') ) {

		?><div class="breaking-banner" data-interval="<?php echo ( $interval > 0 ) ? $interval * 1000 : 'false'; ?>"><div class="story"><?php

	        $args = apply_filters( 'radium_site_header_trending_headlines_posts_args', array(
				'posts_per_page'    => $number,
				'no_found_rows'     => true,
				'post_status'       => 'publish',
				'cat'               => $category,
			));

	        $headlines = Radium_Theme_WP_Query::cache_query( $args, $cache_id );

	        if ( $headlines->have_posts() && radium_get_option('header_trending') ) : ?>
	            <div class="meta-bar-title"><h3><a href="#"><?php echo $breaking_title; ?></a></h3></div><!-- .meta-bar-title -->
	            <div class="meta-bar">
	            	<ul>
	                <?php while ( $headlines->have_posts() ) : $headlines->the_post(); ?>
	                    <li>
							<h3 class="story-h">
								<a href="<?php the_permalink(); ?>">
	                       	    	<span class="story-title"><?php the_title(); ?></span>
	                            	<span class="story-time"><?php echo '  - ' . radium_human_time_diff( get_the_time('U'), current_time('timestamp') ); ?></span>
	                            </a>
	                        </h3>
	                    </li>
	                <?php endwhile; wp_reset_postdata(); ?>
	                </ul>
	            </div>
	    		<?php endif; ?>
	    	</div><!-- .story -->
	    </div><!-- .breaking-banner -->
	    <?php
	    }
	}
	add_action('radium_site_navigation', 'radium_site_header_trending_headlines', 11);

}

if( ! function_exists('radium_top_news') ) {

	function radium_top_news() {

		if (!radium_get_option('header_news') ) return;

	    $display_type 		= radium_get_option('header_news_display_type', false, 'today');
	    $max_number_posts 	= radium_get_option('header_news_number_posts', false, 12);
	    $max_count 			= radium_get_option('header_news_limit', false, 100); //too high may cause performance issues

		$show_date        = radium_get_option('post_meta_elements', 'date', true);
		$show_category    = radium_get_option('post_meta_elements', 'category', true);
		$show_featured    = radium_get_option('post_meta_elements', 'featured', true);

		$args = array(
			'posts_per_page'        => $max_count,
			'order'                 => 'DESC',
			'post_status'           => 'publish',
			'ignore_sticky_posts'   => true
	    );

		$args = apply_filters( __FUNCTION__, $args );

		$cache_id = 'rdm_top_news';

	    if( $display_type == 'today' ) {

            $today = getdate();

            $args['date_query'] = array( array(
                'year'  => $today['year'],
                'month' => $today['mon'],
                'day'   => $today['mday'],
            ));

            $r = Radium_Theme_WP_Query::cache_query( $args, $cache_id. '_today' );
            unset($args['date_query']);

	        if( $r->post_count <= 0 ) {
                $r = Radium_Theme_WP_Query::cache_query( $args, $cache_id. '_latest' );
            }

	    } else {

			$r = Radium_Theme_WP_Query::cache_query( $args, $cache_id. '_latest' );

        }

		$output = null;

		$count = 1; //counter for creating a columns every four items

		$image_size = radium_framework_add_image_sizes();
		$image_size = $image_size['top_news_thumb'];

		$thumb_w = $image_size['width']; //Define width
		$thumb_h = $image_size['height'];

		$img_url = false;
		$crop    = true;

		$new_count = $r->post_count;
		
		if ( $new_count <= 1 ) {
			
			$header_news_title  = radium_get_option( 'header_news_title_single') ? radium_get_option( 'header_news_title_single') : __( 'New Article', 'radium' );
 			
		} else {
			
			$header_news_title  = radium_get_option( 'header_news_title') ? radium_get_option( 'header_news_title') : __( 'New Articles', 'radium' );
		
		}
		
		?>
		<div class="btn-group top-news">
		    <div class="ribbon-shadow-left bg-ribbon-shadow-left"></div>
		    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
		        <span class="number"><?php echo $new_count; ?></span>
		        <span><?php echo $header_news_title; ?></span>
		    </a>
		</div>

		<div class="submenu top-news-items">

	 		<?php

	          if ( $r->have_posts() ) :

			    $output .= '<div class="sub-mega-wrap radium-mega-div cat-menu">';

				$output .= '<div class="subfeatured-articles">';

	            $output .= '<div class="horizontal-carousel-container">';

	            $output .= '<div class="control bg-arrow-carousel-big-prev prev"></div>';

	            $output .= '<div class="horizontal-carousel post">';

				$output .= '<ul class="sub-posts sub-menu">';

					while ( $r->have_posts() && $count < $max_number_posts ) : $r->the_post();

			            //Check if post has a featured image set else get the first image from the gallery and use it. If both statements are false display fallback image.
			            if ( has_post_thumbnail() ) {

			                //get featured image
			                $thumb = get_post_thumbnail_id();
			                $img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the image is too big)

			                $image = $img_url ? radium_resize( $img_url, $thumb_w, $thumb_h, $crop ) : false ;
			                $class = "has-thumbnail";
			            }

			            //add thumbnail fallback
			            if(empty($image) || !has_post_thumbnail() ) {
			                $image = get_radium_first_post_image(true);
			                $class = 'no-thumb';
			            }

			            $output .= '<li class="cat-post ' . $class . ' clearfix">';

			                $output.= "<div class='subcat-thumbnail entry-content-media'>";

				                $output.= "<div class='post-thumb zoom-img-in'>";

				                    $output.= "<a href='".get_permalink()."' title='".get_the_title()."'>";

				                        $output .= '<img src="' . $image . '" alt="' . get_the_title() . '" height="'. $thumb_h .'" width="'. $thumb_w .'"/>';

				                    $output.= "</a>";

				                $output.= "</div>";

				                $output .= '<div class="entry-meta">';

		                        	if( $show_date ) $output .= radium_get_post_grid_date();

				                $output.= "</div>";

				                $output .= '<div class="entry-extras">';

				                	if($show_category) $output .= radium_get_post_grid_cat();
				                	if($show_featured) $output .= radium_get_post_grid_featured();

				                $output .= "</div>";

			                $output.= "</div>";

			                $output.= "<h5 class='subcat-title'>";

			                    $output.= "<a href='".get_permalink()."' title='".get_the_title()."'>" . get_the_title() . "</a>";

			                $output.= "</h5>";

			            $output .= '</li>';

	 					$count++;

			        endwhile;

					$output .= "</ul>"; //This is to ensure there is no open div if the number of elements in user_kicks is not a multiple of 4

					$output .= '</div>';

					$output .= '<div class="control bg-arrow-carousel-big-next next"></div>';

					$output .= '</div>';

					$output .= '</div>';

			    $output .= "</div><!-- .sub-mega-wrap -->\n";

			    echo $output;

			    endif;

			  	wp_reset_postdata();

			   ?>

			</div>

		<?php
	}
	add_action('radium_site_navigation', 'radium_top_news', 12);

}