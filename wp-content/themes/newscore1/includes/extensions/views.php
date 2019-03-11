<?php
/**
 * [radium_theme_post_views function to display number of posts.
 * @param  integer $post_id [description]
 * @return [type]           [description]
 */
function radium_theme_post_views ( $post_id = 0 ) {

    $count = radium_theme_get_post_views( $post_id );

     if ( $count == '' ) {

        echo 0;

        return;
    }

    echo $count;

}

/**
 * [radium_theme_get_post_views description]
 * @param  [type] $post_id [description]
 * @return [type]         [description]
 */
function radium_theme_get_post_views( $post_id = 0 ){

    $post_id = $post_id ? $post_id : get_the_ID();

    $count_key = '_radium_post_views_count';

    $count = get_post_meta( $post_id, $count_key, true );

    if ( $count == '' ) {

        delete_post_meta( $post_id, $count_key );

        add_post_meta( $post_id, $count_key, '0' );

        return 0;

    }

    return $count;
}

// function to count views.
/**
 * [radium_theme_set_post_views description]
 * @param  [type] $post_id [description]
 * @return [type]         [description]
 */
function radium_theme_set_post_views( $post_id = 0  ) {

    if ( radium_theme_get_current_user_role() == 'administrator' && !is_single() ) return;

    $post_id = $post_id ? $post_id : get_the_ID();

    $count_key = '_radium_post_views_count';

    $count = get_post_meta( $post_id, $count_key, true );

    if ( $count == '' ) {

        $count = 0;

        delete_post_meta( $post_id, $count_key );

        add_post_meta( $post_id, $count_key, '0' );

    } else {

        $count++;

        update_post_meta( $post_id, $count_key, $count );

    }

}
add_action('radium_before_single_post_content', 'radium_theme_set_post_views');

/**
 * [radium_theme_posts_column_views Add it to a column in WP-Admin - (Optional)
 * @param  [type] $defaults [description]
 * @return [type]           [description]
 */
function radium_theme_posts_column_views($defaults){
    $defaults['post_views'] = __('Views', 'radium');
    return $defaults;
}
//add_action('manage_posts_custom_column', 'radium_theme_posts_column_views',5,2);

/**
 * [radium_theme_posts_custom_column_views description]
 * @param  [type] $column_name [description]
 * @param  [type] $id          [description]
 * @return [type]              [description]
 */
function radium_theme_posts_custom_column_views($column_name, $id){
    if($column_name === 'post_views'){
        echo radium_theme_get_post_views(get_the_ID());
    }
}
///add_filter('manage_posts_columns', 'radium_theme_posts_custom_column_views');

