<?php

/**
 * BuddyPress - Create Blog
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

get_header( 'buddypress' );

$sidebar = radium_sidebar_loader(radium_get_option('bbpress_layout', false, 'right') );

?>

<?php do_action( 'bp_before_directory_blogs_content' ); ?>

<div class="row">

    <main class="content <?php echo $sidebar['content_class']; ?>"  role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Article">

		<?php do_action( 'bp_before_create_blog_content_template' ); ?>

		<?php do_action( 'template_notices' ); ?>

			<h3><?php _e( 'Create a Site', 'radium' ); ?> &nbsp;<a class="button" href="<?php echo trailingslashit( bp_get_root_domain() . '/' . bp_get_blogs_root_slug() ); ?>"><?php _e( 'Site Directory', 'radium' ); ?></a></h3>

		<?php do_action( 'bp_before_create_blog_content' ); ?>

		<?php if ( bp_blog_signup_enabled() ) : ?>

			<?php bp_show_blog_signup_form(); ?>

		<?php else: ?>

			<div id="message" class="info">
				<p><?php _e( 'Site registration is currently disabled', 'radium' ); ?></p>
			</div>

		<?php endif; ?>

		<?php do_action( 'bp_after_create_blog_content' ); ?>

		<?php do_action( 'bp_after_create_blog_content_template' ); ?>

    </main><!-- END .large-8 columns mobile-four -->

	<?php do_action( 'bp_after_directory_blogs_content' ); ?>

    <?php if( $sidebar['sidebar_active'] ) { ?>

        <aside class="<?php echo $sidebar['sidebar_class']; ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">

            <div id="sidebar-main" class="sidebar">

                <?php get_sidebar( 'buddypress' ); ?>

            </div><!--sidebar-main-->

        </aside><!--sidebar-->

    <?php } ?>

</div><!--.row-->

<?php get_footer( 'buddypress' ); ?>

