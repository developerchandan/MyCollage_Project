<?php /* Single Post */

get_header();

$framework = radium_framework();

$post_sidebar = get_post_meta( get_the_ID(), '_radium_page_layout', true) ? get_post_meta(get_the_ID(), '_radium_page_layout', true) : radium_get_option('single_post_layout', false, 'right');

$sidebar = radium_sidebar_loader($post_sidebar);

do_action('radium_before_page');

?><div class="row">

        <main class="content <?php echo $sidebar['content_class']; ?>"  role="main" itemscope itemtype="http://schema.org/Article">

            <?php // THE LOOP
            if (have_posts()) :

                do_action('radium_before_single_post_content');

                while (have_posts()) : the_post();
                    $format = get_post_format();
                    if( false === $format ) { $format = 'standard'; }
                    if( is_attachment() ) { $format = 'attachment'; }
                     get_template_part( 'includes/post-formats/content', $format );
                endwhile;

                 do_action('radium_after_single_post_content');

                if( $framework->theme_supports( 'comments', 'posts' ) && ( comments_open() || '0' != get_comments_number() )  ) comments_template( '', true );

            endif;
            ?>
            <meta itemprop="datePublished" content="<?php the_date('c'); ?>"/>
            <meta itemprop="dateModified" content="<?php the_modified_date( 'c' ); ?>"/>

            <?php do_action('radium_single_post_meta'); ?>

        </main><!-- END -->

        <?php if( $sidebar['sidebar_active'] ) { ?>

            <aside class="<?php echo $sidebar['sidebar_class']; ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">

                <div class="sidebar">

                    <?php get_sidebar(); ?>

                </div><!-- END .sidebar -->

            </aside><!-- END -->

        <?php } ?>

    </div><!-- END .row -->

<?php do_action('radium_after_page'); ?>

<?php get_footer(); ?>
