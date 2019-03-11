<?php
/**
 * Radium Theme Query Class
 *
 * This is used to create cacheable query to boost performance
 *
 * @since  2.2.0
 *
 * @category RadiumFramework
 * @package  NewsCore WP
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 */

class Radium_Theme_WP_Query {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	private static $instance;

    /**
     * __construct initialize the class and hook into wordpress
     *
     * @return null
     */
    public function __construct() { 
   
    }

    /**
     * Return a cached query
     *
     * @param  string $name_the_transient name of transient key
     * @param  array  $args               query arguments
     * @param  integer $expires           transient expiration in seconds
     * @return Object                     the cached object
     */
    public static function cache_query( $args = array(), $name_the_transient, $expires = 600 ) {
		
		$expires = apply_filters('radium_cache_query_time', radium_get_option('query_transient_cache_time', false, $expires), $name_the_transient);
		
		$args['suppress_filters'] = false;
		
		if( $expires == 0 || !radium_get_option('query_transient', false) ) {
 			
 			$query = new WP_Query( $args );
 			
 		} else {
	        
	        if ( class_exists('SitePress') ) {
	        	
	        	global $sitepress;
	        	
	        	$current_lang = $sitepress->get_current_language();
	        	$name_the_transient = $current_lang ? $name_the_transient . $current_lang : $name_the_transient;
	        }
	        
	        if ( false == get_transient($name_the_transient) ) {
	
	            $query = new WP_Query( $args );
	
	            set_transient( $name_the_transient, $query, $expires );
	
	        } else {
	
	            $query = get_transient($name_the_transient);
	
	        }
        
        }

        return $query;

    }
    
    /**
     * Wrapper around get_posts that utilizes object caching
     * 
     * @access public
     * @param mixed $args (default: NUL)
     * @param bool $force_refresh (default: false)
     * @return void
     */
    public static function get_posts_cached( $args = array(), $name_the_transient, $expires = 600 ) {
    	    	
    	$expires = apply_filters('radium_get_posts_cached_time', radium_get_option('query_transient_cache_time', false, $expires), $name_the_transient);
    	
    	$args['suppress_filters'] = false;
    	
    	if( $expires == 0 || !radium_get_option('query_transient', false) ) {
    			
			$posts = get_posts( $args );
    			
    	} else {
 	    	
	    	if ( false == get_transient($name_the_transient) ) {
	    	
	            $posts = get_posts( $args );
	
	            set_transient( $name_the_transient, $posts, $expires );
	
	        } else {
	
	            $posts = get_transient($name_the_transient);
	
	        }
        
        }
        
        return $posts;
    }

}


/** Related Videos **********************************************************/

/**
 * Filter to "pre_get_posts" to change query vars
 *
 * @since 2.2.0
 */
function radium_related_tax_query_get_posts( $query ) {
	
	if(is_admin() || is_search() )
		return;

 	// Only display posts on search results page
	if (is_search() && $query->is_main_query())
		$query->set('post_type', 'post');
	
	// Make tax_query support "post-format-standard"
	$tax_query = $query->get('tax_query');
	
	if(!empty($tax_query)) {
	
		foreach($tax_query as $index => $single_tax_query) {
			if(empty($single_tax_query['terms']))
				continue;
			
			$in_post_formats = (array)$single_tax_query['terms'];
			
			if($single_tax_query['taxonomy'] == 'post_format'
			&& $single_tax_query['field'] == 'slug'
			&& in_array('post-format-standard', $in_post_formats)) {
				
				// Get reverse operator
				$reverse_operator = 'IN';
				if(empty($single_tax_query['operator']) || $single_tax_query['operator'] == 'IN')
					$reverse_operator = 'NOT IN';
				elseif($single_tax_query['operator'] == 'AND')
					break;
				
				// Get "not in post formats"
				$post_formats = get_theme_support('post-formats');
				$all_post_formats = array();
				if(is_array( $post_formats[0])) {
					$all_post_formats = array();
					foreach($post_formats[0] as $post_format)
						$all_post_formats[] = 'post-format-'.$post_format;
				}
				
				$not_in_post_formats = array_diff($all_post_formats, $in_post_formats);
				
				// Reset post_format in tax_query
				$query->query_vars['tax_query'][$index] = array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => $not_in_post_formats,
					'operator' => $reverse_operator
				);
				
			}
		}
	}
	
	return $query;
}
add_action( 'pre_get_posts', 'radium_related_tax_query_get_posts' );

/**
 * Related Posts
 *
 * @since 2.2.0
 */
