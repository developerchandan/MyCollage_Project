<?php

/**
 *  Radium Video - Video Archive
 *
 * @package Video Central
 * @subpackage Theme
 */
$framework = radium_framework();

$sidebar = radium_sidebar_loader();

get_header(); 

if( is_front_page() ) { 

 	$frontpage = get_post(get_option('page_on_front'));
    $page_id = $frontpage->ID;
  
} else { 

	$page_id = get_the_ID(); 

}
  
if ( !get_post_meta( $page_id, '_radium_hide_title', true ) )
	get_template_part( 'includes/content/content', 'header' );

	do_action('radium_before_page');
?>
	<div class="row page-content video-central-row">

        <main class="content <?php echo $sidebar['content_class']; ?>"  role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Page">

        	<?php do_action( 'video_central_template_before_main_content' ); ?>

        	<?php do_action( 'video_central_template_notices' ); ?>

        	<div id="video-central-front" class="video-central-front">

        		<div class="video-central-entry-content entry-content">

        			<?php video_central_get_template_part( 'content', 'archive-video' ); ?>

        		</div>

        	</div><!-- #video-central-front -->

        	<?php do_action( 'video_central_template_after_main_content' ); ?>

        </main><!-- .large-9 -->

        <?php if( $sidebar['sidebar_active'] ) { ?>
            
            <aside class="<?php echo $sidebar['sidebar_class']; ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
      			<div id="sidebar-main" class="sidebar">
      		     	<?php
      		     		/**
      		     		 * video_central_sidebar hook
      		     		 *
      		     		 * @hooked video_central_get_sidebar - 10
      		     		 */
      		     		do_action( 'video_central_sidebar' );
      		     	?>
      			</div><!--sidebar-main-->
      		</aside><!--sidebar-->
    
      	<?php } ?>

    </div><!-- .video-central-row -->

  </div><!--.row-->
    	  

<?php 
do_action('radium_after_page');

get_footer(); ?>
