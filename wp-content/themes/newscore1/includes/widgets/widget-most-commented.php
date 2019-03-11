<?php
class Radium_Most_Commented extends WP_Widget {

    /**
     * Register widget
    **/
    public function __construct() {

        parent::__construct(
            'radium_most_commented', // Base ID
            __( 'Radium Most Commented Posts', 'radium' ), // Name
            array( 'description' => __( 'Show a list of the most commented posts with comments count', 'radium' ), ) // Args
        );

    }


    /**
     * Front-end display of widget
    **/
    public function widget( $args, $instance ) {

        extract( $args );

        $title = apply_filters('widget_title', $instance['title'] );
        $items_num = $instance['items_num'];

        echo $before_widget;

        if ( $title ) echo $before_title . $title . $after_title;

           global $post;

           $post_args = array(
                'order' => 'DESC',
                'orderby' => 'comment_count',
                'posts_per_page' => $items_num,
                'no_found_rows' => true //pagination off
        	);
        	
        	$posts = Radium_Theme_WP_Query::get_posts_cached( $post_args, $this->id_base . $args['id'] );
            if( $posts ) : ?>
            <ul>
            <?php

            $i = 1;

            foreach ( $posts as $post) : get_post($post); ?>

                <li class="clearfix score-<?php echo $i++;?>">

                    <span>
                        <i><?php comments_number( '0', '1', '%' ); ?></i>
                    </span>

                    <h5 class="entry-title">
                        <a href="<?php the_permalink(); ?>">
                            <?php if ( strlen( $post->post_title ) > 30 ) { echo substr( the_title( $before = '', $after = '', FALSE ), 0, 30 ) . ''; } else { the_title(); } ?>
                        </a>
                    </h5>

                </li>

            <?php endforeach; $i++;  ?>

            </ul>

            <?php

            wp_reset_query();

            endif;

        echo $after_widget;

    }


    /**
     * Sanitize widget form values as they are saved
    **/
    public function update( $new_instance, $old_instance ) {

        $instance = array();

        /* Strip tags to remove HTML. For text inputs and textarea. */
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['items_num'] = $new_instance['items_num'];

        return $instance;

    }


    /**
     * Back-end widget form
    **/
    public function form( $instance ) {

        /* Default widget settings. */
        $defaults = array(
            'title' => __('Most Commented', 'radium'),
            'items_num' => '5',
        );
        $instance = wp_parse_args( (array) $instance, $defaults );

    ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'radium'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'items_num' ); ?>"><?php _e('Maximum posts to show:', 'radium'); ?></label>
            <select id="<?php echo $this->get_field_id( 'items_num' ); ?>" name="<?php echo $this->get_field_name( 'items_num' ); ?>" class="widefat">
                <?php for ( $num=1; $num<=15; $num++ ){ ?>
                <option value="<?php echo $num; ?>" <?php if ( $instance["items_num"] == $num ) echo 'selected="selected"'; ?>><?php echo $num; ?></option>
                <?php } ?>
            </select>
        </p>
    <?php
    }

}
register_widget( 'Radium_Most_Commented' );