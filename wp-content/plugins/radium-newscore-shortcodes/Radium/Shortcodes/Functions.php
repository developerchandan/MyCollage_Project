<?php
/*
 * This file is a part of the RadiumFramework core
 * and contains theme specific settings .
 * Please be extremely cautious editing this file,
 *
 * @category RadiumFramework
 * @package  Griddr WP
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 * @since 2.1.0
 */

 class Radium_Shortcodes_Functions {
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

    }

    /**
     * Get Image by ID
     */

    public static function get_image_by_size ( $params = array( 'post_id' => NULL, 'attach_id' => NULL, 'thumb_size' => 'thumbnail' ) ) {

        //array( 'post_id' => $post_id, 'thumb_size' => $grid_thumb_size )
        if ( (!isset($params['attach_id']) || $params['attach_id'] == NULL) && (!isset($params['post_id']) || $params['post_id'] == NULL) ) return;
            $post_id = isset($params['post_id']) ? $params['post_id'] : 0;

        if ( $post_id )
            $attach_id = get_post_thumbnail_id($post_id);

        else $attach_id = $params['attach_id'];

        $thumb_size = $params['thumb_size'];

        global $_wp_additional_image_sizes;
        $thumbnail = '';

        if ( is_string($thumb_size) && ((!empty($_wp_additional_image_sizes[$thumb_size]) && is_array($_wp_additional_image_sizes[$thumb_size])) || in_array($thumb_size, array('thumbnail', 'thumb', 'medium', 'large', 'full') ) ) ) {
            //$thumbnail = get_the_post_thumbnail( $post_id, $thumb_size );
            $thumbnail = wp_get_attachment_image( $attach_id, $thumb_size );
        }

        if ( $thumbnail == '' &&  $attach_id ) {
            if ( is_string($thumb_size) ) {
                $thumb_size = str_replace(array( 'px', ' ', '*', '×' ), array( '', '', 'x', 'x' ), $thumb_size);
                $thumb_size = explode("x", $thumb_size);
            }
            // Resize image to custom size
            $p_img = Radium_Shortcodes_Functions::resize($attach_id, null, $thumb_size[0], $thumb_size[1], true);

            if ( $p_img ) {
                $img_class = '';
                //if ( $grid_layout == 'thumbnail' ) $img_class = ' no_bottom_margin'; class="'.$img_class.'"
                $thumbnail = '<img src="'.$p_img['url'].'" width="'.$p_img['width'].'" height="'.$p_img['height'].'" />';
            }
        }

        $p_img_large = wp_get_attachment_image_src($attach_id, 'large' );

        return array( 'thumbnail' => $thumbnail );
    }


    // get Youtube Video Thumbnail
    public static function get_youtube_video_image( $youtube_id  ) {

        $image_url = 'http://img.youtube.com/vi/'.$youtube_id.'/0.jpg';

        return $image_url;

     }

     // get Vimeo Video Thumbnail
    public static function get_vimeo_video_image( $vimeo_video_id ) {

        $url = 'http://vimeo.com/api/v2/video/'.$vimeo_video_id.'.php';
        $response = wp_remote_get($url);

        if( is_wp_error( $response ) )
            return;

        $xml = wp_remote_retrieve_body( $response );

        $image_data = maybe_unserialize( $xml );

        $image = $image_data[0]['thumbnail_large'];

        return $image;
     }

    /**
     * Radium Image Resize Based on Aqua Resizer https://github.com/sy4mil/Aqua-Resizer
     *
     * Title     : Aqua Resizer
     * Description   : Resizes WordPress images on the fly
     * Version   : 1.1.6
     * Author    : Syamil MJ
     * Author URI    : http://aquagraphite.com
     * License   : WTFPL - http://sam.zoy.org/wtfpl/
     * Documentation : https://github.com/sy4mil/Aqua-Resizer/
     *
     * @param string $url - (required) must be uploaded using wp media uploader
     * @param int $width - (required)
     * @param int $height - (optional)
     * @param bool $crop - (optional) default to soft crop
     * @param bool $single - (optional) returns an array if false
     * @uses wp_upload_dir()
     * @uses image_resize_dimensions()
     * @uses image_resize()
     */
    public static function resize( $url, $width, $height = null, $crop = null, $single = true, $retina = false ) {

        if ( $retina ) {

            $width = ($width * 2);

            $height = isset( $height ) ?  ($height * 2) : null;

        }

        //validate inputs
        if(!$url OR !$width ) return false;

        //define upload path & dir
        $upload_info = wp_upload_dir();
        $upload_dir = $upload_info['basedir'];
        $upload_url = $upload_info['baseurl'];

        //check if $img_url is local
        if(strpos( $url, $upload_url ) === false) return false;

        //define path of image
        $rel_path = str_replace( $upload_url, '', $url);
        $img_path = $upload_dir . $rel_path;

        //check if img path exists, and is an image indeed
        if( !file_exists($img_path) OR !getimagesize($img_path) ) return false;

        //get image info
        $info = pathinfo($img_path);
        $ext = $info['extension'];
        list($orig_w,$orig_h) = getimagesize($img_path);

        //get image size after cropping
        $dims = image_resize_dimensions($orig_w, $orig_h, $width, $height, $crop);
        $dst_w = $dims[4];
        $dst_h = $dims[5];

        //use this to check if cropped image already exists, so we can return that instead
        $suffix = "{$dst_w}x{$dst_h}";
        $dst_rel_path = str_replace( '.'.$ext, '', $rel_path);
        $destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

        if(!$dst_h) {
            //can't resize, so return original url
            $img_url = $url;
            $dst_w = $orig_w;
            $dst_h = $orig_h;
        }
        //else check if cache exists
        elseif(file_exists($destfilename) && getimagesize($destfilename)) {
            $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
        }
        //else, we resize the image and return the new resized image url
        else {

            // Note: This pre-3.5 fallback check will edited out in subsequent version
            if(function_exists('wp_get_image_editor')) {

                $editor = wp_get_image_editor($img_path);

                if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $width, $height, $crop ) ) )
                    return false;

                $resized_file = $editor->save();

                if(!is_wp_error($resized_file)) {
                    $resized_rel_path = str_replace( $upload_dir, '', $resized_file['path']);
                    $img_url = $upload_url . $resized_rel_path;
                } else {
                    return false;
                }

            } else {

                $resized_img_path = image_resize( $img_path, $width, $height, $crop ); // Fallback foo
                if(!is_wp_error($resized_img_path)) {
                    $resized_rel_path = str_replace( $upload_dir, '', $resized_img_path);
                    $img_url = $upload_url . $resized_rel_path;
                } else {
                    return false;
                }

            }

        }

        //return the output
        if($single) {
            //str return
            $image = $img_url;
        } else {
            //array return
            $image = array (
                0 => $img_url,
                1 => $dst_w,
                2 => $dst_h
            );
        }

        return $image;
    }

}
