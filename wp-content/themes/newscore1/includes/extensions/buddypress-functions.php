<?php

if(function_exists('bp_is_active')) {

    // Load BuddyPress Ajax
    require_once(BP_PLUGIN_DIR . '/bp-themes/bp-default/_inc/ajax.php');

    // Avatar Dimensions
    if(!defined('BP_AVATAR_THUMB_WIDTH'))
        define('BP_AVATAR_THUMB_WIDTH', 80);

    if(!defined('BP_AVATAR_THUMB_HEIGHT'))
        define('BP_AVATAR_THUMB_HEIGHT', 80);

    if(!defined('BP_AVATAR_FULL_WIDTH'))
        define('BP_AVATAR_FULL_WIDTH', 128);

    if(!defined('BP_AVATAR_FULL_HEIGHT'))
        define('BP_AVATAR_FULL_HEIGHT', 128);

    // JS Words For Translation
    function bp_dtheme_enqueue_scripts() {
	
        $framework = radium_framework();
		
		// Enqueue various scripts
		wp_enqueue_script( 'bp-jquery-query' );
		wp_enqueue_script( 'bp-jquery-cookie' );
		
		// Enqueue scrollTo only on activity pages
		if ( bp_is_activity_component() ) {
			wp_enqueue_script( 'bp-jquery-scroll-to' );
		}
		
        wp_enqueue_style('radium-buddypress', $framework->theme_css_url .'/buddypress.css');
		
        wp_enqueue_script('radium-buddypress-js', $framework->theme_js_url.'/buddypress.min.js', array('jquery'), '', true);

        $params = array(
            'my_favs'           => __('My Favorites', 'radium'),
            'accepted'          => __('Accepted', 'radium'),
            'rejected'          => __('Rejected', 'radium'),
            'show_all_comments' => __('Show all comments for this thread', 'radium'),
            'show_x_comments'   => __('Show all %d comments', 'radium'),
            'show_all'          => __('Show all', 'radium'),
            'comments'          => __('comments', 'radium'),
            'close'             => __('Close', 'radium'),
            'view'              => __('View', 'radium'),
            'mark_as_fav'       => __('Favorite', 'radium'),
            'remove_fav'        => __('Remove Favorite', 'radium'),
            'unsaved_changes'   => __('Your profile has unsaved changes. If you leave the page, the changes will be lost.', 'radium'),
        );
        wp_localize_script('radium-buddypress-js', 'BP_DTheme', $params);
		
    }

    add_action('wp_enqueue_scripts', 'bp_dtheme_enqueue_scripts');

    // Buttons
    if(!is_admin() OR (defined('DOING_AJAX') && DOING_AJAX)) {

        // Friends button
        if(bp_is_active('friends'))
            add_action('bp_member_header_actions', 'bp_add_friend_button', 5);

        // Activity button
        if(bp_is_active('activity'))
            add_action('bp_member_header_actions', 'bp_send_public_message_button', 20);

        // Messages button
        if (bp_is_active('messages'))
            add_action('bp_member_header_actions', 'bp_send_private_message_button', 20);

        // Group buttons
        if(bp_is_active('groups')) {
            add_action('bp_group_header_actions', 'bp_group_join_button', 5);
            add_action('bp_group_header_actions', 'bp_group_new_topic_button', 20);
            add_action('bp_directory_groups_actions', 'bp_group_join_button');
        }

        // Blog button
        if(bp_is_active('blogs'))
            add_action( 'bp_directory_blogs_actions', 'bp_blogs_visit_blog_button');

    }

}

/** BuddyPress Integration with layout Builder **/
//groups
//activity
//forums
//members
//
