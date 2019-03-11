<?php /* GALLERY POST FORMAT */ ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

		<?php do_action('radium_before_post_title'); ?>

  		<?php if( is_single() ) {  // DISPLAY ON SINGLE ONLY  ?>

	  		<h1 class="entry-title" itemprop="headline">

	  		    <?php the_title(); ?>

	  		</h1><!-- END .entry-title -->

	  	<?php } else {  // END ON SINGLE ONLY ?>

	  		<h2 class="entry-title" itemprop="headline">

	  			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'radium' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>

			</h2><!-- END .entry-title -->

 		<?php } ?>

		<?php do_action('radium_after_post_title'); ?>

  	</header><!-- END .entry-header -->

	<div class="entry-content-media">

		<?php do_action('radium_theme_audio'); ?>

	</div><!-- END .entry-content-media -->

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