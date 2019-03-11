<?php
/*
 * This file is a part of the RadiumFramework core.
 * Please be extremely cautious editing this file,
 *
 * @category RadiumFramework
 * @package  Carlton
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 */

/*
* Get Featured image caption
*
* @param $type - what to show image title, caption, description or alt
*
*/

function radium_get_the_featured_image_details( $parent_id = '', $Image_id = '', $type='caption') {

    if ( $Image_id ) {

        $thumb_id = $Image_id;

    } else {

        $parent_id 	= null;
        $parent_id 	= get_the_ID();
        $thumb_id 	= get_post_thumbnail_id( $parent_id );

    }

    $args = array(
        'post_type' 	=> 'attachment',
        'post_status' 	=> null,
        'post_parent' 	=> $parent_id,
        'include'  		=> $thumb_id,
        'suppress_filters' => false,
    );

    $thumbnail_image = get_posts($args);

    if ($thumbnail_image && isset($thumbnail_image[0])) {

        switch ( $type ) {

            case 'title':
                $output = $thumbnail_image[0]->post_title;
                break;

            case 'description':
                $output = $thumbnail_image[0]->post_content;
                break;

            case 'alt':
                $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
                if(count($alt)) $output = $alt;
                break;

            default:
                $output = $thumbnail_image[0]->post_excerpt;
                break;
        }
        return $output;
    }
}

/*----------------------------------------------------------------------------------
// get Youtube Video Thumbnail
 ----------------------------------------------------------------------------------*/

 function get_radium_youtube_video_image( $youtube_id  ) {

     $url = 'http://gdata.youtube.com/feeds/api/videos/'.$youtube_id.'?v=2&alt=jsonc';

     $response = wp_remote_get($url);

     if( is_wp_error( $response ) )
         return;

     $xml = $response['body'];

     if( is_wp_error( $xml ) )
        return;

    $json = json_decode( $xml );
    $image_url = $json->data->thumbnail->hqDefault;

     return $image_url;

 }


 /*----------------------------------------------------------------------------------
 // get Vimeo Video Thumbnail
  ----------------------------------------------------------------------------------*/

 function get_radium_vimeo_video_image( $vimeo_video_id ) {

    $url = 'http://vimeo.com/api/v2/video/'.$vimeo_video_id.'.php';
    $response = wp_remote_get($url);

    if ( is_wp_error( $response ) )
        return;

    $xml = wp_remote_retrieve_body( $response );

    $image_data = maybe_unserialize( $xml );

    if ( $image_data )
        $image = $image_data[0]['thumbnail_large'];

    return $image;
 }

// remove gallery shortcode styling
add_filter( 'use_default_gallery_style', '__return_false' );

