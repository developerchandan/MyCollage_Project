<?php

/**
 * Posts Element
 *
 * @since 2.1.0
 *
 * @params array $options
 * @param string $current_location Current location of element, featured or primary
 */
if ( ! function_exists( 'radium_builder_blog_category_small_element' )) {
	function radium_builder_blog_category_small_element( $id, $options, $location ) {

		global $post;
		
		$sidebar = radium_sidebar_loader();
		
		//Get Global Page Settings
		$page_items = isset($options['numberposts']) ? $options['numberposts'] : 6;
		$orderby = isset($options['orderby']) ? $options['orderby'] : 'date';
		$order = isset($options['order']) ? $options['order'] : 'DESC';
		$offset = isset($options['offset']) ? $options['offset'] : 0;
		
		$exclude = isset($options['exclude']) ? $options['exclude'] : '';
		$exclude_ids = explode(', ', $exclude);
		$cat_link = false;
		
		//Load Query
		$args = array(
		    'post_type' 		=> 'post',
		    'posts_per_page' 	=> $page_items,
            'ignore_sticky_posts' => true,
            'orderby'		=> $orderby,
            'order'			=> $order,
            'post__not_in'  => $exclude_ids,
            'offset'		=> $offset,
            'no_found_rows' => true //pagination off
		);

		if( $options['categories'] !== 'all') {

 			$category = $options['categories'];
			if( $category ) {
				$args = array_merge( $args, array( 'category_name' => esc_attr( $category ) ) );
				$category_object = get_category_by_slug($category); 
				$category_id = $category_object ? $category_object->term_id : false;
				$cat_link = $category_id ? true : false;
			}
        }       
          
        $cache_id = $options['cache_id'];
        $cat_posts =  Radium_Theme_WP_Query::cache_query( $args, $cache_id );
        
        $title      = ( $options['title'] && $options['title'] !== '_' ) ? $options['title']   : __('Title', 'radium');

        $view_all      	= isset($options['view_all']) ? $options['view_all'] : false;
        $view_all_title = isset($options['view_all_title']) ? $options['view_all_title'] : __('VIEW ALL', 'radium');

		if ( $options['title'] == '_') $title = false;
		
		if ($cat_posts->have_posts()) : ?>

            <?php if( $title ) { ?>
            	<div class="entry-element-title"><div class="ribbon"></div><h3><?php echo $title; ?></h3>
            	<?php if ( $view_all && $cat_link ) { ?><div class="element-category-view-all"><a href="<?php echo get_category_link($category_id); ?>"><?php echo $view_all_title; ?></a></div><?php } ?></div>
            <?php } ?>

            <?php

            $count = 0;

            while ( $cat_posts->have_posts() ) : $cat_posts->the_post();

                global $more; $more = 0;

                $count++;

                if ( $count == 1 ) { ?>

                    <div class="posts-list-excerpt">
                        
                        <article <?php post_class('content-list-big'); ?>>
                        	
                        	<?php do_action('radium_before_post_list_big'); ?>
                        	
	                        <a title="<?php printf(__('Permanent Link to %s', 'radium'), get_the_title()); ?>" href="<?php the_permalink(); ?>">
	                            <?php
	                        		
	                            $image_size = radium_framework_add_image_sizes();
	                            
	                            if ( !$sidebar['sidebar_active'] ) {
	                            	 
	                            	 $image_size = $image_size['content_list_large_0'];
	                            	 
	                            } elseif( is_page_template('page-templates/page-home.php') && !$sidebar['sidebar_active'] ) {
	                            
	                            	 $image_size = $image_size['content_list_large_2'];
	                            
	                            } else { 
	                            
	                            	$image_size = $image_size['content_list_large_1'];
	                            	
	                            }
	                          	                          	                          	
	                            $image = false;
	                        
	                            //Check if post has a featured image set else get the first image from the gallery and use it. If both statements are false display fallback image.
	                        	$image = get_radium_post_image(get_the_ID(), 'post', $image_size['width'], $image_size['height'], true, true );
	                        
	                            if( $image ) { ?>
	                        
	                                <div class="entry-content-media">
	                        
	                                    <div class="post-thumb preload image-loading" style="max-height: <?php echo $image_size['height']; ?>px;">
	                        
	                                        <?php do_action('radium_before_post_list_big_thumb'); ?>
	                        
	                                        <img src="<?php echo $image; ?>" class="wp-post-image" width="<?php echo $image_size['width']; ?>" height="<?php echo $image_size['height']; ?>" alt="<?php the_title(); ?>" />
	                        
	                                        <?php do_action('radium_after_post_list_big_thumb'); ?>
	                        
	                                    </div>
	                        
	                                </div>
	                        
	                            <?php } //image ?>
	                        
	                        	<header class="entry-header">
	                        
	                        		<?php do_action('radium_before_post_list_big_title'); ?>
	                      
	                    			<h2 class="entry-title"><?php the_title(); ?></h2><!-- END .entry-title -->
	                                            
	                        		<?php do_action('radium_after_post_list_big_title'); ?>
	                        
	                        	</header><!-- END .entry-header -->
	                        
	                            <?php if( !empty($post->post_excerpt ) && !$image ) { // POST EXCERPT ON SINGLE ?>
	                        
	                            	<div class="post-excerpt"><?php the_excerpt(); ?></div><!-- END .post-excerpt -->
	                        
	                            <?php  } //END IF EXCERPT ?>
                        	
                        	</a>
                        	
                        	<?php do_action('radium_after_post_list_big'); ?>
                        	
                        </article><!-- END #post-<?php the_ID(); ?> -->

                    </div>

                <?php } else /*if( $count == 2 ) */ { ?>

                    <div class="posts-list">

                        <?php get_template_part('includes/post-formats/content', 'list'); ?>

                    </div><!-- END .posts-list -->

                <?php }

            endwhile;

        endif; wp_reset_postdata();

 	}
}
add_action('radium_builder_blog_category_small', 'radium_builder_blog_category_small_element', 10, 3);