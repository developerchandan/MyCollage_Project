<?php

$framework = radium_framework();

if (!function_exists('radium_load_framework_theme_options')) {
    function radium_load_framework_theme_options()
    {
        $framework = radium_framework();

    /* Field Setting sample
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
    */

$sections[] = array(
                'icon' => $framework->theme_framework_images_url.'/icons/icon-settings.png',
                'title' => __('General Options', 'radium'),
                'desc' => __(' ', 'radium'),
                'fields' => array(

                    array(
                        'id' => 'logo',
                        'type' => 'upload',
                        'title' => __('Upload Logo', 'radium'),
                        'sub_desc' => __('Upload you custom logo here. If empty, the site title will be displayed.', 'radium'),
                    ),

                    array(
                        'id' => 'logo-dimensions',
                        'type' => 'dimensions',
                        'units' => 'px',    // You can specify a unit value. Possible: px, em, %
                        'units_extended' => false,  // Allow users to select any type of unit
                        'title' => __('Logo Dimensions (Width/Height)', 'radium'),
                        'subtitle' => __('Choose the logo dimensions here', 'radium'),
                        'desc' => __('You can enable or disable any piece of this field. Width, Height, or Units.', 'radium'),
                        'default' => array(
                            'width' => 481,
                            'height' => 89,
                        ),
                    ),

                    array(
                        'id' => 'logo_position',
                        'type' => 'select',
                        'title' => __('Logo Position', 'radium'),
                        'sub_desc' => __('', 'radium'),
                            'options' => array(
                                'left' => 'Left',
                                'center' => 'Center',
                                'right' => 'Right',
                            ),
                        'std' => 'left',
                    ),

                    array(
                        'id' => 'site_description',
                        'type' => 'checkbox',
                        'title' => __('Enable Site description', 'radium'),
                            'sub_desc' => __('It will be hidden if you upload a logo.', 'radium'),
                            'std' => 0,
                        'switch' => true,
                    ),

                    array(
                        'id' => 'header_banner_enable',
                        'type' => 'checkbox',
                        'title' => __('Enable Header Banner', 'radium'),
                        'sub_desc' => '',
                        'std' => 1,
                        'switch' => true,
                        ),

                    array(
                        'id' => 'header_banner',
                        'type' => 'upload',
                        'title' => __('Upload Banner', 'radium'),
                        'sub_desc' => __('Upload a banner for the header.', 'radium'),
                       ),

                    array(
                        'id' => 'banner-dimensions',
                        'type' => 'dimensions',
                        'units' => 'px',    // You can specify a unit value. Possible: px, em, %
                        'units_extended' => false,  // Allow users to select any type of unit
                        'title' => __('Banner Dimensions (Width/Height)', 'radium'),
                        'subtitle' => __('Choose the banner dimensions here', 'radium'),
                        'desc' => __('You can enable or disable any piece of this field. Width, Height, or Units.', 'radium'),
                        'default' => array(
                            'width' => 728,
                            'height' => 90,
                        ),
                    ),

                    array(
                        'id' => 'header_banner_link',
                        'type' => 'text',
                        'title' => __('Banner Link', 'radium'),
                        'sub_desc' => __('Banner link. You can use this as an ad.', 'radium'),
                        ),

                    array(
                        'id' => 'header_banner_ad_code',
                        'type' => 'textarea',
                        'title' => __('Banner Ad Code', 'radium'),
                        'sub_desc' => __('You can place a banner ad code. This will override the the two settings above', 'radium'),
                        ),

                     array(
                         'id' => 'login_logo',
                         'type' => 'upload',
                         'title' => __('Upload Login Logo', 'radium'),
                         'sub_desc' => __('Upload a custom logo for the login page.', 'radium'),
                         ),

                    array(
                        'id' => 'favicon',
                        'type' => 'upload',
                        'title' => __('Upload Favicon', 'radium'),
                        'sub_desc' => __('Upload a favicon here. This will override the default. It should be 16px by 16px.', 'radium'),
                        ),

                    array(
                        'id' => 'appleicon',
                        'type' => 'upload',
                        'title' => __('Upload Apple Touch Icon', 'radium'),
                        'sub_desc' => __('Upload you custom icon here. It should be 114px by 114px.', 'radium'),
                        ),

                    array(
                        'id' => 'header_scripts',
                        'type' => 'textarea',
                        'title' => __('Header Scripts.', 'radium'),
                        'sub_desc' => __('Paste any analytics code or javascript code that belongs in the head element of your site here. <strong>DO NOT include the &lt;script&gt; and &lt;/script&gt; tags.</strong>', 'radium'),
                        'std' => '',
                        ),

                    array(
                        'id' => 'footer_scripts',
                        'type' => 'textarea',
                        'title' => __('Footer Scripts', 'radium'),
                        'sub_desc' => __('Paste any analytics code or javascript code that belongs before the closing body tag here. <strong>DO NOT include the &lt;script&gt; and &lt;/script&gt; tags.</strong>', 'radium'),
                        'std' => '',
                        ),

                     array(
                        'id' => 'footer_copyright_text',
                        'type' => 'textarea',
                        'title' => __('Footer Copyright Text', 'radium'),
                        'sub_desc' => __('eg copyright information (html is allowed)', 'radium'),
                        'std' => '',
                         ),

                       ),
                );

        $sections[] = array(
                'title' => __('Layout', 'radium'),
                'desc' => __(' ', 'radium'),
                 'icon' => $framework->theme_framework_images_url.'/icons/icon-layout.png',
                 'fields' => array(

                     array(
                         'id' => 'layout_type',
                         'type' => 'radio_img',
                         'title' => __('Select Theme Layout', 'radium'),
                         'sub_desc' => __('Default (1240px wide) or narrow (1024px wide)', 'radium'),
                             'options' => array(
                                     //'wide'  => array('title'    => 'Wide Layout', 'img'         => $framework->theme_framework_images_url.'/wide.png'),
                                     'boxed' => array('title' => __('Default Layout', 'radium'), 'img' => $framework->theme_framework_images_url.'/boxed.png'),
                                     'narrow' => array('title' => __('Narrow Layout', 'radium'), 'img' => $framework->theme_framework_images_url.'/boxed.png'),
                                 ),//Must provide key => value(array:title|img) pairs for radio options
                         'std' => 'boxed',
                     ),

                    array(
                        'id' => 'loading_bar',
                        'type' => 'checkbox',
                        'title' => __('Loading Bar', 'radium'),
                        'desc' => __('Enable loading bar.', 'radium'),
                        'std' => 1,
                        'switch' => true,
                    ),

                     array(
                         'id' => 'sticky_header',
                         'type' => 'checkbox',
                         'title' => __('Sticky Header', 'radium'),
                         'desc' => __('Enable sticky header.', 'radium'),
                         'std' => 1,
                         'switch' => true,
                     ),

                     array(
                         'id' => 'space_menu_evenly',
                         'type' => 'checkbox',
                         'title' => __('Space Menu Item', 'radium'),
                         'desc' => __('This will space menu items evenly in the header, make sure you don\'t have too many items in there..', 'radium'),
                         'std' => '1',
                         'switch' => true,
                     ),

                     array(
                         'id' => 'header_trending',
                         'type' => 'checkbox',
                         'title' => __('Display Trending/Breaking', 'radium'),
                         'desc' => __('This will enable trending articles in the header.', 'radium'),
                         'std' => '1',
                         'switch' => true,
                     ),

                     array(
                         'id' => 'header_items_ticker_title',
                         'type' => 'text',
                         'title' => __('Header Items Ticker Title', 'radium'),
                         'sub_desc' => '',
                         'std' => __('Breaking', 'radium'),
                     ),

                     array(
                         'id' => 'header_news',
                         'type' => 'checkbox',
                         'title' => __('Display Latest News', 'radium'),
                         'desc' => __('This will enable latest posts in the header.', 'radium'),
                         'std' => '1',
                         'switch' => true,
                     ),

                    array(
                        'id' => 'header_news_limit',
                        'type' => 'text',
                        'title' => __('Header News Counter Limit', 'radium'),
                        'desc' => 'Set a limit for how many items to show as new. Keep it low for performance reasons',
                        'std' => 100,
                    ),

                     array(
                         'id' => 'header_news_title',
                         'type' => 'text',
                         'title' => __('Header News Title', 'radium'),
                         'desc' => 'Will be show if more than one new post is found',
                         'std' => __('New Articles', 'radium'),
                     ),

                    array(
                        'id' => 'header_news_title_single',
                        'type' => 'text',
                        'title' => __('Header News Title (Singlural)', 'radium'),
                        'desc' => 'Will be show if only one new post is found',
                        'std' => __('New Article', 'radium'),
                    ),

                    array(
                        'id' => 'header_search',
                        'type' => 'checkbox',
                        'title' => __('Display a Search Button', 'radium'),
                        'desc' => __('This will enable a search button in the header.', 'radium'),
                        'std' => '1',
                        'switch' => true,
                    ),

                    array(
                        'id' => 'header_search_title',
                        'type' => 'text',
                        'title' => __('Header Search Title', 'radium'),
                        'desc' => '',
                        'std' => __('Search', 'radium'),
                    ),

                    array(
                        'id' => 'header_search_placeholder',
                        'type' => 'text',
                        'title' => __('Header Search Placeholder text', 'radium'),
                        'desc' => '',
                        'std' => __('START TYPING..', 'radium'),
                    ),

                    array(
                        'id' => 'header_random',
                        'type' => 'checkbox',
                        'title' => __('Display Random Posts Button', 'radium'),
                        'desc' => __('This will enable a random posts button in the header.', 'radium'),
                        'std' => '1',
                        'switch' => true,
                    ),

                    array(
                        'id' => 'header_random_title',
                        'type' => 'text',
                        'title' => __('Header Random Title', 'radium'),
                        'desc' => '',
                        'std' => __('Random', 'radium'),
                    ),

                    array(
                        'id' => 'header_tools_items',
                        'type' => 'multi_checkbox',
                        'title' => __('Show Header Tools', 'radium'),
                        'sub_desc' => __('Select which items to show in the header tools section.', 'radium'),
                        'options' => array(
                            'woocart' => __('Woocommerce Shopping Cart', 'radium'),
                            'whishlist' => __('Woocommerce Wishlist', 'radium'),
                            'wpml' => __('WPML Language Menu', 'radium'),
                            'login' => __('Login Form and User Info', 'radium'),
                        ),
                        'std' => array(
                            'woocart' => '1',
                            'whishlist' => '1',
                            'lang' => '1',
                            'login' => '1',
                        ),
                    ),

                    array(
                        'id' => 'story_navigation',
                        'type' => 'select',
                        'title' => __('Story Navigation', 'radium'),
                        'sub_desc' => __('Links for next and previous post', 'radium'),
                            'options' => array(
                                'disable' => __('Disable', 'radium'),
                                'sidebar' => __('Show in the sidebar', 'radium'),
                                'below-post' => __('Show below the post', 'radium'),
                            ),
                        'std' => 'sidebar',
                    ),

                    array(
                        'id' => 'author_info',
                        'type' => 'checkbox',
                        'title' => __('Display Author Details', 'radium'),
                        'desc' => __('This will show the author\'s description set in the profile settings after the post.', 'radium'),
                        'std' => '1',
                        'switch' => true,
                    ),

                    array(
                        'id' => 'author_box_title',
                        'type' => 'text',
                        'title' => __('Author Box Title', 'radium'),
                        'desc' => '',
                        'std' => __('About the Author', 'radium'),
                    ),

                    array(
                        'id' => 'share_posts',
                        'type' => 'checkbox_hide_below',
                        'title' => __('Display social share buttons', 'radium'),
                        'desc' => __('This displays social links in the single post layout and social sharing count in the grid layouts', 'radium'),
                        'std' => '1',
                        'switch' => true,
                    ),

                    array(
                        'id' => 'share_posts_position',
                        'type' => 'select',
                        'title' => __('Social share buttons position', 'radium'),
                        'desc' => '<br>'.__('Select the position of the share button.', 'radium'),
                        'options' => array(
                            'left' => __('Left', 'radium'),
                            //'right'  => __('Right', 'radium'),
                            'above' => __('Show above post content', 'radium'),
                            'below' => __('Show below the post content', 'radium'),
                            'above-below' => __('Show above and below post content', 'radium'),
                        ),
                        'std' => 'sidebar',
                    ),

                    array(
                        'id' => 'social_links',
                        'type' => 'checkbox',
                        'title' => __('Display social link buttons', 'radium'),
                        'desc' => __('This displays social links in the sidebar', 'radium'),
                        'std' => '1',
                        'switch' => true,
                    ),

                    array(
                        'id' => 'show_tags',
                        'type' => 'checkbox',
                        'title' => __('Display tags', 'radium'),
                        'desc' => __('Show tags after the post', 'radium'),
                        'std' => '1',
                        'switch' => true,
                    ),

                    array(
                        'id' => 'show_cats',
                        'type' => 'checkbox',
                        'title' => __('Display Categories', 'radium'),
                        'desc' => __('Show categories after the post', 'radium'),
                        'std' => '1',
                        'switch' => true,
                    ),

                    array(
                        'id' => 'single_recent_posts',
                        'type' => 'checkbox',
                        'title' => __('Display latest items above posts', 'radium'),
                        'desc' => '',
                        'std' => '1',
                        'switch' => true,
                    ),

                    array(
                        'id' => 'single_recent_posts_hide_below',
                        'type' => 'checkbox_hide_below',
                        'title' => __('Choose which categories to use', 'radium'),
                        'desc' => '',
                        'switch' => true,
                    ),

                    array(
                        'id' => 'single_recent_post_categories',
                        'type' => 'cats_multi_select',
                        'title' => __('Select specific categories to use', 'radium'),
                        'desc' => __('If this is diabled, all latest posts will be displayed', 'radium'),
                        'args' => array('number' => '100'),//uses get_categories
                    ),

                    array(
                        'id' => 'single_recent_post_number',
                        'type' => 'text',
                        'title' => __('Number of post to show above posts', 'radium'),
                        'desc' => '',
                        'std' => 15,
                    ),

                    array(
                        'id' => 'related_posts',
                        'type' => 'checkbox',
                        'title' => __('Display Related Content', 'radium'),
                        'desc' => __('Show related content below the post', 'radium'),
                        'std' => '1',
                        'switch' => true,
                    ),

                    array(
                        'id' => 'related_posts_title',
                        'type' => 'text',
                        'title' => __('Related Posts Title', 'radium'),
                        'desc' => '',
                        'std' => __('Some Related Posts', 'radium'),
                    ),

                    array(
                        'id' => 'back_to_top',
                        'type' => 'checkbox',
                        'title' => __('Back to Top Button', 'radium'),
                        'desc' => '',
                        'std' => 1,
                        'switch' => true,
                    ),

                    array(
                        'id' => 'header_breadcrumb_title',
                        'type' => 'text',
                        'title' => __('Header Breadcrumb Title', 'radium'),
                        'desc' => '',
                        'std' => __('You Are Here:', 'radium'),
                    ),

                    array(
                        'id' => 'header_breadcrumb_home_title',
                        'type' => 'text',
                        'title' => __('Header Breadcrumb Home Title', 'radium'),
                        'desc' => '',
                        'std' => __('Home', 'radium'),
                    ),

                    array(
                        'id' => 'single_post_layout',
                        'type' => 'radio_img',
                        'title' => __('Single Post Layout', 'radium'),
                        'sub_desc' => __('Select a layout for single posts.', 'radium'),
                            'options' => array(
                                        'right' => array('title' => '2 col right', 'img' => $framework->theme_framework_images_url.'/2cr.png'),
                                        'left' => array('title' => '2 col left ', 'img' => $framework->theme_framework_images_url.'/2cl.png'),
                                        'none' => array('title' => '1 col no sidebar', 'img' => $framework->theme_framework_images_url.'/1col.png'),
                                    ),//Must provide key => value(array:title|img) pairs for radio options
                        'std' => 'right',
                    ),

                    array(
                        'id' => 'post_meta_elements',
                        'type' => 'multi_checkbox',
                        'title' => __('Post Meta Elements', 'radium'),
                        'sub_desc' => __('Select which items to show in the post thumbnails.', 'radium'),
                        'options' => array(
                            'date' => __('Date', 'radium'),
                            'category' => __('Category', 'radium'),
                            'featured' => __('Featured', 'radium'),
                            'rating_score' => __('Rating', 'radium'),
                        ),
                        'std' => array(
                            'date' => '1',
                            'category' => '1',
                            'featured' => '1',
                            'rating_score' => '1',
                        ),
                    ),

                    array(
                        'id' => 'single_post_meta_elements',
                        'type' => 'multi_checkbox',
                        'title' => __('Single Post Meta Elements', 'radium'),
                        'sub_desc' => __('Select which details to show in the post view.', 'radium'),
                        'options' => array(
                            'date' => __('Date', 'radium'),
                            'author' => __('Author', 'radium'),
                        ),
                        'std' => array(
                            'date' => '1',
                            'author' => '1',
                        ),
                    ),

                    array(
                        'id' => 'all_posts_page_title',
                        'type' => 'text',
                        'title' => __('All Posts Page Title', 'radium'),
                        'desc' => __('This will be displayed if the option at "Settings->Reading" is set to "Your latest posts"', 'radium'),
                        'std' => __('All Posts', 'radium'),
                    ),
                    array(
                        'id' => 'post_archives_layout',
                        'type' => 'radio_img',
                        'title' => __('Post Archives Layout', 'radium'),
                        'sub_desc' => __('Select a layout for Post Archives.', 'radium'),
                            'options' => array(
                                'right' => array('title' => '2 col right', 'img' => $framework->theme_framework_images_url.'/2cr.png'),
                                'left' => array('title' => '2 col left ', 'img' => $framework->theme_framework_images_url.'/2cl.png'),
                                'none' => array('title' => '1 col no sidebar', 'img' => $framework->theme_framework_images_url.'/1col.png'),
                                        ),//Must provide key => value(array:title|img) pairs for radio options
                        'std' => 'right',
                    ),

                    array(
                        'id' => 'bbpress_layout',
                        'type' => 'radio_img',
                        'title' => __('BBPress Sidebar', 'radium'),
                        'sub_desc' => __('Select a layout for Post Archives.', 'radium'),
                            'options' => array(
                                'right' => array('title' => '2 col right', 'img' => $framework->theme_framework_images_url.'/2cr.png'),
                                'left' => array('title' => '2 col left ', 'img' => $framework->theme_framework_images_url.'/2cl.png'),
                                'none' => array('title' => '1 col no sidebar', 'img' => $framework->theme_framework_images_url.'/1col.png'),
                                        ),//Must provide key => value(array:title|img) pairs for radio options
                        'std' => 'right',
                    ),

                    array(
                        'id' => 'woocommerce_archive_layout',
                        'type' => 'radio_img',
                        'title' => __('Woocommerce Archive Sidebar', 'radium'),
                        'sub_desc' => __('Select a layout for Post Archives.', 'radium'),
                            'options' => array(
                                'right' => array('title' => '2 col right', 'img' => $framework->theme_framework_images_url.'/2cr.png'),
                                'left' => array('title' => '2 col left ', 'img' => $framework->theme_framework_images_url.'/2cl.png'),
                                'none' => array('title' => '1 col no sidebar', 'img' => $framework->theme_framework_images_url.'/1col.png'),
                                        ),//Must provide key => value(array:title|img) pairs for radio options
                        'std' => 'left',
                    ),

                    array(
                        'id' => 'woocommerce_footer_layout',
                        'type' => 'radio_img',
                        'title' => __('Woocommerce Footer Layout', 'radium'),
                        'sub_desc' => __('Select a layout for the woocommerce footer.', 'radium'),
                            'options' => array(
                                '' => array('title' => 'none',  'img' => $framework->theme_framework_images_url.'/footer-widgets-0.png'),
                                '100' => array('title' => '1 col', 'img' => $framework->theme_framework_images_url.'/footer-widgets-1.png'),
                                '50-50' => array('title' => '2 col', 'img' => $framework->theme_framework_images_url.'/footer-widgets-2.png'),
                                '33-33-33' => array('title' => '3 col', 'img' => $framework->theme_framework_images_url.'/footer-widgets-3.png'),
                                '25-25-25-25' => array('title' => '4 col', 'img' => $framework->theme_framework_images_url.'/footer-widgets-4.png'),
                            ),//Must provide key => value(array:title|img) pairs for radio options
                        'std' => '50-25-25',
                    ),

                    array(
                        'id' => 'footer_layout',
                        'type' => 'radio_img',
                        'title' => __('Footer Layout', 'radium'),
                        'sub_desc' => __('Select a layout for the footer.', 'radium'),
                            'options' => array(
                                '' => array('title' => 'none',  'img' => $framework->theme_framework_images_url.'/footer-widgets-0.png'),
                                '100' => array('title' => '1 col', 'img' => $framework->theme_framework_images_url.'/footer-widgets-1.png'),
                                '50-50' => array('title' => '2 col', 'img' => $framework->theme_framework_images_url.'/footer-widgets-2.png'),
                                '33-33-33' => array('title' => '3 col', 'img' => $framework->theme_framework_images_url.'/footer-widgets-3.png'),
                                '25-25-25-25' => array('title' => '4 col', 'img' => $framework->theme_framework_images_url.'/footer-widgets-4.png'),
                            ),//Must provide key => value(array:title|img) pairs for radio options
                        'std' => '50-25-25',
                    ),

                ),
              );

        $sections[] = array(
                'icon' => $framework->theme_framework_images_url.'/icons/icon-settings.png',
                'title' => __('Customize', 'radium'),
                'desc' => __(' ', 'radium'),
                'fields' => array(

                    array(
                            'id' => 'theme_style',
                            'type' => 'radio_img',
                            'title' => __('Theme Style', 'radium'),
                            'sub_desc' => __('Please select a main skin for your site. <br>(Colors can be customized further using the customizer.)', 'radium'),
                                'options' => array(
                                    'default' => array(
                                        'title' => __('Default Skin', 'radium'),
                                        'img' => $framework->theme_css_url.'/skins/default.jpg',
                                    ),
                                    'white' => array(
                                        'title' => __('Light Skin', 'radium'),
                                        'img' => $framework->theme_css_url.'/skins/white.jpg',
                                    ),

                                ),//Must provide key => value(array:title|img) pairs for radio options
                            'std' => 'default',
                        ),

                         array(
                             'id' => 'body_bg_pattern',
                             'type' => 'radio_img',
                             'title' => __('Background Styles', 'radium'),
                             'sub_desc' => __('Select a background style for the <strong>boxed</strong> layout.', 'radium'),
                                 'options' => array(
                                     'pattern_rad.png' => array(
                                         'title' => __('Default', 'radium'),
                                         'img' => $framework->theme_images_url.'/patterns/pattern_rad.png',
                                     ),
                                     'crissxcross.png' => array(
                                         'title' => 'CrissXcross',
                                         'img' => $framework->theme_images_url.'/patterns/crissxcross.png',
                                     ),
                                     'crossed_stripes.png' => array(
                                         'title' => 'Crossed_stripes',
                                         'img' => $framework->theme_images_url.'/patterns/crossed_stripes.png',
                                     ),
                                     'crosses.png' => array(
                                         'title' => 'Crosses',
                                         'img' => $framework->theme_images_url.'/patterns/crosses.png',
                                     ),
                                     'cubes.png' => array(
                                         'title' => 'Cubes',
                                         'img' => $framework->theme_images_url.'/patterns/cubes.png',
                                     ),
                                     'diagmonds.png' => array(
                                         'title' => 'Diagmonds',
                                         'img' => $framework->theme_images_url.'/patterns/diagmonds.png',
                                     ),
                                     'dark.jpg' => array(
                                         'title' => 'Dark',
                                         'img' => $framework->theme_images_url.'/patterns/dark.jpg',
                                     ),
                                     'fabric.jpg' => array(
                                         'title' => 'Fabric',
                                         'img' => $framework->theme_images_url.'/patterns/fabric.jpg',
                                     ),
                                     'graphy.png' => array(
                                         'title' => 'Graphy',
                                         'img' => $framework->theme_images_url.'/patterns/graphy.png',
                                     ),
                                     'kuji.png' => array(
                                         'title' => 'Kuji',
                                         'img' => $framework->theme_images_url.'/patterns/kuji.png',
                                     ),
                                     'micro_carbon.png' => array(
                                         'title' => 'Micro-carbon',
                                         'img' => $framework->theme_images_url.'/patterns/micro_carbon.png',
                                     ),
                                     'padded.png' => array(
                                         'title' => 'Padded',
                                         'img' => $framework->theme_images_url.'/patterns/padded.png',
                                     ),
                                     'plaid.png' => array(
                                         'title' => 'Plaid',
                                         'img' => $framework->theme_images_url.'/patterns/plaid.png',
                                     ),
                                     'project_papper.png' => array(
                                         'title' => 'Project papper',
                                         'img' => $framework->theme_images_url.'/patterns/project_papper.png',
                                     ),
                                     'px_by_gre3g.png' => array(
                                         'title' => 'Px_by_Gre3g',
                                         'img' => $framework->theme_images_url.'/patterns/px_by_gre3g.png',
                                     ),
                                     'random_grey_variations.png' => array(
                                         'title' => 'Random grey variations',
                                         'img' => $framework->theme_images_url.'/patterns/random_grey_variations.png',
                                     ),
                                     'vichy.png' => array(
                                         'title' => 'Vichy',
                                         'img' => $framework->theme_images_url.'/patterns/vichy.png',
                                     ),
                                     'wood_pattern_trans.png' => array(
                                         'title' => 'Wood pattern transparent',
                                         'img' => $framework->theme_images_url.'/patterns/wood_pattern_trans.png',
                                     ),
                                     'wood_pattern.png' => array(
                                         'title' => 'Wood pattern',
                                         'img' => $framework->theme_images_url.'/patterns/wood_pattern.png',
                                     ),
                                     'xv.png' => array(
                                         'title' => 'XV',
                                         'img' => $framework->theme_images_url.'/patterns/xv.png',
                                     ),
                                     '' => array(
                                         'title' => 'None',
                                         'img' => $framework->theme_images_url.'/patterns/none.png',
                                     ),
                                 ),//Must provide key => value(array:title|img) pairs for radio options
                             'std' => '',
                        ),

                        /*
                        array(
                            'id' => 'header_style',
                            'type' => 'select',
                            'title' => __('Header Style', 'radium'),
                            'sub_desc' => __('', 'radium'),
                                'options' => array(
                                    'dark' 	=> 'Dark',
                                    'default' => 'Default',
                                    'red' => 'Red',
                                    'green' => 'Green'
                                ),
                            'std' => 'left'
                        ), */

                        array(
                             'id' => 'main_bg',
                             'type' => 'background',
                             'title' => __('Upload a background image', 'radium'),
                             'sub_desc' => __('Upload an image to be used as the background here. This will override the ones above.', 'radium'),
                        ),

                    array(
                        'id' => 'custom_colors',
                        'type' => 'checkbox',
                        'title' => __('Enable Custom Colors', 'radium'),
                        'desc' => __('Enable to load styles from the customizer.', 'radium'),
                        'std' => 1,
                        'switch' => true,
                    ),

                     /*
                      * Custom Css
                      */
                    array(
                        'id' => 'user_custom_styles',
                        'type' => 'textarea',
                        'title' => __('Add Custom CSS', 'radium'),
                        'sub_desc' => __('Place more custom css here. Don&#39;t wrap it in &#60;style&#62; tags', 'radium'),
                        'std' => '',
                        ),
                    ),
                );

        if ($framework->theme_supports('primary', 'google_fonts')) {
            $sections[] = array(
                'icon' => $framework->theme_framework_images_url.'/icons/icon-typography.png',
                'title' => __('Typography', 'radium'),
                'desc' => __('<p class="description">These are the options for fonts used within the theme.</p>', 'radium'),
                'fields' => array(

                    array(
                        'id' => 'theme_default_typeface',
                        'type' => 'checkbox',
                        'title' => __('Disable Default Theme Typeface', 'radium'),
                        'desc' => __('Prevent the default typefaces that come with the theme from loading. (On means they are disabled)', 'radium'),
                        'sub_desc' => __('Useful if you intend on using the typographer manager below', 'radium'),
                        'std' => 0,
                        'switch' => true,
                    ),

                    /* array(
                        'id'            => 'logotext',
                        'type'          => 'typography',
                        'title'         => __('Logo Typography', 'radium'),
                        "desc" 			=> __("Select the font and style for the site header text.", "radium"),
                        'subdesc'      	=> __('Typography option with each property can be called individually.', 'radium'),
                        //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                        'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'       => false, // Only appears if google is true and subsets not set to false
                        //'font-size'     => false,
                        //'line-height'   => false,
                        //'word-spacing'  => true,  // Defaults to false
                        //'letter-spacing'=> true,  // Defaults to false
                        //'color'         => false,
                        'preview'       => true, // Disable the previewer
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'selector'      => 'h2.site-description, .side-id', // An array of CSS selectors to apply this font style to dynamically
                        'units'         => 'px', // Defaults to px
                        'default'       => array(
                            'color'         => '#333',
                            'font-style'    => '700',
                            'font-family'   => 'Abel',
                            'google'        => true,
                            'font-size'     => '33px',
                            'line-height'   => '40px'
                        ),
                    ), */

                    array(
                        'title' => __('Primary Typeface', 'radium'),
                        'name' => '',
                        'desc' => __('Select the font and style for the body text.', 'radium'),
                        'id' => 'primary_typeface',
                        'selector' => 'html, body',
                        'type' => 'typography',
                        'preview' => array('text' => __('The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. 1234567890', 'radium')),
                        'default' => array(
                            'font-style' => '700',
                            'font-family' => 'Lato',
                            'google' => '16px',
                            'font-size' => '33px',
                            'line-height' => '29px',
                        ),
                    ),

                    array(
                        'title' => __('Secondary Typeface', 'radium'),
                        'name' => '',
                        'desc' => __('Select the font and style for the title.', 'radium'),
                        'id' => 'secondary_typeface',
                        'selector' => 'h1, h2, h3, h4, h5, h6, .main_menu>ul>li>a, .main_menu>ul>li>a strong, #bottom-footer #footer-menu ul li a, .nav-tabs>li a, #colophon #theme-credits, .top-news .number, #main-menu .menu-item-object-category .sub-mega-wrap>ul>li .subcat-title, .widget_radium_post_tabs .tab-hold #tabs>li, .breadcrumb, .widget_radium_social_fans, #header .site-navigation .search-form .container input[type=text], #main-menu .menu-item-object-category.has-cat-megamenu .sub-mega-wrap>ul .subcat-title, .site-header-toolbar .menu.right>li>a, .site-header-toolbar .top-menu>li>a, #main-menu .menu-item-object-category.has-cat-megamenu .sub-mega-wrap:not(.single-cat) .sub-menu>li>a, .main_menu>ul>li>a, .main_menu>ul>li>a .menu-title-outer, .single .post-side-share .title, .video-central-nav-tabs>li, .site-header-toolbar .bag-header, #header .site-id, #header .site-id a, .fallback_menu .radium_mega>li>a, .buddypress div.item-list-tabs ul li a, .buddypress div.item-list-tabs ul li span, .buddypress div.item-list-tabs ul li a, .buddypress div.item-list-tabs ul li span, .buddypress div.poster-meta, .buddypress .item-list .activity-content .activity-header, .buddypress .item-list .activity-content .comment-header, .widget .swa-activity-list .swa-activity-content .swa-activity-header, .widget .swa-activity-list .swa-activity-content .comment-header, .buddypress div.activity-comments div.acomment-meta, .widget div.swa-activity-comments div.acomment-meta, li.bbp-forum-info, li.bbp-topic-title, #bbpress-forums li.bbp-header, #bbpress-forums fieldset.bbp-form legend, form label',
                        'type' => 'typography',
                        'preview' => array('text' => __('The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. 1234567890', 'radium')),
                        //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'font-size' => false,
                        'line-height' => false,
                        //'word-spacing'  => true,  // Defaults to false
                        //'letter-spacing'=> true,  // Defaults to false
                        'color' => false,
                        'text-align' => false,
                        'text-shadow' => false,
                        'text-decoration' => false,
                        'text-shadow' => false,
                        'text-transform' => false,
                        'default' => array(
                            'font-style' => '700',
                            'font-family' => 'Lato',
                        ),
                    ),

                    array(
                        'title' => 'Custom Typography',
                        'name' => 'Selector Groups',
                        'desc' => __('Add a new selector group (comma delimited) to generate a font style option below. You must save the options first to customize.', 'radium'),
                        'id' => 'user_font_selectors',
                        'selector' => 'h1',
                        'type' => 'multi_typography',
                        'placeholder' => __('Add New Selector Group', 'radium'),
                    ),

                    ),
                );
        }

        $sections[] = array(
                'icon' => $framework->theme_framework_images_url.'/icons/icon-social.png',
                'title' => __('Social Profiles', 'radium'),
                'desc' => __('', 'radium'),
                'fields' => array(
                        array(
                            'id' => 'twitter_username',
                            'type' => 'text',
                            'title' => __('Twitter', 'radium'),
                            'sub_desc' => __('Your Twitter username (no @).', 'radium'),
                            'desc' => '',
                            'std' => '',
                            ),
                        array(
                            'id' => 'facebook_page_url',
                            'type' => 'text',
                            'title' => __('Facebook Page Id', 'radium'),
                            'sub_desc' => __('Your facebook page/profile id', 'radium')."(<a target='_blank' href='http://findmyfbid.com/'>more Info</a>)",
                            'desc' => '',
                            'std' => '',
                            ),

                        array(
                            'id' => 'facebook_page_access_token',
                            'type' => 'text',
                            'title' => __('Facebook App ID', 'radium'),
                            'sub_desc' => __('Your facebook page/profile id', 'radium')."(<a target='_blank' href='http://hellboundbloggers.com/2010/07/10/find-facebook-profile-and-page-id/'>more Info</a>)",
                            'desc' => '',
                            'std' => '',
                            ),
                         array(
                             'id' => 'facebook_page_access_secret',
                             'type' => 'text',
                             'title' => __('Facebook Page Access Secret', 'radium'),
                             'sub_desc' => __('Your facebook page/profile id', 'radium')."(<a target='_blank' href='http://hellboundbloggers.com/2010/07/10/find-facebook-profile-and-page-id/'>more Info</a>)",
                             'desc' => '',
                             'std' => '',
                             ),

                        array(
                            'id' => 'dribbble_username',
                            'type' => 'text',
                            'title' => __('Dribbble', 'radium'),
                            'sub_desc' => __('Your Dribbble username', 'radium'),
                            'desc' => '',
                            'std' => '',
                            ),

                            array(
                                'id' => 'dribbble_access_token',
                                'type' => 'text',
                                'title' => __('Dribbble Access Token', 'radium'),
                                'sub_desc' => __("Genererate one <a href='https://dribbble.com/account/applications' target='_blank'>here</a>", 'radium'),
                                'desc' => '',
                                'std' => '',
                                ),

                        array(
                            'id' => 'tumblr_username',
                            'type' => 'text',
                            'title' => __('Tumblr', 'radium'),
                            'sub_desc' => __('Your Tumblr username', 'radium'),
                            'desc' => '',
                            'std' => '',
                            ),
                        array(
                            'id' => 'spotify_username',
                            'type' => 'text',
                            'title' => __('Spotify', 'radium'),
                            'sub_desc' => __('Your Spotify username', 'radium'),
                            'desc' => '',
                            'std' => '',
                            ),
                        array(
                            'id' => 'skype_username',
                            'type' => 'text',
                            'title' => __('Skype', 'radium'),
                            'sub_desc' => __('Your Skype username', 'radium'),
                            'desc' => '',
                            'std' => '',
                            ),
                        array(
                            'id' => 'linkedin_page_url',
                            'type' => 'text',
                            'title' => __('LinkedIn', 'radium'),
                            'sub_desc' => __('Your LinkedIn page/profile url', 'radium'),
                            'desc' => '',
                            'std' => '',
                            ),
                        array(
                            'id' => 'lastfm_username',
                            'type' => 'text',
                            'title' => __('Last.fm', 'radium'),
                            'sub_desc' => __('Your Last.fm username', 'radium'),
                            'desc' => '',
                            'std' => '',
                            ),
                        array(
                            'id' => 'googleplus_page_url',
                            'type' => 'text',
                            'title' => __('Google+', 'radium'),
                            'sub_desc' => __('Your Google+ account or ID', 'radium'),
                            'desc' => '',
                            'std' => '',
                            ),

                        array(
                            'id' => 'googleplus_api_key',
                            'type' => 'text',
                            'title' => __('Google+ API Key', 'radium'),
                            'sub_desc' => __('Your Google+ api key', 'radium'),
                            'desc' => '',
                            'std' => '',
                            ),

                        array(
                            'id' => 'flickr_page_url',
                            'type' => 'text',
                            'title' => __('Flickr', 'radium'),
                            'sub_desc' => __('Your Flickr page url', 'radium'),
                            'desc' => '',
                            'std' => '',
                            ),
                        array(
                            'id' => 'youtube_channel_id',
                            'type' => 'text',
                            'title' => __('YouTube Channel ID', 'radium'),
                            'sub_desc' => __('Your YouTube channel id', 'radium'),
                            'desc' => '',
                            'std' => '',
                            ),
                        array(
                            'id' => 'youtube_api_key',
                            'type' => 'text',
                            'title' => __('YouTube Api key', 'radium'),
                            'sub_desc' => __('Your YouTube api key id', 'radium'),
                            'desc' => '',
                            'std' => '',
                            ),

                        array(
                            'id' => 'vimeo_username',
                            'type' => 'text',
                            'title' => __('Vimeo Channel ID', 'radium'),
                            'sub_desc' => __('Your Vimeo channel ID', 'radium'),
                            'desc' => '',
                            'std' => '',
                            ),
                        array(
                            'id' => 'behance_username',
                            'type' => 'text',
                            'title' => __('Behance', 'radium'),
                            'sub_desc' => __('Your Behance username', 'radium'),
                            'desc' => '',
                            'std' => '',
                            ),
                        array(
                            'id' => 'behance_api_key',
                            'type' => 'text',
                            'title' => __('Behance API key', 'radium'),
                            'sub_desc' => __("Get a Behance api key here <a href='https://www.behance.net/dev'>https://www.behance.net/dev</a>", 'radium'),
                            'desc' => '',
                            'std' => '',
                            ),
                        array(
                            'id' => 'pinterest_username',
                            'type' => 'text',
                            'title' => __('Pinterest full URL (Beta)', 'radium'),
                            'sub_desc' => __('Your Pinterest full URL (Beta) including http://', 'radium'),
                            'desc' => '',
                            'std' => '',
                            'validate' => 'url',
                            ),
                        array(
                            'id' => 'yelp_url',
                            'type' => 'text',
                            'title' => __('Yelp', 'radium'),
                            'sub_desc' => __('Your Yelp URL', 'radium'),
                            'desc' => '',
                            'std' => '',
                            ),
                        array(
                            'id' => 'instagram_username',
                            'type' => 'text',
                            'title' => __('Instagram', 'radium'),
                            'sub_desc' => __('Your Instagram username', 'radium'),
                            'desc' => '',
                            'std' => '',
                            ),
                      array(
                          'id' => 'instagram_access_token',
                          'type' => 'text',
                          'title' => __('Instagram Access Token', 'radium'),
                          'sub_desc' => __('Your Instagram Access Token <a href="http://instagram.com/developer">http://instagram.com/developer.</a>', 'radium'),
                          'desc' => '',
                          'std' => '',
                          ),
                      array(
                          'id' => 'soundcloud_username',
                          'type' => 'text',
                          'title' => __('SoundCloud', 'radium'),
                          'sub_desc' => __('Your SoundCloud username', 'radium'),
                          'desc' => '',
                          'std' => '',
                          ),

                      array(
                          'id' => 'soundcloud_clientid',
                          'type' => 'text',
                          'title' => __('SoundCloud Client ID', 'radium'),
                          'sub_desc' => __("A SoundCloud client id is needed in order to get number of fans. Get the id by visiting <a href='http://soundcloud.com/you/apps/new'>http://soundcloud.com/you/apps/new</a>", 'radium'),
                          'desc' => '',
                          'std' => '',
                          ),
                    ),
                );

        $sections[] = array(
            'icon' => $framework->theme_framework_images_url.'/icons/icon-performance.png',
            'title' => __('Performance (Beta)', 'radium'),
            'desc' => __('', 'radium'),
            'fields' => array(
                    array(
                        'id' => 'query_transient',
                        'type' => 'checkbox_hide_below',
                        'title' => __('Cache Queries Using Transients', 'radium'),
                        'sub_desc' => __("Enable caching of queries using the transient API. Learn More <a href='http://codex.wordpress.org/Transients_API'>http://codex.wordpress.org/Transients_API</a>. Disable this option if you are using a Caching plugin.", 'radium'),
                        'desc' => '',
                        'std' => '1',
                        'switch' => true,
                    ),
                    array(
                        'id' => 'query_transient_cache_time',
                        'type' => 'text',
                        'title' => __('Cache Time', 'radium'),
                        'sub_desc' => __('How often to refresh the cache in seconds. eg 600', 'radium'),
                        'desc' => '',
                        'std' => '600',
                        'validate' => 'numeric',
                        ),
            ),
           );

        return apply_filters(__FUNCTION__, $sections);
    }//function

add_filter('radium-opts-sections-'.$framework->theme_option_name, 'radium_load_framework_theme_options');
}
