<?php

/**
 * Template Name: Blog Archive
 *
 * @package radium framework
 * @subpackage Theme
 */

get_header();

$framework = radium_framework();

//Get Global Page Settings
$posts_per_page = get_post_meta (get_the_ID(), '_radium_items_count', true) ? get_post_meta (get_the_ID(), '_radium_items_count', true) : get_option('posts_per_page');
$page_columns = get_post_meta (get_the_ID(), '_radium_page_columns', true);
$sidebar_position = get_post_meta (get_the_ID(), '_radium_page_layout', true) ? get_post_meta (get_the_ID(), '_radium_page_layout', true) : 'right';

$max_num_pages  = false; // Maximum number of pages to show

$sidebar = radium_sidebar_loader( $sidebar_position );
$sidebars = $sidebar['sidebar_active'] ? 1 : 0;

$image_size = radium_framework_add_image_sizes();

//Pagination Loader

//fix pagination when used as a static front page
// @since newscore 1.3.0
if ( is_front_page() ) {

    $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;

    global $wp_query;
    $wp_query->query_vars['paged'] = $paged;

} else {

    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
}

$args = apply_filters( 'page_archive_posts_args', array(
    'posts_per_page' => $posts_per_page,
    'paged' 		 => $paged,
));
$cat_posts = new WP_Query( $args );

//options - one-columns, two-columns, small-thumbs, mix
$blog_type  = $page_columns ? $page_columns :'small-thumbs';

//image resizer settings
$crop = true; //resize but retain proportions
$single = true; //return array

get_template_part( 'includes/content/content', 'header' );

do_action('radium_before_blog_archive_content');

$framework->post_query = $cat_posts;
$sidebars = $sidebar['sidebar_active'] ? 1 : 0;

