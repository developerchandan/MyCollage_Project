<?php
/*
 * This file is a part of the RadiumFramework core
 * and contains theme specific settings .
 * Please be extremely cautious editing this file,
 *
 * Also note that most functions here can be customized/modified
 *
 * @category RadiumFramework
 * @package  Griddr WP
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 * @since 2.1.0
 */

/*-----------------------------------------------------------------------------------*/
/*	Button Config
/*-----------------------------------------------------------------------------------*/

$radium_shortcodes['button'] = array(
	'no_preview' => true,
	'params' => array(
		'url' => array(
			'std' => '#',
			'type' => 'text',
			'label' => __('Button URL:', 'radium'),
			'desc' => __('', 'radium')
		),

		'target' => array(
			'type' => 'select',
			'label' => __('Link Target:', 'radium'),
			'desc' => __('', 'radium'),
			'options' => array(
				'_self' => '_self (open in same window)',
				'_blank' => '_blank (open in new window)'
			)
		),

		'style' => array(
			'type' => 'select',
			'label' => __('Style:', 'radium'),
			'desc' => __('', 'radium'),
			'options' => array(
				' ' => 'Default',
				'white' => 'White',
				'grey' => 'Grey',
				'green' => 'Green',
				'blue' => 'Blue',
				'red' => 'Red',
				'orange' => 'Orange',
			)
		),

		'size' => array(
			'type' => 'select',
			'label' => __('Size:', 'radium'),
			'desc' => __('', 'radium'),
			'options' => array(
				'small' => 'Small',
				'medium' => 'Medium',
				'large' => 'Large'
			)
		),

		'type' => array(
			'type' => 'select',
			'label' => __('Type:', 'radium'),
			'desc' => __('', 'radium'),
			'options' => array(
				'round' => 'Round',
				'square' => 'Square'
			)
		),

		'icon' => array(
			'type' => 'text',
			'label' => __('Icon:', 'radium'),
			'desc' => __('eg: icon-download', 'radium'),


		),


		'content' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Button Text:', 'radium'),
			'desc' => __('', 'radium'),
			)
		),

	'shortcode' => '[button url="{{url}}" style="{{style}}" size="{{size}}" type="{{type}}" icon="{{icon}}" target="{{target}}"] {{content}} [/button]',
	'popup_title' => __('Button Shortcode', 'radium')
);

/*-----------------------------------------------------------------------------------*/
/*	Icon Boxes
/*-----------------------------------------------------------------------------------*/

