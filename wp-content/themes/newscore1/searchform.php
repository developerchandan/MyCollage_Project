<form id="searchform" class="searchform" method="get" action="<?php echo get_home_url(); ?>">

    <div class="clearfix default_searchform">

     <input type="text" name="s" class="s" onblur="if (this.value == '') {this.value = 'Search here...';}" onfocus="if (this.value == 'Search here...') {this.value = '';}" value="Search here..." />
           
		<input type="submit" value="<?php _e('Search','radium'); ?>" class="button">

    </div><!-- END .clearfix default_searchform -->

    <?php do_action('radium_search_form'); ?>

</form><!-- END #searchform -->