?>
<div class="row">

    <main role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/WebPageElement" class="<?php echo $sidebar['content_class']; ?>">

        <?php do_action('radium_before_blog_archive_loop'); ?>

        <div id="post-box" >

            <?php

            if ( $blog_type == 'one-column' ) :

                if ( $cat_posts->have_posts()) : while ($cat_posts->have_posts()) : $cat_posts->the_post();

                    global $more;
                    $more = false;
                    $format = get_post_format();

                    $format = $format ? $format : 'standard';

                    get_template_part( 'includes/post-formats/content', $format );

                endwhile; else :

                    get_template_part( 'includes/content/content', 'not-found' );

                endif;

            else :

                if ( $blog_type == 'two-columns') {

                    $type = array(

                        1 => array(
                            0 => 'small',
                            1 => 'small',
                        )

                    );

                    $reset_counter_at = 2;

                } elseif ( $blog_type == 'small-thumbs') {

                    $type = array(

                        1 => array(
                            0 => 'small-thumbs',
                        )
                    );

                    $reset_counter_at = 2;

                } else {

                    $type = array(

                        1 => array(
                            0 => 'big',
                            1 => 'small',
                            2 => 'small'
                        ),

                        2 => array(
                            0 => 'big',
                            1 => 'mini',
                            2 => 'mini',
                            3 => 'mini'

                        ),

                        3 => array(
                            0 => 'small',
                            1 => 'small',
                            2 => 'mini',
                            3 => 'mini',
                            4 => 'mini'
                        )

                    );

                    $reset_counter_at = 4;
                }
                ?>

                <section id="blog-grid">
                    <div class="blog-grid-container">

                    <?php

                    $type_counter = 0;
                    $which_type = 1;

                    if ( $cat_posts->have_posts() ) : while ( $cat_posts->have_posts() ) : $cat_posts->the_post();

                        global $more;
                        $more = false;
                        $format = get_post_format();
                        $aspect_ratio = 1.77777777778;

                        //check if a sidebar is present
                        if ( $sidebars == '1' ) {

                               if ( $blog_type == 'small-thumbs' ) {

                                   $thumb_w = $image_size['blog_grid_small_thumbs_1']['width'];
                                $text_length= '35';

                               } elseif ( $blog_type == 'two-columns') {

                                   $thumb_w = $image_size['blog_grid_two_columns_1']['width'];
                                   $text_length = 28;

                               }

                       } else {

                               if ( $blog_type == 'small-thumbs' ) {

                                   $thumb_w = $image_size['blog_grid_small_thumbs_0']['width'];
                                   $text_length = 50;

                               } elseif ( $blog_type == 'two-columns') {

                                  $thumb_w = $image_size['blog_grid_two_columns_0']['width'];
                                  $text_length = 38;

                               }

                           }

                        $thumb_h = round($thumb_w/$aspect_ratio) + 15;
                        $position = $type[$which_type][$type_counter];

                        if ( $type_counter % count($type[$which_type]) == 0 ) { ?>

                        <div class="blog-grid-items clearfix">

                        <?php }

                            $element_class = $type[$which_type][$type_counter];

                            if ( $type_counter % count($type[$which_type]) == count($type[$which_type]) - 1 )
                                $element_class .= ' last';

                        ?>

                            <div <?php post_class("grid_elements clearfix $element_class"); ?>>

                                <?php if ( $position !== 'small-thumbs' && $position !== 'small' && $position !== 'smaller' ) { ?>

                                    <?php do_action( 'radium_post_grid_before_header' ); ?>

                                    <header class="entry-header">
                                        <h2 class="entry-title"><a title="<?php printf(__('Permanent Link to %s', 'radium'), get_the_title()); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                        <?php if ($type[$which_type][$type_counter] !== 'mini') do_action( 'radium_post_grid_meta' ); ?>
                                    </header><!-- .entry-header -->

                                    <?php do_action( 'radium_post_grid_after_header' ); ?>

                                <?php }

                                    //Check if post has a featured image set else get the first image from the gallery and use it. If both statements are false display fallback image.
                                    if ( has_post_thumbnail() ) {

                                        //get featured image
                                        $thumb      = get_post_thumbnail_id();
                                        $img_url    = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the image is too big)
                                        $image      = radium_resize($img_url, $thumb_w, $thumb_h, $crop, $single);
                                        $grid_class = 'has-thumb ' . get_post_format();

                                    }

                                    //add thumbnail fallback
                                    if(empty($image) || !has_post_thumbnail() ) {
                                        $image      = get_radium_first_post_image(true);
                                        $grid_class = 'no-thumb ' . get_post_format();
                                    }

                                    if( $image) { ?>
                                        <div class="entry-content-media"  style="height: <?php echo $thumb_h; ?>px;">
                                            <div class="post-thumb preload image-loading">
                                                <a title="<?php printf(__('Permanent Link to %s', 'radium'), get_the_title()); ?>" href="<?php the_permalink(); ?>">
                                                    <img src="<?php echo $image ?>" alt="<?php the_title();?>"  style="height: <?php echo $thumb_h; ?>px;" height="<?php echo $thumb_h; ?>" width="<?php echo $thumb_w; ?>"/>
                                                </a>
                                            </div>
                                            <?php do_action( 'radium_post_grid_extras' ); ?>
                                        </div>
                                    <?php } ?>

                                <div class="content_wrapper">
                                    <?php if ( $position == 'small-thumbs' || $position == 'small' || $position == 'smaller' ) { ?>

                                        <header class="entry-header">

                                            <?php do_action( 'radium_post_grid_before_header' ); ?>

                                            <h2 class="entry-title">
                                                <a title="<?php printf(__('Permanent Link to %s', 'radium'), get_the_title()); ?>" href="<?php the_permalink(); ?>">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h2>

                                            <?php do_action( 'radium_post_grid_after_header' ); ?>

                                        </header><!-- .entry-header -->

                                    <?php } ?>
                                    <article class="entry-content">
                                        <?php if ( $type[$which_type][$type_counter] == 'small' || $type[$which_type][$type_counter] == 'small-thumbs' || $type[$which_type][$type_counter] == 'mini') { ?>
                                                <p><?php echo wp_trim_words( get_the_excerpt(), $text_length ); ?></p>
                                                <p><a href="<?php the_permalink(get_the_ID()); ?>" class="more-link"><span><?php _e( 'Continue Reading &rarr;', 'radium' ); ?></span></a></p>
                                            <?php } else { ?>
                                                <?php the_content( __( '<span>Continue Reading &rarr;</span>', 'radium' ) ); ?>
                                            <?php } ?>
                                    </article><!-- .entry-content -->
                                </div>
                                <?php if ( $type[$which_type][$type_counter] !== 'small-thumbs' || $type[$which_type][$type_counter] !== 'mini' ) do_action( 'radium_post_grid_footer_meta' ); ?>

                            </div>

                            <?php if ( $type_counter % count($type[$which_type]) == count($type[$which_type]) - 1 ) { ?><div class="blog-grid-divider clearfix"></div></div><?php }

                            $type_counter++;

                            if ( $type_counter == count($type[$which_type]) ) {
                                $which_type++;
                                $type_counter = 0;
                            }

                            if ( $which_type == $reset_counter_at )  $which_type = 1;

                        endwhile; else :

                            get_template_part( 'includes/content/content', 'not-found' );

                        endif; ?>

                    </div>

                </section>

                <?php

                do_action('radium_pagination');

            endif;

            wp_reset_postdata(); ?>

        </div><!-- #post-box -->

        <?php do_action('radium_after_blog_archive_loop'); ?>

    </main><!-- END main -->

    <?php if( $sidebar['sidebar_active'] ) { ?>

        <aside class="<?php echo $sidebar['sidebar_class']; ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
            <div id="sidebar-main" class="sidebar">
                <?php get_sidebar(); ?>
            </div><!--sidebar-main-->
        </aside><!--sidebar-->

    <?php } ?>

</div><!-- END .row -->

<?php do_action('radium_after_blog_archive_content'); ?>

<?php get_footer(); ?>
