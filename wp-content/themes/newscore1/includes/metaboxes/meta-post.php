<?php

/**
 *  Meta Boxes Page Post Type
 *
 * @since 2.1.6
 *
 * @return $meta_boxes
 */
function radium_register_post_meta_boxes( $meta_boxes ){

    $prefix = apply_filters( 'radium_theme_metabox_prefix', '_radium_');

    global $meta_boxes, $pagenow;

    $framework = radium_framework();

/*--------------------------------------------------------------------*/
/*  POST FORMAT: AUDIO
/*--------------------------------------------------------------------*/
$meta_boxes[] = array(
    'id' => 'radium-meta-box-settings',
    'title' =>  __('Post Settings', 'radium'),
    'page' => array('post'),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
                "name" => __('Feature Post:','radium'),
                "desc" => __('Mark this post as featured','radium'),
                "id" => $prefix."featured",
                "type" => "checkbox",
                "std" => 0
        ),
        
        array(
                "name" => __('Editor\'s Pick:','radium'),
                "desc" => __('Mark this post as an editor\'s pick','radium'),
                "id" => $prefix."editors_pick",
                "type" => "checkbox",
                "std" => 0
        ),
        
        array(
                "name" => __('Carousel slider:','radium'),
                "desc" => __('Add this post to carousel slider','radium'),
                "id" => $prefix."carousel_slider",
                "type" => "checkbox",
                "std" => 1
        ),
        
        array(
            'name'     => __('Featured Image Size:', 'radium'),
            'id'       => $prefix . 'featured_image_size',
            'type'     => 'radio_image',
            'options'  => array(
                'large'      => '<img src="' . $framework->theme_framework_images_url . '/image_large.png" alt="' . __('Fullwidth', 'radium') . '" title="' . __('Large Featured Image"', 'radium') . ' />',
                'medium'      => '<img src="' . $framework->theme_framework_images_url . '/image_medium.png" alt="' . __('Medium Images', 'radium') . '" title="' . __('Small Featured Image', 'radium') . '" />',
                'none'      => '<img src="' . $framework->theme_framework_images_url . '/image_none.png" alt="' . __('No Image', 'radium') . '" title="' . __('No Featured Image', 'radium') . '" />',
                
            ),
            'std'  => '',
            'desc' => __('', 'radium')
        ),
        
        array(
                "name" => __('Featured Image Aspect Ratio:','radium'),
                "desc" => __('Preserve featured image aspect ratio (do not crop the image)','radium'),
                "id" => $prefix."featured_image_aspect_ratio",
                "type" => "checkbox",
                "std" => 0
        ),
        
        array(
            'name'     => __('Page Layout (Sidebars):', 'radium'),
            'id'       => $prefix . 'page_layout',
            'type'     => 'radio_image',
            'options'  => array(
                'none'      => '<img src="' . $framework->theme_framework_images_url . '/1col.png" alt="' . __('Fullwidth - No sidebar', 'radium') . '" title="' . __('Fullwidth - No sidebar"', 'radium') . ' />',
                'left'      => '<img src="' . $framework->theme_framework_images_url . '/2cl.png" alt="' . __('Sidebar on the left', 'radium') . '" title="' . __('Sidebar on the left', 'radium') . '" />',
                'right'     => '<img src="' . $framework->theme_framework_images_url . '/2cr.png" alt="' . __('Sidebar on the right', 'radium') . '" title="' . __('Sidebar on the right', 'radium') . '" />'
            ),
            'std'  => '',
            'desc' => __('', 'radium')
        ),
    ),
);

/*--------------------------------------------------------------------*/
/*  POST FORMAT: AUDIO
/*--------------------------------------------------------------------*/
$meta_boxes[] = array(
	'id' => 'radium-meta-box-audio',
	'title' =>  __('Audio Settings', 'radium'),
	'page' => array('post'),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => 'Audio Track(s)',
			'id'   => "{$prefix}audio",
			'type' => 'file_advanced',
			"desc" => __('Supported formats are mp3, m4a, oga, fla, wma','radium'),
			//'max_file_uploads' => 1,
			'mime_type' => 'audio' // Leave blank for all file types
		),
		array(
		    'name' 	=> __('Poster Image', 'radium'),
		    'desc' 	=> __('The Preview Image (800px by 500px recommended)', 'radium'),
		    'id' 	=> $prefix . 'poster',
		    'type' 	=> 'image_advanced',
		    'max_file_uploads' => 1,
		)
 	),
);


if ( function_exists('video_central')) {
	
	/*--------------------------------------------------------------------*/
	/*  POST FORMAT: VIDEO - get video central videos
	/*--------------------------------------------------------------------*/
	$meta_boxes[] = array(
		'id' => 'radium-meta-box-video',
		'title' =>  __('Video Settings', 'radium'),
		'page' => array('post'),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
	 
			// POST
			array(
				'name'	=> __( 'Video', 'radium' ),
				'id'    => "{$prefix}video_id",
				'desc' 	=> __('Select a video uploaded to video central', 'radium'),
				'type'  => 'post',
				'post_type' => 'video',
				'field_type' => 'select_advanced',
				'query_args' => array(
					'post_status' => 'publish',
					'posts_per_page' => '-1',
				)
			),

 		)
	
	);

} else {
	
	/*--------------------------------------------------------------------*/
	/*  POST FORMAT: VIDEO 
	/*--------------------------------------------------------------------*/
	$meta_boxes[] = array(
		'id' => 'radium-meta-box-video',
		'title' =>  __('Video Settings', 'radium'),
		'page' => array('post'),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array( "name" => __('Video File','radium'),
					"desc" => __('The URL to the .m4v video file','radium'),
					"id" => $prefix . "video",
					'type' => 'file_advanced',
						'mime_type' => 'video' // Leave blank for all file types
			),
			array(
			    'name' 	=> __('Poster Image', 'radium'),
			    'desc' 	=> __('The Preview Image (800px by 500px recommended)', 'radium'),
			    'id' 	=> $prefix . 'poster',
			    'type' 	=> 'image_advanced',
			    'max_file_uploads' => 1,
			),
			array(
				'name' => __('Video URL', 'radium'),
				'desc' => __('If you are using something other than a self hosted video such as Youtube or Vimeo, paste the video page url here. The video will be embedded automatically. This field will override the ones above.', 'radium'),
				'id' => $prefix . 'embed_code',
				'type' => 'textarea',
				'std' => ''
			)
		)
	
	);
	
}

