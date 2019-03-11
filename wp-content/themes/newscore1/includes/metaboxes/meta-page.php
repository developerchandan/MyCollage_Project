<?php
/**
 *  Meta Boxes Page Post Type
 *
 * @since 2.1.6
 *
 * @return $meta_boxes
 */
function radium_register_page_meta_boxes( $meta_boxes ){

    $prefix = apply_filters( 'radium_theme_metabox_prefix', '_radium_');

    global $meta_boxes, $pagenow;

    $framework = radium_framework();

    $arg = array(

        array('name' => __('Hide Page Title', 'radium'),
            'id'   => $prefix . 'hide_title',
            'type' => 'checkbox',
            'std' => '',
        ),

  		/*array('name' => __('Subtitle:', 'radium'),
 			'id'   => $prefix . 'subtitle',
 			'type' => 'text',
 			'desc' => 'Page subtitle',
 		), */

 		array(
 			'name'     => __('Page Layout (Sidebars):', 'radium'),
 			'id'       => $prefix . 'page_layout',
 			'type'     => 'radio_image',
 			'options'  => array(
 				'' 			=> '<img src="' . $framework->theme_framework_images_url . '/1col.png" alt="' . __('Fullwidth - No sidebar', 'radium') . '" title="' . __('Fullwidth - No sidebar"', 'radium') . ' />',
 				'left'  	=> '<img src="' . $framework->theme_framework_images_url . '/2cl.png" alt="' . __('Sidebar on the left', 'radium') . '" title="' . __('Sidebar on the left', 'radium') . '" />',
 				'right' 	=> '<img src="' . $framework->theme_framework_images_url . '/2cr.png" alt="' . __('Sidebar on the right', 'radium') . '" title="' . __('Sidebar on the right', 'radium') . '" />'
 			),
 			'std'  => '',
 			'desc' => __('', 'radium')
 		),

    );

    $meta_boxes[] = array(
    	'id' => 'details',
    	'title' => 'Page Settings',
    	'pages' => array('page'),
    	'context' => 'normal',
    	'priority' => 'high',
    	'fields' => apply_filters( 'radium_page_setting_metaboxes', $arg )
    );

       /* ---------------------------------------------------------------------- */
    /*  Page Sidebar
    /* ---------------------------------------------------------------------- */
     $sidebar = array(

        array(
            'name' => __('Select Column Layout:', 'radium'),
            'id'   => $prefix . 'page_columns',
            'type'      => 'select',
            'options'   => array(
                //'one-column' => 'One Column',
                'two-columns' => 'Two Columns',
                'small-thumbs' => 'Small Thumbs',
            ),
            'multiple'  => false,
            'std'       => array( 'one-columns' )
        ),

        array(
            'name' => __('Items per Page ', 'radium'),
            'id'   => $prefix . 'items_count',
            'type' => 'text',
            'std'  => '-1',
            'desc' => ''
        ),

    );

    $meta_boxes[] = array(
        'id'       => 'page-cpt-sidebar',
        'title'    => __('Template Settings', 'radium'),
        'pages'    => array('page'),
        'context'  => 'side',
        'priority' => 'high',
        'fields'   => apply_filters( 'radium_page_sidebar_metaboxes', $sidebar )
    );

    return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'radium_register_page_meta_boxes' );
