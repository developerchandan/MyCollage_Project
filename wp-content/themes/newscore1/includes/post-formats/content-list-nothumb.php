<?php /* STANDARD POST FORMAT */


$category = get_the_category();
//$category[0]->cat_name;

?>

<article <?php post_class('content-list-small clearfix'); ?>>

	<header class="entry-header">

		<?php //do_action('radium_before_post_list_title'); ?>

		<h3 class="entry-title">

			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'radium' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>

		</h3><!-- END .entry-title -->

    	<?php //do_action('radium_after_post_list_title'); ?>

	</header><!-- END .entry-header -->

</article><!-- END #post-<?php the_ID(); ?> -->