/*-----------------------------------------------------------------------------------*/
/* Create the Gallery with a Slider */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'get_radium_gallery' ) ) {
    function get_radium_gallery( $postid, $image_w, $image_h = '', $crop = '', $meta_field = '' ) {

    //validate inputs
    if(!$postid OR !$image_w ) return false;

    $slide_id = $postid;
    $thumbid = 0;
    $output = null;

    if( $meta_field ) {

        $attachments = rwmb_meta( $meta_field, 'type=image' );

         if ( is_array( $attachments ) ) {

             $output .='<!-- BEGIN #slider-'.$postid.' -->
                 <div class="slider-wrapper">
                     <div class="post-slider post-slider-'.$postid.'">
                          <div id="slider-'.$postid.'"  class="loading media-slider">';
                              $output .='<ul class="slides">';
                              $i = 0;
                                foreach( $attachments as $image ) {

                                    $alt 		= ($image['alt']) 		? $image['alt'] : '';
                                    $caption 	= ($image['caption']) 	? $image['caption'] : '';

                                    $image = radium_resize( $image['full_url'], $image_w, $image_h, $crop ); //resize & crop the image

                                    $output .='<li>';

                                        $output .='<img height="'.$image_h.'" width="'.$image_w.'" src="'.$image.'" alt="'.$alt.'" style="display: block; height:'. $image_h .'px; width:'. $image_w .'px;"/>';

                                        if ( $caption )
                                            $output .= "<div class='slider-desc'><span class='gallery-caption'>". $caption ."</span></div>";

                                    $output .= '</li>';

                                    $i++;
                              }
                             $output .='</ul>';

                         $output .='</div>';

                 $output .= '</div><!-- END .post-slider-->';

                 $output .= '<div class="post-slider-nav post-slider-nav-'.$postid.'">';

                     $output .='<div id="carousel-'.$postid.'"  class="loading media-slider-nav">';

                        $output .='<ul class="slides">';

                            $i = 0;
                            $image_w = 150;
                            $image_h = 80;

                            foreach( $attachments as $image ) {

                                $image = radium_resize( $image['full_url'], $image_w, $image_h, true ); //resize & crop the image

                                $output .='<li><img height="'.$image_h.'" width="'.$image_w.'" src="'.$image.'" /></li>';

                                $i++;
                            }

                        $output .='</ul>';

                    $output .='</div><!-- END .media-slider-nav -->';

                 $output .= '</div><!-- END .post-slider-->';

             $output .= '</div><!-- END #slider-'.$postid.' -->';

        }

    } else {

        // get the featured image for the post
        if( has_post_thumbnail($postid) ) $thumbid = get_post_thumbnail_id($postid);

        //Create Exclusion array
        $exclude_images = array();
        $bg_images = get_post_meta( $postid, '_radium_bgimage', false );
        foreach ( $bg_images as $att ) $exclude_images[]=$att;

        // get all of the attachments for the post
        $args = array(
            'orderby' 			=> 'menu_order',
            'post_type' 		=> 'attachment',
            'post_parent' 		=> $postid,
            'exclude' 			=> $exclude_images,
            'post_mime_type' 	=> 'image',
            'post_status' 		=> null,
            'numberposts' 		=> -1,
            'suppress_filters' => false,
        );

        $attachments = get_posts($args);

        if( !empty($attachments) ) {

          $output .='<!-- BEGIN #slider-'.$postid.' -->
            <div class="slider-wrapper">
                <div class="post-slider post-slider-'.$postid.'">
                     <div id="slider-'.$postid.'" class="loading media-slider">';
                     $output .='<ul class="slides">';
                                  $i = 0;
                                  foreach( $attachments as $attachment ) {
                                      if( $attachment->ID == $thumbid ) continue;

                                      $src = wp_get_attachment_image_src( $attachment->ID, 'full' );
                                      $image = radium_resize( $src[0], $image_w, $image_h, $crop ); //resize & crop the image

                                      $caption = $attachment->post_excerpt;
                                      $caption = ($caption) ? "<div class='slider-desc'><span class='gallery-caption'>$caption</span></div>" : '';
                                      $alt = ( !empty($attachment->post_content) ) ? $attachment->post_content : $attachment->post_title;
                                      $output .='<li><img height="'.$image_h.'" width="'.$image_w.'" src="'.$image.'" alt="'.$alt.'" />'.$caption.'</li>';

                                      $i++;
                                  }
                    $output .='</ul>';

                $output .='</div>
                        </div>
                    </div><!-- END #slider-'.$postid.' -->';
             }

         }

         return $output;
    }
}

