<?php

/**
 * Template Name: bbPress - Topic Tags
 *
 * @package radium framework
 * @subpackage Theme
 */

get_header();

$sidebar = radium_sidebar_loader();

?>

<?php get_template_part( 'includes/content/content', 'header' ); ?>

<div class="row page-content">

    <main id="main" class="<?php echo $sidebar['content_class']; ?> clearfix" role="main">

	<?php do_action( 'bbp_template_notices' ); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<div id="bbp-topic-tags" class="bbp-topic-tags">
			<div class="entry-content">

				<?php get_the_content() ? the_content() : _e( '<p>This is a collection of tags that are currently popular on our forums.</p>', 'radium' ); ?>

				<div id="bbp-topic-hot-tags">

					<?php wp_tag_cloud( array( 'smallest' => 9, 'largest' => 38, 'number' => 80, 'taxonomy' => bbp_get_topic_tag_tax_id() ) ); ?>

				</div>

			</div>
		</div><!-- #bbp-topic-tags -->

	<?php endwhile; ?>

   </main><!-- #main -->

    <?php if( $sidebar['active']) { ?>

        <aside id="sidebar" class="sidebar <?php echo $sidebar['sidebar_class']; ?>">
            <div id="sidebar-main" class="sidebar">
                <?php get_sidebar('Internal Sidebar'); ?>
            </div><!--sidebar-main-->
        </aside>

    <?php } ?>

</div><!--.row-->

<?php get_footer(); ?>