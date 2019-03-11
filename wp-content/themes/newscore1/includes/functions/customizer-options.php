<?php

/**
 * Setup theme for customizer options.
 */
function radium_get_theme_customizer_options(){

        /* color properties
            - border-color
            - color
            - background-color
        */

        /* Sample config
            'id here' => array(
                'color' => '',
                'background-color' => '',
                'border-color' => '',
                'border-bottom-color' => '', //etc, any colored property will do
            ),
        */

        // Setup logo options
        $options['header_tools_options'] = array(

            'header_tools_bg_color' => array(
                'name' 		=> __( 'Background Color', 'radium' ),
                'id'		=> 'header_tools_bg_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '',
                    'background-color' => '#header .site-header-toolbar',
                ),
            ),

            'header_tools_border_color' => array(
                'name' 		=> __( 'Border Color', 'radium' ),
                'id' 		=> 'header_tools_border_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'border-color' => '#header .site-header-toolbar'
                ),
            ),

            'header_tools_color' => array(
                'name' 		=> __( 'Text Color', 'radium' ),
                'id' 		=> 'header_tools_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '#header .site-header-toolbar',
                ),
            ),

            'header_tools_links_color' => array(
                'name' 		=> __( 'Links Color', 'radium' ),
                'id' 		=> 'header_tools_links_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '.site-header-toolbar .menu.right>li>a, .site-header-toolbar .top-menu>li>a ',
                ),
            ),

            'header_tools_hover_accent_color' => array(
                'name' 		=> __( 'Hover Accent Color', 'radium' ),
                'id' 		=> 'header_tools_hover_accent_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'background-color' => '.site-header-toolbar .menu.right>li:after,
                    .site-header-toolbar .top-menu>li:after,
                    .orange.button.transparent:after',
                ),
            ),

            'header_tools_dropdown_bg_color' => array(
                'name' 		=> __( 'DropDown Background Color', 'radium' ),
                'id' 		=> 'header_tools_dropdown_bg_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'background-color' => '.site-header-toolbar .header-tools>ul>li .sub-menu',
                    'border-bottom-color' => '.site-header-toolbar .header-tools>ul>li .sub-menu li:first-child:before'
                ),
            ),

            'header_tools_dropdown_color' => array(
                'name' 		=> __( 'DropDown Color', 'radium' ),
                'id' 		=> 'header_tools_dropdown_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '.site-header-toolbar .header-tools>ul>li .sub-menu,
                    .site-header-toolbar .header-tools .account-item .user-info-details .username_container .user_email, .site-header-toolbar .header-tools .account-item .user-info-details .username_container .user_login,
                    .site-header-toolbar .bag-empty, .site-header-toolbar .wishlist-empty,
                    .site-header-toolbar .header-tools>ul>li .sub-menu .bag-product-price, .site-header-toolbar .header-tools>ul>li .sub-menu .bag-product-quantity',
                ),
            ),

            'header_tools_dropdown_title_color' => array(
                'name' 		=> __( 'DropDown Title Color', 'radium' ),
                'id' 		=> 'header_tools_dropdown_title_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '.site-header-toolbar .bag-header,
                    .site-header-toolbar .header-tools .account-item .user-info-details .username_container span.display_name',
                ),
            ),

            'header_tools_dropdown_links_color' => array(
                'name' 		=> __( 'DropDown Links Color', 'radium' ),
                'id' 		=> 'header_tools_dropdown_links_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '.site-header-toolbar .header-tools>ul>li .sub-menu li a',
                ),
            ),

            'header_tools_dropdown_accent_color' => array(
                'name' 		=> __( 'DropDown Accent Color', 'radium' ),
                'id' 		=> 'header_tools_dropdown_accent_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '.site-header-toolbar .orange.button.transparent, .site-header-toolbar .header-tools>ul>li .sub-menu li a.button',
                    'background-color' => '.site-header-toolbar .orange.button.transparent',
                ),
            ),

            'header_tools_dropdown_border_color' => array(
                'name' 		=> __( 'DropDown Border Color', 'radium' ),
                'id' 		=> 'header_tools_dropdown_border_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'border-color' => '.site-header-toolbar .bag-header,
                    .site-header-toolbar .bag-empty, .site-header-toolbar .wishlist-empty,
                    .site-header-toolbar .header-tools .account-item .user-info-details,
                    .site-header-toolbar .header-tools .account-item .user-info-extra-links,
                    .site-header-toolbar .header-tools .account-item .user-info-nav-primary ul li,
                    .site-header-toolbar .bag-product'
                ),
            ),

        );

        radium_add_customizer_section( 'header_tools_options', __( 'Header Tools', 'radium' ), $options['header_tools_options'], 1 );

        // Setup logo options
        $options['header_options'] = array(

            'header_bg_color' => array(
                'name' 		=> __( 'Background Color', 'radium' ),
                'id'		=> 'header_bg_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '',
                    'background-color' => '#header',
                ),
            ),
            'header_color' => array(
                'name' 		=> __( 'Text Color', 'radium' ),
                'id' 		=> 'header_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '#header',
                ),
            ),

            'header_links_color' => array(
                'name' 		=> __( 'Links Color', 'radium' ),
                'id' 		=> 'header_links_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '#header',
                ),
            ),

            'header_menu_top_level_bg_color' => array(
                'name'      => __( 'Top Level Menu Background Color', 'radium' ),
                'id'        => 'header_menu_top_level_bg_color',
                'type'      => 'color',
                'transport' => 'postMessage',
                'selectors' 	=> array(
                    'background-color' => '#header .site-navigation .nav-primary, .header-style-default #header .site-navigation .nav-primary.stuck',
                ),
            ),

            'header_menu_top_level_links_color' => array(
                'name'      => __( 'Top Level Menu Links Color', 'radium' ),
                'id'        => 'header_menu_top_level_links_color',
                'type'      => 'color',
                'transport' => 'postMessage',
                'selectors' 	=> array(
                    'color' => '.header-style-default .main_menu>ul>li>a, .header-style-default .main_menu>ul>li>a .submenu-link>.menu-title-outer',
                ),
            ),

            'header_menu_top_level_border_color' => array(
                'name'      => __( 'Top Level Menu Border Color', 'radium' ),
                'id'        => 'header_menu_top_level_border_color',
                'type'      => 'color',
                'transport' => 'postMessage',
                'selectors' 	=> array(
                    'border-color' => '#header .site-navigation .nav-primary, .header-style-default #header .site-navigation .nav-primary.stuck'
                ),
             ),

             'header_menu_top_level_hover_color' => array(
                 'name'      => __( 'Top Level Menu Hover Color', 'radium' ),
                 'id'        => 'header_menu_top_level_hover_color',
                 'type'      => 'color',
                 'transport' => 'postMessage',
                 'selectors' 	=> array(
                     'color' => '.main_menu>ul>li:hover>a, .header-style-default .main_menu>ul>li:hover>a, .header-style-default .main_menu>ul>li:hover>a .submenu-link>.menu-title-outer'
                 ),
              ),

            'header_menu_bg_color' => array(
                'name'      => __( 'DropDown Menu Background Color', 'radium' ),
                'id'        => 'header_menu_bg_color',
                'type'      => 'color',
                'transport' => 'postMessage',
                'selectors' 	=> array(
                    'background-color' => '.main_menu .radium_mega .radium-mega-div,
                    .main_menu .radium_mega > li > ul,
                    .main_menu .radium_mega > li > ul ul,
                    #main-menu .menu-item-object-category.has-cat-megamenu .sub-mega-wrap,
                    #main-menu .menu-item-object-video_category.has-cat-megamenu .sub-mega-wrap,
                    .main_menu>ul>li li ul.sub-menu,
                    .main_menu>ul>li>.sub-menu ',
                ),
            ),

            'header_menu_links_color' => array(
                'name' 		=> __( 'DropDown Menu Links Color', 'radium' ),
                'id' 		=> 'header_menu_links_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '.main_menu a,
                    #main-menu .menu-item-object-category .sub-mega-wrap:not(.single-cat) .sub-menu>li.active a,
                    #main-menu .menu-item-object-category .sub-mega-wrap:not(.single-cat) .sub-menu>li:hover a,
                    #main-menu .menu-item-object-video_category .sub-mega-wrap:not(.single-cat) .sub-menu>li.active a,
                    #main-menu .menu-item-object-video_category .sub-mega-wrap:not(.single-cat) .sub-menu>li:hover a ',
                ),
            ),

            'header_menu_border_color' => array(
                'name' 		=> __( 'DropDown Menu Border Color', 'radium' ),
                'id' 		=> 'header_menu_border_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '',
                    'border-color' => '#main-menu .menu-item-object-category .sub-mega-wrap:not(.single-cat) .sub-menu>li:first-child,
                    #main-menu .menu-item-object-category .sub-mega-wrap:not(.single-cat) .sub-menu>li,
                    #main-menu .menu-item-object-category .sub-mega-wrap:not(.single-cat) .sub-menu,
                    #main-menu .menu-item-object-category .sub-mega-wrap li,
                    #main-menu .menu-item-object-category .sub-mega-wrap:not(.single-cat) .sub-menu>li:first-child,
                    #main-menu .menu-item-object-video_category .sub-mega-wrap:not(.single-cat) .sub-menu>li,
                    #main-menu .menu-item-object-video_category .sub-mega-wrap:not(.single-cat) .sub-menu,
                    #main-menu .menu-item-object-video_category .sub-mega-wrap li,
                    .main_menu>ul>li>ul li,
                    #main-menu .menu-item-object-category .sub-mega-wrap .subcat,
                    #main-menu .menu-item-object-category .sub-mega-wrap li:last-child,
                    #main-menu .menu-item-object-video_category .sub-mega-wrap .subcat,
                    #main-menu .menu-item-object-video_category .sub-mega-wrap li:last-child,
                    .main_menu .radium-mega-menu-columns ul li,
                    .main_menu .radium-mega-div .mega-title',
                    'border-bottom-color' => '.main_menu > ul > li ul ul li'
                ),
            ),

            'header_menu_hover_accent_color' => array(
                'name' 		=> __( 'DropDown Menu Hover Accent Color', 'radium' ),
                'id' 		=> 'header_menu_hover_accent_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(

                    'color' => '.main_menu>ul>li.current-menu-item>a,
                    .main_menu>ul>li.current-menu-item>a .menu-title-outer,
                    .main_menu>ul>li.current-menu-parent>a,
                    .main_menu>ul>li.current-menu-parent>a .menu-title-outer,
                    #main-menu .menu-item-object-category .sub-mega-wrap .subcat a:hover,
                    #main-menu .menu-item-object-video_category .sub-mega-wrap .subcat a:hover,
                    .main_menu .radium-mega-menu-columns ul li a:hover,
                    .main_menu>ul>li>ul li a:hover',

                    'background-color' => '.main_menu>ul>li>a:after,
                    #main-menu .menu-item-object-category .sub-mega-wrap .sub-menu>li.cat-post:after,
                    #main-menu .menu-item-object-video_category .sub-mega-wrap .sub-menu>li.cat-post:after,
                    .main_menu>ul>li>ul li:after,
                    .main_menu>ul>li div ul li li:after,
                    .main_menu .radium-mega-menu-columns ul li a:after,
                    .main_menu>ul>li>a:after,
                    #main-menu .menu-item-object-category.has-cat-megamenu .sub-mega-wrap:not(.single-cat) .sub-menu > li:hover, #main-menu .menu-item-object-category.has-cat-megamenu .sub-mega-wrap:not(.single-cat) .sub-menu > li.active, #main-menu .menu-item-object-video_category.has-cat-megamenu .sub-mega-wrap:not(.single-cat) .sub-menu > li:hover, #main-menu .menu-item-object-video_category.has-cat-megamenu .sub-mega-wrap:not(.single-cat) .sub-menu > li.active',

                    'border-color' => '#main-menu .menu-item-object-category.has-cat-megamenu .sub-mega-wrap,
                    #main-menu .menu-item-object-video_category.has-cat-megamenu .sub-mega-wrap,
                    .main_menu ul>li>ul.sub-menu,
                    .main_menu .radium-mega-div, .radium-mega-hr',

                    'border-left-color' => '#main-menu .menu-item-object-category .sub-mega-wrap:not(.single-cat) .sub-menu>li.active:after,
                    #main-menu .menu-item-object-category .sub-mega-wrap:not(.single-cat) .sub-menu>li:hover:after,
                    #main-menu .menu-item-object-video_category .sub-mega-wrap:not(.single-cat) .sub-menu>li.active:after,
                    #main-menu .menu-item-object-video_category .sub-mega-wrap:not(.single-cat) .sub-menu>li:hover:after,#main-menu .menu-item-object-category.has-cat-megamenu .sub-mega-wrap:not(.single-cat) .sub-menu > li:hover:after, #main-menu .menu-item-object-category.has-cat-megamenu .sub-mega-wrap:not(.single-cat) .sub-menu > li.active:after, #main-menu .menu-item-object-video_category.has-cat-megamenu .sub-mega-wrap:not(.single-cat) .sub-menu > li:hover:after, #main-menu .menu-item-object-video_category.has-cat-megamenu .sub-mega-wrap:not(.single-cat) .sub-menu > li.active:after',

                    'border-bottom-color' => '.main_menu>ul>li div.sub-mega-wrap.radium-mega-div:before,
                    .main_menu ul>li>ul.sub-menu li:first-child>a:after,
                    .main_menu>ul>li>a.open-mega-a:before,
                    .main_menu>ul>li>a.open-sub-a:before, #main-menu .menu-item-object-category.has-cat-megamenu .sub-mega-wrap:not(.single-cat) .sub-menu > li:hover, #main-menu .menu-item-object-category.has-cat-megamenu .sub-mega-wrap:not(.single-cat) .sub-menu > li.active, #main-menu .menu-item-object-video_category.has-cat-megamenu .sub-mega-wrap:not(.single-cat) .sub-menu > li:hover, #main-menu .menu-item-object-video_category.has-cat-megamenu .sub-mega-wrap:not(.single-cat) .sub-menu > li.active'
                ),
            ),

            'header_extras_bg_color' => array(
                'name'      => __( 'Header Extras BG Color', 'radium' ),
                'id'        => 'header_extras_bg_color',
                'type'      => 'color',
                'transport' => 'postMessage',
                'selectors' 	=> array(
                    'background-color' => '.top-news, #header-nav-extras',
                ),
            ),

            'header_extras_color' => array(
                'name'      => __( 'Header Extras Color', 'radium' ),
                'id'        => 'header_extras_color',
                'type'      => 'color',
                'transport' => 'postMessage',
                'selectors' 	=> array(
                    'color' => '.top-news,
                    #header-nav-extras,
                    .top-news a,
                    .top-news a:hover,
                    #header-nav-extras a,
                    #header-nav-extras a:hover',
                ),
            ),

            'header_ticker_title_bg' => array(
                'name'      => __( 'Header Ticker Title BG', 'radium' ),
                'id'        => 'header_ticker_title_bg',
                'type'      => 'color',
                'transport' => 'postMessage',
                'selectors' 	=> array(
                    'background-color' => '.breaking-banner .meta-bar-title',
                    'border-left-color' => '.breaking-banner .meta-bar-title:after'
                ),
            ),

            'header_ticker_title_color' => array(
                'name'      => __( 'Header Ticker Title Color', 'radium' ),
                'id'        => 'header_ticker_title_color',
                'type'      => 'color',
                'transport' => 'postMessage',
                'selectors' 	=> array(
                    'color' => '.breaking-banner .meta-bar-title h3 a',
                ),
            ),

            'header_ticker_bg' => array(
                'name'      => __( 'Header Ticker BG', 'radium' ),
                'id'        => 'header_ticker_bg',
                'type'      => 'color',
                'transport' => 'postMessage',
                'selectors' 	=> array(
                    'background-color' => '.breaking-banner .story',
                ),
            ),

            'header_ticker_color' => array(
                'name'      => __( 'Header Ticker Color', 'radium' ),
                'id'        => 'header_ticker_color',
                'type'      => 'color',
                'transport' => 'postMessage',
                'selectors' 	=> array(
                    'color' => '.breaking-banner .meta-bar a, .breaking-banner .story-h a',
                ),
            ),

        );
        radium_add_customizer_section( 'header_options', __( 'Header', 'radium' ), $options['header_options'], 2 );

        // Setup main styles options
        $options['main_styles_options'] = array(

            'body_bg_color' => array(
                'name' 		=> __( 'Body Background Color', 'radium' ),
                'id'		=> 'body_bg_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'background-color' => 'html, body',
                ),
            ),

            'body_text_color' => array(
                'name' 		=> __( 'Main Content Text Color', 'radium' ),
                'id'		=> 'body_text_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => 'body, p, .widget li a',
                ),
            ),

            'body_darker_text_color' => array(
                'name' 		=> __( 'Main Content Darker Text Color', 'radium' ),
                'id'		=> 'body_darker_text_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => 'code,
                    textarea:focus,
                    .comment-author a,
                    .author-description,
                    .comment-author cite,
                    .archives-list ul li a:hover,
                    .post-password-required .entry-content label,
                    .section .widget_radium_tweets li,
                    .white-bg *,
                    .entry-content p a:hover,

                    input[type="text"]:hover,
                    input[type="text"]:focus,
                    input[type="password"]:hover,
                    input[type="password"]:focus,
                    input[type="date"]:hover,
                    input[type="date"]:focus,
                    input[type="datetime"]:hover,
                    input[type="datetime"]:focus,
                    input[type="email"]:hover,
                    input[type="email"]:focus,
                    input[type="number"]:hover,
                    input[type="number"]:focus,
                    input[type="search"]:hover,
                    input[type="search"]:focus,
                    input[type="tel"]:hover,
                    input[type="tel"]:focus,
                    input[type="time"]:hover,
                    input[type="time"]:focus,
                    input[type="url"]:hover,
                    input[type="url"]:focus,
                    textarea:hover,
                    textarea:focus',
                ),
            ),

            'body_text_secondary_color' => array(
                'name' 		=> __( 'Main Content Secondary Text Color', 'radium' ),
                'id'		=> 'body_text_secondary_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '.post .post-excerpt p,
                    .post .post-excerpt, .about-author .inner>h3,
                    #related-posts>h3,
                    #comments #reply-title, #comments>h3,
                    .radium-theme-pagination ul li span.current,
                    .cross-sells.products .widget .widget-title,
                    .related.products .widget .widget-title,
                    .upsells.products .widget .widget-title,
                    .section-title',
                    'background-color' => '.single main footer.meta strong,
                    .single-video footer.meta strong',
                    'border-color' => ''
                ),
            ),

            'body_title_color' => array(
                'name' 		=> __( 'Main Title Color', 'radium' ),
                'id'		=> 'body_title_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '#page-header h1,
                    h1, h2, h3, h4, h5, h6,
                    .post .entry-header h1,
                    .blog-grid-items .small .entry-title a,
                    .blog-grid-items .smaller .entry-title a,
                    .blog-grid-items .small-thumbs .entry-title a,
                    .video-central ul.video-central-list > li > .entry-title a,
                    .widget_radium_post_tabs .tab-hold #tabs>li a,
                    .widget .widget-title,
                    .widget_radium_post_tabs .has-popular-posts.has-recent-posts .tab-hold #tabs>li.comments:before,
                    .wpcf7-form p,
                    .entry-rating .user-rating span,
                    #builder-container .entry-element-title h3,
                    .content-list-small .entry-header .entry-title a,
                    .featured ul li .entry-title a,
                    .widget_radium_social_fans .fans-home-number,
                    .nav-tabs>li.active a, .nav-tabs>li.active:hover a,
                    .recent-posts-carousel .entry-summary .entry-title a',
                ),
            ),

            'body_blockquote_color' => array(
                'name' 		=> __( 'Main Blockquote Color', 'radium' ),
                'id'		=> 'body_blockquote_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '',
                    'background-color' => '',
                    'border-color' => ''
                ),
            ),

            'accent_color' => array(
                'name' 		=> __( 'Accent Color', 'radium' ),
                'id' 		=> 'accent_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '.logged-in-as a,
                        .entry-content p a,
                        .comment-reply-link:hover,
                        .widget_radium_post_tabs .tab-hold #tabs>li.popular:before,
                        #bottom-footer ul li a:hover,
                        #bottom-footer #footer-menu ul li a:hover,
                        .product-small .entry-summary a ,
                        .product_meta a,
                        .woocommerce .product form.cart .variations .reset_variations,
                        .woocommerce-main-image.zoom:hover [class^=icon-],
                        .woocommerce-review-link,
                        .woocommerce .yith-wcwl-add-to-wishlist a:hover,
                        .video-central-single-video-meta .video-central-entry-author .video-central-author-name,
                        .author-desc a,
                        .not-found-message p a, #cancel-comment-reply-link, .logged-in-as a, #header .site-id a',

                    'background-color' => '::selection,
                        button.button,
                        .btn[type="submit"],
                        input[type="button"],
                        input[type="reset"],
                        input[type="submit"],
                        .button[type="submit"],
                        .widget_radium_recent_posts .post-thumb:hover .format-icon,
                        .woocommerce .quick-view,
                        .woocommerce ul.products li.product-category h3,
                        .radium-gallery.thumbnails > a:before,
                        .radium-gallery-item > a:before,
                        .widget table#wp-calendar a,
                        .like.like-complete a.like-object div.like-opening div.like-circle,
                        div.like-opening div.like-circle,
                        .video-central-nav-tabs > li:after,
                        #gototop:hover',

                    'border-color' => '#builder-container .entry-element-title,
                        .nav-tabs,
                        .pagination-wrapper a:hover,
                        .pagination-wrapper a.current,
                        .tagcloud a,
                        .woocommerce .woocommerce-pagination ul li.current,
                        .woocommerce .woocommerce-pagination ul li:hover,
                        .woocommerce-main-image.zoom:hover [class^=icon-],
                        .woocommerce .yith-wcwl-add-to-wishlist a:hover,
                        div.like-opening,
                        .video-home-slider-grid .video-wall-wrap .carousel-nav li.active .thumb,  .shop_table .product-name a, .woocommerce table.shop_table tr td.product-remove .remove, .tagcloud a',
                        'background-color' => '.loading-dots span,  ::selection, button.button, .btn[type="submit"], input[type="button"], input[type="reset"], input[type="submit"], .button[type="submit"], .widget_radium_recent_posts .post-thumb:hover .format-icon, .woocommerce .quick-view, .woocommerce ul.products li.product-category h3, .radium-gallery.thumbnails > a:before, .radium-gallery-item > a:before, .widget table#wp-calendar a, .like.like-complete a.like-object div.like-opening div.like-circle, div.like-opening div.like-circle, .video-central-nav-tabs > li:after, #gototop:hover'
                ),
            ),

            'secondary_accent_color' => array(
                'name' 		=> __( 'Secondary Accent Color', 'radium' ),
                'id' 		=> 'secondary_accent_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'background-color' => '.entry-category.none,
                        .btn:hover,
                        .button:hover,
                        button.button:hover,
                        .btn[type="submit"]:hover,
                        input[type="reset"]:hover,
                        input[type="submit"]:hover,
                        input[type="button"]:hover,
                        .format-link .link-wrapper,
                        .button[type="submit"]:hover,
                        .widget_radium_cta .button.cta,
                        .form-submit input[type="submit"]:hover',
                ),
            ),

            'body_border_color' => array(
                'name' 		=> __( 'Border Color', 'radium' ),
                'id'		=> 'body_border_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '.recent-posts-carousel .control.next:before,
                        .recent-posts-carousel .control.prev:before',
                        'border-color' => '.recent-posts-carousel .control.prev,
                        .recent-posts-carousel .control.next,
                        .recent-posts-carousel-container,
                        #builder-container.sidebar-right,
                        .page-template-page-templatespage-home-php #builder-container,
                        .page-template-page-templatespage-home-php .builder-main,
                        main.sidebar-right,
                        #builder-container.sidebar-left,
                        main.sidebar-left,
                        #comments .comment-body,
                        .widget_radium_post_tabs .tab-hold #tabs>li,
                        .widget_radium_post_tabs .tab-hold #tabs>li.comments,
                        .content-list-small,
                        #page-header>.row,
                        .widget_radium_recent_posts li,
                        .widget_radium_recent_posts li:first-child,
                        .widget_recent_comments li:first-child,
                        .widget_recent_comments li,
                        #twitter_div li:first-child,
                        #twitter_div li,
                        .comment,
                        .bypostauthor .comment .avatar,
                        .pingback,
                        .radium-toggle,
                        .hr,
                        hr,
                        .woocommerce-message,
                        .woocommerce-error,
                        .woocommerce-info,
                        .shop_attributes tr,
                        .product_meta > span,
                        .woocommerce .product .woocommerce-tabs,
                        .woocommerce .product .woocommerce-tabs ul.tabs,
                        .woocommerce .product .woocommerce-tabs ul.tabs li,
                        .woocommerce .product .woocommerce-tabs ul.tabs li.active,
                        .woocommerce .product .woocommerce-tabs .panel,
                        #main .quantity input.minus,
                        #main .quantity input.plus,
                        .quantity input.minus,
                        .quantity input.plus,
                        .quantity,
                        #main .quantity,
                        .review-item,
                        #review_form #respond,
                        #reviews #comments ol.commentlist li img,
                        #reviews #comments ol.commentlist li .comment-text,
                        .woocommerce .woocommerce-pagination ul,
                        .woocommerce .woocommerce-pagination ul li,
                        .widget_product_categories > ul > li,
                        .widget_layered_nav > ul > li,
                        .widget_product_categories > ul > li:first-child,
                        .widget_layered_nav > ul > li:first-child,
                        .widget_radium_recent_posts .post-date,
                        .product_list_widget li:first-child,
                        .product_list_widget li,
                        .element-divider .divider-dashed,
                        table,
                        .stage .page-grid-item,
                        .radium-gallery .page-grid-item,
                        .pagination-wrapper a,
                        input[type="text"],
                        input[type="password"],
                        input[type="date"],
                        input[type="datetime"],
                        input[type="email"],
                        input[type="number"],
                        input[type="search"],
                        input[type="tel"],
                        input[type="time"],
                        input[type="url"],
                        textarea,
                        .pagination-wrapper a:hover,
                        .pagination-wrapper a.current,
                        .widget_radium_post_tabs .tab-holder .news-list li',
                    'border-right-color' => '#comments .comment-body:before'
                ),
            ),

            'secondary_body_border_color' => array(
                'name' 		=> __( 'Secondary Border Color', 'radium' ),
                'id'		=> 'secondary_body_border_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '.radium-theme-pagination ul li span.current,
                        .video-central-pagination .video-central-pagination-links .page-numbers.current',
                    'background-color' => '',
                    'border-color' => '.post .post-excerpt,
                        .about-author .inner>h3,
                        #related-posts>h3,
                        #comments #reply-title, #comments>h3,
                        .radium-theme-pagination ul li span.current,
                        .cross-sells.products .widget .widget-title,
                        .related.products .widget .widget-title,
                        .upsells.products .widget .widget-title,
                        .video-central-pagination .video-central-pagination-links .page-numbers.current,
                        .section-title'
                ),
            ),

            'body_form_input_bg' => array(
                'name' 		=> __( 'Form input Box BG Color', 'radium' ),
                'id'		=> 'body_form_input_bg',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'background-color' => 'input[type="text"],
                        input[type="password"],
                        input[type="date"],
                        input[type="datetime"],
                        input[type="email"],
                        input[type="number"],
                        input[type="search"],
                        input[type="tel"],
                        input[type="time"],
                        input[type="url"],
                        textarea',
                ),
            ),

            // Side Share
            'post_side_share_bg_color' => array(
                'name' 		=> __( 'Post Side Share BG Color', 'radium' ),
                'id'		=> 'post_side_share_bg_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'background-color' => '.single .post-side-share',
                ),
            ),

            'post_side_share_color' => array(
                'name' 		=> __( 'Post Side Share Color', 'radium' ),
                'id'		=> 'post_side_share_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '.single .post-side-share',
                ),
            ),

            'post_side_share_bubble_bg_color' => array(
                'name' 		=> __( 'Post Side Share Bubble BG Color', 'radium' ),
                'id'		=> 'post_side_share_bubble_bg_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'background-color' => '.single .post-side-share .count',
                ),
            ),

            'post_side_share_bubble_bg_color' => array(
                'name' 		=> __( 'Post Side Share Bubble BG Color', 'radium' ),
                'id'		=> 'post_side_share_bubble_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '.single .post-side-share .count',
                ),
            ),

            // Sidebar Widgets
            'sidebar_widget_secondary_title' => array(
                'name' 		=> __( 'Sidebar Widget Secondary Title', 'radium' ),
                'id'		=> 'sidebar_widget_secondary_title',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '.widget ul li a',
                ),
            ),

        );

        radium_add_customizer_section( 'main_styles_options', __( 'Main Style', 'radium' ), $options['main_styles_options'], 3 );

        $options['post_styles_options'] = array(

            'post_category_tag_bg_color' => array(
                'name' 		=> __( 'Post Category Tag BG Color', 'radium' ),
                'id'		=> 'post_category_tag_bg_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'background-color' => '.entry-category.none',
                ),
            ),

            'post_category_tag_color' => array(
                'name' 		=> __( 'Post Category Color', 'radium' ),
                'id'		=> 'post_category_tag_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '.entry-featured',
                ),
            ),

            'post_featured_tag_bg_color' => array(
                'name' 		=> __( 'Post Featured BG tag', 'radium' ),
                'id'		=> 'post_featured_tag_bg_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'background-color' => '.entry-featured',
                ),
            ),

            'post_featured_tag_color' => array(
                'name' 		=> __( 'Post Featured tag', 'radium' ),
                'id'		=> 'post_featured_tag_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '.entry-featured',
                ),
            ),

            'post_tax_title_bg_color' => array(
                'name' 		=> __( 'Post Taxonomies Title BG color', 'radium' ),
                'id'		=> 'post_tags_title_bg_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'background-color' => '.single main footer.meta strong',
                ),
            ),

            'post_tax_title_color' => array(
                'name' 		=> __( 'Post Taxonomies Title Color', 'radium' ),
                'id'		=> 'post_tax_title_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '.single main footer.meta strong',
                ),
            ),

            'post_tax_bg_color' => array(
                'name' 		=> __( 'Post Taxonomies BG color', 'radium' ),
                'id'		=> 'post_tax_bg_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'background-color' => '.single main footer.meta a',
                ),
            ),

            'post_tax_color' => array(
                'name' 		=> __( 'Post Taxonomies Color', 'radium' ),
                'id'		=> 'post_tax_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '.single main footer.meta a',
                ),
            ),

        );

        radium_add_customizer_section( 'post_styles_options', __( 'Post Style', 'radium' ), $options['post_styles_options'], 4 );

        $options['ratings_styles_options'] = array(

            'rating_final_score_bg_color' => array(
                'name' 		=> __( 'Rating Final Score BG Color', 'radium' ),
                'id'		=> 'rating_final_score_bg_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'background-color' => '.entry-rating .rating-final-score, .widget_radium_widget_latest_reviews .total, .blog-grid-items .grid_elements .entry-meta div.entry-review, .entry-header .entry-meta div.entry-review, .smaller .entry-meta div.entry-review, .subcat-thumbnail .entry-meta div.entry-review, .type-post .entry-meta div.entry-review, .large-carousel .carousel-item .entry-meta .entry-review, .large-carousel .carousel-item .entry-meta .entry-review, .widget_radium_most_commented li span',
                    'border-top-color' => '.widget_radium_widget_latest_reviews .total::after, .widget_radium_most_commented li span i:after',
                    'border-left-color' => '.widget_radium_most_commented li span i:after'
                ),
            ),

            'rating_final_score_color' => array(
                'name' 		=> __( 'Rating Final Score Color', 'radium' ),
                'id'		=> 'rating_final_score_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '.entry-rating .rating-final-score span, .widget_radium_widget_latest_reviews .total, .widget_radium_most_commented li span',
                ),
            ),

            'rating_bars_bg_color' => array(
                'name' 		=> __( 'Rating Bars Background Color', 'radium' ),
                'id'		=> 'rating_bars_bg_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'background-color' => '.entry-rating.percentage .rating-percentage-wrapper',
                ),
            ),

            'rating_bars_color' => array(
                'name' 		=> __( 'Rating Bars Color', 'radium' ),
                'id'		=> 'rating_bars_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'background-color' => '.entry-rating.percentage .rating-percentage .rating-percentage span, .widget_radium_widget_latest_reviews .score-line span',
                ),
            ),

        );

        radium_add_customizer_section( 'ratings_styles_options', __( 'Rating System Style', 'radium' ), $options['ratings_styles_options'], 5 );

        // Setup main styles options
        $options['footer_styles_options'] = array(

             'footer_bg_color' => array(
                 'name' 		=> __( 'Footer Background Color', 'radium' ),
                 'id'		=> 'footer_bg_color',
                 'type' 		=> 'color',
                 'transport'	=> 'postMessage',
                 'selectors' 	=> array(
                     'background-color' => '#bottom-footer .inner,
                     #bottom-footer .widget-title,
                     #bottom-footer .widget_radium_buzz_widget h3.widget-buzz-header,
                     #bottom-footer .widget-title span,
                     #bottom-footer .widget_radium_buzz_widget h3.widget-buzz-header span',
                 ),
             ),

            'footer_color' => array(
                'name' 		=> __( 'Footer Text Color', 'radium' ),
                'id' 		=> 'footer_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '#bottom-footer,
                    #bottom-footer p,
                    #bottom-footer .textwidget,
                    #bottom-footer ul li a',
                ),
            ),

            'footer_widget_title_color' => array(
                'name' 		=> __( 'Footer Widget Title Color', 'radium' ),
                'id' 		=> 'footer_widget_title_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '#bottom-footer .widget-title span,
                    #bottom-footer .widget_radium_buzz_widget h3.widget-buzz-header span',
                ),
            ),

            'footer_links_color' => array(
                'name' 		=> __( 'Footer Links Color', 'radium' ),
                'id' 		=> 'footer_links_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '#bottom-footer a,
                    #bottom-footer p a,
                    #bottom-footer p a,
                    #bottom-footer ul li a,
                    #bottom-footer #footer-menu ul li a ',
                ),
            ),

            'footer_border_color' => array(
                'name' 		=> __( 'Footer Border Color', 'radium' ),
                'id' 		=> 'footer_border_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'border-color' => '#bottom-footer #footer-menu,
                    #bottom-footer .inner,
                    #bottom-footer ul li,
                    #bottom-footer .widget .widget_nav_menu ul li,
                    #bottom-footer .widget_radium_newsletter'
                ),
            ),

            'footer_credits_bg_color' => array(
                'name' 		=> __( 'Footer Credits Background Color', 'radium' ),
                'id'		=> 'footer_credits_bg_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'background-color' => '#colophon',
                ),
            ),

            'footer_credits_color' => array(
                'name' 		=> __( 'Footer Credits Text Color', 'radium' ),
                'id' 		=> 'footer_credits_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '#colophon *',
                ),
            ),

            'footer_credits_links_color' => array(
                'name' 		=> __( 'Footer Credits Links Color', 'radium' ),
                'id' 		=> 'footer_credits_links_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'color' => '#colophon a',
                ),
            ),

            'footer_credits_border_color' => array(
                'name' 		=> __( 'Footer Credits Border Color', 'radium' ),
                'id' 		=> 'footer_credits_border_color',
                'type' 		=> 'color',
                'transport'	=> 'postMessage',
                'selectors' 	=> array(
                    'border-color' => '#colophon'
                ),
            ),

        );

        radium_add_customizer_section( 'footer_styles_options', __( 'Footer Style', 'radium' ), $options['footer_styles_options'], 6 );

        return $options;
    }
    add_action( 'after_setup_theme', 'radium_get_theme_customizer_options' );

?>
