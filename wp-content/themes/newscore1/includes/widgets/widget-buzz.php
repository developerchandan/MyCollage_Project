<?php

/**
 * Plugin Name: Middle Buzz Widget
 */
add_action( 'widgets_init', 'radium_buzz_load_widgets' );

function radium_buzz_load_widgets() {

    register_widget( 'Radium_Buzz_widget' );

}

class Radium_Buzz_widget extends WP_Widget {

    /**
     * Widget setup.
     */

    public function __construct() {
        parent::__construct(
            'radium_buzz_widget', // BASE ID
            __('Radium Buzz Widget', 'radium'), // NAME
            array( 'description' => __( 'A widget designed for the Homepage Middle Widget Area that displays a list of posts from a category of your choice.', 'radium' ), )
        );
    }

    /**
     * How to display the widget on the screen.
     */

    function widget( $args, $instance ) {

        extract( $args );
		
		$featured_class = $wrapper_classes = null;
		
        /* Our variables from the widget settings. */
        $title = apply_filters('widget_title', $instance['title'] );
        $title_style =  isset($instance['title_style']) ? $instance['title_style'] : '';

        $number = $instance['number'];
        $type 	= $instance['type'];
        $date 	= !empty($instance['date']) ? $instance['date'] : '';
        
        $categories = $instance['categories'];
		
		if ( $title_style == 'on')
			$wrapper_classes = 'featured';

		if ( $date !== 'on')
			$wrapper_classes .= ' dates-off';
		
        echo $before_widget;
        
        ?>
        
        <div class="<?php echo $wrapper_classes; ?>">
        
        <h3 class="widget-buzz-header"><span><?php echo $title; ?></span></h3>
        <ul class="widget-buzz">
        <?php
        $args = array( 'cat' => $categories, 'posts_per_page' => $number );

        if( $type == 'featured' ) {

            $args['meta_query'] = array(
                array(
                    'key' => '_radium_featured',
                    'value' => '1',
                    'compare' => '='
                )
            );
        
        } elseif( $type == 'editors' ) {
        
       		$args['meta_query'] = array(
       		    array(
       		        'key' => '_radium_editors_pick',
       		        'value' => '1',
       		        'compare' => '='
       		    )
       		);
       		
        } else {

            //$args['orderby'] = 'comment_count';
            //$args['order'] = 'DESC';

            $args['meta_key'] = '_radium_post_views_count';
            $args['orderby']  = 'meta_value_num';

        }

        $args['ignore_sticky_posts'] = true;
 		
		global $post;
          
        $posts = Radium_Theme_WP_Query::get_posts_cached( $args, $this->id_base . $instance['widget_id'] );
        
        foreach ($posts as $post ) : setup_postdata($post); ?>
            <li>
                <?php if ( $date == 'on') { ?><div class="entry-meta"><div class="date"><?php echo get_the_time('F j, Y'); ?></div></div><?php } ?>
                <h3 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
            </li>
            <?php

        endforeach;

        wp_reset_postdata();

        ?></ul>
        
        </div><?php

        /* After widget (defined by themes). */
        echo $after_widget;
    }

    /**
     * Update the widget settings.
     */

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        /* Strip tags for title and name to remove HTML (important for text inputs). */
        $instance['title'] = strip_tags( $new_instance['title'] );
       
        $instance['title_style'] = $new_instance['title_style'];
       
        $instance['number'] = strip_tags( $new_instance['number'] );

        $instance['type'] = strip_tags( $new_instance['type'] );

        $instance['categories'] = $new_instance['categories'];

        $instance['widget_id'] = $new_instance['widget_id'];

        $instance['date'] = $new_instance['date'];

        return $instance;

    }

    function form( $instance ) {

        /* Set up some default widget settings. */
        $defaults = array(
            'title' => __('The Latest', 'radium'), 
            'title_style' => 'on',
            'number' => 6,
            'widget_id' => rand(1000, 10000),
            'type' => 'editors',
            'date' => 'on',
        );

        $instance = wp_parse_args( (array) $instance, $defaults );
        $type = $instance[ 'type' ]; ?>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
        </p>
        <p>
        	<input class="checkbox" type="checkbox" <?php checked($instance['title_style'], 'on'); ?> id="<?php echo $this->get_field_id('title_style'); ?>" name="<?php echo $this->get_field_name('title_style'); ?>" />
        	<label for="<?php echo $this->get_field_id('title_style'); ?>"><?php _e('Title Styling (Red triangle)', 'radium'); ?></label>
        </p>

        <!-- Number of posts -->
        <p>
            <label for="<?php echo $this->get_field_id( 'number' ); ?>">Number of posts to display:</label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" size="3" />
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php _e( 'Type', 'radium' ); ?></label>
            <select id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>">
                <option value="featured" <?php selected( 'featured', $type ); ?>><?php _e( 'Featured', 'radium' ); ?></option>
                <option value="popular" <?php selected( 'popular', $type ); ?>><?php _e( 'Popular', 'radium' ); ?></option>
                <option value="editors" <?php selected( 'editors', $type ); ?>><?php _e( 'Editor\'s Pick', 'radium' ); ?></option>
            </select>
        </p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['date'], 'on'); ?> id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" />
			<label for="<?php echo $this->get_field_id('date'); ?>"><?php _e('Show Dates', 'radium'); ?></label>
		</p>
		
        <!-- Category -->
        <p>
            <label for="<?php echo $this->get_field_id('categories'); ?>">Select category (select All Categories to display latest posts):</label>
            <select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" style="width:100%;">

                <option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>All Categories</option>

                <?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>

                <?php foreach($categories as $category) { ?>

                <option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>

                <?php } ?>

            </select>

        </p>

    <?php

    }

}

?>