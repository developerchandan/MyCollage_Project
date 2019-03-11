<?php

/*--------------------------------------------------------------------

 	Widget Name: Radium Newsletter Widget
 	Widget URI: http://www.radiumthemes.com
 	Description:  A custom widget that displays a newsletter sign up field.
 	Author: RadiumThemes
 	Author URI: http://www.radiumthemes.com
 
/*--------------------------------------------------------------------*/

// ADD FUNTION TO WIDGETS_INIT
add_action( 'widgets_init', 'reg_radium_newsletter' );

// REGISTER WIDGET
function reg_radium_newsletter() {
	register_widget( 'Radium_Newsletter_Widget' );
}

// WIDGET CLASS
class Radium_Newsletter_Widget extends WP_Widget {
 
/*--------------------------------------------------------------------*/
/*	WIDGET SETUP
/*--------------------------------------------------------------------*/
public function __construct() {
	parent::__construct(
 		'radium_newsletter', // BASE ID
		'Radium Newsletter', // NAME
		array( 'description' => __( 'A custom widget that displays a newsletter subscribe field', 'radium' ), )
	);
}
	
	
/*--------------------------------------------------------------------*/
/*	DISPLAY WIDGET
/*--------------------------------------------------------------------*/
function widget( $args, $instance ) {
	extract( $args );
	
	$title = apply_filters('widget_title', $instance['title'] );

	// WIDGET VARIABLES
	$subscribecode = $instance['subscribecode'];
	$desc = $instance['desc'];
	$animate = $instance['animate'];
	$placeholder = $instance['placeholder'];
	
	// BEFORE WIDGET
	echo $before_widget;
	
	?> 
		
	<?php if ( $title ) echo $before_title . $title . $after_title; ?>
	
	<?php if($desc != '') : ?><p><?php echo $desc; ?></p><?php endif; ?>
 	
 	<?php if ( $subscribecode == '#' ) { ?>
 		<form action="<?php echo $subscribecode; ?>" method="post" name="mc-embedded-subscribe-form" class="validate" target="_blank">
		
			<input type="email" name="EMAIL" class="email-newsletter" value="<?php echo $placeholder; ?>" required="" onfocus="this.value='';" onblur="if(this.value=='')this.value='<?php echo $placeholder; ?>';">
			
			<input type="submit" value="<?php _e('Subscribe', 'radium'); ?>" class="button <?php if($animate != '') : ?>animated ButtonShake <?php endif; ?>">
		
		</form><!-- END .form -->
 	<?php } else { ?><div class="radium-newsletter-form-wrapper" data-animate="<?php echo $animate; ?>"><?php echo $subscribecode; ?></div><?php
	}

	// AFTER WIDGET
	echo $after_widget;
}


/*--------------------------------------------------------------------*/
/*	UPDATE WIDGET
/*--------------------------------------------------------------------*/
function update( $new_instance, $old_instance ) {
	
	$instance = $old_instance;
	
	// STRIP TAGS TO REMOVE HTML - IMPORTANT FOR TEXT IMPUTS
	$instance['title'] = strip_tags( $new_instance['title'] );
	$instance['subscribecode'] = stripslashes( $new_instance['subscribecode'] );
	$instance['desc'] = stripslashes( $new_instance['desc'] );
	$instance['animate'] = strip_tags( $new_instance['animate'] );

	return $instance;
}
	
	
/*--------------------------------------------------------------------*/
/*	WIDGET SETTINGS (FRONT END PANEL)
/*--------------------------------------------------------------------*/ 
function form( $instance ) {

	// WIDGET DEFAULTS
	$defaults = array(
		'title' => 'Newsletter.',
		'subscribecode' => '',
		'desc' => 'This is a nice and simple  email newsletter widget. Yuppers.',
		'animate' => true
	);
		
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	
	<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title / Intro:', 'radium') ?></label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>
	
	
	<p style="margin-top: -8px;">
	<textarea class="widefat" rows="5" cols="15" id="<?php echo $this->get_field_id( 'desc' ); ?>" name="<?php echo $this->get_field_name( 'desc' ); ?>"><?php echo $instance['desc']; ?></textarea>
	</p>
	
	<p>
	<label for="<?php echo $this->get_field_id( 'subscribecode' ); ?>"><?php _e('Subscribe Code:', 'radium') ?></label>
	<textarea class="widefat" rows="5" cols="15" id="<?php echo $this->get_field_id( 'subscribecode' ); ?>" name="<?php echo $this->get_field_name( 'subscribecode' ); ?>"><?php echo $instance['subscribecode']; ?></textarea>
 	</p>
	
	<p>
	<?php if ($instance['animate']){ ?>
	<input type="checkbox" style="margin-top: 3px;" id="<?php echo $this->get_field_id( 'animate' ); ?>" name="<?php echo $this->get_field_name( 'animate' ); ?>" checked="checked" />
	<?php } else { ?>
	<input type="checkbox" style="margin-top: 3px;" id="<?php echo $this->get_field_id( 'animate' ); ?>" name="<?php echo $this->get_field_name( 'animate' ); ?>"  />
	<?php } ?>
	
	<label for="<?php echo $this->get_field_id( 'animate' ); ?>"><?php _e('&nbsp;Shake Animate', 'radium') ?></label>
	</p>
	<?php
	} // END FORM

} // END CLASS
?>