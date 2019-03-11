<?php /* 404 Template */ ?>

<?php get_header(); ?>

 	<div class="row">
		
		<div class="large-5 columns large-centered not-found-message">
			<h2><?php _e('OOH no!', 'radium'); ?></h2>
			<h1><?php _e( ' It\'s a 404 Error', 'radium' ); ?></h1>
			 <p><?php echo radium_get_option( 'error_text'); ?><br>&larr; <b><a href="javascript:javascript:history.go(-1)"><?php _e( 'Go Back', 'radium' ); ?></a></b><?php _e( ' or ', 'radium' ); ?><b><a href="<?php echo home_url(); ?>"><?php _e( 'Go Home', 'radium' ); ?></a></b> &rarr;</p>

    	</div><!-- END .large-8 columns centered -->
		
	</div><!-- END .row -->
	
 <?php get_footer(); ?>