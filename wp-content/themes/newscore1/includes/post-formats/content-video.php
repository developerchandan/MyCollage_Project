<?php /* GALLERY POST FORMAT */ ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

		<?php do_action('radium_before_post_title'); ?>

  		<?php if( is_single() ) {  // DISPLAY ON SINGLE ONLY  ?>

  			<h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1><!-- END .entry-title -->

  		<?php } else {  // END ON SINGLE ONLY ?>

  			<h2 class="entry-title" itemprop="headline"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'radium' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2><!-- END .entry-title -->

  		<?php } ?>

  		<?php do_action('radium_after_post_title'); ?>

  	</header><!-- END .entry-header -->

	<div class="entry-content-media">
		<?php 
		
		$video_id = get_post_meta( get_the_ID(), '_radium_video_id', true);
		
		if ( function_exists('video_central') && $video_id ) {
  			
			?>
			<article id="video-central-player-<?php video_central_video_id($video_id); ?>" class="video-central-player loading">
			
			    <?php do_action( 'video_central_template_before_video_player' ); ?>
			
			    <?php video_central_player($video_id); ?>
			
			    <?php do_action( 'video_central_template_after_video_player' ); ?>
			
			</article>
			
			
		<?php 
		
		} else {
			 
			do_action('radium_theme_video'); 
		
		}
		
		?>
		
	</div><!-- END .entry-content-media -->

	<?php if(!empty($post->post_excerpt) && is_single() ) { // POST EXCERPT ON SINGLE ?>

	  	<div class="post-excerpt" itemprop="description"><?php the_excerpt(); ?></div><!-- END .post-excerpt -->

	<?php  } //END IF EXCERPT ?>

	<div class="entry-content">

		<?php do_action('radium_before_post_content'); ?>

		<div itemprop="articleBody" class="clearfix">

			<?php the_content( __( '<span>Read More</span><span class="right comments-count">'.get_radium_comment_count().'</span>', 'radium' ) ); ?>
		
		</div>
		
		<?php do_action('radium_after_post_content'); ?>

	</div><!-- END .entry-content -->

</article><!-- END #post-<?php the_ID(); ?> -->