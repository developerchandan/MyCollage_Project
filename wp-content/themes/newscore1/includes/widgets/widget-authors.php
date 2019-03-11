<?php

class Radium_Authors_Widget extends WP_Widget {

    /**
     * Register widget
    **/
    public function __construct() {

        parent::__construct(
            'radium_site_authors', // Base ID
            __( 'Radium Site Authors', 'radium' ), // Name
            array( 'description' => __( 'Display the site authors', 'radium' ), ) // Args
        );

    }

    /**
     * Front-end display of widget
    **/
    public function widget( $args, $instance ) {

        extract( $args );

        $title = apply_filters('widget_title', $instance['title'] );
        $items_num = isset($instance['items_num']) ? $instance['items_num'] : 10;

        echo $before_widget;

		if ( $title ) echo $before_title . $title . $after_title;

        $query_args = array(
            'role' => 'author',
            'order' => 'DESC',
            'orderby' => 'post_count',
            'number' => $items_num
        );

		$authors = get_users( $query_args );

        if( $authors ) { ?>
            <div class="inner">
                <ul>
                <?php
                foreach ( $authors as $author ):

                    // Get the author ID
                    $author_id = $author->ID;

                    // Retrive the gravatar image by author email address
                    $author_avatar = get_avatar( get_the_author_meta( 'user_email', $author_id ), '', '', get_the_author_meta( 'display_name', $author_id ) );
                    ?>

                    <li>
                        <a href="<?php echo get_author_posts_url( $author_id ); ?>">
                            <?php echo $author_avatar; ?>
                        </a>
                    </li>

                <?php endforeach; ?>
                </ul>
            </div>
        <?php
        }

        echo $after_widget;

    }


    /**
     * Sanitize widget form values as they are saved
     */
    public function update( $new_instance, $old_instance ) {

        $instance = array();

        /* Strip tags to remove HTML. For text inputs and textarea. */
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['items_num'] = strip_tags( $new_instance['items_num'] );

        return $instance;

    }

    /**
     * Back-end widget form
     */
    public function form( $instance ) {

        /* Default widget settings. */
        $defaults = array(
            'title' => 'Authors',
            'items_num' => '10'
        );
        $instance = wp_parse_args( (array) $instance, $defaults );

    ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'radium'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'items_num' ); ?>"><?php _e('Maximum thumbs to show:', 'radium'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'items_num' ); ?>" name="<?php echo $this->get_field_name( 'items_num' ); ?>" value="<?php echo $instance['items_num']; ?>" size="1" />
        </p>
    <?php
    }

}
register_widget( 'Radium_Authors_Widget' );