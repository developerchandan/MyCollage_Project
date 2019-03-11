<?php
if ( !function_exists('radium_builder_blog_latest_element_ajax') ) {

	add_action('wp_ajax_nopriv_radium_builder_blog_latest_element_ajax', 'radium_builder_blog_latest_element_ajax');
	add_action('wp_ajax_radium_builder_blog_latest_element_ajax', 'radium_builder_blog_latest_element_ajax');

	/**
	 * radium_builder_blog_latest_element_ajax  Load More posts
	 * @echo json object                  [description]
	 */
	function radium_builder_blog_latest_element_ajax(){

	    if ( !isset($_REQUEST) ) return;

	   // $cats = $_REQUEST['cat_object_id'];
	    $item_count =  $_REQUEST['item_count'];
	    $page =  $_REQUEST['page'];
	    $cache_id = $_REQUEST['cache_id'];
	    $type = $_REQUEST['type'];
	 	$category = $_REQUEST['categories'];
	 	$lang = $_REQUEST['lang'];

	    $output = radium_builder_blog_get_latest_element_content( $item_count, $page, $cache_id, $type, $category, $lang);

	    $output = json_encode($output);

	    echo $output;

	    die;

	}

}

if ( !function_exists('radium_builder_blog_get_latest_element_content') ) {

	/**
	 * [radium_builder_blog_get_latest_element_content description]
	 * @param  integer $item_count items to show
	 * @param  integer  $page       page
	 * @param  string  $cache_id   id to use for caching request
	 * @param  string  $category   which category to get content from, can be an array
	 * @return string              return html
	 */
	function radium_builder_blog_get_latest_element_content ( $item_count = 4, $page = 1, $cache_id = '', $type = 'latest', $category = 'all', $current_lang ) {

	    global $post;

	    $output =  null;

	    //image resizer settings
	    $crop = true; //resize but retain proportions
	    $single = true; //return array

	    $offset = $item_count;

		if ( class_exists('SitePress')) {

			global $sitepress;
	 		$sitepress->switch_lang($current_lang);

		}

	    //Load Query
	    $args = array(
	        'post_type'         => 'post',
	        'posts_per_page'    => $item_count,
	        'paged'             => $page,
	    	'post_status'    => 'publish',
		    'suppress_filters' 	=> false
	    );

	    if( $category !== 'all') {

	        $latest = $category;

	        if( $latest ) $args = array_merge( $args, array( 'category_name' => esc_attr( $latest ) ) );

	    }

	    if ( $type == 'popular' ) {

	    	$args['meta_key'] = '_radium_post_views_count';
	    	$args['orderby']  = 'meta_value_num';

	    } elseif ( $type == 'featured' ) {

	    	$args['meta_key'] = '_radium_featured';
	    	$args['meta_query'] = array(
	    		array(
	    			'key' => '_radium_featured',
	    			'value' => '1',
	    		)
	    	);

	    }

		$args = apply_filters('radium_builder_blog_get_latest_element_content_query_args', $args);

	    $cat_posts = new WP_Query( $args );

	    if ($cat_posts->have_posts()) :

	        $count = 0;

	        $output .= '<div class="row">';

	        while ($cat_posts->have_posts()) : $cat_posts->the_post();

	            global $more;
	            $more = 0;

	            $count++;

	            $format = get_post_format() ? get_post_format() : 'standard';

	            if ( $count == 1 ) {

	                $output .= '<div class="large-6 columns posts-list-excerpt">';

	                  $output .= radium_load_template_part( 'includes/post-formats/content', 'list-big' );

	                $output .= '</div>';

	                $output .= '<div class="large-6 columns">';

	                    } else {

	                        $output .= '<div class="posts-list">';

	                            $output .= radium_load_template_part('includes/post-formats/content', 'list');

	                        $output .= '</div><!-- END .posts-list -->';

	                    }

	                    endwhile;

	                $output .= '</div><!--.large-6.columns -->';

	        $output .= '</div>';

	    endif;

	    wp_reset_postdata();

		if ( class_exists('SitePress')) $sitepress->switch_lang($current_lang);

	    return $output;
	}

}

