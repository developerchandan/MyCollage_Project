<?php
/*-----------------------------------------------------------------------------------

 	Widget Name: Tabbed Content Widget
 	Widget URI:
 	Description:  A widget that displays your recent portfolios.
 	Author: RadiumThemes
 	Author URI: http://radiumthemes.com
 	Version: 1.0

-----------------------------------------------------------------------------------*/

// Add function to widgets_init that'll load our widget.
add_action('widgets_init', 'radium_posts_tabs_load_widgets');

// Register widget.
function radium_posts_tabs_load_widgets() {
	register_widget('Radium_Posts_Tabs_Widget');
}

// Widget class
class Radium_Posts_Tabs_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		parent::__construct(
	 		'radium_post_tabs', // Base ID
			__('Radium Post Tabs', 'radium'), // Name
			array( 'description' => __( 'Popular posts, Recent post and Comments', 'radium' ), )
		);
	}

	/*-----------------------------------------------------------------------------------*/
	/*	Display Widget
	/*-----------------------------------------------------------------------------------*/

	public function widget($args, $instance) {
		global $post;

		extract($args);

		$posts 				= $instance['posts'];
		$comments 			= $instance['comments'];
		$recent_posts_count = isset($instance['recent_posts']) ? $instance['recent_posts'] : 6;
		
		$show_popular_posts = isset($instance['show_popular_posts']) ? true : false;
		$show_recent_posts 	= isset($instance['show_recent_posts']) ? true : false;
		$show_comments 		= isset($instance['show_comments']) ? true : false;

        $thumbnail_size  = isset($instance['thumbnail_size']) ? $instance['thumbnail_size'] : 'large';

       //Set Thumbs
        if ( $thumbnail_size == 'small-left' ||  $thumbnail_size == 'small-right') {
            $title_tag = 'h5';

        } else {
            $title_tag = 'h4';
        }
        
       	$class = null;
       	
       	$class .= $show_popular_posts ? 'has-popular-posts' : '';
        $class .= $show_recent_posts ? ' has-recent-posts' : '';
        $class .= $show_comments ? ' has-recent-comments' : '';
        
		echo $before_widget;

		?>
		<div class="posts-widget-wrapper thumbnail-<?php echo $thumbnail_size; ?> <?php echo $class; ?>">
            <div class="tab-holder">
    			<div class="tab-hold tabs-wrapper">
    				<ul id="tabs" class="tabset tabs clearfix">
    					<?php if($show_popular_posts == 'true'): ?>
    						<li class="popular active"><a href="#popular"><span><?php _e('Popular', 'radium'); ?></span></a></li>
    					<?php endif; ?>
    					<?php if($show_recent_posts == 'true'): ?>
    						<li class="recent"><a href="#recent"><span><?php _e('Recent', 'radium'); ?></span></a></li>
    					<?php endif; ?>
    					<?php if($show_comments == 'true'): ?>
    						<li class="comments"><a href="#comments"><span><?php _e('Comments', 'radium'); ?></span></a></li>
    					<?php endif; ?>
    				</ul>
    				<div class="tab-box tabs-container">
    					<?php if($show_popular_posts) : ?>

    						<div id="popular" class="tab tab_content popular" style="display: block;">
                                <?php $this->get_posts('popular', $instance ); ?>
    						</div>

    					<?php endif;

    					if( $show_recent_posts ) : 
    						$style = $show_popular_posts ? 'display: none;' : 'display: block;';
    					?>

    						<div id="recent" class="tab tab_content recent" style="<?php echo $style; ?>">
                                <?php $this->get_posts('recent', $instance ); ?>
    						</div>

    					<?php endif; ?>

    					<?php 
    					
    					if($show_comments) :
    					   $style = $show_recent_posts ? 'display: none;' : 'display: block;';
    					 
    					 ?>

    						<div id="comments" class="tab tab_content comments" style="<?php echo $style; ?>">

    							<ul class="news-list">

    								<?php
    								$number = $instance['comments'];

    								global $wpdb, $comments, $comment;

    								$number = 3;
    								if($number < 1)
    									$number = 1;
    								else if($number > 15)
    									$number = 15;

    								if( !$comments = wp_cache_get('recent_comments', 'widget') ) {

    									$sql = "select * from $wpdb->comments where comment_approved = '1' order by comment_date_gmt DESC limit $number";
    									$comments = $wpdb->get_results($sql);
    									wp_cache_add('recent_comments', $comments, 'widget');

    								}

    								if( $comments ) :

    									foreach((array)$comments as $comment) : ?>

    										<li class="comments">
    											<?php

    											$url = get_comment_author_url();
    											$author = get_comment_author();

    											?>

    											<h5 class="entry-title">
    												<a href='<?php echo $url; ?>' rel='external nofollow' class='url'><?php echo $author; ?></a> on <a href="<?php echo get_comment_link($comment->comment_ID); ?>"><?php echo get_the_title($comment->comment_post_ID); ?></a>
    											</h5>
    											<div class="entry-meta"><?php echo get_the_time('F j Y'); ?></div>

    										</li>

    										<?php

    									endforeach;

    								endif;

    								?>
    							</ul>
    						</div>
    					<?php endif; ?>

    				</div>
    			</div>
    		</div>

        </div>

		<?php
		echo $after_widget;
	}

	function update($new_instance, $instance) {

		$instance['posts'] = $new_instance['posts'];
		$instance['comments'] = $new_instance['comments'];
		$instance['recent_posts'] = $new_instance['recent_posts'];
		$instance['show_popular_posts'] = $new_instance['show_popular_posts'];
		$instance['show_recent_posts'] = $new_instance['show_recent_posts'];
		$instance['show_comments'] = $new_instance['show_comments'];
		$instance['show_recent_posts'] = $new_instance['show_recent_posts'];
        $instance['thumbnail_size'] = $new_instance['thumbnail_size'];

		return $instance;
	}

	function form($instance) {

		$defaults = array(
			'posts' 	=> 6,
			'comments' 	=> 6,
			'recent_posts' => 6,
			'show_popular_posts' => 'on',
			'show_recent_posts'  => 'on',
			'show_comments'      => 'on',
            'thumbnail_size'     => 'large',
		);

		$instance = wp_parse_args((array) $instance, $defaults);
        $thumbnail_size = $instance['thumbnail_size'];

	?><p>
			<label for="<?php echo $this->get_field_id('posts'); ?>"><?php _e('Number of posts:', 'radium'); ?></label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>" />
		</p>

        <p>
            <label for="<?php echo $this->get_field_id('thumbnail_size'); ?>"><?php _e('Thumbnail size', 'radium'); ?></label>
            <select id="<?php echo $this->get_field_id( 'thumbnail_size' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail_size' ); ?>" class="widefat">
                <?php
                $i = 0;
                $options = array('small-left', 'large', 'small-right');
                foreach ($options as $option) {

                    $selected = $thumbnail_size == $option ? 'selected="selected"' : '';
                    echo '<option value="' . $option . '" id="' . $option . '" '. $selected . '>'. $option .'</option>';

                }
                ?>
            </select>
        </p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_popular_posts'], 'on'); ?> id="<?php echo $this->get_field_id('show_popular_posts'); ?>" name="<?php echo $this->get_field_name('show_popular_posts'); ?>" />
			<label for="<?php echo $this->get_field_id('show_popular_posts'); ?>"><?php _e('Show popular posts', 'radium'); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_recent_posts'], 'on'); ?> id="<?php echo $this->get_field_id('show_recent_posts'); ?>" name="<?php echo $this->get_field_name('show_recent_posts'); ?>" />
			<label for="<?php echo $this->get_field_id('show_recent_posts'); ?>"><?php _e('Show recent posts', 'radium'); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_comments'], 'on'); ?> id="<?php echo $this->get_field_id('show_comments'); ?>" name="<?php echo $this->get_field_name('show_comments'); ?>" />
			<label for="<?php echo $this->get_field_id('show_comments'); ?>"><?php _e('Show comments', 'radium'); ?></label>
		</p>
	<?php }

    function get_posts($type = 'recent', $instance ) {

        $thumbnail_size  = isset($instance['thumbnail_size']) ? $instance['thumbnail_size'] : 'large';
        $posts           = $instance['posts'];

       //Set Thumbs
        if ( $thumbnail_size == 'small-left' ||  $thumbnail_size == 'small-right') {
            $thumb_w    = '70'; //Define width
            $thumb_h    = '48'; // Define height
            $title_tag = 'h5';

        } else {
        
            $thumb_w    = '298'; //Define width
            $thumb_h    = '140'; // Define height
            $title_tag = 'h4';
        
        }

        $crop       = true; //resize
        $single     = true; //return array
		
		$args = array(
			'ignore_sticky_posts' => true,
			'showposts' => $posts, 
			'no_found_rows' => true //pagination off
		);
		
        if ( $type == 'recent' ) {
			
            $posts = new WP_Query($args);

        } else {
			
            $args['meta_key']   = '_radium_post_views_count';
            $args['orderby']    = 'meta_value_num';
            $args['orderby']    = 'comment_count';
            $args['order']      = 'DESC';

            $posts = new WP_Query($args);

        }
        
        if($posts->have_posts()) : ?>
            <ul class="news-list">
                <?php while($posts->have_posts()): $posts->the_post();

					$image = $thumb = $img_url = null;

                    //Check if post has a featured image set else get the first image from the gallery and use it. If both statements are false display fallback image.
                    if ( has_post_thumbnail() ) {

                        //get featured image
                        $thumb = get_post_thumbnail_id();
                        $img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the image is too big)

                    } else {

                        $attachments = get_children(
                            array(
                                'post_parent' => get_the_ID(),
                                'post_type' => 'attachment',
                                'post_mime_type' => 'image',
                                'orderby' => 'menu_order'
                            )
                        );

                        if ( ! is_array($attachments) ) continue;
                            $count = count($attachments);
                            $first_attachment = array_shift($attachments);

                        if ($first_attachment )
                             @$img_url = wp_get_attachment_url( $first_attachment->ID,'full' ); //get full URL to image (use "large" or "medium" if the image is too big)

                    }

                    $image = radium_resize($img_url, $thumb_w, $thumb_h, $crop, $single);

                    //add thumbnail fallback
                    if(empty($image)) $image = get_radium_first_post_image(true);

                ?>
                <li class="clearfix">
                	<div class="entry-content-media">
	                    <div class="post-image post-thumb zoom-img-in">
	                        <a href="<?php the_permalink(); ?>">
	
	                            <?php do_action('radium_before_post_tab_widget_thumb'); ?>
	
	                            <img src="<?php echo $image ?>" alt="<?php the_title(); ?>" height="<?php echo $thumb_h; ?>" width="<?php echo $thumb_w; ?>" />
	
	                            <?php do_action('radium_after_post_tab_widget_thumb'); ?>
	
	                        </a>
	                        <?php if ( $thumbnail_size == 'large') { ?>
	
	                        <div class="entry-meta">
	                            <?php do_action('radium_before_post_tab_widget_post_meta'); ?>
	                            <div class="date"><?php radium_human_time(); ?></div>
	                            <?php do_action('radium_after_post_tab_widget_post_meta'); ?>
	                        </div><?php } ?>
	
	                    </div>
                    </div>
                    
                    <div class="post-holder">
                        <<?php echo $title_tag; ?> class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo $title_tag; ?>>
                        <?php if ( $thumbnail_size == 'small-left' ||  $thumbnail_size == 'small-right') { ?><div class="entry-meta"><div class="date"><?php the_date(); ?></div></div><?php } ?>
                    </div>
                </li>
                <?php endwhile; ?>
            </ul>
            <?php

            endif;

            wp_reset_postdata();

    }

}
?>