function radium_theme_has_related_posts( $args = '' ) {

    global $post;

    $framework = radium_framework();

    $query_args = array();

    $defaults = array(
        'number' => 5
    );

    $args = wp_parse_args($args, $defaults);

    extract($args);

    // Check limited number
    if(!$number) return;

    // Check taxonomies
    $taxes = get_post_taxonomies($post->ID);

    if(empty($taxes)) return;

    $taxes = array_unique(array_merge(array('post_tag', 'category'), $taxes));

    $tax_query = array();
    $in_tax_query_array = array();
    $and_tax_query_array = array();
    $post_format_query_array = null;

    foreach($taxes as $tax) {

        if( $tax == 'post_format') {
            // Post format
            $post_format = get_post_format($post->ID);
            if(!$post_format) $post_format = 'standard';
            $post_format_query_array = array(
                'taxonomy' => 'post_format',
                'field' => 'slug',
                'terms' => 'post-format-'.$post_format,
                'operator' => 'IN'
            );

            continue;
        }

        $terms = get_the_terms($post->ID, $tax);

        if(empty($terms))
            continue;

        $term_ids = array();
        foreach($terms as $term)
            $term_ids[] = $term->term_id;

        $in_tax_query_array[$tax] = array(
            'taxonomy' => $tax,
            'field' => 'id',
            'terms' => $term_ids,
            'operator' => 'IN'
        );

        $and_tax_query_array[$tax] = array(
            'taxonomy' => $tax,
            'field' => 'id',
            'terms' => $term_ids,
            'operator' => 'AND'
        );
    }

    if(empty($in_tax_query_array) && empty($and_tax_query_array))
        return;

    $query_args = array(
        'post_type' => get_post_type($post->ID),
        'ignore_sticky_posts' => true,
        'posts_per_page' => $number
    );

    $current_post_id = $post->ID;
    $found_posts = array();

    // Multiple Taxonomy Query: relation = AND, operator = AND
    $query_args['tax_query'] = $and_tax_query_array;
    $query_args['tax_query'][] = $post_format_query_array;
    $query_args['tax_query']['relation'] = 'AND';
    $query_args['post__not_in'] = array($post->ID);

    $related = new WP_Query($query_args);

    foreach($related->posts as $post)
        $found_posts[] = $post->ID;

    // Multiple Taxonomy Query: relation = AND, operator = IN
    if(count($found_posts) < $number) {
        $query_args['tax_query'] = $in_tax_query_array;
        $query_args['tax_query'][] = $post_format_query_array;
        $query_args['tax_query']['relation'] = 'AND';
        $query_args['post__not_in'] = array_merge(array($current_post_id), $found_posts);
        $related = new WP_Query($query_args);
        foreach($related->posts as $post)
            $found_posts[] = $post->ID;
    }

    $post_format_query = array(
        'taxonomy' => 'post_format',
        'field' => 'slug',
        'terms' => get_post_format(),
        'operator' => 'IN'
    );

    // Foreach Each Taxonomy Query: operator = AND
    if(count($found_posts) < $number) {

        foreach($and_tax_query_array as $and_tax_query) {
            $query_args['tax_query'] = array($and_tax_query);
            $query_args['tax_query'][] = $post_format_query_array;
            $query_args['tax_query']['relation'] = 'AND';
            $query_args['post__not_in'] = array_merge(array($current_post_id), $found_posts);
            $related = new WP_Query($query_args);
            foreach($related->posts as $post)
                $found_posts[] = $post->ID;

            if(count($found_posts) > $number)
                break;
        }
    }

    // Foreach Each Taxonomy Query: operator = IN
    if(count($found_posts) < $number) {

        foreach($in_tax_query_array as $in_tax_query) {
            $query_args['tax_query'] = array($in_tax_query);
            $query_args['tax_query'][] = $post_format_query_array;
            $query_args['tax_query']['relation'] = 'AND';
            $query_args['post__not_in'] = array_merge(array($current_post_id), $found_posts);
            $related = new WP_Query($query_args);
            foreach($related->posts as $post)
                $found_posts[] = $post->ID;

            if(count($found_posts) > $number)
                break;
        }
    }

    if(empty($found_posts))
        return;

    $query_args['tax_query'] = '';
    $query_args['post__in'] = $found_posts;
    $framework->related_posts_query = new WP_Query($query_args);

    return apply_filters( __FUNCTION__, $framework->related_posts_query->have_posts(), $framework->related_posts_query );
}

/**
 * Whether there are more posts available in the loop
 *
 * @since 2.2.0
 *
 * @uses video_central:related_video_query::have_posts() To check if there are more videos
 *                                          available
 * @return object Forum information
 */
function radium_theme_related_posts() {

    // Put into variable to check against next
    $have_posts = radium_framework()->related_posts_query->have_posts();

    // Reset the post data when finished
    if ( empty( $have_posts ) )
        wp_reset_postdata();

    return $have_posts;
}

/**
 * Loads up the current post in the loop
 *
 * @since 2.2.0
 *
 * @uses video_central:related_video_query::the_post() To get the current video
 * @return object Forum information
 */
function radium_theme_the_related_post() {
    return radium_framework()->related_posts_query->the_post();
}

/**
 * Flush post special case query cache on post save
 * 
 * @return void
 */ 
function radium_flush_post_query_cache () {

    global $post;
	
	if ((!defined ("DOING_AUTOSAVE") || !DOING_AUTOSAVE) && get_post_type ($post) == "post" && radium_get_option('query_transient', false) ) { // Post type can also be page, post, etc
		
		$keys = array(
			'rm_hder_trng_hdlns',
			'rdm_top_news_today',
			'rdm_top_news_latest'
		);
		
		foreach ($keys as $key) {
			delete_transient( $key );
		}
		
	} // if ()
}
add_action ("save_post", "radium_flush_post_query_cache");