$radium_shortcodes['icon'] = array(
	'params' => array(),
	//'shortcode' => ' {{child_shortcode}} ', // as there is no wrapper shortcode
	'popup_title' => __('Icon Shortcodes', 'radium'),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	//'child_shortcode' => array(
		'params' => array(

			'title' => array(
				'type' => 'text',
				'label' => __('Title:', 'radium'),
				'desc' => __('', 'radium'),
				'std' => ''
			),

			'title_tag' => array(
				'type' => 'text',
				'label' => __('Title tag:', 'radium'),
				'desc' => __('ex: h1, h2, h3 etc', 'radium'),
				'std' => ''
			),

 			'icon' => array(
				'type'=>'icons',
				'std' => '',
				'label' => __('Icons:', 'radium'),
				'desc' => __('', 'radium'),
				'options'	=> array(
				  'icon-glass' => 'icon-glass',
				  'icon-music' => 'icon-music',
				  'icon-search' => 'icon-search',
				  'icon-envelope' => 'icon-envelope',
				  'icon-heart' => 'icon-heart',
				  'icon-star' => 'icon-star',
				  'icon-star-empty' => 'icon-star-empty',
				  'icon-user' => 'icon-user',
				  'icon-film' => 'icon-film',
				  'icon-th-large' => 'icon-th-large',
				  'icon-th' => 'icon-th',
				  'icon-th-list' => 'icon-th-list',
				  'icon-ok' => 'icon-ok',
				  'icon-remove' => 'icon-remove',
				  'icon-zoom-in' => 'icon-zoom-in',
				  'icon-zoom-out' => 'icon-zoom-out',
				  'icon-off' => 'icon-off',
				  'icon-signal' => 'icon-signal',
				  'icon-cog' => 'icon-cog',
				  'icon-trash' => 'icon-trash',
				  'icon-home' => 'icon-home',
				  'icon-file' => 'icon-file',
				  'icon-time' => 'icon-time',
				  'icon-road' => 'icon-road',
				  'icon-download-alt' => 'icon-download-alt',
				  'icon-download' => 'icon-download',
				  'icon-upload' => 'icon-upload',
				  'icon-inbox' => 'icon-inbox',
				  'icon-play-circle' => 'icon-play-circle',
				  'icon-repeat' => 'icon-repeat',
				  'icon-refresh' => 'icon-refresh',
				  'icon-list-alt' => 'icon-list-alt',
				  'icon-lock' => 'icon-lock',
				  'icon-flag' => 'icon-flag',
				  'icon-headphones' => 'icon-headphones',
				  'icon-volume-off' => 'icon-volume-off',
				  'icon-volume-down' => 'icon-volume-down',
				  'icon-volume-up' => 'icon-volume-up',
				  'icon-qrcode' => 'icon-qrcode',
				  'icon-barcode' => 'icon-barcode',
				  'icon-tag' => 'icon-tag',
				  'icon-tags' => 'icon-tags',
				  'icon-book' => 'icon-book',
				  'icon-bookmark' => 'icon-bookmark',
				  'icon-print' => 'icon-print',
				  'icon-camera' => 'icon-camera',
				  'icon-font' => 'icon-font',
				  'icon-bold' => 'icon-bold',
				  'icon-italic' => 'icon-italic',
				  'icon-text-height' => 'icon-text-height',
				  'icon-text-width' => 'icon-text-width',
				  'icon-align-left' => 'icon-align-left',
				  'icon-align-center' => 'icon-align-center',
				  'icon-align-right' => 'icon-align-right',
				  'icon-align-justify' => 'icon-align-justify',
				  'icon-list' => 'icon-list',
				  'icon-indent-left' => 'icon-indent-left',
				  'icon-indent-right' => 'icon-indent-right',
				  'icon-facetime-video' => 'icon-facetime-video',
				  'icon-picture' => 'icon-picture',
				  'icon-pencil' => 'icon-pencil',
				  'icon-map-marker' => 'icon-map-marker',
				  'icon-adjust' => 'icon-adjust',
				  'icon-tint' => 'icon-tint',
				  'icon-edit' => 'icon-edit',
				  'icon-share' => 'icon-share',
				  'icon-check' => 'icon-check',
				  'icon-move' => 'icon-move',
				  'icon-step-backward' => 'icon-step-backward',
				  'icon-fast-backward' => 'icon-fast-backward',
				  'icon-backward' => 'icon-backward',
				  'icon-play' => 'icon-play',
				  'icon-pause' => 'icon-pause',
				  'icon-stop' => 'icon-stop',
				  'icon-forward' => 'icon-forward',
				  'icon-fast-forward' => 'icon-fast-forward',
				  'icon-step-forward' => 'icon-step-forward',
				  'icon-eject' => 'icon-eject',
				  'icon-chevron-left' => 'icon-chevron-left',
				  'icon-chevron-right' => 'icon-chevron-right',
				  'icon-plus-sign' => 'icon-plus-sign',
				  'icon-minus-sign' => 'icon-minus-sign',
				  'icon-remove-sign' => 'icon-remove-sign',
				  'icon-ok-sign' => 'icon-ok-sign',
				  'icon-question-sign' => 'icon-question-sign',
				  'icon-info-sign' => 'icon-info-sign',
				  'icon-screenshot' => 'icon-screenshot',
				  'icon-remove-circle' => 'icon-remove-circle',
				  'icon-ok-circle' => 'icon-ok-circle',
				  'icon-ban-circle' => 'icon-ban-circle',
				  'icon-arrow-left' => 'icon-arrow-left',
				  'icon-arrow-right' => 'icon-arrow-right',
				  'icon-arrow-up' => 'icon-arrow-up',
				  'icon-arrow-down' => 'icon-arrow-down',
				  'icon-share-alt' => 'icon-share-alt',
				  'icon-resize-full' => 'icon-resize-full',
				  'icon-resize-small' => 'icon-resize-small',
				  'icon-plus' => 'icon-plus',
				  'icon-minus' => 'icon-minus',
				  'icon-asterisk' => 'icon-asterisk',
				  'icon-exclamation-sign' => 'icon-exclamation-sign',
				  'icon-gift' => 'icon-gift',
				  'icon-leaf' => 'icon-leaf',
				  'icon-fire' => 'icon-fire',
				  'icon-eye-open' => 'icon-eye-open',
				  'icon-eye-close' => 'icon-eye-close',
				  'icon-warning-sign' => 'icon-warning-sign',
				  'icon-plane' => 'icon-plane',
				  'icon-calendar' => 'icon-calendar',
				  'icon-random' => 'icon-random',
				  'icon-comment' => 'icon-comment',
				  'icon-magnet' => 'icon-magnet',
				  'icon-chevron-up' => 'icon-chevron-up',
				  'icon-chevron-down' => 'icon-chevron-down',
				  'icon-retweet' => 'icon-retweet',
				  'icon-shopping-cart' => 'icon-shopping-cart',
				  'icon-folder-close' => 'icon-folder-close',
				  'icon-folder-open' => 'icon-folder-open',
				  'icon-resize-vertical' => 'icon-resize-vertical',
				  'icon-resize-horizontal' => 'icon-resize-horizontal',
				  'icon-bar-chart' => 'icon-bar-chart',
				  'icon-twitter-sign' => 'icon-twitter-sign',
				  'icon-facebook-sign' => 'icon-facebook-sign',
				  'icon-camera-retro' => 'icon-camera-retro',
				  'icon-key' => 'icon-key',
				  'icon-cogs' => 'icon-cogs',
				  'icon-comments' => 'icon-comments',
				  'icon-thumbs-up' => 'icon-thumbs-up',
				  'icon-thumbs-down' => 'icon-thumbs-down',
				  'icon-star-half' => 'icon-star-half',
				  'icon-heart-empty' => 'icon-heart-empty',
				  'icon-signout' => 'icon-signout',
				  'icon-linkedin-sign' => 'icon-linkedin-sign',
				  'icon-pushpin' => 'icon-pushpin',
				  'icon-external-link' => 'icon-external-link',
				  'icon-signin' => 'icon-signin',
				  'icon-trophy' => 'icon-trophy',
				  'icon-github-sign' => 'icon-github-sign',
				  'icon-upload-alt' => 'icon-upload-alt',
				  'icon-lemon' => 'icon-lemon',
				  'icon-phone' => 'icon-phone',
				  'icon-check-empty' => 'icon-check-empty',
				  'icon-bookmark-empty' => 'icon-bookmark-empty',
				  'icon-phone-sign' => 'icon-phone-sign',
				  'icon-twitter' => 'icon-twitter',
				  'icon-facebook' => 'icon-facebook',
				  'icon-github' => 'icon-github',
				  'icon-unlock' => 'icon-unlock',
				  'icon-credit-card' => 'icon-credit-card',
				  'icon-rss' => 'icon-rss',
				  'icon-hdd' => 'icon-hdd',
				  'icon-bullhorn' => 'icon-bullhorn',
				  'icon-bell' => 'icon-bell',
				  'icon-certificate' => 'icon-certificate',
				  'icon-hand-right' => 'icon-hand-right',
				  'icon-hand-left' => 'icon-hand-left',
				  'icon-hand-up' => 'icon-hand-up',
				  'icon-hand-down' => 'icon-hand-down',
				  'icon-circle-arrow-left' => 'icon-circle-arrow-left',
				  'icon-circle-arrow-right' => 'icon-circle-arrow-right',
				  'icon-circle-arrow-up' => 'icon-circle-arrow-up',
				  'icon-circle-arrow-down' => 'icon-circle-arrow-down',
				  'icon-globe' => 'icon-globe',
				  'icon-wrench' => 'icon-wrench',
				  'icon-tasks' => 'icon-tasks',
				  'icon-filter' => 'icon-filter',
				  'icon-briefcase' => 'icon-briefcase',
				  'icon-fullscreen' => 'icon-fullscreen',
				  'icon-group' => 'icon-group',
				  'icon-link' => 'icon-link',
				  'icon-cloud' => 'icon-cloud',
				  'icon-beaker' => 'icon-beaker',
				  'icon-cut' => 'icon-cut',
				  'icon-copy' => 'icon-copy',
				  'icon-paper-clip' => 'icon-paper-clip',
				  'icon-save' => 'icon-save',
				  'icon-sign-blank' => 'icon-sign-blank',
				  'icon-reorder' => 'icon-reorder',
				  'icon-list-ul' => 'icon-list-ul',
				  'icon-list-ol' => 'icon-list-ol',
				  'icon-strikethrough' => 'icon-strikethrough',
				  'icon-underline' => 'icon-underline',
				  'icon-table' => 'icon-table',
				  'icon-magic' => 'icon-magic',
				  'icon-truck' => 'icon-truck',
				  'icon-pinterest' => 'icon-pinterest',
				  'icon-pinterest-sign' => 'icon-pinterest-sign',
				  'icon-google-plus-sign' => 'icon-google-plus-sign',
				  'icon-google-plus' => 'icon-google-plus',
				  'icon-money' => 'icon-money',
				  'icon-caret-down' => 'icon-caret-down',
				  'icon-caret-up' => 'icon-caret-up',
				  'icon-caret-left' => 'icon-caret-left',
				  'icon-caret-right' => 'icon-caret-right',
				  'icon-columns' => 'icon-columns',
				  'icon-sort' => 'icon-sort',
				  'icon-sort-down' => 'icon-sort-down',
				  'icon-sort-up' => 'icon-sort-up',
				  'icon-envelope-alt' => 'icon-envelope-alt',
				  'icon-linkedin' => 'icon-linkedin',
				  'icon-undo' => 'icon-undo',
				  'icon-legal' => 'icon-legal',
				  'icon-dashboard' => 'icon-dashboard',
				  'icon-comment-alt' => 'icon-comment-alt',
				  'icon-comments-alt' => 'icon-comments-alt',
				  'icon-bolt' => 'icon-bolt',
				  'icon-sitemap' => 'icon-sitemap',
				  'icon-umbrella' => 'icon-umbrella',
				  'icon-paste' => 'icon-paste',
				  'icon-lightbulb' => 'icon-lightbulb',
				  'icon-exchange' => 'icon-exchange',
				  'icon-cloud-download' => 'icon-cloud-download',
				  'icon-cloud-upload' => 'icon-cloud-upload',
				  'icon-user-md' => 'icon-user-md',
				  'icon-stethoscope' => 'icon-stethoscope',
				  'icon-suitcase' => 'icon-suitcase',
				  'icon-bell-alt' => 'icon-bell-alt',
				  'icon-coffee' => 'icon-coffee',
				  'icon-food' => 'icon-food',
				  'icon-file-alt' => 'icon-file-alt',
				  'icon-building' => 'icon-building',
				  'icon-hospital' => 'icon-hospital',
				  'icon-ambulance' => 'icon-ambulance',
				  'icon-medkit' => 'icon-medkit',
				  'icon-fighter-jet' => 'icon-fighter-jet',
				  'icon-beer' => 'icon-beer',
				  'icon-h-sign' => 'icon-h-sign',
				  'icon-plus-sign-alt' => 'icon-plus-sign-alt',
				  'icon-double-angle-left' => 'icon-double-angle-left',
				  'icon-double-angle-right' => 'icon-double-angle-right',
				  'icon-double-angle-up' => 'icon-double-angle-up',
				  'icon-double-angle-down' => 'icon-double-angle-down',
				  'icon-angle-left' => 'icon-angle-left',
				  'icon-angle-right' => 'icon-angle-right',
				  'icon-angle-up' => 'icon-angle-up',
				  'icon-angle-down' => 'icon-angle-down',
				  'icon-desktop' => 'icon-desktop',
				  'icon-laptop' => 'icon-laptop',
				  'icon-tablet' => 'icon-tablet',
				  'icon-mobile-phone' => 'icon-mobile-phone',
				  'icon-circle-blank' => 'icon-circle-blank',
				  'icon-quote-left' => 'icon-quote-left',
				  'icon-quote-right' => 'icon-quote-right',
				  'icon-spinner' => 'icon-spinner',
				  'icon-circle' => 'icon-circle',
				  'icon-reply' => 'icon-reply',
				  'icon-github-alt' => 'icon-github-alt',
				  'icon-folder-close-alt' => 'icon-folder-close-alt',
				  'icon-folder-open-alt' => 'icon-folder-open-alt'
				),
			),//

			'style' => array(
				'type' => 'text',
				'label' => __('Style', 'radium'),
				'desc' => __('', 'radium'),
				'std' =>''
			),

			'content' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Content:', 'radium'),
				'desc' => __('', 'radium'),
				'std' => ''
			)

		),
		'shortcode' => '[icon title_tag="{{title_tag}}" title="{{title}}" icon="{{icon}}" type="{{style}}" ] {{content}} [/icon] ',
		'clone_button' => __('Click to Add Another Icon', 'radium')
	//)
);


