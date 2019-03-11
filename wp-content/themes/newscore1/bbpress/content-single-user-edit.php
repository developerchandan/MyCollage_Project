<?php

/**
 * Single User Edit Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div class="large-3 columns bbp-user-details">

	<?php
	// Profile details
	bbp_get_template_part( 'bbpress/user', 'details'        );
	?>

</div><!-- end .bbp-user-details -->

<div class="large-9 columns bbp-user-tabs tabs pseudo-tabs">

	<div class="tabs-controls radium-tabs-horizontal">
	
		<ul class="radium-user-tab-nav clearfix">
			<li>
				<?php if ( bbp_is_subscriptions_active() && ( bbp_is_user_home_edit() || current_user_can( 'edit_users' ) ) ) : ?>
					<a href="<?php echo bbp_get_user_profile_url(); ?>#bbp-author-subscriptions" class="tab-control pseudo-tab-control"><?php _e( 'Subscriptions', 'radium' ); ?></a>
				<?php endif; ?>
			</li>
			<li>
				<a href="<?php echo bbp_get_user_profile_url(); ?>#bbp-author-favorites" class="tab-control pseudo-tab-control"><?php _e( 'Favorite threads', 'radium' ); ?></a>
			</li>
			<li>
				<a href="<?php echo bbp_get_user_profile_url(); ?>#topics-created" class="tab-control pseudo-tab-control"><?php _e( 'Created threads', 'radium' ); ?></a>
			</li>
			<li>
				<?php if ( bbp_is_user_home_edit() || current_user_can( 'edit_users' ) ) : ?>
					<a href="<?php bbp_user_profile_edit_url(); ?>" class="tab-control pseudo-tab-control current"><?php _e( 'Edit', 'radium' ); ?></a>
				<?php endif; ?>
			</li>
		</ul>
		
	</div>
	
	<div class="tabs-content">
	
		<?php
		// User edit form
		bbp_get_template_part( 'bbpress/form', 'user-edit' );
		?>
	
	</div><!-- end .tabs-content -->

</div><!-- end .bbp-user-tabs -->