<?php

$framework 				= radium_framework();
$radium_show_recent 	= radium_get_option('single_recent_posts');

if /* if the recent is checked in admin options then show the recent box */ ( $radium_show_recent ) {
	
	$categories_array = radium_get_option('single_recent_post_categories', false, true);
	$single_recent_posts_hide_below = radium_get_option('single_recent_posts_hide_below', false, true);
	$show_items = radium_get_option('single_recent_post_number', false, 15);
	
	$categories = null;
	
    $image_size = radium_framework_add_image_sizes();
    $image_size = $image_size['content_teaser_small'];

    $thumb_w = $image_size['width']; //Define width
    $thumb_h = $image_size['height'];
    $crop    = true; //resize but retain proportions
    $single  = true; //return array

	$thumb = $img_url = $image = null;

    $show_items = apply_filters( 'radium_posts_teaser_count', $show_items); // Number of recent posts that will be shown.

	$i = 1;
	
	$title_word_limit = apply_filters('single_recent_posts_word_limit', 7);
	
	$cache_id = 'rdm_recent_posts_' . get_the_ID();
     
    //Load Query
    $args = array (
        'posts_per_page' => $show_items,
        'order'          => 'DESC',
        'post_status'    => 'publish',
        'ignore_sticky_posts' => true,
        'no_found_rows' => true //pagination off
    );
    		
	if ( is_array($categories_array) ) {

		foreach ( $categories_array as $key => $value ) {
		
			if ( $value ) {
				$categories .= sprintf('%s,', $value);
			}
			
		}
		
		if($categories) $categories = radium_remove_trailing_char( $categories, ',' );

	}
    	    			
    if( $categories && $single_recent_posts_hide_below) {
    	$args = array_merge( $args, array( 'cat' => esc_attr( $categories ) ) );
    } 

    $recent = Radium_Theme_WP_Query::get_posts_cached( $args, $cache_id ); 
	
	global $post;

	if( $recent ) : ?>

    <div class="recent-posts-carousel-container">

		<div class="teaser-container recent-posts-carousel clearfix">

            <div class="horizontal-carousel-container">

                <div class="control prev"></div>

                <div class="horizontal-carousel post">

        			<ul class="clearfix">

        			<?php foreach ( $recent as $post ) : setup_postdata($post);

                        //Check if post has a featured image set else get the first image from the gallery and use it. If both statements are false display fallback image.

                        if ( has_post_thumbnail() ) {

                            //get featured image
                            $thumb      = get_post_thumbnail_id();
                            $img_url    = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the image is too big)
                            $image      = radium_resize($img_url, $thumb_w, $thumb_h, $crop, $single);
                            $grid_class = 'has-thumb ' . get_post_format();

                        }

                        //add thumbnail fallback
                        if(empty($image) || !has_post_thumbnail() ) {
                            $image      = get_radium_first_post_image(true);
                            $grid_class = 'no-thumb ' . get_post_format();
                        }

                        ?>

        				<li class="<?php echo $grid_class; ?>">

                            <article class="teaser teaser-mini">

                                <div class="inner">

                					<div class="grid-thumb">
                					    
                					    <?php do_action('radium_before_recent_post_thumb'); ?>
                					
                						<a title="<?php printf(__('Permanent Link to %s', 'radium'), get_the_title()); ?>" href="<?php the_permalink(); ?>" data-width="<?php echo $thumb_w; ?>" data-height="<?php echo $thumb_h; ?>">
                							<img src="<?php echo $image ?>" alt="<?php the_title();?>" width="<?php echo $thumb_w; ?>" height="<?php echo $thumb_h; ?>"/>
                						</a>
                						
                						<?php do_action('radium_after_recent_post_thumb'); ?>
                						
                					</div><!-- .grid-thumb -->

                					<div class="entry-summary">
                					    <?php do_action('radium_before_recent_post_title'); ?>
                						<h6 class="entry-title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), $title_word_limit ); ?></a></h6>
                						<?php do_action('radium_after_recent_post_title'); ?>
                 					</div><!-- .entry-summary -->

                                </div><!-- .inner-->

                            </article>

        				</li><!--column-->

        	  			<?php $i++; ?>

        			<?php endforeach; wp_reset_postdata(); ?>

        		  </ul>

              </div><!-- .horizontal-carousel-->

              <div class="control next"></div>

          </div><!-- .horizontal-carousel-container -->

	   </div><!-- .recent-posts-carousel -->

    </div><!-- .recent-posts-carousel-container -->

	<?php endif; // tags loop

}