/*-----------------------------------------------------------------------------------*/
/*	Social Icons
/*-----------------------------------------------------------------------------------*/
$radium_shortcodes['social_icons'] = array(
	'no_preview' => true,
	'params' => array(
		'type' => array(
					'type' => 'select',
					'label' => __('Select Icon:', 'radium'),
					'desc' => __('', 'radium'),
					'options' => array(
						'behance' => 'Behance',
						'delicious' => 'Delicious',
						'digg' => 'Digg',
						'dribbble' => 'Dribbble',
						'facebook' => 'Facebook',
						'flickr' => 'Flickr',
						'forrst' => 'Forrst',
						'foursquare' => 'FourSquare',
						'github' => 'GitHub',
						'googleplus' => 'Google Plus',
						'Linkedin' => 'LinkedIn',
						'pinterest' => 'Pinterest',
						'reddit' => 'Reddit',
						'rss' => 'RSS',
						'stumbleupon' => 'StumbleUpon',
						'twitter' => 'Twitter',
						'vimeo' => 'Vimeo',
						'yelp' => 'Yelp',
						'youtube' => 'YouTube',
						'zerply' => 'Zerply',
						'youtube' => 'Youtube',
					)
				),

		'link' => array(
			'std' => '#',
			'type' => 'text',
			'label' => __('Icon URL:', 'radium'),
			'desc' => __('', 'radium')
		),
		'style' => array(
			'type' => 'select',
			'label' => __('Select Icon:', 'radium'),
			'desc' => __('', 'radium'),
			'std' => '',
			'options' => array(
				'style1' => 'Style1',
				'style2' => 'Style2',
				'style3' => 'Style3',
				'style4' => 'Style4',
			)
		),

	),

	'shortcode' => '[social-icon style="{{style}}" link="{{link}}" type="{{type}}"/]',
	'popup_title' => __('Social Media Icon Shortcodes', 'radium')
);

