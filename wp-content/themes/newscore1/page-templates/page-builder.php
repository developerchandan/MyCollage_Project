<?php
/**
 * Template Name: Custom Layout
 *
 * This template file is a core part of the 
 * Radium Framework. This framework is 
 * designed around this file NEVER being altered. It 
 * is advised that any edits to the way this file 
 * displays its content be done with via hooks and filters.
 * 
 * @author		Franklin M Gitonga
 * @copyright	Copyright (c) Franklin M Gitonga
 * @link		http://radiumthemes.com
 * @package 	Radium Framework
 * @since 		2.1.0
 */

get_header(); 

$sidebar = radium_sidebar_loader();

$layout_id = radium_builder_config( 'builder' );

$layout = radium_builder_config( 'layout_id', null, $layout_id );

// Featured area
if( radium_builder_config( 'featured' ) ) {

	$layout_post_id = $layout_id ? $layout_id : radium_post_id_by_name( $layout, 'radium_layout' );
	$featured_settings =  get_post_meta( $layout_post_id, 'settings', true ); 
		
	?>
	<div id="featured-area" <?php if( isset( $featured_settings['settings']['featured']['layout'] ) ) { ?>class="<?php echo $featured_settings['settings']['featured']['layout']; ?>" <?php } ?> style="<?php if( isset( $featured_settings['settings']['featured']['background']['color'] ) ) { ?>background-color: <?php echo $featured_settings['settings']['featured']['background']['color']; ?>; <?php } if( isset( $featured_settings['settings']['featured']['background']['url']) ) { ?> background-image: url('<?php echo $featured_settings['settings']['featured']['background']['url']; ?>'); background-repeat: repeat; <?php } ?> background-position: center center; " >
		<div class="<?php if( $featured_settings['settings']['featured']['layout']  !== 'wide') { echo 'row'; } else { echo 'fullwidth'; }  ?> clearfix">
			<?php radium_builder_elements( null, 'featured', $layout_id ); ?>
		</div>
	</div>
<?php 

} else { 

	//Load page header page header if featured area is inactive
	if( is_front_page() ) { 
	
	 	$frontpage = get_post(get_option('page_on_front'));
	    $page_id = $frontpage->ID;
	  
	} else { 
	
		$page_id = get_the_ID(); 
	
	}
	         
	if ( !get_post_meta( $page_id, '_radium_hide_title', true ) )
		get_template_part( 'includes/content/content', 'header' );
	
} 

?>	
<section id="builder-container" class="row">

	<main id="main" class="<?php echo $sidebar['content_class']; ?>" role="main">
		<div id="content" role="main">
			<?php radium_builder_elements( null, 'primary', $layout_id ); ?>
		</div><!-- #content  -->
	</main><!-- #main -->
	
	<?php if( $sidebar['sidebar_active'] ) { ?>

        <aside class="<?php echo $sidebar['sidebar_class']; ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
  			<div id="sidebar-main" class="sidebar">
  		     	<?php get_sidebar(); ?>
  			</div><!--sidebar-main-->
  		</aside><!--sidebar-->

  	<?php } ?>
  	
</section>
<?php get_footer();