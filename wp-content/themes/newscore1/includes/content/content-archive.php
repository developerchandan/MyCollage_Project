<?php
/*
 * The template for displaying content on the archive page.
 */

global $archive_i;
$class = '';

if( isset($archive_i) && $archive_i % 3 == 0 )
    $class = 'first';

if( has_post_thumbnail( get_the_ID() ) )
    $class .= ' has-thumbnail';

?>
<article <?php post_class($class); ?> >

    <?php if( has_post_thumbnail() ) : ?>

        <div class="entry-thumbnail">

            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'radium' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">

                <?php if ( has_post_format('Video') || has_post_format('Audio') || has_post_format('Gallery')) : ?>

                    <?php //echo //radium_post_format_icons(); ?>

                <?php endif ?>

                <?php if( $archive_i == 1 ): ?>

                    <?php the_post_thumbnail('large'); ?>

                <?php else: ?>

                    <?php the_post_thumbnail('medium'); ?>

                <?php endif; ?>

            </a>

            <?php if( $archive_i == 1 ): ?>

                <header class="entry-header">
                    <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'radium' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                    </h2>

                    <div class="entry-meta entry-meta-top">

                        <?php //radium_human_time(); ?>

                        <?php
                            $categories_list = get_the_category_list( __( ', ', 'radium' ) );
                            if ( $categories_list && radium_categorized_blog() ) :
                        ?>

                        <span class="cat-links">
                            <?php printf( __( '<span> on </span>%1$s', 'radium' ), $categories_list ); ?>
                        </span>

                        <?php endif; ?>
                        <span class="author">by <?php the_author_posts_link(); ?></span>

                    </div>

                </header>

            <?php endif; ?>

        </div>

        <?php endif; ?>

        <div class="post-inner">
            <header class="entry-header">
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'radium' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

                <div class="entry-meta entry-meta-top">
                    <?php// radium_human_time(); ?>

                    <?php
                        /* translators: used between list items, there is a space after the comma */
                        $categories_list = get_the_category_list( __( ', ', 'radium' ) );
                        if ( $categories_list && radium_categorized_blog() ) :
                    ?>
                    <span class="cat-links">
                        <?php printf( __( '<span> on </span>%1$s', 'radium' ), $categories_list ); ?>
                    </span>
                    <?php endif; // End if categories ?>

                    <span class="author">by <?php the_author_posts_link(); ?> </span>
                </div>
            </header>

            <div class="entry-content">
                <?php the_excerpt(); ?>
            </div><!-- .entry-content -->

            <footer class="entry-meta entry-meta-bottom">
                <?php
                    /* translators: used between list items, there is a space after the comma */
                    $tags_list = get_the_tag_list( '', __( ', ', 'radium' ) );
                    if ( $tags_list ) :
                ?>
                <span class="tags-links">
                    <?php printf( __( 'Tags: %1$s', 'radium' ), $tags_list ); ?>
                </span>
                <?php endif; // End if $tags_list ?>

            </footer>
        </div>
    </article>