//Icon
$radium_shortcodes['icon-fonts'] = array(
	'no_preview' => true,
	'params' => array(

		'size' => array(
			'type'	=>'select',
			'label'	=>__('Icon Size', 'radium'),
			'desc' 	=> __('Tiny is recommended to be used inline with regular text. <br/> Small is recommended to be used inline right before heading text. <br> Large is recommended to be used at the top of columns.', 'radium'),
			'options'	=> array(
				'tiny' 	=> 'Tiny',
				'small' => 'Small',
				'large' => 'Large'
			)
		),
		'icon' => array(
			'type'=>'icons',
			'std' => '',
			'label' => __('Icons:', 'radium'),
			'desc' => __('', 'radium'),
			'options'	=> array(
			  'icon-glass' => 'icon-glass',
			  'icon-music' => 'icon-music',
			  'icon-search' => 'icon-search',
			  'icon-envelope' => 'icon-envelope',
			  'icon-heart' => 'icon-heart',
			  'icon-star' => 'icon-star',
			  'icon-star-empty' => 'icon-star-empty',
			  'icon-user' => 'icon-user',
			  'icon-film' => 'icon-film',
			  'icon-th-large' => 'icon-th-large',
			  'icon-th' => 'icon-th',
			  'icon-th-list' => 'icon-th-list',
			  'icon-ok' => 'icon-ok',
			  'icon-remove' => 'icon-remove',
			  'icon-zoom-in' => 'icon-zoom-in',
			  'icon-zoom-out' => 'icon-zoom-out',
			  'icon-off' => 'icon-off',
			  'icon-signal' => 'icon-signal',
			  'icon-cog' => 'icon-cog',
			  'icon-trash' => 'icon-trash',
			  'icon-home' => 'icon-home',
			  'icon-file' => 'icon-file',
			  'icon-time' => 'icon-time',
			  'icon-road' => 'icon-road',
			  'icon-download-alt' => 'icon-download-alt',
			  'icon-download' => 'icon-download',
			  'icon-upload' => 'icon-upload',
			  'icon-inbox' => 'icon-inbox',
			  'icon-play-circle' => 'icon-play-circle',
			  'icon-repeat' => 'icon-repeat',
			  'icon-refresh' => 'icon-refresh',
			  'icon-list-alt' => 'icon-list-alt',
			  'icon-lock' => 'icon-lock',
			  'icon-flag' => 'icon-flag',
			  'icon-headphones' => 'icon-headphones',
			  'icon-volume-off' => 'icon-volume-off',
			  'icon-volume-down' => 'icon-volume-down',
			  'icon-volume-up' => 'icon-volume-up',
			  'icon-qrcode' => 'icon-qrcode',
			  'icon-barcode' => 'icon-barcode',
			  'icon-tag' => 'icon-tag',
			  'icon-tags' => 'icon-tags',
			  'icon-book' => 'icon-book',
			  'icon-bookmark' => 'icon-bookmark',
			  'icon-print' => 'icon-print',
			  'icon-camera' => 'icon-camera',
			  'icon-font' => 'icon-font',
			  'icon-bold' => 'icon-bold',
			  'icon-italic' => 'icon-italic',
			  'icon-text-height' => 'icon-text-height',
			  'icon-text-width' => 'icon-text-width',
			  'icon-align-left' => 'icon-align-left',
			  'icon-align-center' => 'icon-align-center',
			  'icon-align-right' => 'icon-align-right',
			  'icon-align-justify' => 'icon-align-justify',
			  'icon-list' => 'icon-list',
			  'icon-indent-left' => 'icon-indent-left',
			  'icon-indent-right' => 'icon-indent-right',
			  'icon-facetime-video' => 'icon-facetime-video',
			  'icon-picture' => 'icon-picture',
			  'icon-pencil' => 'icon-pencil',
			  'icon-map-marker' => 'icon-map-marker',
			  'icon-adjust' => 'icon-adjust',
			  'icon-tint' => 'icon-tint',
			  'icon-edit' => 'icon-edit',
			  'icon-share' => 'icon-share',
			  'icon-check' => 'icon-check',
			  'icon-move' => 'icon-move',
			  'icon-step-backward' => 'icon-step-backward',
			  'icon-fast-backward' => 'icon-fast-backward',
			  'icon-backward' => 'icon-backward',
			  'icon-play' => 'icon-play',
			  'icon-pause' => 'icon-pause',
			  'icon-stop' => 'icon-stop',
			  'icon-forward' => 'icon-forward',
			  'icon-fast-forward' => 'icon-fast-forward',
			  'icon-step-forward' => 'icon-step-forward',
			  'icon-eject' => 'icon-eject',
			  'icon-chevron-left' => 'icon-chevron-left',
			  'icon-chevron-right' => 'icon-chevron-right',
			  'icon-plus-sign' => 'icon-plus-sign',
			  'icon-minus-sign' => 'icon-minus-sign',
			  'icon-remove-sign' => 'icon-remove-sign',
			  'icon-ok-sign' => 'icon-ok-sign',
			  'icon-question-sign' => 'icon-question-sign',
			  'icon-info-sign' => 'icon-info-sign',
			  'icon-screenshot' => 'icon-screenshot',
			  'icon-remove-circle' => 'icon-remove-circle',
			  'icon-ok-circle' => 'icon-ok-circle',
			  'icon-ban-circle' => 'icon-ban-circle',
			  'icon-arrow-left' => 'icon-arrow-left',
			  'icon-arrow-right' => 'icon-arrow-right',
			  'icon-arrow-up' => 'icon-arrow-up',
			  'icon-arrow-down' => 'icon-arrow-down',
			  'icon-share-alt' => 'icon-share-alt',
			  'icon-resize-full' => 'icon-resize-full',
			  'icon-resize-small' => 'icon-resize-small',
			  'icon-plus' => 'icon-plus',
			  'icon-minus' => 'icon-minus',
			  'icon-asterisk' => 'icon-asterisk',
			  'icon-exclamation-sign' => 'icon-exclamation-sign',
			  'icon-gift' => 'icon-gift',
			  'icon-leaf' => 'icon-leaf',
			  'icon-fire' => 'icon-fire',
			  'icon-eye-open' => 'icon-eye-open',
			  'icon-eye-close' => 'icon-eye-close',
			  'icon-warning-sign' => 'icon-warning-sign',
			  'icon-plane' => 'icon-plane',
			  'icon-calendar' => 'icon-calendar',
			  'icon-random' => 'icon-random',
			  'icon-comment' => 'icon-comment',
			  'icon-magnet' => 'icon-magnet',
			  'icon-chevron-up' => 'icon-chevron-up',
			  'icon-chevron-down' => 'icon-chevron-down',
			  'icon-retweet' => 'icon-retweet',
			  'icon-shopping-cart' => 'icon-shopping-cart',
			  'icon-folder-close' => 'icon-folder-close',
			  'icon-folder-open' => 'icon-folder-open',
			  'icon-resize-vertical' => 'icon-resize-vertical',
			  'icon-resize-horizontal' => 'icon-resize-horizontal',
			  'icon-bar-chart' => 'icon-bar-chart',
			  'icon-twitter-sign' => 'icon-twitter-sign',
			  'icon-facebook-sign' => 'icon-facebook-sign',
			  'icon-camera-retro' => 'icon-camera-retro',
			  'icon-key' => 'icon-key',
			  'icon-cogs' => 'icon-cogs',
			  'icon-comments' => 'icon-comments',
			  'icon-thumbs-up' => 'icon-thumbs-up',
			  'icon-thumbs-down' => 'icon-thumbs-down',
			  'icon-star-half' => 'icon-star-half',
			  'icon-heart-empty' => 'icon-heart-empty',
			  'icon-signout' => 'icon-signout',
			  'icon-linkedin-sign' => 'icon-linkedin-sign',
			  'icon-pushpin' => 'icon-pushpin',
			  'icon-external-link' => 'icon-external-link',
			  'icon-signin' => 'icon-signin',
			  'icon-trophy' => 'icon-trophy',
			  'icon-github-sign' => 'icon-github-sign',
			  'icon-upload-alt' => 'icon-upload-alt',
			  'icon-lemon' => 'icon-lemon',
			  'icon-phone' => 'icon-phone',
			  'icon-check-empty' => 'icon-check-empty',
			  'icon-bookmark-empty' => 'icon-bookmark-empty',
			  'icon-phone-sign' => 'icon-phone-sign',
			  'icon-twitter' => 'icon-twitter',
			  'icon-facebook' => 'icon-facebook',
			  'icon-github' => 'icon-github',
			  'icon-unlock' => 'icon-unlock',
			  'icon-credit-card' => 'icon-credit-card',
			  'icon-rss' => 'icon-rss',
			  'icon-hdd' => 'icon-hdd',
			  'icon-bullhorn' => 'icon-bullhorn',
			  'icon-bell' => 'icon-bell',
			  'icon-certificate' => 'icon-certificate',
			  'icon-hand-right' => 'icon-hand-right',
			  'icon-hand-left' => 'icon-hand-left',
			  'icon-hand-up' => 'icon-hand-up',
			  'icon-hand-down' => 'icon-hand-down',
			  'icon-circle-arrow-left' => 'icon-circle-arrow-left',
			  'icon-circle-arrow-right' => 'icon-circle-arrow-right',
			  'icon-circle-arrow-up' => 'icon-circle-arrow-up',
			  'icon-circle-arrow-down' => 'icon-circle-arrow-down',
			  'icon-globe' => 'icon-globe',
			  'icon-wrench' => 'icon-wrench',
			  'icon-tasks' => 'icon-tasks',
			  'icon-filter' => 'icon-filter',
			  'icon-briefcase' => 'icon-briefcase',
			  'icon-fullscreen' => 'icon-fullscreen',
			  'icon-group' => 'icon-group',
			  'icon-link' => 'icon-link',
			  'icon-cloud' => 'icon-cloud',
			  'icon-beaker' => 'icon-beaker',
			  'icon-cut' => 'icon-cut',
			  'icon-copy' => 'icon-copy',
			  'icon-paper-clip' => 'icon-paper-clip',
			  'icon-save' => 'icon-save',
			  'icon-sign-blank' => 'icon-sign-blank',
			  'icon-reorder' => 'icon-reorder',
			  'icon-list-ul' => 'icon-list-ul',
			  'icon-list-ol' => 'icon-list-ol',
			  'icon-strikethrough' => 'icon-strikethrough',
			  'icon-underline' => 'icon-underline',
			  'icon-table' => 'icon-table',
			  'icon-magic' => 'icon-magic',
			  'icon-truck' => 'icon-truck',
			  'icon-pinterest' => 'icon-pinterest',
			  'icon-pinterest-sign' => 'icon-pinterest-sign',
			  'icon-google-plus-sign' => 'icon-google-plus-sign',
			  'icon-google-plus' => 'icon-google-plus',
			  'icon-money' => 'icon-money',
			  'icon-caret-down' => 'icon-caret-down',
			  'icon-caret-up' => 'icon-caret-up',
			  'icon-caret-left' => 'icon-caret-left',
			  'icon-caret-right' => 'icon-caret-right',
			  'icon-columns' => 'icon-columns',
			  'icon-sort' => 'icon-sort',
			  'icon-sort-down' => 'icon-sort-down',
			  'icon-sort-up' => 'icon-sort-up',
			  'icon-envelope-alt' => 'icon-envelope-alt',
			  'icon-linkedin' => 'icon-linkedin',
			  'icon-undo' => 'icon-undo',
			  'icon-legal' => 'icon-legal',
			  'icon-dashboard' => 'icon-dashboard',
			  'icon-comment-alt' => 'icon-comment-alt',
			  'icon-comments-alt' => 'icon-comments-alt',
			  'icon-bolt' => 'icon-bolt',
			  'icon-sitemap' => 'icon-sitemap',
			  'icon-umbrella' => 'icon-umbrella',
			  'icon-paste' => 'icon-paste',
			  'icon-lightbulb' => 'icon-lightbulb',
			  'icon-exchange' => 'icon-exchange',
			  'icon-cloud-download' => 'icon-cloud-download',
			  'icon-cloud-upload' => 'icon-cloud-upload',
			  'icon-user-md' => 'icon-user-md',
			  'icon-stethoscope' => 'icon-stethoscope',
			  'icon-suitcase' => 'icon-suitcase',
			  'icon-bell-alt' => 'icon-bell-alt',
			  'icon-coffee' => 'icon-coffee',
			  'icon-food' => 'icon-food',
			  'icon-file-alt' => 'icon-file-alt',
			  'icon-building' => 'icon-building',
			  'icon-hospital' => 'icon-hospital',
			  'icon-ambulance' => 'icon-ambulance',
			  'icon-medkit' => 'icon-medkit',
			  'icon-fighter-jet' => 'icon-fighter-jet',
			  'icon-beer' => 'icon-beer',
			  'icon-h-sign' => 'icon-h-sign',
			  'icon-plus-sign-alt' => 'icon-plus-sign-alt',
			  'icon-double-angle-left' => 'icon-double-angle-left',
			  'icon-double-angle-right' => 'icon-double-angle-right',
			  'icon-double-angle-up' => 'icon-double-angle-up',
			  'icon-double-angle-down' => 'icon-double-angle-down',
			  'icon-angle-left' => 'icon-angle-left',
			  'icon-angle-right' => 'icon-angle-right',
			  'icon-angle-up' => 'icon-angle-up',
			  'icon-angle-down' => 'icon-angle-down',
			  'icon-desktop' => 'icon-desktop',
			  'icon-laptop' => 'icon-laptop',
			  'icon-tablet' => 'icon-tablet',
			  'icon-mobile-phone' => 'icon-mobile-phone',
			  'icon-circle-blank' => 'icon-circle-blank',
			  'icon-quote-left' => 'icon-quote-left',
			  'icon-quote-right' => 'icon-quote-right',
			  'icon-spinner' => 'icon-spinner',
			  'icon-circle' => 'icon-circle',
			  'icon-reply' => 'icon-reply',
			  'icon-github-alt' => 'icon-github-alt',
			  'icon-folder-close-alt' => 'icon-folder-close-alt',
			  'icon-folder-open-alt' => 'icon-folder-open-alt'
			),
		),//


	),

	'shortcode' => '[icon  size="{{size}}" icon="{{icon}}" /]',
	'popup_title' => __('Icon Font Shortcode', 'radium')
);


