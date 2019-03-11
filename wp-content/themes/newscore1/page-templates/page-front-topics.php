<?php

/**
 * Template Name: bbPress - Topics (Newest)
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

			<div id="topics-front" class="bbp-topics-front">
				<div class="entry-content">

					<?php the_content(); ?>

					<?php bbp_get_template_part( 'content', 'archive-topic' ); ?>

				</div>
			</div><!-- #topics-front -->

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