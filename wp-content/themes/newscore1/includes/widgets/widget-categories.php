<?php

/**
 * Plugin Name: Category Widget
 */
add_action( 'widgets_init', 'radium_widgets_categories_init' );

function radium_widgets_categories_init() {
	register_widget( 'Radium_Widget_Categories' );
}

class Radium_Widget_Categories extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'radium_categories_widget', // Base ID
			'Radium Categories', // Name
			array( 'description' => __( 'Display categories', 'radium' ), ) // Args
		);
	}

	function widget( $args, $instance ) {
	
		extract($args);

		if ( ! empty( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base);
		}

		$show_count = ! empty( $instance['show_count'] ) ? '1' : '0';

		echo $before_widget;
		if ( $instance['title'] ) echo $before_title . $title . $after_title;

		$cats_args = array(
			'pad_counts' => true,
		);

		if ( isset( $instance['selected_cats'] ) ) {
			$cats_args['include'] = $instance['selected_cats'];
		}

		$categories = get_categories( $cats_args );

		echo '<ul>';
		
		foreach ( $categories as $category ) :
			$category_classes = '';

			if ( $show_count ) {
				$category_classes .= ' show-count';
			}

			if ( empty( $title_html ) ) {
				$category_classes .= ' no-title';
			}
			?>
			<li class="category <?php echo $category_classes ?> clearfix">
				<?php if ( $show_count ) : ?>
				<div class="category-post-count label"><?php echo sprintf( "%02s", $category->count ); ?></div>
				<?php endif; ?>

				<h4 class="entry-title">
					<a href="<?php echo get_category_link( $category->cat_ID ); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'radium'), $category->name ); ?>" rel="bookmark">
						<?php echo $category->name ?>
					</a>
				</h4>
			</li>
		<?php endforeach;
		echo '</ul>';

		wp_reset_postdata();
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['show_count'] = $new_instance['show_count'] ? 1 : 0;

		$new_instance = wp_parse_args( (array) $new_instance, $this->default );
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['selected_cats'] = $new_instance['selected_cats'];

		return $instance;
	}

	function form( $instance ) {
		
		$default = array(
			'title' => __('Categories', 'radium'),
			'show_count' => 1,
			'selected_cats' => array(),
		);
		
		$instance = wp_parse_args( (array) $instance, $default );

		$title = strip_tags( $instance['title'] );
		$show_count = $instance['show_count'] ? 'checked="checked"' : '';
		$show_posts = $instance['show_posts'] ? 'checked="checked"' : '';
		$selected_cats = $instance['selected_cats'];
		?>

		<!-- title -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','radium'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>

		<!-- show count -->
		<p>
			<input class="checkbox" type="checkbox" <?php echo $show_count; ?> id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>" />
			<label for="<?php echo $this->get_field_id('show_count'); ?>"><?php _e('Show post counts','radium'); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('selected_cats'); ?>"><?php _e('Select Categories (No select for all):','radium'); ?></label>
			<ul class="radium-category-checklist" id="<?php echo $this->get_field_id('selected_cats'); ?>" name="<?php echo $this->get_field_name('selected_cats'); ?>">
				<?php
				$walker = new Radium_Walker_Category_Checklist();
				$walker->set_field_name( $this->get_field_name('selected_cats') );

				wp_category_checklist( 0, 0, $selected_cats, false, $walker );
				?>
			</ul>
		</p>

		<?php
	}
}

/* -----------------------------------------------------------------------------
 * Custom Walker, duplicated from Walker_Category_Checklist
 * -------------------------------------------------------------------------- */
class Radium_Walker_Category_Checklist extends Walker  {
	var $tree_type = 'category';
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');
	var $field_name = 'post_category';

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent<ul class='children'>\n";
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		extract($args);
		if ( empty($taxonomy) )
			$taxonomy = 'category';

		$name = $this->field_name;

		$class = in_array( $category->term_id, $popular_cats ) ? ' class="popular-category"' : '';
		$output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" . '<label class="selectit"><input value="' . $category->term_id . '" type="checkbox" name="'.$name.'[]" id="in-'.$taxonomy.'-' . $category->term_id . '"' . checked( in_array( $category->term_id, $selected_cats ), true, false ) . disabled( empty( $args['disabled'] ), false, false ) . ' /> ' . esc_html( apply_filters('the_category', $category->name )) . '</label>';
	}

	function end_el( &$output, $category, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}

	function set_field_name( $field_name ) {
		$this->field_name = $field_name;
	}
}