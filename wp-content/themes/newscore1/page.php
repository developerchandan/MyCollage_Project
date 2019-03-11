<?php /* Default Template *

/**
* The template for displaying all pages.
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
	<div class="row page-content">

        <main class="content <?php echo $sidebar['content_class']; ?>"  role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Page">

			<?php while ( have_posts() ) : the_post();

				do_action('radium_before_content');

				get_template_part( 'includes/content/content', 'page' );

				do_action('radium_after_content');
				
				// If the theme supports comments in pages and comments are open or we have at least one comment, load up the comment template
				if( $framework->theme_supports( 'comments', 'pages' ) && ( comments_open() || '0' != get_comments_number() )  ) comments_template( '', true );  ?>

	 		<?php endwhile; // end of the loop. ?>

	  	</main><!-- #main -->

        <?php if( $sidebar['sidebar_active'] ) { ?>

            <aside class="<?php echo $sidebar['sidebar_class']; ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
	  			<div id="sidebar-main" class="sidebar">
	  		     	<?php get_sidebar(); ?>
	  			</div><!--sidebar-main-->
	  		</aside><!--sidebar-->

	  	<?php } ?>

	  </div><!--.row-->

<?php

do_action('radium_after_page');

get_footer();

?>