if ( !function_exists('radium_builder_blog_element_ajax') ) {

	add_action('wp_ajax_nopriv_radium_builder_blog_element_ajax', 'radium_builder_blog_element_ajax');
	add_action('wp_ajax_radium_builder_blog_element_ajax', 'radium_builder_blog_element_ajax');

	/**
	 * radium_builder_blog_latest_element_ajax  Load More posts
	 * @echo json object                  [description]
	 */
	function radium_builder_blog_element_ajax(){

	    if ( !isset($_REQUEST) ) return;

	   // $cats = $_REQUEST['cat_object_id'];
	    $item_count = $_REQUEST['item_count'];
	    $orderby 	= $_REQUEST['orderby'];
	    $order		= $_REQUEST['order'];
	    $exclude	= $_REQUEST['exclude'];
        $offset     = $_REQUEST['offset'];
	    $page 		= $_REQUEST['page'];
	    $type 		= $_REQUEST['type'];
	    $sidebars 	= $_REQUEST['sidebars'];
	    $builder 	= $_REQUEST['builder'];
	    $readmore 	= $_REQUEST['readmore'];
		$categories = $_REQUEST['categories'];
		$excerpt 	= $_REQUEST['excerpt'];
		$lang 		= $_REQUEST['lang'];

	    $output = radium_builder_get_blog_element_content( true, $item_count, $orderby, $order, $exclude, $offset, $page, $type, $builder, $sidebars, $readmore, $categories, $excerpt, $lang);

	    $output = json_encode($output);

	    echo $output;

	    die;

	}

}

