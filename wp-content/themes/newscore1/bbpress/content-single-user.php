<?php

/**
 * Single User Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>


<div class="large-3 columns bbp-user-details">

	<?php
	// Profile details
	bbp_get_template_part( 'bbpress/user', 'details' );
	?>
	<?php if ( bbp_is_user_home() || current_user_can( 'edit_users' ) ) : ?>
		<a href="<?php bbp_user_profile_edit_url(); ?>"><?php _e( 'Edit', 'radium' ); ?></a>
	<?php endif; ?>
</div><!-- end .bbp-user-details -->

<div class="large-9 columns bbp-user-tabs tabs">
	<div id="radium-user-tabs-<?php echo rand(1, 100); ?>" class="radium-user-tabs  radium-tabs-horizontal clearfix">
		<div class="radium-tab-inner">
			<ul class="radium-user-tab-nav clearfix">
				<?php if ( bbp_is_subscriptions_active() && ( bbp_is_user_home() || current_user_can( 'edit_users' ) ) ) : ?>
					<li><a href="#subscriptions" class="tab-control"><?php _e( 'Subscriptions', 'radium' ); ?></a></li>
				<?php endif; ?>
				<li><a href="#favorites" class="tab-control"><?php _e( 'Favorite threads', 'radium' ); ?></a></li>
				<li><a href="#topics-started" class="tab-control"><?php _e( 'Created threads', 'radium' ); ?></a></li>
				<?php if(class_exists('BBP_Mark_As_Read') ): ?>
					<li><a href="#unread-topics" class="tab-control"><?php _e( 'Unread Topics', 'radium' ); ?></a></li>
				<?php endif; ?>
 			</ul>
			
			<div id="bbpress-forums" class="tabs-content clearfix">

				<div id="subscriptions" class="radium-user-tab clearfix">
					<?php bbp_get_template_part( 'bbpress/user', 'subscriptions'  ); ?>
				</div>	
				
				<div id="favorites" class="radium-user-tab clearfix">
					<?php bbp_get_template_part( 'bbpress/user', 'favorites' ); ?>
				</div>
				
				<div id="topics-started" class="radium-user-tab clearfix">
					<?php bbp_get_template_part( 'bbpress/user', 'topics-created' ); ?>
				</div>
				
				<?php if(class_exists('BBP_Mark_As_Read') ): ?>
				<div id="unread-topics" class="radium-user-tab clearfix">
					<?php do_action('radium_show_unread_topics'); ?>
				</div>
				<?php endif; ?>
				
			</div><!-- end .tabs-content -->
			
		</div>
	</div>
</div><!-- end .bbp-user-tabs -->

<script>
    jQuery(function() {
		jQuery('.radium-user-tabs').tabs({
		    select: function(event, ui) {
		        window.location.hash = ui.tab.hash;
		    }
		}); 
	  });
</script>