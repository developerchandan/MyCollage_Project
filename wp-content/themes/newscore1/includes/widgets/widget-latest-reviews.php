<?php

class Radium_Widget_Latest_Reviews extends WP_Widget {

    /**
     * Register widget
    **/
    public function __construct() {

        parent::__construct(
            'radium_widget_latest_reviews', // Base ID
            __( 'Radium Latest Reviews', 'radium' ), // Name
            array( 'description' => __( 'Display the latest posts with reviews', 'radium' ), ) // Args
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

            $post_args = array(
                'posts_per_page' => $items_num,
                'no_found_rows' => true, //pagination off
                'meta_query' => array(
                    array(
                        'key' => '_radium_post_score',
                        'value' => '1',
                        'compare' => 'LIKE'
                    )
                )
            );
               
        	$posts = Radium_Theme_WP_Query::get_posts_cached( $post_args, $this->id_base . $args['id'] );

            ?><ul class="score-box"><?php

			global $post;

            foreach ($posts as $post ) { setup_postdata($post);

                $score_total = radium_get_total_post_score();
            ?>

                <li class="clearfix">

                    <span class="total"><?php echo $score_total; ?>%</span>

                    <h5 class="entry-meta"><a href="<?php the_permalink(); ?>"><?php if ( strlen( $post->post_title ) > 25 ) { echo substr( get_the_title(), 0, 25 ) . '...'; } else { echo get_the_title(); } ?></a></h5>

                    <div class="score-outer">
                        <div class="score-line" style="width:<?php echo $score_total; ?>%;"><span></span></div>
                    </div>

                </li>

            <?php } ?>
            </ul>
            <?php wp_reset_postdata();

        echo $after_widget;

    }


    /**
     * Sanitize widget form values as they are saved
    **/
    public function update( $new_instance, $old_instance ) {

        $instance = array();

        /* Strip tags to remove HTML. For text inputs and textarea. */
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['items_num'] = strip_tags( $new_instance['items_num'] );

        return $instance;

    }


    /**
     * Back-end widget form
    **/
    public function form( $instance ) {

        /* Default widget settings. */
        $defaults = array(
            'title' => __('Latest Reviews', 'radium'),
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
            <input type="text" id="<?php echo $this->get_field_id( 'items_num' ); ?>" name="<?php echo $this->get_field_name( 'items_num' ); ?>" value="<?php echo $instance['items_num']; ?>" size="1" />
        </p>
    <?php
    }

}
register_widget( 'Radium_Widget_Latest_Reviews' );