if ( !function_exists('radium_builder_get_blog_element_content') ) {

	/**
	 * radium_builder_blog_get_blog_element_content get blog content
	 * @param  integer $item_count items to show
	 * @param  integer  $page       page
	 * @param  string  $cache_id   id to use for caching request
	 * @param  string  $category   which category to get content from, can be an array
	 * @return string              return html
	 */
	function radium_builder_get_blog_element_content ( $ajax, $item_count = 6, $orderby = 'date', $order = 'DESC', $exclude = '', $offset = '', $paged = 1, $blog_type = 'one-column', $builder = true, $sidebars = '2', $readmore = true, $categories = 'all', $excerpt = true, $current_lang = '', $options = array() ) {

		global $post;

		if ( class_exists('SitePress')) {

			global $sitepress;

			if ( !$ajax ) {
				$current_lang = $sitepress->get_current_language();
			}

			// save current language
			$sitepress->switch_lang($current_lang);

		}

		$pages_data = null;
		$test = null;
		$image_size = radium_framework_add_image_sizes();

		if ( !$ajax) $categories = null;

		$crop = true; //resize but retain proportions
		$single = true; //return array

		$exclude_ids = explode(', ', $exclude);

        if( $ajax )
            $offset = $offset + ( $paged - 1 ) * $item_count;

		//Load Query
		$args = array(
		    'post_type' 		=> 'post',
		    'posts_per_page' 	=> $item_count,
		    'paged' 			=> $paged,
	    	'post_status'         => 'publish',
		    'suppress_filters'    => false,
		    'orderby'		       => $orderby,
		    'order'			       => $order,
            'post__not_in'         => $exclude_ids,
            'offset'               =>  $offset
		);

		if( !$ajax ) {

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

		}

		$all_categories = isset($options['categories']) && $options['categories']['all'] ? true : false;

		if( $categories !== 'all' && $categories && !$all_categories) {
			$args = array_merge( $args, array( 'category_name' => esc_attr( $categories ) ) );
	    }

		$args = apply_filters('radium_builder_get_blog_element_content_query_args', $args);

		$query = new WP_Query( $args );

		ob_start();

		if ( $blog_type == 'one-column' ) :

			if ($query->have_posts()) :

				if ($item_count > 0) {
				    $pages = ceil($query->found_posts / $item_count);
				    $pages_data = 'data-pages="'.$pages.'"';
				}

				while ($query->have_posts()) : $query->the_post();

					global $more;
					$more = false;
					$format = get_post_format();

					if( false === $format ) { $format = 'standard'; }
					if( $format == 'aside' || $format == 'gallery' || $format == 'link' || $format == 'quote' || $format == 'status') { }

				    get_template_part( 'includes/content/content', $format );

				endwhile;

			else :

				get_template_part( 'includes/content/content', 'not-found' );

			endif;

		else :

	        if ( $blog_type == 'three-columns') {

	            $type = array(

	                1 => array(
	                    0 => 'smaller',
	                    1 => 'smaller',
	                    2 => 'smaller',
	                )
	            );

	            $reset_counter_at = 2;

	        } else if ( $blog_type == 'two-columns') {

				$type = array(

					1 => array(
						0 => 'small',
						1 => 'small',
					)
				);

				$reset_counter_at = 2;

			} elseif ( $blog_type == 'small-thumbs' ) {

				$type = array(

					1 => array( 0 => 'small-thumbs' )
				);

				$reset_counter_at = 2;

			} else {

				$type = array(

					1 => array(
						0 => 'big',
						1 => 'small',
						2 => 'small'
					),

					2 => array(
						0 => 'big',
						1 => 'mini',
						2 => 'mini',
						3 => 'mini'

					),

					3 => array(
						0 => 'small',
						1 => 'small',
						2 => 'mini',
						3 => 'mini',
						4 => 'mini'
					)
				);
				$reset_counter_at = 4;

			}
			?>

			 <section id="blog-grid">

		         <div class="blog-grid-container <?php echo 'sidebars_' . $sidebars; ?>">

		            <?php

		            $type_counter = 0;
		            $which_type = 1;
		            $i = 1;
		            $aspect_ratio = 1.77777777778;

		            if ( $query->have_posts() ) :

			            if ($item_count > 0) {
			                $pages = ceil($query->found_posts / $item_count);
			                $pages_data = 'data-pages="'.$pages.'"';
			            }

			            while ( $query->have_posts() ) : $query->the_post();

			                global $more;

			                $more = $readmore ? false : true;

			                $format = get_post_format();

	                        $element_class = $close_group = $group = $position = $open = null;

							//check if a sidebar is present
	                        if ( $sidebars == '2' ) {

	                            if ( $blog_type == 'small-thumbs' ) {

	                       			$thumb_w = $image_size['blog_element_small_thumbs_2']['width'];
	                           		$text_length = 10;

	                            } elseif ( $blog_type == 'two-columns') {

	                       		    $thumb_w = $image_size['blog_element_two_columns_2']['width'];
	                                $text_length = 18;

	                            } elseif ( $blog_type == 'three-columns') {

	                                $thumb_w = $image_size['blog_element_three_columns_2']['width'];
	                                $text_length = 10;

	                            }

	                       } elseif ( $sidebars == '1' ) {

	                       		if ( $blog_type == 'small-thumbs' ) {

	                       			$thumb_w = $image_size['blog_element_small_thumbs_1']['width'];
	                       			$text_length = 15;

	                       		} elseif ( $blog_type == 'two-columns') {

	                       		    $thumb_w = $image_size['blog_element_two_columns_1']['width'];
	                       			$text_length = 28;

	                       		} elseif ( $blog_type == 'three-columns') {

	                                $thumb_w = $image_size['blog_element_three_columns_1']['width'];
	                                $text_length = 10;

	                            }

	                       } else {

	                       		if ( $blog_type == 'small-thumbs' ) {

	                       			$thumb_w = $image_size['blog_element_small_thumbs_0']['width'];
	                       			$text_length = 50;

	                       		} elseif ( $blog_type == 'two-columns') {

	                       		    $thumb_w = $image_size['blog_element_two_columns_0']['width'];
	                       		    $text_length = 38;

	                       		} elseif ( $blog_type == 'three-columns') {

	                                $thumb_w = $image_size['blog_element_three_columns_0']['width'];
	                                $text_length = 16;

	                            }

	                       	}

							$thumb_h = round($thumb_w/$aspect_ratio);

	                        $number_in_group = count($type[$which_type]);
	                        $position = $type[$which_type][$type_counter];

	                        $group = ( $number_in_group !== 0 ) ? $type_counter % $number_in_group : 0;

	                        $close_group = $number_in_group ? ($group == $number_in_group - 1) : false;

			                if ( $group == 0 ) { ?><div class="blog-grid-items clearfix post-box-wrapper"><?php }

	                        $element_class = $position . ' sidebars_' . $sidebars;

	                        if ( $group == 0 ) $element_class .= ' first';
	                        if ( $group == $number_in_group - 1 ) $element_class .= ' last';

			                ?><div <?php post_class("grid_elements post-box $element_class"); ?>><?php

	                            if ( $position !== 'small-thumbs' && $position !== 'small' && $position !== 'smaller' ) { ?>

	                                <?php do_action( 'radium_post_grid_before_header' ); ?>

	                                <header class="entry-header">
	                                    <h2 class="entry-title"><a title="<?php printf(__('Permanent Link to %s', 'radium'), get_the_title()); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	                                    <?php if ($position !== 'mini') do_action( 'radium_post_grid_meta' ); ?>
	                                </header><!-- .entry-header -->

	                                <?php do_action( 'radium_post_grid_after_header' ); ?>

	                            <?php }

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

	                                if( $image) { ?>
	                                    <div class="entry-content-media" style="height: <?php echo $thumb_h; ?>px;">
	                                        <div class="post-thumb preload image-loading zoom-img-in">
	                                            <a title="<?php printf(__('Permanent Link to %s', 'radium'), get_the_title()); ?>" href="<?php the_permalink(); ?>">
	                                                <img src="<?php echo $image ?>" alt="<?php the_title();?>" height="<?php echo $thumb_h; ?>" width="<?php echo $thumb_w; ?>" style="height: <?php echo $thumb_h; ?>px;"/>
	                                            </a>
	                                        </div>
	                                        <?php do_action( 'radium_post_grid_extras' ); ?>
	                                    </div>
	                                <?php } ?>

	                            <div class="content_wrapper">
	                                <?php if ( $position == 'small-thumbs' || $position == 'small' || $position == 'smaller' ) { ?>

	                                    <header class="entry-header">

	                                        <?php do_action( 'radium_post_grid_before_header' ); ?>

	                                        <h2 class="entry-title">
	                                            <a title="<?php printf(__('Permanent Link to %s', 'radium'), get_the_title()); ?>" href="<?php the_permalink(); ?>">
	                                                <?php the_title(); ?>
	                                            </a>
	                                        </h2>

	                                        <?php do_action( 'radium_post_grid_after_header' ); ?>

	                                    </header><!-- .entry-header -->

	                                <?php } ?>

	                                <?php if ( $excerpt ) {  ?>
	                                <article class="entry-content">
	                                    <?php if ( $position == 'small' || $position == 'smaller' || $position == 'small-thumbs' || $position == 'mini') { ?>
	                                    	<p><?php echo wp_trim_words( get_the_excerpt(), $text_length ); ?></p>

	                                        <?php if ( $readmore ) { ?><p><a href="<?php the_permalink(get_the_ID()); ?>" class="more-link"><span><?php _e( 'Continue Reading &rarr;', 'radium' ); ?></span></a><?php do_action( 'radium_post_grid_comments' ); ?></p><?php } ?>

	                                    <?php } else {
	                                    	the_content( __( '<span>Continue Reading &rarr;</span>', 'radium' ) );
	                                    } ?>
	                                </article><!-- .entry-content -->
	                                <?php } ?>
	                            </div>

	                            <?php if ( $position !== 'small' || $position !== 'smaller' || $position !== 'small-thumbs' || $position !== 'mini' ) do_action( 'radium_post_grid_footer_meta' ); ?>

	                        </div><?php

	                        if ( $close_group ) { ?><div class="blog-grid-divider clearfix"></div></div><?php }

		                    $i++;
		                    $type_counter++;

		                    if ( $type_counter == $number_in_group ) {
		                        $which_type++;
		                        $type_counter = 0; //reset type counter
		                    }

		                    if ( $which_type == $reset_counter_at ) $which_type = 1;

		                endwhile;

	                else :

	                    if ( !$ajax ) {

	                    	get_template_part( 'includes/content/content', 'not-found' );

	                    } else {

	                    	 get_template_part( 'includes/content/content', 'not-found-ajax' );

	                    }

	                endif; ?>

	            </div>
	        </section>

		<?php endif;

		wp_reset_postdata();

		if ( class_exists('SitePress')) $sitepress->switch_lang($current_lang);

		$readmore = isset($options['readmore']) ? $options['readmore'] : true;

		if ( !$ajax && $readmore ) {

			$load_more_text = isset($options['load_more_text']) ? $options['load_more_text'] : __('Load More Posts', 'radium');
			$excerpt = isset($options['show_excerpt']) && $options['show_excerpt'] == '' ? '0' : '1';

			$categories = esc_html($categories);

		?>
	        <div class="load-more-blog load-more-button center clearfix">
	            <button title="<?php echo $load_more_text; ?>" data-categories="<?php echo $categories; ?>" data-text="<?php echo $load_more_text; ?>" data-count="<?php echo $item_count; ?>" data-orderby="<?php echo $orderby; ?>" data-order="<?php echo $order; ?>" data-exclude="<?php echo $exclude; ?>" data-offset="<?php echo $offset; ?>" data-page="<?php echo $paged; ?>" data-type="<?php echo $blog_type; ?>" data-sidebars="<?php echo $sidebars; ?>" data-builder="<?php echo $builder; ?>" data-readmore="<?php echo $readmore; ?>" data-excerpt="<?php echo $excerpt; ?>" data-lang="<?php echo $current_lang; ?>" <?php echo $pages_data; ?> ><span><?php echo $load_more_text; ?></span></button>
	        </div>
	    <?php }

		$output = ob_get_contents();

		ob_get_clean();

		return $output;
	}

}
