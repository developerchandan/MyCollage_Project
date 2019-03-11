<?php

/**
 * Posts Element
 *
 * @since 2.1.0
 *
 * @params array $options
 * @param string $current_location Current location of element, featured or primary
 */
if ( ! function_exists( 'radium_builder_blog_latest_element' )) {
	function radium_builder_blog_latest_element( $id, $options, $location  ) {

        $page_items = $pages_data = $current_lang = null;
		$sidebar = radium_sidebar_loader(); 
		
		//Get Global Page Settings
		$cache_id = $options['cache_id'];
        $title      = isset($options['title']) ? $options['title'] : __('Title', 'radium');
		$page_items = isset($options['numberposts']) ? $options['numberposts'] : 4;
		$active_tabs = isset($options['active_tabs']) ? $options['active_tabs'] : array('latest' => '1', 'popular' => '1', 'featured' => '1');
		
		$categories = isset($options['categories']) ? $options['categories'] : 'all';
		
		if ( class_exists('SitePress')) {
		
			global $sitepress;
			$current_lang = $sitepress->get_current_language();
		
		}
		
        if ( $options['title'] == '_') $title = false;

        $paged = 1;
        
        $image_size = radium_framework_add_image_sizes();
        
        if ( !$sidebar['sidebar_active'] ) {
        	 
        	 $image_size = $image_size['content_list_large_0'];
        	 
        } elseif( is_page_template('page-templates/page-home.php') && !$sidebar['sidebar_active'] ) {
        
        	 $image_size = $image_size['content_list_large_2'];
        
        } else { 
        
        	$image_size = $image_size['content_list_large_1'];
        	
        }

		if ( $title ) { ?>

            <div class="entry-element-title">
                <div class="ribbon"></div>
                <h3 class="clearfix"><?php echo $title; ?></h3>
                
                <div class="latest-posts-tabs">
                	<ul class="nav nav-tabs clearfix">
                		<?php if ( $active_tabs['latest'] ) { ?><li class="active"><a href="#latest-posts-<?php echo $id; ?>" data-toggle="tab"><?php _e('Latest', 'radium'); ?></a></li><?php } ?>
                		<?php if ( $active_tabs['popular'] ) { ?><li><a href="#popular-posts-<?php echo $id; ?>" data-toggle="tab"><?php _e('Popular', 'radium'); ?></a></li><?php } ?>
                		<?php if ( $active_tabs['featured'] ) { ?><li><a href="#featured-posts-<?php echo $id; ?>" data-toggle="tab"><?php _e('Featured', 'radium'); ?></a></li><?php } ?>
                	</ul>
                </div>
                
            </div>

            <?php } ?>
                       
         	<div class="tab-content">
            	
            	<?php if ( $active_tabs['latest'] ) { ?>

            	<div id="latest-posts-<?php echo $id; ?>" class="tab-pane fade in active">
										
                    <div class="content-inner">
						<?php
						
						//Load Query
						$args = array(
				 		    'posts_per_page' => $page_items,
				            'paged' => $paged,
				            'ignore_sticky_posts' => true
						);
						
						if( $options['categories'] !== 'all') {
				
				 			$category = $options['categories'];
				
							if( $category ) $args = array_merge( $args, array( 'category_name' => esc_attr( $category ) ) );
				
				        }
										
				       $latest_posts = Radium_Theme_WP_Query::cache_query( $args, $cache_id. '_latest' );
				
						if ($latest_posts->have_posts()) : ?>
						
	                    <div class="row"><?php
	
	                    $count = 0;
	
	                    if ($page_items > 0) {
	                        $pages = ceil($latest_posts->found_posts / $page_items);
	                        $pages_data = 'data-pages="'.$pages.'"';
	                    }
	
		                while ($latest_posts->have_posts()) : $latest_posts->the_post();
		
		                        $count++;
	
	                        if ( $count == 1 ) { 
	                        
	                        	//check for an image 
	                        	if ( has_post_thumbnail() ) {
	                        	
										//get featured image
	                        	       	$thumb = get_post_thumbnail_id();
	                        	        $img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the image is too big)
 	                        	}
 	                        	
	                        ?>
	
	                            <div class="large-6 columns posts-list-excerpt clearfix">
	
	                                <article <?php post_class('content-list-big'); ?>>
										
										<?php do_action('radium_before_post_list_big'); ?>
	                                	
	                                	<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'radium' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
		                                	
		                                    <?php
		                             
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
	
	                            </div><!-- END .large-6.columns -->
	
	                            <div class="large-6 columns posts-list">
	
	                        <?php } else { ?>
	
	                            <div class="posts-list">
	                            
	                            	<?php get_template_part('includes/post-formats/content', 'list'); ?>
	
	                            </div><!-- END .posts-list -->
	
	                        <?php }
	
	                    	endwhile; wp_reset_postdata(); ?>
	
	                    </div><!-- END .large-6.columns -->

                	</div><!--.row -->

                	</div><!--.content-inner -->
					
					<?php if ($options['load_more']) { ?>
					
			        <div class="load-more-latest load-more-button load-more-latest-element center clearfix">
			            <button data-type="latest" data-page="<?php echo $paged; ?>" data-category="<?php echo $categories; ?>"  title="<?php echo $options['load_more_text']; ?>" data-count="<?php echo $page_items; ?>" data-cache_id="<?php echo $page_items; ?>" <?php echo $pages_data; ?> data-lang="<?php echo $current_lang; ?>"><?php echo $options['load_more_text']; ?></button>
			        </div>
			
			    <?php } ?>
			    
			</div><!--.tab-pane -->

        		<?php endif; ?>
        	    
        	    <?php } ?>
        	    
        	    <?php if ( $active_tabs['popular'] ) { ?>
        		
        		<?php

    			//Load Query
    			$args = array(
    	 		    'posts_per_page' => $page_items,
    	            'paged' => $paged,
    	            'ignore_sticky_posts' => true,
    			);
    			
    			$args['meta_key'] = '_radium_post_views_count';
    			$args['orderby']  = 'meta_value_num';
    			
    			if( $options['categories'] !== 'all') {
    	
    	 			$latest = $options['categories'];
    	
    				if( $latest ) $args = array_merge( $args, array( 'category_name' => esc_attr( $latest ) ) );
    	
    	        }
    				    	
    	       $popular_posts = Radium_Theme_WP_Query::cache_query( $args, $cache_id.'_popular' );
    	
    			if ($popular_posts->have_posts()) : ?>
    			
    			<div id="popular-posts-<?php echo $id; ?>" class="tab-pane fade">
    				
    			    <div class="content-inner">
    			
    			    	<div class="row"><?php 

	                $count = 0;
	
	                if ($page_items > 0) {
	                    $pages = ceil($popular_posts->found_posts / $page_items);
	                    $pages_data = 'data-pages="'.$pages.'"';
	                }
	
	                while ($popular_posts->have_posts()) : $popular_posts->the_post();
	
	                        $count++;
	
	                    if ( $count == 1 ) { ?>
	
	                        <div class="large-6 columns posts-list-excerpt clearfix">
	
	                        	<article <?php post_class('content-list-big'); ?>>
	                        	
	                        		<?php do_action('radium_before_post_list_big'); ?>
	                        	
	                        		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'radium' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
		                        		
		                        	    <?php
		                         
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
	
	                        </div><!-- END .large-6.columns -->
	
	                        <div class="large-6 columns posts-list">
	
	                    <?php } else { ?>
	
	                        <div class="posts-list">
	
	                            <?php get_template_part('includes/post-formats/content', 'list'); ?>
	
	                        </div><!-- END .posts-list -->
	
	                    <?php }
	
	                	endwhile; wp_reset_postdata(); ?>
	
	                </div><!-- END .large-6.columns -->
	
	        	</div><!--.row -->
				
				</div><!--.content-inner -->
				
				<?php if ($options['load_more']) { ?>
				
			        <div class="load-more-popular load-more-button load-more-latest-element center clearfix">
			            <button data-type="popular" data-page="<?php echo $paged; ?>" data-category="<?php echo $categories; ?>" title="<?php echo $options['load_more_text']; ?>" data-count="<?php echo $page_items; ?>" data-cache_id="<?php echo $page_items; ?>" <?php echo $pages_data; ?> data-lang="<?php echo $current_lang; ?>"><?php echo $options['load_more_text']; ?></button>
			        </div>
			
			    <?php } ?>
				    
	    	</div><!--.tab-pane -->
		
				<?php endif; ?>
				
				<?php } ?>
				
				<?php if ( $active_tabs['featured'] ) { ?>
				
				<?php
					
				//Load Query
				$args = array(
				    'posts_per_page' => $page_items,
					'paged' => $paged,
					'meta_key' 		=> '_radium_featured',
					'ignore_sticky_posts' => true,
					'meta_query' => array(
						array(
							'key' => '_radium_featured',
							'value' => '1',
						),
					)
				);
				
				if( $options['categories'] !== 'all') {
				
					$latest = $options['categories'];
				
					if( $latest ) $args = array_merge( $args, array( 'category_name' => esc_attr( $latest ) ) );
					
				}
								
				$featured_posts = Radium_Theme_WP_Query::cache_query( $args, $cache_id.'_featured' );
				
				if ($featured_posts->have_posts()) : ?> 
				
					<div id="featured-posts-<?php echo $id; ?>" class="tab-pane fade">
					
						<div class="content-inner">
					
							<div class="row">
							
						<?php
				
				        $count = 0;
				
				        if ($page_items > 0) {
				            $pages = ceil($featured_posts->found_posts / $page_items);
				            $pages_data = 'data-pages="'.$pages.'"';
				        }
				
				        while ($featured_posts->have_posts()) : $featured_posts->the_post();
				
				                $count++;
				
				            if ( $count == 1 ) { ?>
				
				                <div class="large-6 columns posts-list-excerpt clearfix">
				
	                                <article <?php post_class('content-list-big'); ?>>
	                                	
	                                	<?php do_action('radium_before_post_list_big'); ?>
	                                	
	                                	<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'radium' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
	                                	
		                                    <?php
		                                
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
				
				                </div><!-- END .large-6.columns -->
				
				                <div class="large-6 columns posts-list">
				
				            <?php } else { ?>
				
				                <div class="posts-list">
				
				                    <?php get_template_part('includes/post-formats/content', 'list'); ?>
				
				                </div><!-- END .posts-list -->
				
				            <?php }
				
				        	endwhile; wp_reset_postdata(); ?>
				
				        </div><!-- END .large-6.columns -->
				
					</div><!--.row -->
				
				</div><!--.content-inner -->
				
				<?php if ($options['load_more']) { ?>
				
				<div class="load-more-featured load-more-button load-more-latest-element center clearfix">
				    <button data-type="featured" data-page="<?php echo $paged; ?>" data-category="<?php echo $categories; ?>" title="<?php echo $options['load_more_text']; ?>" data-count="<?php echo $page_items; ?>" data-cache_id="<?php echo $page_items; ?>" data-lang="<?php echo $current_lang; ?>" <?php echo $pages_data; ?> ><?php echo $options['load_more_text']; ?></button>
				</div>
				
				<?php } ?>
				
			</div><!--.tab-pane -->

        		<?php endif; ?>
        		
        		<?php } ?>
        		
        	</div>
        	
        <?php

 	}
}
add_action('radium_builder_blog_latest', 'radium_builder_blog_latest_element', 10, 3);