/*-----------------------------------------------------------------------------------*/
/*	Echo Gallery
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'radium_gallery' ) ) {
    function radium_gallery($postid, $image_w, $image_h='', $crop = '', $meta_field ='' ) {
        echo get_radium_gallery( $postid, $image_w, $image_h, $crop, $meta_field );
    }
}

/*-----------------------------------------------------------------------------------*/
/*	Lightbox Gallery
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'get_radium_lightbox_gallery' ) ) {
    function get_radium_lightbox_gallery( $postid, $image_w, $image_h = '', $crop = '', $meta_field = '', $columns = '' ) {

    //validate inputs
    if(!$postid OR !$image_w ) return false;

    $slide_id = $postid;
    $thumbid = 0;
    $output = null;

    if( $meta_field ) {

        $attachments = rwmb_meta( $meta_field, 'type=image' );

         if ( is_array( $attachments ) ) {

            $output .='<div class="lightbox-wrapper"><div class="radium-gallery thumbnails">';
            $i = 0;
             foreach( $attachments as $image ) {

                $classes = array( 'zoom' );

                //if ( $i == 0 || $i % $columns == 0 ) $classes[] = 'first';

                //if ( ( $i + 1 ) % $columns == 0 ) $classes[] = 'last';

                $src = $image['full_url'];
                $caption = $image['caption'] ? $image['caption'] : null;

                if ( ! $src )
                    continue;

                $image = radium_resize( $src, $image_w, $image_h, $crop ); //resize & crop the image
                $image_class = esc_attr( implode( ' ', $classes ) );
                $image_title = esc_attr( $caption );

                $output .='<a href="'.$src.'" itemprop="image" class="'.$image_class.'" title="'.$image_title.'" rel="prettyPhoto[product-gallery]">';

                $output .='<img height="'.$image_h.'" width="'.$image_w.'" class="wp-post-image" src="'.$image.'" alt="'.$image_title.'"  rel="prettyPhoto[lightbox-gallery]" />';

                $output .='</a>';

                $i++;

            }

             $output .='</div></div>';

        }

    } else {

        // get the featured image for the post
        if( has_post_thumbnail($postid) ) $thumbid = get_post_thumbnail_id($postid);

        //Create Exclusion array
        $exclude_images = array();
        $bg_images = get_post_meta( $postid, '_radium_bgimage', false );
        foreach ( $bg_images as $att ) $exclude_images[]=$att;

        // get all of the attachments for the post
        $args = array(
            'orderby' 			=> 'menu_order',
            'post_type' 		=> 'attachment',
            'post_parent' 		=> $postid,
            'exclude' 			=> $exclude_images,
            'post_mime_type' 	=> 'image',
            'post_status' 		=> null,
            'numberposts' 		=> -1,
            'suppress_filters' => false,
        );

        $attachments = get_posts($args);

        if( !empty($attachments) ) {

          $output .='<!-- BEGIN #slider-'.$postid.' -->
            <div class="slider-wrapper">
                <div class="post-slider post-slider-'.$postid.'">
                     <div id="slider-'.$postid.'" class="loading media-slider">';
                     $output .='<ul class="slides">';
                                  $i = 0;
                                  foreach( $attachments as $attachment ) {
                                      if( $attachment->ID == $thumbid ) continue;

                                      $src = wp_get_attachment_image_src( $attachment->ID, 'full' );
                                      $image = radium_resize( $src[0], $image_w, $image_h, $crop ); //resize & crop the image

                                      $caption = $attachment->post_excerpt;
                                      $caption = ($caption) ? "<div class='slider-desc'><span class='gallery-caption'>$caption</span></div>" : '';
                                      $alt = ( !empty($attachment->post_content) ) ? $attachment->post_content : $attachment->post_title;
                                      $output .='<li><img height="'.$image_h.'" width="'.$image_w.'" src="'.$image.'" alt="'.$alt.'" />'.$caption.'</li>';

                                      $i++;
                                  }
                    $output .='</ul>';

                $output .='</div>
                        </div>
                    </div><!-- END #slider-'.$postid.' -->';
             }

         }

         return $output;
    }
}

/*-----------------------------------------------------------------------------------*/
/*	Echo Gallery
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'radium_lightbox_gallery' ) ) {
    function radium_lightbox_gallery($postid, $image_w, $image_h='', $crop = '', $meta_field ='', $columns = '' ) {
        echo get_radium_lightbox_gallery( $postid, $image_w, $image_h, $crop, $meta_field, $columns );
    }
}


/*-----------------------------------------------------------------------------------*/
/*	Echo Gallery
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'radium_gallery' ) ) {
    function radium_gallery($postid, $image_w, $image_h='', $crop = '', $meta_field ='' ) {
        echo get_radium_gallery( $postid, $image_w, $image_h, $crop, $meta_field );
    }
}

/*-----------------------------------------------------------------------------------*/
/*	Popup Gallery
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'get_radium_popup_gallery' ) ) {
    function get_radium_popup_gallery( $postid, $image_w, $image_h = '', $crop = '', $meta_field = '', $columns = '' ) {

    //validate inputs
    if(!$postid OR !$image_w ) return false;

    $slide_id = $postid;
    $thumbid = 0;
    $output = null;

    if( $meta_field ) {

        $attachments = rwmb_meta( $meta_field, 'type=image' );

        if ( is_array( $attachments ) ) {

            $output .='<div class="popup-gallery">';

                $output .='<h3 class="entry-title">Photo Gallery</h3>';

                $output .='<a class="gallery-image" rel="trb-gallery-id-2" alt="" title="'.get_the_title().'" href="'.get_radium_post_image( get_the_ID(), 'post', 9999 ).'">';
                    $output .='<img height="'.$image_h.'" width="'.$image_w.'" src="'.get_radium_post_image( get_the_ID(), 'post', 900, 500 ).'" alt="'.get_the_title().'">';
                    $output .='<span class="popup-gallery-open"><i class="icon-picture"></i> View Gallery ('. count($attachments) .' images)</span>';
                $output .='</a>';

                $output .='<span style="display:none;">';

                $i = 0;

                foreach( $attachments as $image ) {

                    $src = $image['full_url'];
                    $caption = $image['caption'] ? $image['caption'] : null;
                    $alt = $image['alt'] ? $image['alt'] : null;
                    if ( ! $src ) continue;
                      $image_title = esc_attr( $caption );

                    $output .='<a class="gallery-image" itemprop="image" rel="trb-gallery-id-2" alt="'.$alt.'" title="'.$image_title.'" href="'.$src.'"></a>';

                    $i++;
                }

                $output .='<div id="gallery-ad">';

                    $output .='<div id="radium-popup-gallery-ad-300x250-slideshow" class="ad-wrapper" style="width:300px; height:250px;">';

                    $ad = apply_filters(__fUNCTION__ .'ad', '');

                    $output .= $ad;

                    $output .='</div>';

                    $output .='</div>';

                $output .='</span>';

            $output .='</div>';

        }

        return $output;

        }
    }
}

/*-----------------------------------------------------------------------------------*/
/*	Echo Popup Gallery
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'radium_popup_gallery' ) ) {
    function radium_popup_gallery($postid, $image_w, $image_h='', $crop = '', $meta_field ='', $columns = '' ) {
        echo get_radium_popup_gallery( $postid, $image_w, $image_h, $crop, $meta_field, $columns );
    }
}

/**
 * Get Post Image
 *
 * @uses has_post_thumbnail()
 * @uses get_post_thumbnail_id()
 * @uses wp_get_attachment_url()
 * @uses get_the_ID()
 * @uses get_post_meta()
 * @uses get_radium_youtube_video_image()
 * @uses radium_resize()
 * @uses get_radium_first_post_image()
 *
 * @return string
 * @since 2.1.4
 */

