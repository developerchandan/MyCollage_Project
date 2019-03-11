<?php

/**
 * Posts Element
 *
 * @since 2.1.0
 *
 * @params array $options
 * @param string $current_location Current location of element, featured or primary
 */
if ( ! function_exists( 'radium_builder_blog_review_element' )) {
	function radium_builder_blog_review_element( $id, $options, $location  ) {

		global $post, $post_id;

        $output = null;

        $id = $post_id;
        $categories = null;

        $title = isset($options['title']) ? $options['title'] : '';
        if ( $options['title'] == '_') $title = false;
        
        $subtitle = isset($options['subtitle']) ? $options['subtitle'] : '';
        $limit = isset($options['limit']) ? $options['limit'] : 16;
		$orderby = isset($options['orderby']) ? $options['orderby'] : 'date';
		$order = isset($options['order']) ? $options['order'] : 'DESC';
		$offset = isset($options['offset']) ? $options['offset'] : 0;
		
		$exclude = isset($options['exclude']) ? $options['exclude'] : '';
		$exclude_ids = explode(', ', $exclude);
  
        $args = array(
            'posts_per_page' => esc_attr( $limit ),
            'ignore_sticky_posts' => true,
            'orderby'		=> $orderby,
            'order'			=> $order,
            'post__not_in'  => $exclude_ids,
            'offset'		=> $offset,
            'no_found_rows' => true, //pagination off
            'meta_query' => array(
                array(
                    'key' => '_radium_post_score',
                    'value' => '1',
                    'compare' => '='
                )
            )
        );
        
        $type = 'post';

		$posts = Radium_Theme_WP_Query::get_posts_cached( $args, $options['cache_id'] );

        if( $categories ) $args = array_merge( $args, array( 'category_name' => esc_attr( $categories ) ) );

        if( $posts ) {

            if ( $title ) { ?>
                <div class="entry-element-title"><div class="ribbon"></div><h3><?php echo esc_attr($title); ?></h3></div>
            <?php } ?>

            <div class="subfeatured-articles reviews-carousel">

                <div class="horizontal-carousel-container">

                    <div class="control prev"></div>

                    <div class="horizontal-carousel <?php echo $type; ?>">

                        <ul>

                <?php

                $sidebar = radium_sidebar_loader();

                $image_size = radium_framework_add_image_sizes();
                $image_size = $image_size['review_carousel_small'];

                $thumb_w = $image_size['width']; //Define width
                $thumb_h = $image_size['height'];

                $crop   = true; //resize but retain proportions
                $single = true; //return array

				global $post;

                foreach( $posts as $post ) { setup_postdata($post);

                    $excerpt = strip_tags(wp_trim_words( get_the_excerpt(), '16' ));
                    $post_type = $post_class = $post_type = $category_name = null;
                    $post_type = get_post_format() ? get_post_format() : 'standard';
                    $post_class = strtolower($post_type);
                    $terms = get_the_terms( get_the_ID(), 'category' );

                    $image = get_radium_post_image(get_the_ID(), $post_type, $thumb_w, $thumb_h, $crop, $single );

                    if( is_array($terms) ) {
                        foreach ( $terms as $term ) {
                            $category_name .= $term->name.', ';
                        }
                    }

                    $category_name = rtrim( $category_name, ', ' );
                    ?>

                    <li itemscope>

                        <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" class="review-slide-item <?php echo esc_attr( $type ); ?> post-<?php echo $post_type; ?>">

                            <div class="inner">

                                <div class="entry-content-media">

                                    <div class="post-thumb preload image-loading">

                                        <?php do_action('radium_before_post_review_thumb'); ?>

                                            <img src="<?php echo $image ?>" alt="<?php the_title(); ?>" class="review-image wp-post-image" width="<?php echo $thumb_w; ?>" height="<?php echo $thumb_h; ?>"/>

                                        <?php do_action('radium_after_post_review_thumb'); ?>

                                    </div>

                                </div>

                                <header class="entry-header">

                                    <?php do_action('radium_before_post_review_title'); ?>

                                    <h3 class="entry-title">
                                    	<?php echo get_the_title( $post->ID ); ?>
                                    </h3>

                                    <?php do_action('radium_after_post_review_title'); ?>

                                </header>

                            </div><!-- .inner -->

                        </a>

                    </li>

                    <?php }

                    wp_reset_postdata();

                    ?>

                </ul>

            </div>

            <div class="control next"></div>

        </div>

    </div><!-- end .radium-carousel -->

    <?php }

 	}

}
add_action('radium_builder_blog_review', 'radium_builder_blog_review_element', 10, 3);