/*-----------------------------------------------------------------------------------*/
/*  Lists
/*-----------------------------------------------------------------------------------*/

$radium_shortcodes['lists'] = array(
    'no_preview' => true,
    'params' => array(

        'icon' => array(
            'type' => 'text',
            'label' => __('List Style:', 'radium'),
            'desc' => __('eg: icon-ok ', 'radium'),
        ),

        'style' => array(
            'type' => 'select',
            'label' => __('Select Post Type:', 'radium'),
            'desc' => __('', 'radium'),
            'std' => '',
            'options' => array(
                '' => 'Default',
                'dark' => 'Dark',
            )
        ),

        'content' => array(
            'std' => '',
            'type' => 'textarea',
            'label' => __('List Content', 'radium'),
            'desc' => __('Enter your list here. <br>Example: (&lt;ul&gt;&lt;li&gt;some content &lt;/li&gt;&lt;/ul&gt;)', 'radium'),
        )
    ),
    'shortcode' => '[list icon="{{icon}} {{style}}"] {{content}} [/list] ',
    'popup_title' => __('List Style Shortcodes', 'radium')
);


/*-----------------------------------------------------------------------------------*/
/*  Radium Image
/*-----------------------------------------------------------------------------------*/

$radium_shortcodes['radium_image'] = array(
    'no_preview' => true,
    'params' => array(

        'image_id' => array(
            'type' => 'text',
            'label' => __('Image ID:', 'radium'),
            'desc' => __(' ', 'radium'),
        ),

        'frame' => array(
            'type' => 'select',
            'label' => __('Select Border Style:', 'radium'),
            'desc' => __('', 'radium'),
            'std' => '',
            'options' => array(
                '' => 'None',
                'borderframe' => 'Borderframe',
                'glowframe' => 'Glowframe',
                'shadowframe' => 'Shadowframe',
                'glowframe' => 'Glowframe',
            )
        ),

        'image_size' => array(
            'type' => 'select',
            'label' => __('Image Size:', 'radium'),
            'desc' => __(' ', 'radium'),
            'options' => array(
                'large' => 'Large',
            )
        ),

        'caption' => array(
            'type' => 'text',
            'label' => __('Caption:', 'radium'),
            'desc' => __('', 'radium'),
        ),

        'lightbox' => array(
            'type' => 'select',
            'label' => __('Show Lightbox:', 'radium'),
            'desc' => __('', 'radium'),
            'std' => 'no',
            'options' => array(
                'no' => 'No',
                'yes' => 'Yes',
            )
        ),

        'link_target' => array(
            'type' => 'select',
            'label' => __('LInk Target', 'radium'),
            'desc' => __('', 'radium'),
            'std' => '_self',
            'options' => array(
                '_self' => 'Self',
                '_blank' => 'New Window/Tab',
            )
        ),
    ),
    'shortcode' => '[radium_image image_id="{{image_id}}" image_size="{{image_size}}" frame="{{frame}}" caption="{{caption}}" lightbox="{{lightbox}}" link_target="{{link_target}}" ] ',
    'popup_title' => __('Radium Image Shortcodes', 'radium')
);

