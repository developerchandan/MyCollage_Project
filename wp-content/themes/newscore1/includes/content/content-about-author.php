<section class="about-author" itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person">
	
	<div class="inner clearfix">
	
	     <?php $author_box_title = radium_get_option( 'author_box_title') ? radium_get_option( 'author_box_title') : __('About the Author', 'radium'); ?>
	
	    <h3><span><?php echo $author_box_title; ?></span></h3>
	
		<div class="author-avatar" itemprop="image">
			<?php
	
	        $image_size = radium_framework_add_image_sizes();
	        $image_size = $image_size['single_get_the_author_meta'];
	        $thumb_w = $image_size['width']; //Define width
	
	        echo get_avatar( get_the_author_meta('user_email'), $thumb_w, '' );
	
	        ?>
		</div><!-- END .author-avatar -->
	
		<div class="author-desc author" >
			<h4 itemprop="name"><?php the_author_meta('display_name'); ?></h4>
			<p>
	
				<?php if (get_the_author_meta('description')) { 
					
					the_author_meta('description');
	
				} else {
	
					_e( 'This author has not added a biography. Meanwhile ', 'radium' );
	
					the_author_meta('display_name'); _e( ' has contributed ', 'radium' );
	
					the_author_posts(); _e( ' posts.', 'radium' );
	
					?>
	
					<a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>">
						<?php _e( ' Click here', 'radium' ); ?>
					</a>
	
					<?php _e( ' to view them.', 'radium' ); ?>
	
	 			<?php } // END if get_the_author_meta('description') ?>
	
			</p>
	
			<?php do_action('radium_author_icons'); ?>
	
		</div><!-- END .large-10 .columns -->
		
	</div>
	
</section><!-- END .about-author -->