<?php

/**
 * Radium Video - Search
 *
 * @package Video Central
 * @subpackage Theme
 */

get_header(); 

get_template_part( 'includes/content/content', 'header' );

do_action('radium_before_page');

$sidebar = radium_sidebar_loader('right');

?>

    <div class="row">

        <main class="content <?php echo $sidebar['content_class']; ?>"  role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Page">

            <?php do_action( 'video_central_template_before_main_content' ); ?>

            <?php do_action( 'video_central_template_notices' ); ?>

            <div id="video-central-front" class="video-central-front">

                <div class="video-central-entry-content">

                    <?php video_central_get_template_part( 'content', 'search' ); ?>

                </div>

            </div><!-- #video-central-front -->

            <?php do_action( 'video_central_template_after_main_content' ); ?>

        </main><!-- .large-9 -->
        
        <?php if( $sidebar['sidebar_active'] ) { ?>

			<aside class="<?php echo $sidebar['sidebar_class']; ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
	
	            <div class="sidebar">
	                <?php
	                    /**
	                     * video_central_sidebar hook
	                     *
	                     * @hooked video_central_get_sidebar - 10
	                     */
	                    do_action( 'video_central_sidebar' );
	                ?>
	            </div>
	
			</aside><!-- END -->
		
		<?php } ?>

    </div><!-- .row -->

<?php get_footer(); ?>
