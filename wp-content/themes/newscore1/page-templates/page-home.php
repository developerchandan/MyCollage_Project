<?php

/**
 * Template Name: Home
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Theme
 * @since 1.0.0
 */
get_header();

do_action('radium_before_blog_index');

$custom_layout_id = radium_builder_config( 'builder' );

$sidebar = radium_sidebar_loader();

$layout = radium_builder_config( 'layout_id', null, $custom_layout_id );

// Featured area
if( radium_builder_config( 'featured', null, $custom_layout_id ) ) {

    $layout_post_id = $custom_layout_id ? $custom_layout_id : radium_post_id_by_name( $layout, 'radium_layout' );
    $featured_settings =  get_post_meta( $layout_post_id, 'settings', true );

    ?>
    <div id="featured-area" <?php if( isset( $featured_settings['settings']['featured']['layout'] ) ) { ?>class="<?php echo $featured_settings['settings']['featured']['layout']; ?>" <?php } ?> style="<?php if( isset( $featured_settings['settings']['featured']['background']['color'] ) ) { ?>background-color: <?php echo $featured_settings['settings']['featured']['background']['color']; ?>; <?php } if( isset( $featured_settings['settings']['featured']['background']['url']) ) { ?> background-image: url('<?php echo $featured_settings['settings']['featured']['background']['url']; ?>'); background-repeat: repeat; <?php } ?> background-position: center center; " >
        <div class="<?php if( $featured_settings['settings']['featured']['layout']  !== 'wide') { echo 'row'; } else { echo 'fullwidth'; }  ?> clearfix">
            <?php radium_builder_elements( $layout, 'featured', $custom_layout_id ); ?>
        </div>
    </div>
<?php

}

$inner_main_classes = $sidebar['sidebar_position'] == 'left' ? 'push-3' : '';
$inner_sidebar_classes = $sidebar['sidebar_position'] == 'left' ? 'pull-9' : '';

?>
<div class="row">

    <main class="<?php echo $sidebar['content_class']; ?> builder-main" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/WebPageElement">

        <div class="row">

            <section id="builder-container" class="large-9 columns <?php echo $inner_main_classes; ?>">
                <div id="content" role="main">
                    <?php radium_builder_elements( $layout, 'primary', $custom_layout_id ); ?>
                </div><!-- #content  -->
            </section>

            <aside class="large-3 columns <?php echo $inner_sidebar_classes; ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
                <div id="sidebar-secondary" class="sidebar">
                    <?php dynamic_sidebar('Home Sidebar 1'); // DISPLAY THE SIDEBAR ?>
                </div><!--sidebar-main-->
            </aside><!--sidebar-->

        </div><!-- END .row -->

    </main>

    <?php if( $sidebar['sidebar_active'] ) { ?>

        <aside class="<?php echo $sidebar['sidebar_class']; ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
              <div id="sidebar-main" class="sidebar">
                <?php dynamic_sidebar('Home Sidebar 2'); // DISPLAY THE SIDEBAR ?>
              </div><!--sidebar-main-->
          </aside><!--sidebar-->

      <?php } ?>

</div><!-- END .row -->

<?php

do_action('radium_after_blog_index');

get_footer();

?>
