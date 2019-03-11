<?php /* STANDARD POST FORMAT */ 
		
$image_size = radium_framework_add_image_sizes();
$image_size = is_page_template('page-templates/page-home.php') ? $image_size['content_list_large_2'] : $image_size['content_list_large_1'];
	
$image = false;

//Check if post has a featured image set else get the first image from the gallery and use it. If both statements are false display fallback image.
$image = get_radium_post_image(get_the_ID(), 'post', $image_size['width'], $image_size['height'], true, true );

?>
<article <?php post_class('content-list-big'); ?>>
	
	<?php do_action('radium_before_post_list_big'); ?>
	
	<a title="<?php printf(__('Permanent Link to %s', 'radium'), get_the_title()); ?>" href="<?php the_permalink(); ?>">
	    
	    <?php if( $image ) { ?>
	
	        <div class="entry-content-media">
	
	            <div class="post-thumb preload image-loading">
	
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