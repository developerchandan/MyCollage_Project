<?php

$framework 				= radium_framework();

$radium_show_related 	= radium_get_option('related_posts');

if /* if the related is checked in admin options then show the related box */ ( $radium_show_related !== "" ) :
	
	$related_posts_title = radium_get_option( 'related_posts_title') ? radium_get_option( 'related_posts_title') : __('Some Related Posts', 'radium');

    $post_sidebar = get_post_meta( get_the_ID(), '_radium_page_layout', true) ? get_post_meta(get_the_ID(), '_radium_page_layout', true) : radium_get_option('single_post_layout', false, 'right');
    $sidebar = radium_sidebar_loader($post_sidebar);

    $image_size = radium_framework_add_image_sizes();
    $image_size = $sidebar['sidebar_active'] ? $image_size['single_related_small'] : $image_size['single_related_large'];

    $crop       = true; //resize but retain proportions
    $single     = true; //return array

	$thumb = $img_url = $image = null;

    $show_items = apply_filters( 'radium_related_posts_count', 5); // Number of related posts that will be shown.

	$i 			= 1;
    $start 		= $show_items;

	if( $related_posts = radium_theme_has_related_posts( array( 'number' => $show_items ) ) ) :

    	$count_posts = $framework->related_posts_query->post_count;
		
        switch ($count_posts) {
            case '1':
                $wrapper_class = 'one-item';
                break;

            case '2':
                $wrapper_class = 'two-items';
                break;

            case '3':
                $wrapper_class = 'three-items';
                break;

            case '4':
                $wrapper_class = 'four-items';
                break;

            default:
                $wrapper_class = 'five-items';
                break;
        }
	?>

		<div id="related-posts" class="clearfix">

			<h3><span><?php echo $related_posts_title; ?></span></h3>

			<ul class="clearfix <?php echo $wrapper_class; ?>">

			<?php

 			while ( radium_theme_related_posts() ) : radium_theme_the_related_post();

                if ( $sidebar['sidebar_active'] ) {

                    if( $i == 1 && $count_posts == 5 ) {

                        $thumb_w = 300; //Define width
                        $thumb_h = 302;

                    } else {

	                    switch ($count_posts) {
	                    
	                        case '1':
	                            $thumb_w = 899; //Define width
	                            $thumb_h = 302;
	                            break;
	
	                        case '2':
	                            $thumb_w = 449; //Define width
	                            $thumb_h = 302;
	                            break;
	
	                        case '3':
	                            $thumb_w = 299; //Define width
	                            $thumb_h = 302;
	                            break;
	
	                        case '4':
	                            $thumb_w = 449; //Define width
	                            $thumb_h = 150;
	                            break;
	
	                        default:
	                            $thumb_w = 299; //Define width
	                            $thumb_h = 150;
	                            break;
	                    }
	                    
                    }

                } else {

                    if( $i == 1  && $count_posts == 5 ) {

                        $thumb_w = 402; //Define width
                        $thumb_h = 302;

                    } else {

                        switch ($count_posts) {
                            case '1':
                                $thumb_w = 1210; //Define width
                                $thumb_h = 402;
                                break;

                            case '2':
                                $thumb_w = 605; //Define width
                                $thumb_h = 402;
                                break;

                            case '3':
                                $thumb_w = 403; //Define width
                                $thumb_h = 402;
                                break;

                            case '4':
                                $thumb_w = 302; //Define width
                                $thumb_h = 201;
                                break;

                            default:
                                $thumb_w = 401; //Define width
                                $thumb_h = 201;
                                break;
                        }

                    }



                }

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

					<a href="<?php the_permalink(); ?>" class="inner">

						<div class="entry-content-media">
							<div class="post-thumb preload image-loading">
	                        	<?php do_action('radium_before_related_post_thumb'); ?>
								<img src="<?php echo $image ?>" alt="<?php the_title();?>" width="<?php echo $thumb_w; ?>" height="<?php echo $thumb_h; ?>"/>
	                       		<?php do_action('radium_after_related_post_thumb'); ?>
	                       	</div>
	                    </div>

						<header class="entry-header">
							<?php do_action('radium_before_related_post_title'); ?>
							<h4 class="entry-title"><?php the_title(); ?></h4>
							<?php do_action('radium_after_related_post_title'); ?>
	 					</header><!-- .entry-summary -->

					</a>

				</li><!--column-->

	  			<?php $i++; $start++; ?>

			<?php endwhile; ?>

		  </ul>

	   </div><!--related-->

	<?php endif; // tags loop

endif;