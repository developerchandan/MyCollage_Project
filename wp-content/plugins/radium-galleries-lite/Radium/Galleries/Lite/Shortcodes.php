<?php
/**
 * Shortcodes class for Radium_Galleries.
 *
 * @since 1.0.0
 *
 * @package	Radium_Galleries
 * @author	Franklin M Gitonga
 */

class Radium_Galleries_Lite_Shortcodes {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		remove_shortcode( 'gallery' );

		add_shortcode('gallery', array( $this, 'gallery_shortcode'));

	}

	/**
	 * The Gallery shortcode.
	 *
	 * This implements the functionality of the Gallery Shortcode for displaying
	 * WordPress images on a post.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr Attributes of the shortcode.
	 * @return string HTML content to display gallery.
	 */
	public function gallery_shortcode($attr) {

		$post = get_post();

		static $instance = 0;
		$instance++;

		if ( ! empty( $attr['ids'] ) ) {
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) )
				$attr['orderby'] = 'post__in';
			$attr['include'] = $attr['ids'];
		}

		// Allow plugins/themes to override the default gallery template.
		$output = apply_filters('post_gallery', '', $attr);
		if ( $output != '' )
			return $output;

		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( !$attr['orderby'] )
				unset( $attr['orderby'] );
		}

		extract(shortcode_atts(array(
			'order'		=> 'ASC',
			'orderby'	=> 'menu_order ID',
			'id'		=> $post->ID,
			'itemtag'	=> 'div',
			'icontag'	=> 'div',
			'captiontag'=> 'div',
			'columns'	=> 3,
			'size'		=> 'full',
			'include'	=> '',
			'exclude'	=> '',
			'link' 		=> '',
			'type'      => 'lightbox', // lightbox, slider, default,
			'height'     => 500,
			'width'      => 600,
		), $attr));

		//Setup Gallery from arguments above. Some of the default Parameters from Wordpress will be ignored i.e size, itemtag, icontag, captiontag

        if ( $columns == 4 ) {

            $size = array( 239, 149 );
            $size_class = 'four-columns';

        } elseif ( $columns == 3 ) {

			$size = array( 300, 200 );
			$size_class = 'three-columns';

		} elseif ( $columns == 2  ) {

 			$size = array( 430, 300 );
			$size_class = 'two-columns';

		} elseif ( $columns == 1 ) {

            $size = array( 930, (930/1.6666) );
            $size_class = 'one-column';

		} else {

			$size = array( 300, 200 );
			$size_class = 'three-columns';
		}

		$id = intval($id);
		if ( 'RAND' == $order )
			$orderby = 'none';

		if ( !empty($include) ) {

			$_attachments = get_posts(
				array(
					'include' 			=> $include,
					'post_status' 		=> 'inherit',
					'post_type' 		=> 'attachment',
					'post_mime_type' 	=> 'image',
					'order' 			=> $order,
					'orderby' 			=> $orderby
				)
			);

			$attachments = array();

			foreach ( $_attachments as $key => $val )
				$attachments[$val->ID] = $_attachments[$key];

		} elseif ( !empty($exclude) ) {

			$attachments = get_children(
				array(
					'post_parent' 		=> $id,
					'exclude' 			=> $exclude,
					'post_status' 		=> 'inherit',
					'post_type' 		=> 'attachment',
					'post_mime_type' 	=> 'image',
					'order' 			=> $order,
					'orderby' 			=> $orderby
				)
			);

		} else {

			$attachments = get_children(
				array(
					'post_parent' 		=> $id,
					'post_status' 		=> 'inherit',
					'post_type' 		=> 'attachment',
					'post_mime_type' 	=> 'image',
					'order' 			=> $order,
					'orderby' 			=> $orderby
				)
			);

		}

		if ( empty($attachments) )
			return '';

		if ( is_feed() ) {

			$output = "\n";

			foreach ( $attachments as $att_id => $attachment )
				$output .= wp_get_attachment_link($att_id, $size, true) . "\n";

			return $output;
		}

		$itemtag 		= tag_escape($itemtag);
		$captiontag 	= tag_escape($captiontag);
		$icontag 		= tag_escape($icontag);
		$valid_tags 	= wp_kses_allowed_html( 'post' );

		$columns 		= intval($columns);
		$itemwidth 		= $columns > 0 ? floor(100/$columns) : 100;
		$float 			= is_rtl() ? 'right' : 'left';
		$selector 		= "radium-gallery-{$instance}";

		if( $type === 'slider') {

			global $_wp_additional_image_sizes;
			$size = array( 9999, 99999 );
			$output .= "<div id='$selector' class='gallery gallery-id-{$id} gallery-{$type} ";

			// height of slider container
			$output .= "' width='".$width."'>\n";

			if(!in_array($size, $_wp_additional_image_sizes)){

			}

			$thumb_size = array(
				'h' => intval(get_option('thumbnail_size_h')),
		    	'w' => intval(get_option('thumbnail_size_w'))
			);

			foreach ( $attachments as $id => $attachment ) {

				$output .= "\t".'<a href="'.$attachment->guid.'">'."\n";

				$output .= wp_get_attachment_image( $id, $size, array(
								'class'	=> "attachment-$size",
								'alt'   => trim(strip_tags( get_post_meta($id, '_wp_attachment_image_alt', true))),
								'title' => trim(strip_tags( $attachment->post_title ))
				));

		        $output .= "\t\t".'<img title="'.wptexturize($attachment->post_excerpt).'" alt="';
		        $output .= trim(strip_tags( get_post_meta($id, '_wp_attachment_image_alt', true) ));
		        $output .= '" src="'.wp_get_attachment_thumb_url( $id );
		        $output .= "\" height='".$thumb_size['h']."' width='".$thumb_size['w']."' />\n";

		    	$output .= "\t".'</a>'."\n";
		    }

		    $output .= "</div>\n";

		} else {

			$gallery_style 	= $gallery_div = '';

			$gallery_div 	= "<div class='radium-gallery-wrapper'><div id='$selector' class='radium-gallery loading radium-gallery-id-{$id} clearfix'>";
			$output 		= apply_filters( 'radium_gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

			$i = 0;

			foreach ( $attachments as $id => $attachment ) {

	 			$img_url = wp_get_attachment_url( $id ); //get full URL to image (use "large" or "medium" if the image is too big)

				$image =  Radium_Galleries_Lite_Resizer::resize( $img_url, $size[0], $size[1], true, true);

                $post_title = $attachment->post_title ? $attachment->post_title :null;

				$gallery_item_container_open = "<{$itemtag} class='radium-gallery-item grid-thumb page-grid-item {$size_class}'>";

                $output .= apply_filters( 'radium_gallery_item_container_open', $gallery_item_container_open );

	 			if($type === 'core'){
					$href = isset($attr['link']) && 'file' == $attr['link'] ? $attachment->guid : get_attachment_link($id);
				} else {
					$href = $attachment->guid;
				}

				$output .= "<a rel='gallery[".$instance."]'  href='".$href."' data-width='". $size[0] ."' data-height='".$size[1] ."'>";
				$output .= "<img src={$image} alt='{$attachment->post_title}'/>";
				$output .= "</a>";
				$output .= $post_title ? "<h4>".$post_title."</h4>" : null;

				if ( $captiontag && trim($attachment->post_excerpt) ) {
					$output .= "<{$captiontag} class='wp-caption-text radium-gallery-caption'>";
					$output .= wp_trim_words( wptexturize($attachment->post_excerpt), 8, '...');
					$output .= "</{$captiontag}>";
				}

				$output .= "</{$itemtag}>";

			}

			$output .= "</div></div>\n";

		}

		return $output;
	}

}