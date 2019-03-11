<?php /* STANDARD POST FORMAT */
$image = null;
$image_size 			= radium_framework_add_image_sizes();
$sidebar 				= radium_sidebar_loader(radium_get_option('single_post_layout', false, 'right') );
$featured_image_size 	= get_post_meta( get_the_ID(), '_radium_featured_image_size', true) ? get_post_meta( get_the_ID(), '_radium_featured_image_size', true) : 'large';
$featured_image_aspect_ratio 	= get_post_meta( get_the_ID(), '_radium_featured_image_aspect_ratio', true) ? get_post_meta( get_the_ID(), '_radium_featured_image_aspect_ratio', true) : false;

if ( $featured_image_size == 'large' ) {
	
	$image_size = $sidebar['sidebar_active'] ? $image_size['single_blog_large'] : $image_size['single_blog_large'];
	
} else {
	
	$image_size = $sidebar['sidebar_active'] ? $image_size['single_blog_small'] : $image_size['single_blog_small'];
		
} 

$thumb_w = $image_size['width']; //Define width
$thumb_h = $image_size['height'];
$adjusted_height = ''; //used to preserve aspect ratio
$img_url = false;
$crop = ( is_single() ) ? false : true;

//Check if post has a featured image set else get the first image from the gallery and use it. If both statements are false display fallback image.
if ( has_post_thumbnail() && $featured_image_size !== 'none' ) {

    //get featured image
    $thumb = get_post_thumbnail_id();
    $img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the image is too big)
		
	$image_meta = wp_get_attachment_metadata($thumb);	
} 

?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if( $img_url ) { ?>

        <div class="row post-top <?php echo $featured_image_size; ?>">

            <div class="entry-media-wrapper">

			<?php 
                $caption = radium_get_the_featured_image_details( 'caption' ); 
                $caption = strip_tags($caption, '<p><br>'); //strip all except divs and p tags 
                
                if( $featured_image_aspect_ratio && $featured_image_size == 'large') {                                 
	               
	                //$img_dimensions 	= getimagesize($image); //Dimensions of the post-featured image used by the end-user
	                $original_img_width 	= $image_meta['width'];
	                $original_img_height 	= $image_meta['height'];
	               	
	                //The assumption is that the Frame must always be of min-height: 450px; refer to style.min.css:line 13900
	                $img_ratio 			= $original_img_height/$original_img_width;  
	                if ($img_ratio > 0.513){ //0.513 is the ratio -> (frame_height:frame_width) (ie. 0.513:1)
	                	$adjusted_height = round( ($img_ratio/0.513 * 450), 0, PHP_ROUND_HALF_UP);
	                	$thumb_w = $image_size['width']; //Define width
	                	$thumb_h = $adjusted_height;
	                } 
	                
                }
                
                $image 				= $img_url ? radium_resize( $img_url, $thumb_w, $thumb_h, $crop ) : false ;
                $image_bg_style 	= $adjusted_height ? 'min-height: ' . $adjusted_height. 'px;' : 'background-image: url(' . $image . ');';
                $image_style 		= $featured_image_aspect_ratio ? '' : 'display: none;';
                
             ?>

	            <div class="entry-content-media" style="<?php echo $image_bg_style; ?>">
					
					<?php if( $featured_image_size !== 'large' ) { ?>
					
	                <div class="post-thumb preload image-loading">
	                	<figure class="image-outset">
	                        <?php if( is_single() ) { ?>
	                        	
	                        	<a title="<?php the_title(); ?>" href="<?php echo $img_url; ?>" rel="lightbox">
	
	                            	<img src="<?php echo $image; ?>" class="wp-post-image" width="<?php echo $thumb_w; ?>" height="<?php echo $thumb_h; ?>" alt="<?php the_title(); ?>" />
	                            	<?php if ($caption) { ?><div class="feature-caption"><?php echo $caption; ?></div><?php } ?>
								
								</a>
								
	                        <?php } else { ?>
	
	                            <a title="<?php printf(__('Permanent Link to %s', 'radium'), get_the_title()); ?>" href="<?php the_permalink(); ?>">
	                                <img src="<?php echo $image; ?>" class="wp-post-image" width="<?php echo $thumb_w; ?>" height="<?php echo $thumb_h; ?>" alt="<?php the_title(); ?>" />
	                            <?php if ($caption) { ?><div class="feature-caption"> <?php echo $caption; ?></div><?php } ?>
	                            </a>
	
	                        <?php }  ?>
	                    </figure>
	                </div>
	                
	                <?php } else { ?>
	                
	                	<img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" style="<?php echo $image_style; ?>"/>
	                
	                <?php } ?>
	
	            </div>
	
	        </div><!-- END .entry-media-wrapper -->
	
	        <div class="entry-header-wrapper">

    <?php } //image ?>

        	<header class="entry-header">

        		<?php do_action('radium_before_post_title'); ?>

        		<?php if( is_single() ) {  // DISPLAY ON SINGLE ONLY  ?>

        			<h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1><!-- END .entry-title -->

        		<?php } else {  // END ON SINGLE ONLY ?>

        			<h2 class="entry-title" itemprop="headline"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'radium' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2><!-- END .entry-title -->

        		<?php } ?>

        		<?php do_action('radium_after_post_title'); ?>

        	</header><!-- END .entry-header -->

    <?php if( $image ) { ?>

        </div><!-- END .large-6.columns -->

    </div><!-- END .row -->

    <?php } //image ?>

    <?php if(!empty($post->post_excerpt) && is_single() ) { // POST EXCERPT ON SINGLE ?>

    	<div class="post-excerpt" itemprop="description">

    		<?php the_excerpt(); ?>

    	</div><!-- END .post-excerpt -->

    <?php  } //END IF EXCERPT ?>

	<div class="entry-content">

		<?php do_action('radium_before_post_content'); ?>

		<div itemprop="articleBody" class="clearfix">
			<?php the_content( __( '<span>Read More</span><span class="right comments-count">'.get_radium_comment_count().'</span>', 'radium' ) ); ?>
		</div>

		<?php do_action('radium_after_post_content'); ?>

	</div><!-- END .entry-content -->
	
</article><!-- END #post-<?php the_ID(); ?> -->