if ( !function_exists( 'get_radium_post_image' ) ) {
    function get_radium_post_image( $post_id, $post_type, $image_w, $image_h = '', $crop = '', $single = true ) {

          $class = $img_url = $image = null;

        //// SETUP THUMBNAILS ////
        //Check if post has a featured image set else get the first image from the gallery and use it. If both statements are false display fallback image.
        if ( has_post_thumbnail($post_id) ) {

            //get featured image
            $thumb = get_post_thumbnail_id($post_id);
            $img_url = wp_get_attachment_url( $thumb, 'full' ); //get full URL to image (use "large" or "medium" if the image is too big)

        } else {

            $attachments = get_children(
                array(
                    'post_parent' => $post_id,
                    'post_type' => 'attachment',
                    'post_mime_type' => 'image',
                    'orderby' => 'menu_order'
                )
            );

            if ( ! is_array( $attachments ) ) { return false; }

            $count = count($attachments);
            $first_attachment = array_shift($attachments);

            $img_url = is_object($first_attachment) ? wp_get_attachment_url( $first_attachment->ID,'full' ) : null; //get full URL to image (use "large" or "medium" if the image is too big)

        }

        if ( $post_type == 'video' && !$img_url ) {

            $remote_video_url = get_post_meta($post_id, '_radium_embed_code', true);

               if ( strpos($remote_video_url, 'youtu') > 0 ) {

                if (preg_match('%(?:youtube\.com/(?:user/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $remote_video_url, $result)) {
                    $video_id = $result[1];
                }

                if( isset( $video_id ) ) $image = get_radium_youtube_video_image($video_id);

            } elseif (strpos($remote_video_url, 'vimeo') > 0) {

                sscanf(parse_url($remote_video_url, PHP_URL_PATH), '/%d', $video_id);

                    if( isset( $video_id ) ) $image = get_radium_vimeo_video_image($video_id);

            } elseif ( get_post_meta($post_id, '_radium_poster', true) ) {

                  $poster_id =  rwmb_meta('_radium_poster', 'type=file', $post_id );

                  foreach ( $poster_id as $poster) {
                      $image = $poster['url'];
                  }
            }

        } else {

            $image = radium_resize($img_url, $image_w, $image_h, $crop, $single);

        }

        //add thumbnail fallback
        if(!$image) {
            $image = get_radium_first_post_image(true);
            $class = 'fallback-image';
        }

        //// END SETUP THUMBNAIL ////

        return apply_filters('get_radium_post_image', $image, $post_id);
    }

}

/**
 * Echo Get Post Image
 *
 * @uses get_radium_post_image()
 * @return string
 *
 * @since 2.1.4
 */
if ( !function_exists( 'radium_post_image' ) ) {
    function radium_post_image($post_id, $post_type, $image_w, $image_h='', $crop = '' ) {
        echo get_radium_post_image( $post_id, $post_type, $image_w, $image_h, $crop );
    }
}

/**
 * Get Post Video
 *
 * @uses get_radium_video()
 * @return string
 *
 * @since 2.1.5
 */
 function get_radium_theme_video() {

     $output = $file_url = null;

     $remote_video_url = get_post_meta(get_the_ID(), '_radium_embed_code', true);

     if( !empty($remote_video_url) ) {

         $output .= '<div class="video-frame">';

         if ( strpos($remote_video_url, 'youtu') > 0 ) {

             if (preg_match('%(?:youtube\.com/(?:user/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $remote_video_url, $result)) {
                 $video_id = $result[1];
             }

             if( isset( $video_id ) ) $output .= '<iframe width="700" height="350" src="//www.youtube-nocookie.com/embed/'.$video_id.'?rel=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>';

         } elseif (strpos($remote_video_url, 'vimeo') > 0) {

             sscanf(parse_url($remote_video_url, PHP_URL_PATH), '/%d', $video_id);

             if( isset( $video_id ) ) {

                 $output .= '<iframe src="http://player.vimeo.com/video/'.$video_id.'" width="700" height="350" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';

             }

         }

         $output .= '</div>';

     } elseif ( class_exists('Radium_MediaElements_Helper')) {

          $files = rwmb_meta('_radium_video', 'type=file', get_the_ID() );

         foreach ( $files as $file) {
             $file_url = $file['url'];
         }

         $poster_id =  rwmb_meta('_radium_poster', 'type=file', get_the_ID() );
         foreach ( $poster_id as $poster) {
             $poster_url = $poster['url'];
         }

         if ( $file_url ) $output .= do_shortcode('[radium_video id="" href="'.$file_url.'" poster="'.$poster_url.'"]');

     }

     return $output;

 }

 /**
  * Echo Get Post Image
  *
  * @uses get_radium_video()
  * @return string
  *
  * @since 2.1.5
  */
 if ( !function_exists( 'radium_theme_video' ) ) {
     function radium_theme_video() {
         echo get_radium_theme_video();
     }
 }
 add_action('radium_theme_video', 'radium_theme_video');


 /**
  * Get Post Audio
  *
  * @uses get_radium_theme_audio()
  * @return string
  *
  * @since 2.1.5
  */
  function get_radium_theme_audio() {

      $output = $img = null;

      $images = rwmb_meta( '_radium_poster', 'type=image' );

      foreach ( $images as $image ) // SUPPORT FOR CUSTOM EXPORT - CLASS AND CAPTION (VIEW.JS)
          $img = $image['full_url'];

      if ( $img ) $output .='<img src="'.$img.'" class="media-image" alt="'.$image['alt'].'" />';

      if ( class_exists('Radium_MediaElements_Helper')) {

          $files = rwmb_meta('_radium_audio', 'type=file', get_the_ID() );

          foreach ( $files as $file ) {

              $output .= do_shortcode('[radium_audio href="'.$file['url'].'" ]');

          }

      }

      return $output;

  }

  /**
   * Echo Get Post Audio
   *
   * @uses get_radium_theme_audio()
   * @return string
   *
   * @since 2.1.5
   */
  if ( !function_exists( 'radium_theme_audio' ) ) {
      function radium_theme_audio() {
          echo get_radium_theme_audio();
      }
  }

 add_action('radium_theme_audio', 'radium_theme_audio');

 /**
  * Get Post Gallery
  *
  * @uses get_radium_theme_gallery()
  * @return string
  *
  * @since 2.1.5
  */
 function get_radium_theme_gallery() {

     $output = $thumb_ID = null;

     $layout = get_post_meta(get_the_ID(), '_radium_page_layout', true);

    $sidebar = radium_sidebar_loader($layout);

    $image_size = radium_framework_add_image_sizes();
    $image_size = $sidebar['sidebar_active'] ? $image_size['radium_medium'] : $image_size['radium_large'];

    $image_w = $image_size['width']; //Define width
    $image_h = $image_size['height'];

     $gallery_layout = get_post_meta(get_the_ID(), '_radium_gallery_type', true);

     // IF SLIDESHOW LAYOUT
     if ( $gallery_layout == 'slideshow' ) {

         radium_gallery( get_the_ID(), $image_w , false, null, '_radium_gallery_images' );

     } elseif ( $gallery_layout == 'stacked' ) {

        $images = rwmb_meta( '_radium_gallery_images', 'type=image' );

        foreach ( $images as $image ) { // SUPPORT FOR CUSTOM EXPORT - CLASS AND CAPTION (VIEW.JS)

            $caption = $image['caption'];

            $output .= '<div class="gallery-image">';
            $output .= '<img src="'.$image['full_url'].'" alt="'.$image['alt'].'" />';
            if ( $caption ) $output .= '<h6 class="media-caption">'.$caption.'</h6>'; //CAPTIONS
            $output .= '</div>';

        } // END FOR EACH IMAGE

     } elseif ( $gallery_layout == 'popup-slideshow' ) {

         $output .= get_radium_popup_gallery( get_the_ID(), 313, 200, true, '_radium_gallery_images', 2 );

     } elseif ( $gallery_layout == 'lightbox' ) {

         $output .= get_radium_lightbox_gallery( get_the_ID(), 313, 200, true, '_radium_gallery_images', 2 );

     } else {

         $thumb = get_post_thumbnail_id();
         $img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the image is too big)
         $image = radium_resize( $img_url, $image_w , true ); //resize & crop the image

         if ( $image ) {

             $img_id = get_post_thumbnail_id(get_the_ID());
             $output .='<figure><img src="'.$image.'" class="wp-post-image" width="'.$image_w.'"/></figure>';

         }

     }

     return $output;

 }

  /**
   * Echo Get Post Audio
   *
   * @uses get_radium_theme_audio()
   * @return string
   *
   * @since 2.1.5
   */
  if ( !function_exists( 'radium_theme_gallery' ) ) {
      function radium_theme_gallery() {
          echo get_radium_theme_gallery();
      }
  }

 add_action('radium_theme_gallery', 'radium_theme_gallery');