/*-----------------------------------------------------------------------------------*/
/*  Radium Video
/*-----------------------------------------------------------------------------------*/

$radium_shortcodes['radium_video'] = array(

    'title'     => '',
            'link'      => '',
            'thumbnail' => '',


    'no_preview' => true,
    'params' => array(

        'title' => array(
            'type' => 'text',
            'label' => __('Title:', 'radium'),
            'desc' => __('', 'radium'),
        ),

        'link' => array(
            'type' => 'text',
            'label' => __('Link to video:', 'radium'),
            'desc' => __('eg: http://www.youtube.com/watch?v=abcdefg', 'radium'),
        ),

        'size' => array(
            'type' => 'text',
            'label' => __('Size: eg 650 x 500', 'radium'),
            'desc' => __('', 'radium'),
        ),

        'fullwidth' => array(
            'type' => 'select',
            'label' => __('Show fullwidth:', 'radium'),
            'desc' => __('', 'radium'),
            'std' => 'yes',
            'options' => array(
                'no' => 'No',
                'yes' => 'Yes',
            )
        ),

        'lightbox' => array(
            'type' => 'select',
            'label' => __('Show Lightbox:', 'radium'),
            'desc' => __('', 'radium'),
            'std' => 'yes',
            'options' => array(
                'no' => 'No',
                'yes' => 'Yes',
            )
        ),

        'thumbnail' => array(
            'type' => 'text',
            'label' => __('Thumbnail Url:', 'radium'),
            'desc' => __('Useful when lightbox is enabled', 'radium'),
        ),
    ),
    'shortcode' => '[radium_embed_video title="{{title}}" link="{{link}}" size="{{size}}" fullwidth="{{fullwidth}}"  lightbox="{{lightbox}}" thumbnail="{{thumbnail}}"] ',
    'popup_title' => __('Radium Video Shortcodes', 'radium')
);


