<?php
/**
 * The template used for displaying page content in page.php and custom templates
 */
?><div class="row">
	<div class="large-12 columns">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="page-box entry-content">
            <?php do_action('radium_before_page_content'); ?>
            <?php the_content(); ?>
            <?php do_action('radium_after_page_content'); ?>
            </div><!-- .entry-content -->
		</article><!-- #post-<?php the_ID(); ?> -->
	</div>
</div>