/*--------------------------------------------------------------------*/
/*  POST FORMAT: LINK
/*--------------------------------------------------------------------*/
$meta_boxes[] = array(
	'id' => 'radium-meta-box-link',
	'title' =>  __('Link Settings', 'radium'),
	'page' => array('post'),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array( "name" => __('Link URL:','radium'),
				"desc" => __('ex: www.radiumthemes.com','radium'),
				"id" => $prefix."link_url",
				"type" => "text",
				"std" => 'www.'
			),
	),

);

$meta_boxes[] = array(
	'id' => 'radium-meta-box-gallery',
	'title' => __('Gallery Settings', 'radium'),
	'page' => array('post'),
	'context' => 'normal',
	'priority' => 'high',

	'fields' => array(
		array( "name" => 'Gallery Images',
				"desc" => 'Images uploaded here will show up in the item page.',
				"id" => $prefix . "gallery_images",
				"type" => 'image_advanced',
 		),
		array(
			'name' 	=>  __('Gallery Type', 'radium'),
			'desc'	=> __('How to display Gallery', 'radium'),
			'id' 	=> $prefix . 'gallery_type',
			"type" 	=> "select",
			'std'	=>'featured',
			'options' => array(
				'stacked' 	=>'Stacked',
				'slideshow' =>'Slideshow',
				'popup-slideshow' =>'Popup Slideshow',
				'lightbox' 	=>'Lightbox',
			)
		),
    )
);

    $meta_boxes[] = array(
        'id' => 'radium-meta-post-rating',
        'title' =>  __('Post Rating Settings', 'radium'),
        'page' => array('post'),
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array( "name" => __('Enable Post Rating:','radium'),
                    "desc" => __('Turn on the rating feature','radium'),
                    "id" => $prefix."post_score",
                    "type" => "select",
                    'class'=> "rating-options-switch",
                    'options'  => array(
                        1 => __( 'Enable', 'radium' ),
                        0 => __( 'Disable', 'radium' )
                    )
            ),

            array( "name" => __('Rating Type:','radium'),
                    "desc" => __('','radium'),
                    "id" => $prefix."rating_type",
                    "type" => "select",
                    'class'=> "rating-options",
                    'options'  => array(
                        'stars' => __( 'Stars', 'radium' ),
                        'percentage' => __( 'Percentage', 'radium' )
                    )
            ),

            array(
                'name'      => 'Rating Header',
                'desc'      => "Leave empty if you don't want it",
                'id'        => "{$prefix}rating_header",
                'type'      => 'text',
                'class'=> "rating-options",
                'std'       => "",
                'cols'      => "50",
                'rows'      => "4"
            ),

            array( "name" => __('Brief Summary','radium'),
                    "desc" => __('The ratings summary in a word or two (eg Excellent, Good, Very Good, Bad, Poor)','radium'),
                    "id" => $prefix."rating_brief_summary",
                    "type" => "text",
                    'class'=> "rating-options",
            ),

            array( "name" => __('Longer Summary','radium'),
                    "desc" => __('The ratings summary','radium'),
                    "id" => $prefix."rating_longer_summary",
                    'type'      => 'textarea',
                    'class'=> "rating-options",
                    'std'       => "",
                    'cols'      => "50",
                    'rows'      => "4"
            ),

            array( "name" => __('Rating Display:','radium'),
                    "desc" => __('Where in the post do you want it to display?','radium'),
                    "id" => $prefix."rating_display_position",
                    "type" => "select",
                    'class'=> "rating-options",
                    'options'  => array(
                        'top' => __( 'Top', 'radium' ),
                        'bottom' => __( 'Bottom', 'radium' )
                    )
            ),

            array( "name" => __('Fields','radium'),
                    "desc" => __('','radium'),
                    "id" => $prefix."rating",
                    "type" => "repeater",
					'class'=> "rating-options",
                    /// Array of 'value' => 'Label' pairs for select box
                    'options'  => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '7',
                        '8' => '8',
                        '9' => '9',
                        '10' => '10',
                    ),

            ),

            array( "name" => __('Enable User Rating:','radium'),
                    "desc" => __('Allow users to add their rating','radium'),
                    "id" => $prefix."user_rating_enable",
                    "type" => "select",
                    'class'=> "rating-options",
                    'options'  => array(
                        1 => __( 'Enable', 'radium' ),
                        0 => __( 'Disable', 'radium' )
                    )
            ),

        ),

    );

    return $meta_boxes;

}

add_filter( 'rwmb_meta_boxes', 'radium_register_post_meta_boxes' );