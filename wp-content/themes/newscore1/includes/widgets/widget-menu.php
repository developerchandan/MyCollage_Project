<?php
// Add function to widgets_init that will load our widget.
add_action( 'widgets_init', 'radium_menu_widgets' );

// Register widget.
function radium_menu_widgets() {
	register_widget( 'Radium_Menu_Widget' );
}

class Radium_Menu_Widget extends WP_Widget {
 
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
	
		$framework = radium_framework();
		
		parent::__construct(
	 		'radium_pages_menu', // Base ID
			'Radium Pages', // Name
			array( 'description' => __( 'Use this widget on pages to display aside menu with children or siblings of the current page', 'radium' ), )
		);
	}
	
	/* ---------------------------------------------------------------------------
	 * Outputs the HTML for this widget.
	 * --------------------------------------------------------------------------- */
	function widget( $args, $instance ) {

		if ( ! isset( $args['widget_id'] ) ) $args['widget_id'] = null;
		
		extract( $args, EXTR_SKIP );

		$title = null;
				
		$sticky = isset( $instance['sticky'] ) ? $instance['sticky'] : null;
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo $before_widget;
		
		if ( $title ) echo $before_title . $title . $after_title;
		
		$aPost = $parentID = null;

		if( $instance['use_page_sibling'] ) {
		
			// sibling
			$aPost = get_post( get_the_ID() );
			
			$parentID = $aPost ? $aPost->ancestors[0] : null;
			
		} else {
		
			// children
			$parentID = get_the_ID();
			
		}

		$aPages = wp_list_pages( array(
			'title_li' 		=> '',	
			'depth' 		=> 1,
			'child_of' 		=> $parentID,
			'link_after' 	=> '<em></em>',
			'echo' 			=> 0,
		));
					
		if( $aPages ): ?>
		
			<nav class="submenu <?php echo $sticky; ?>">
				
				<ul><?php echo $aPages; ?></ul>
			
			</nav>
			
		<?php endif;
		
		echo $after_widget;
	}


	/* ---------------------------------------------------------------------------
	 * Deals with the settings when they are saved by the admin.
	 * --------------------------------------------------------------------------- */
	function update( $new_instance, $old_instance ) {
	
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		
 		//$instance['sticky'] = strip_tags( $new_instance['sticky'] );
 		 		
		$instance['use_page_sibling'] = (int) $new_instance['use_page_sibling'];
		
		return $instance;
		
	}

	
	/* ---------------------------------------------------------------------------
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 * --------------------------------------------------------------------------- */
	function form( $instance ) {
		$title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : '';
		//$sticky = $instance[ 'sticky' ];
		$use_page_title = isset( $instance['use_page_title'] ) ? absint( $instance['use_page_title'] ) : 0;
		$use_page_sibling = isset( $instance['use_page_sibling'] ) ? absint( $instance['use_page_sibling'] ) : 0;
?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'radium' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			
			<!--
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'sticky' ) ); ?>"><?php _e( 'Make Menu Sticky on Scroll ', 'radium' ); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'sticky' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sticky' ) ); ?>">
					<option value="sticky" <?php selected( 'yes', $sticky ); ?>><?php _e( 'Yes', 'radium' ); ?></option>
					<option value="" <?php selected( 'no', $sticky ); ?>><?php _e( 'No', 'radium' ); ?></option>
 				</select>
			</p>
			-->
			
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'use_page_sibling' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'use_page_sibling' ) ); ?>" type="radio" value="1" <?php if( $use_page_sibling  ) echo "checked='checked'" ?>/>
				
				<label for="<?php echo esc_attr( $this->get_field_id( 'use_page_sibling' ) ); ?>"><?php _e( 'Show page siblings', 'radium' ); ?></label>	
				<br/>
				<input id="<?php echo esc_attr( $this->get_field_id( 'use_page_children' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'use_page_sibling' ) ); ?>" type="radio" value="0" <?php if( !$use_page_sibling ) echo "checked='checked'" ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'use_page_children' ) ); ?>"><?php _e( 'Show child pages', 'radium' ); ?></label>	
			</p>
		<?php
	}
}
?>