/*-----------------------------------------------------------------------------------*/
/*  Columns Config
/*-----------------------------------------------------------------------------------*/

$radium_shortcodes['columns'] = array(
    'params' => array(),
    'shortcode' => ' {{child_shortcode}} ', // since there is no wrapper shortcode
    'popup_title' => __('Column Shortcodes', 'radium'),
    'no_preview' => true,

    // child shortcode is clonable & sortable
    'child_shortcode' => array(
        'params' => array(
            'column' => array(
                'type' => 'select',
                'label' => __('Column Size:', 'radium'),
                'desc' => __('', 'radium'),
                'options' => array(
                    'one_third' => '1/3 &nbsp;&nbsp;&nbsp;&nbsp;One Third',
                    'one_third_last' => '1/3L &nbsp;&nbsp;One Third Last',
                    'two_third' => '2/3 &nbsp;&nbsp;&nbsp;&nbsp;Two Thirds',
                    'two_third_last' => '2/3L &nbsp;&nbsp;Two Thirds Last',
                    'one_half' => '1/2 &nbsp;&nbsp;&nbsp;&nbsp;One Half',
                    'one_half_last' => '1/2L &nbsp;&nbsp;One Half Last',
                    'one_fourth' => '1/4 &nbsp;&nbsp;&nbsp;&nbsp;One Fourth',
                    'one_fourth_last' => '1/4L &nbsp;&nbsp;One Fourth Last',
                    'three_fourth' => '3/4 &nbsp;&nbsp;&nbsp;&nbsp;Three Fourth',
                    'three_fourth_last' => '3/4L &nbsp;&nbsp;Three Fourths Last',
                    'one_fifth' => '1/5 &nbsp;&nbsp;&nbsp;&nbsp;One Fifth',
                    'one_fifth_last' => '1/5L &nbsp;&nbsp;One Fifth Last',
                    'two_fifth' => '2/5 &nbsp;&nbsp;&nbsp;&nbsp;Two Fifth',
                    'two_fifth_last' => '2/5L &nbsp;&nbsp;Two Fifths Last',
                    'three_fifth' => '3/5 &nbsp;&nbsp;&nbsp;&nbsp;Three Fifth',
                    'three_fifth_last' => '3/5L &nbsp;&nbsp;Three Fifths Last',
                    'four_fifth' => '4/5 &nbsp;&nbsp;&nbsp;&nbsp;Four Fifth',
                    'four_fifth_last' => '4/5L &nbsp;&nbsp;Four Fifths Last',
                    'one_sixth' => '1/6 &nbsp;&nbsp;&nbsp;&nbsp;One Sixth',
                    'one_sixth_last' => '1/6L &nbsp;&nbsp;One Sixth Last',
                    'five_sixth' => '5/6 &nbsp;&nbsp;&nbsp;&nbsp;Five Sixths',
                    'five_sixth_last' => '5/6L &nbsp;&nbsp;Five Sixths Last'
                )
            ),
            'content' => array(
                'std' => '',
                'type' => 'textarea',
                'label' => __('Column Content:', 'radium'),
                'desc' => __('', 'radium'),
            )
        ),

        'shortcode' => '[{{column}}] {{content}} [/{{column}}] ',
        'clone_button' => __('Click to Add Another Column', 'radium')
    )
);

