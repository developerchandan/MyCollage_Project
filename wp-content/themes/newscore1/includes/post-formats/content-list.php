<?php /* STANDARD POST FORMAT */
$image = null;
$image_size = radium_framework_add_image_sizes();
$image_size = $image_size['content_list_small'];

$thumb_w = $image_size['width']; //Define width
$thumb_h = $image_size['height'];

$img_url = false;
$crop    = true;

//Check if post has a featured image set else get the first image from the gallery and use it. If both statements are false display fallback image.
if ( has_post_thumbnail() ) {

    //get featured image
    $thumb = get_post_thumbnail_id();
    $img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the image is too big)

    $image = $img_url ? radium_resize( $img_url, $thumb_w, $thumb_h, $crop ) : false ;

}
?>

<article <?php post_class('content-list-small clearfix'); ?>>

    <?php if( $image ) { ?>

    <div class="entry-content-media">

        <div class="post-thumb preload image-loading">

            <?php do_action('radium_before_post_list_thumb'); ?>

            <a title="<?php printf(__('Permanent Link to %s', 'radium'), get_the_title()); ?>" href="<?php the_permalink(); ?>">
                <img src="<?php echo $image; ?>" class="wp-post-image" width="<?php echo $thumb_w; ?>" height="<?php echo $thumb_h; ?>" alt="<?php the_title(); ?>" />
            </a>

            <?php do_action('radium_after_post_list_thumb'); ?>

        </div>

    </div>

    <?php } //image ?>

	<header class="entry-header">

		<?php do_action('radium_before_post_list_title'); ?>

		<h3 class="entry-title">

			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'radium' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>

		</h3><!-- END .entry-title -->

    	<?php do_action('radium_after_post_list_title'); ?>

	</header><!-- END .entry-header -->

</article><!-- END #post-<?php the_ID(); ?> -->