<?php

/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Carlton
 * @since Carlton 1.0
 */
get_header();

$framework = radium_framework();
$blog_type = 'small-thumbs';

if ( is_home() && is_front_page() ) { //detect when Settings -> Reading is not set

	 get_template_part( 'includes/content/content', 'header-index' );

	$sidebar_position = radium_get_option('post_archives_layout') ? radium_get_option('post_archives_layout') : 'right';

} else {

	get_template_part( 'includes/content/content', 'header' );

	$options = radium_get_category_option(get_cat_id( single_cat_title("",false) ));

	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

	$sidebar_position = isset($options['sidebar']) ? $options['sidebar'] : 'right';

	//Check if sidebar is active
	//options - one-columns, two-columns, small-thumbs, mix
	$blog_type  = isset($options['layout']) ? $options['layout'] : $blog_type;

}

$sidebar = radium_sidebar_loader( $sidebar_position );

$sidebars = $sidebar['sidebar_active'] ? 1 : 0;
$image_size = radium_framework_add_image_sizes();

//image resizer settings
$crop = true; //resize but retain proportions
$single = true; //return array

do_action('radium_before_category_content');

//setup search query
global $query_string;
$query_args = explode("&", $query_string);
$search_query = array();

foreach($query_args as $key => $string) {

	$query_split = explode("=", $string);
	$urldecode = isset($query_split[1]) ? urldecode($query_split[1]) : '';
	$search_query[$query_split[0]] = $urldecode;

} // foreach


$framework->post_query = new WP_Query($search_query);

?>
<div class="row">

	<main role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog" class="<?php echo $sidebar['content_class']; ?>">

		<?php do_action('radium_before_category_loop'); ?>

		<div id="post-box" >

			<?php

			if ( $blog_type == 'one-column' ) :

				if ($framework->post_query->have_posts()) : while ($framework->post_query->have_posts()) : $framework->post_query->the_post();

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
					$i = 1;
					$type_counter = 0;
					$which_type = 1;
					$aspect_ratio = 1.77777777778;

					if ($framework->post_query->have_posts()) : while ($framework->post_query->have_posts()) : $framework->post_query->the_post();

							$image = null;

							global $more;
							$more = false;
							$format = get_post_format();

							switch ( $type[$which_type][$type_counter] ) {

								case 'mini':

									$thumb_w = $image_size['blog_grid_mini_0']['width']; //Define width
									$text_length = 10;

									break;

								case 'small':

									$thumb_w = $image_size['blog_grid_small_0']['width']; //Define width
									$text_length = 28; //number of words

									break;

								case 'small-thumbs':

									$thumb_w = $image_size['blog_grid_small_thumbs_0']['width'];
									$text_length = 15;

									break;

								case 'big':
									$thumb_w = $image_size['blog_grid_big_0']['width']; //Define width
									$text_length = 10;

									break;

								default:
									break;
							}

							//check if a sidebar is present
							if ( $sidebars == '1' ) {

								   if ( $blog_type == 'small-thumbs' ) {

									   $thumb_w = $image_size['blog_grid_small_thumbs_1']['width'];
									   //$text_length = 10;

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

							$thumb_h = round($thumb_w/$aspect_ratio);

							$number_in_group = count($type[$which_type]);
							$position = $type[$which_type][$type_counter];

							 $group = ( $number_in_group !== 0) ? $type_counter % $number_in_group : 0;

							 $close_group = $number_in_group ? ($group == $number_in_group - 1) : false;

							 $element_class = $position . ' sidebars_' . $sidebars;

							 if( ($i % 3 == 0) && $blog_type == 'three_columns') {echo 'third'; $close_group = true; }

							if ( $group == 0 ) { ?><div class="blog-grid-items clearfix post-box-wrapper"><?php }

							   if ( $group == $number_in_group - 1 )
								 $element_class .= ' last';

							?>
								<div <?php post_class("grid_elements post-box $position $element_class"); ?>>

									<?php if ( $position !== 'small-thumbs' && $position !== 'small' ) { ?>

										<?php do_action( 'radium_post_grid_before_header' ); ?>

										<header class="entry-header">
											<h2 class="entry-title"><a title="<?php printf(__('Permanent Link to %s', 'radium'), get_the_title()); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
											<?php if ($position !== 'mini') do_action( 'radium_post_grid_meta' ); ?>
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
												<div class="post-thumb preload image-loading zoom-img-in">
													<a title="<?php printf(__('Permanent Link to %s', 'radium'), get_the_title()); ?>" href="<?php the_permalink(); ?>">
														<img src="<?php echo $image ?>" alt="<?php the_title();?>"  style="height: <?php echo $thumb_h; ?>px;" height="<?php echo $thumb_h; ?>" width="<?php echo $thumb_w; ?>"/>
													</a>
												</div>
												<?php do_action( 'radium_post_grid_extras' ); ?>
											</div>
										<?php } ?>

									<div class="content_wrapper">
										<?php if ( $position == 'small-thumbs' || $position == 'small' ) { ?>

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
											<?php if ( $position == 'small' || $position == 'small-thumbs' || $position == 'mini') { ?>
													<p><?php echo wp_trim_words( get_the_excerpt(), $text_length ); ?></p>
													<p><a href="<?php the_permalink(get_the_ID()); ?>" class="more-link"><span><?php _e( 'Continue Reading &rarr;', 'radium' ); ?></span></a>
													<?php do_action( 'radium_post_grid_comments' ); ?>
												   </p>
												<?php } else {
												   the_content( __( '<span>Continue Reading &rarr;</span>', 'radium' ) );
												} ?>
										</article><!-- .entry-content -->
									</div>
									<?php if ( $position !== 'small' || $position !== 'small-thumbs' || $position !== 'mini' ) do_action( 'radium_post_grid_footer_meta' ); ?>

								</div>

								<?php if ( $close_group ) { ?><div class="blog-grid-divider clearfix"></div></div><?php }

								$i++;
								$type_counter++;

								if ( $type_counter == $number_in_group ) {
									$which_type++;
									$type_counter = 0; //reset type counter
								}

								if ( $which_type == $reset_counter_at ) $which_type = 1;

							endwhile;

						else :

							get_template_part( 'includes/content/content', 'not-found' );

						endif; ?>

					</div>
				</section>

			<?php

			do_action('radium_pagination');

			endif; ?>

		</div><!-- #post-box -->

		<?php do_action('radium_after_category_loop'); ?>

	</main><!-- END main -->

	<?php if( $sidebar['sidebar_active'] ) { ?>

		<aside class="<?php echo $sidebar['sidebar_class']; ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
			<div id="sidebar-main" class="sidebar">
				<?php get_sidebar(); ?>
			</div><!--sidebar-main-->
		</aside><!--sidebar-->

	<?php } ?>

</div><!-- END .row -->

<?php do_action('radium_after_category_content'); ?>

<?php get_footer(); ?>