/*-----------------------------------------------------------------------------------*/
/*  Tabs Config
/*-----------------------------------------------------------------------------------*/

$radium_shortcodes['tabs'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode' => '[tabs] {{child_shortcode}}  [/tabs]',
    'popup_title' => __('Tab Shortcode', 'radium'),

    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Title:', 'radium'),
                'desc' => __('', 'radium'),
            ),
            'type' => array(
                'type' => 'select',
                'label' => __('Tabs Type', 'radium'),
                'desc' => __('', 'radium'),
                'options' => array(
                    'vertical' => 'Vertical',
                    'horizontal' => 'Horizontal'
                )
            ),
            'content' => array(
                'std' => '',
                'type' => 'textarea',
                'label' => __('Tab Content:', 'radium'),
                'desc' => __('', 'radium')
            )
        ),
        'shortcode' => '[tab title="{{title}}" type="{{type}}"] {{content}} [/tab]',
        'clone_button' => __('Click to Add Another Tab', 'radium')
    )
);

/*-----------------------------------------------------------------------------------*/
/*  Toggle Config
/*-----------------------------------------------------------------------------------*/

$radium_shortcodes['toggle'] = array(
    'no_preview' => true,
    'params' => array(
        'title' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('Title:', 'radium'),
            'desc' => __('', 'radium'),

        ),
        'content' => array(
            'std' => '',
            'type' => 'textarea',
            'label' => __('Content:', 'radium'),
            'desc' => __('Add the toggle content. (HTML Accepted)', 'radium'),
        ),
        'state' => array(
            'type' => 'select',
            'label' => __('Loading State:', 'radium'),
            'desc' => __('Select the state of the toggle on page load.', 'radium'),
            'options' => array(
                'open' => 'Open',
                'closed' => 'Closed'
            )
        ),

    ),
    'shortcode' => '[toggle title="{{title}}" state="{{state}}"] {{content}} [/toggle]',
    'popup_title' => __('Toggle Content Shortcode', 'radium')
);

?>
