<?php 
/**
 * Attachment template
 *
 * @since NewsCore 1.5.1
 *
 */
 
 $image_size 		= radium_framework_add_image_sizes();
 $attachment_size 	=  $image_size['attachment_size'];
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  	<header class="entry-header">

  		<?php do_action('radium_before_post_title'); ?>
  
		<h1 class="entry-title" itemprop="headline">

		    <?php the_title(); ?>

		</h1><!-- END .entry-title -->
  
  		<?php do_action('radium_after_post_title'); ?>

  	</header><!-- END .entry-header -->

	<div class="entry-content-media clearfix" itemprop="articleBody">

		<?php if ( wp_attachment_is_image() ) :
			
			$attachments = array_values( 
				get_children( 
					array( 
						'post_parent' => $post->post_parent, 
						'post_status' => 'inherit', 
						'post_type' => 'attachment', 
						'post_mime_type' => 'image', 
						'order' => 'ASC', 
						'orderby' => 'menu_order ID' 
					) 
				) 
			);
			
			foreach ( $attachments as $k => $attachment ) {
				if ( $attachment->ID == $post->ID )
					break;
			}
		
			// If there is more than 1 image attachment in a gallery
			if ( count( $attachments ) > 1 ) {
				$k++;
				if ( isset( $attachments[ $k ] ) )
					// get the URL of the next image attachment
					$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
				else
					// or get the URL of the first image attachment
					$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
			} else {
				// or, if there's only 1 image attachment, get the URL of the image
				$next_attachment_url = wp_get_attachment_url();
			}
 		
		$image_content = '<p class="attachment"><a href="'. esc_url( $next_attachment_url ).'" title="'. the_title_attribute('echo=0') .'" rel="attachment">'. wp_get_attachment_image( $post->ID, array( $attachment_size['width'], $attachment_size['height'] ) ) .'</a></p>';
	
	else :
		
		$image_content = '<a href="'. esc_url( wp_get_attachment_url() ) .'" title="'.the_title_attribute('echo=0') .'" rel="attachment">'. basename( get_permalink() ). '</a>';
	
	endif; ?>

	</div><!-- END .entry-content-media -->

	<div class="entry-content">

		<?php do_action('radium_before_post_content'); ?>

		<div itemprop="articleBody" class="clearfix">
 			<?php echo $image_content; ?>
 		</div>
 		
	   <?php if(!empty($post->post_excerpt) && is_single() ) { // POST EXCERPT ON SINGLE ?>
	
	    	<div class="post-excerpt" itemprop="description">
	
	    		<?php the_excerpt(); ?>
	
	    	</div><!-- END .post-excerpt -->
	
	    <?php  } //END IF EXCERPT ?>

		<?php do_action('radium_after_post_content'); ?>

	</div><!-- END .entry-content -->
 
</article><!-- END #post-<?php the_ID(); ?> -->