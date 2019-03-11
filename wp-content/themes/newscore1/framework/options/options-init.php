<?php

$framework = radium_framework();

if(!class_exists('Radium_Options')){
	require_once( $framework->theme_framework_dir. '/options/options.php' );
}

/*
 * This is the meat of creating the options page
 *
 * Override some of the default values, uncomment the args and change the values
 * - no $args are required, but there there to be over ridden if needed.
 */
function setup_radium_framework_options(){

	$framework = radium_framework();

	$args = array();

	//google api key MUST BE DEFINED IF YOU WANT TO USE GOOGLE WEBFONTS
	$args['google_api_key'] = 'AIzaSyAXpS28j-eNGn1Ph_cUMeWqc28jyTlKtJ0';

	//Remove the default stylesheet? make sure you enqueue another one or the page will look whack!
	//$args['stylesheet_override'] = true;

	//Add HTML before the form
	$args['intro_text'] = '';

	//Setup custom links in the footer for share icons
	$args['share_icons']['twitter'] = array(
											'link' => 'http://twitter.com/radiumthemes',
											'title' => 'Follow me on Twitter',
											'img' => $framework->theme_framework_images_url .'/icons/icon-twitter.png'
									);

	//Choose to disable the import/export feature
	//$args['show_import_export'] = false;

	//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
	//$args['opt_name'] = $framework->theme_option_name;

	//Custom menu icon
	$args['menu_icon'] = '';

	//Custom menu title for options page - default is "Options"
	$args['menu_title'] = __('Theme Options', 'radium');

	//Custom Page Title for options page - default is "Options"
	$args['page_title'] = __('Theme Options', 'radium');

	//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "radium_theme_options"
	$args['page_slug'] = 'radium_theme_options';

	//Custom page capability - default is set to "manage_options"
	$args['page_cap'] = 'manage_options';

	//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
	$args['page_type'] = 'submenu';

	//parent menu - default is set to "themes.php" (Appearance)
	//the list of available parent menus is available here: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	$args['page_parent'] = 'themes.php';

	//custom page location - default 100 - must be unique or will override other items
	$args['page_position'] = 100;

	//Custom page icon class (used to override the page icon next to heading)
	//$args['page_icon'] = 'icon-themes';

	//Want to disable the sections showing as a submenu in the admin? uncomment this line
	$args['allow_sub_menu'] = false;

	/*//Set ANY custom page help tabs - displayed using the new help tab API, show in order of definition
	$args['help_tabs'][] = array(
								'id' => 'radium-opts-1',
								'title' => __('Theme Information 1', 'radium'),
								'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'radium')
								);
	$args['help_tabs'][] = array(
								'id' => 'radium-opts-2',
								'title' => __('Theme Information 2', 'radium'),
								'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'radium')
								);

	//Set the Help Sidebar for the options page - no sidebar by default
	$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'radium');

	*/

	$sections = array();

	/* Fields
		'id' => 'logo', //must be unique
		'type' => 'upload', //built-in fields include:
						  //text|textarea|editor|checkbox|multi_checkbox|radio|radio_img|button_set|select|multi_select|color|date|divide|info|upload
		'title' => __('Upload Logo', 'radium'),
		'sub_desc' => __('This is a little space under the Field Title in the Options table, additional info is good in here.', 'radium'),
		'desc' => __('This is the description field, again good for additional info.', 'radium'),
		'validate' => '', //built-in validation includes: email|html|html_custom|no_html|js|numeric|url
		'msg' => 'custom error message', //override the default validation error message for specific fields
		'std' => '', //This is a default value, used to set the options on theme activation, and if the user hits the Reset to defaults Button
		'class' => '' //Set custom classes for elements if you want to do something a little different - default is "regular-text"
		),


	$sections[] = array(
					'title' => __('Getting Started', 'radium'),
					'desc' => __('<p class="description">Welcome to MetroCorp. If you have any problems, click here for the Support Forum. Also, feel free to check out our other Premium WordPress Themes:</p>', 'radium'),
					'icon' => $framework->theme_framework_images_url.'/icons/icon-attach.png',
					'fields' => array()
	 			);
	 			*/

	$tabs = array();

	if( $framework->theme_dev_mode ) {

		$theme_data = wp_get_theme();
		$theme_uri = $theme_data->get('ThemeURI');
		$description = $theme_data->get('Description');
		$author = $theme_data->get('Author');
		$version = $theme_data->get('Version');
	 	global $wp_version;

		$theme_info = '<div class="radium-opts-section-desc">';
		$theme_info .= '<p class="radium-opts-theme-data description theme-uri">'.__('<strong>Theme URL:</strong> ', 'radium').'<a href="'.$theme_uri.'" target="_blank">'.$theme_uri.'</a></p>';
		$theme_info .= '<p class="radium-opts-theme-data description theme-author">'.__('<strong>Author:</strong> ', 'radium').$author.'</p>';
		$theme_info .= '<p class="radium-opts-theme-data description theme-version">'.__('<strong>Version:</strong> ', 'radium').$version.'</p>';
		$theme_info .= '<p class="radium-opts-theme-data description theme-framework-version">'.__('<strong>Framework Version:</strong> ', 'radium').$framework->theme_framework_version.'</p>';
		$theme_info .= '<p class="radium-opts-theme-data description theme-description">'.$description.'</p>';
	  	$theme_info .= '<p class="radium-opts-theme-data description php-version"> PHP Version: '.PHP_VERSION.'</b></p>';
	 	$theme_info .= '<p class="radium-opts-theme-data description wp-version">WordPress Version: '.$wp_version.'</p>';
	 	$theme_info .= '</div>';

		$tabs['theme_info'] = array(
			'icon' => $framework->theme_framework_images_url .'/icons/icon-info.png',
			'title' => __('Theme Information', 'radium'),
			'content' => $theme_info
			);

		if(file_exists(trailingslashit(get_stylesheet_directory()).'includes/docs/index.html')){
			$tabs['theme_docs'] = array(
				'icon' => $framework->theme_framework_images_url .'/icons/icon-book.png',
				'title' => __('Documentation', 'radium'),
				'content' => '<iframe src="'.trailingslashit(get_stylesheet_directory()).'includes/docs/index.html" width="100%" height="100%"></iframe>'
				);
			}//if

	}//Dev Mode

	global $Radium_Options;

	$Radium_Options = new Radium_Options($sections, $args, $tabs);

}
add_action('init', 'setup_radium_framework_options', 0);

