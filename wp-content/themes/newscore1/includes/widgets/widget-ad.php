<?php

/**
 * Plugin Name: Ad Widget
 */
add_action( 'widgets_init', 'radium_ad_load_widget' );

function radium_ad_load_widget() {

	register_widget( 'Radium_AD_Widget' );

}

class Radium_AD_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */

	function __construct() {

        parent::__construct(
            'radium_ad_widget', // BASE ID
            'Radium: Ad Widget', // NAME
            array( 'description' => __( 'A widget that displays an ad of any size.', 'radium' ), )
        );

	}

	/**
	 * How to display the widget on the screen.
	 */

	function widget( $args, $instance ) {

		extract( $args );

		/* Our variables from the widget settings. */
		$ad_code = $instance['ad_code'];

		echo $before_widget;

		?>
			<div class="widget-ad clearfix">

				<h3><?php _e( 'Advertisement', 'radium' ); ?></h3>

				<?php echo stripslashes($ad_code); ?>

			</div><!--widget-ad-->

		<?php

	   /* After widget */
		echo $after_widget;

	}

	/**
	 * Update the widget settings.
	 */

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['ad_code'] = $new_instance['ad_code'];

		return $instance;

	}

	function form( $instance ) {

		/* Set up some default widget settings. */

		$defaults = array( 'ad_code' => 'Enter ad code here');

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Ad code -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_code' ); ?>">Ad code:</label>
			<textarea id="<?php echo $this->get_field_id( 'ad_code' ); ?>" name="<?php echo $this->get_field_name( 'ad_code' ); ?>" style="width:96%;" rows="6"><?php echo $instance['ad_code']; ?></textarea>
		</p>

	<?php

	}

}

?>