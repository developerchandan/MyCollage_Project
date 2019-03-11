<?php
/** Remove DiggDigg from specific pages */
function radium_exclude_digg_digg() {

    if ( get_post_type() !== 'post' ) {
        remove_filter( 'the_excerpt', 'dd_hook_wp_content' );
        remove_filter( 'the_content', 'dd_hook_wp_content' );
    }

}
add_action('template_redirect', 'radium_exclude_digg_digg');

/* Social Sharing Meta*/
function radium_theme_social_sharing_facebook_meta() {

if ( !is_single() || class_exists('All_in_One_SEO_Pack') || class_exists('WPSEO_Frontend') ) return;

$image = get_radium_first_post_image();

?>
<meta itemprop="image" content="<?php echo $image; ?>">
<meta property="og:image" content="<?php echo $image; ?>"/>
<meta name="twitter:image" content="<?php echo $image; ?>" />
<?php
}
add_action('radium_meta', 'radium_theme_social_sharing_facebook_meta');

/**
 * [radium_single_post_side_share description]
 * @return [type] [description]
 */
function radium_single_post_side_share () {

    if ( !radium_get_option('share_posts') ) return;

    global $post_id;

    $queried_post = get_post($post_id);

    $url = get_permalink( get_the_ID() );

    $title = get_the_title( get_the_ID() );

    $position = radium_get_option('share_posts_position', false, 'left');

    ?>

    <div id="post-side-share-<?php echo $position; ?>" class="post-side-share position-<?php echo $position; ?>">
        <?php if ($position == 'left'  || $position == 'right') { ?><div class="title"><span><?php _e('Share', 'radium'); ?></span></div><?php } ?>
        <div class="clearfix">
            <a class="icon icon-twitter icon_embed_tw" href="http://twitter.com/home/?status=<?php echo urlencode($url . " - " . $title); ?>" title="Twitter" target="blank">
                <span class="share-network"><?php _e('Twitter', 'radium'); ?></span>
            </a>
            <a class="icon icon-facebook icon_embed_fb" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode( $url ); ?>&amp;t=<?php echo urlencode( $title ); ?>" title="Facebook" target="blank">
                <span class="share-network"><?php _e('Facebook', 'radium'); ?></span>
            </a>

            <a class="icon icon-google-plus icon_embed_gplus" href="https://plusone.google.com/_/+1/confirm?hl=en&amp;url=<?php echo urlencode($url); ?>" title="Googleplus" target="blank">
                <span class="share-network"><?php _e('Google +', 'radium'); ?></span>
            </a>

            <a class="icon icon-linkedin icon_embed_linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode($url); ?>&amp;summary=<?php echo urlencode($title); ?>&amp;source=<?php echo urlencode(home_url()); ?>" title="Linkin" target="blank">
                <span class="share-network"><?php _e('Linkedin', 'radium'); ?></span>
            </a>

            <a class="icon icon-comment icon_embed_comments" href="#comment" title="<?php _e('Comments', 'radium'); ?>">
                <span class="share-network"><?php _e('Comments', 'radium'); ?></span>
            </a>

            <?php do_action(__FUNCTION__); ?>

            <span class="arrow"></span>
        </div>
    </div>
    <?php
}

$share_posts_position = radium_get_option('share_posts_position', false, 'left');

if ( $share_posts_position == 'left' ) {

    add_action('radium_before_single_post_content', 'radium_single_post_side_share');

} elseif ( $share_posts_position == 'above' ) {

    add_action('radium_before_post_content', 'radium_single_post_side_share');

} elseif ( $share_posts_position == 'below' ) {

    add_action('radium_after_post_content', 'radium_single_post_side_share');

} elseif ( $share_posts_position == 'above-below' ) {

    add_action('radium_before_post_content', 'radium_single_post_side_share');
    add_action('radium_after_post_content', 'radium_single_post_side_share');

}

/**
 *  Social account Links
 */

 function radium_social_account_links() {

     if ( !radium_get_option('social_links') ) return;

     $output = null;
     $style = 'style1';

    $twitter 	= radium_get_option('twitter_username');
    $facebook	= radium_get_option('facebook_page_url');
    $dribbble 	= radium_get_option('dribbble_username');
    $vimeo 		= radium_get_option('vimeo_username');
    $tumblr 	= radium_get_option('tumblr_username');
    $spotify 	= radium_get_option('spotify_username');
    $skype 		= radium_get_option('skype_username');
    $linkedin 	= radium_get_option('linkedin_page_url');
    $lastfm 	= radium_get_option('lastfm_username');
    $googleplus = radium_get_option('googleplus_page_url');
    $flickr 	= radium_get_option('flickr_page_url');
    $youtube 	= radium_get_option('youtube_username');
    $behance 	= radium_get_option('behance_username');
    $pinterest 	= radium_get_option('pinterest_username');
    $instagram 	= radium_get_option('instagram_username');
    $yelp 		= radium_get_option('yelp_url');

    if ($twitter)
        $output .= '<li class="twitter"><a href="http://www.twitter.com/'.$twitter.'" target="_blank"><span class="social-icon twitter '.$style.'" data-type="twitter"></span></a></li>'."\n";

    if ($facebook)
        $output .= '<li class="facebook"><a href="http://www.facebook.com/'.$facebook.'" target="_blank"><span class="social-icon facebook '.$style.'" data-type="facebook"></span></a></li>'."\n";

    if ($dribbble)
        $output .= '<li class="dribbble"><a href="http://www.dribbble.com/'.$dribbble.'" target="_blank"><span class="social-icon dribble '.$style.'" data-type="dribbble"></span></a></li>'."\n";

    if ($vimeo)
        $output .= '<li class="vimeo"><a href="http://www.vimeo.com/'.$vimeo.'" target="_blank"><span class="social-icon vimeo '.$style.'" data-type="vimeo"></span></a></li>'."\n";

    if ($tumblr) {

        $tumblr_url = ($tumblr == '#') ? '#' : 'http://'. $tumblr .'.tumblr.com/';

        $output .= '<li class="tumblr"><a href="'. $tumblr_url .'" target="_blank"><span class="social-icon tumblr '.$style.'" data-type="tumblr"></span></a></li>'."\n";
    }

    if ($spotify)
        $output .= '<li class="spotify"><a href="http://open.spotify.com/user/'.$spotify.'" target="_blank"><span class="social-icon spotify '.$style.'" data-type="spotify"></span></a></li>'."\n";

    if ($skype)
        $output .= '<li class="skype"><a href="skype:'.$skype.'" target="_blank"><span class="social-icon skype '.$style.'" data-type="skype"></span></a></li>'."\n";

    if ($linkedin)
        $output .= '<li class="linkedin"><a href="http://www.linkedin.com/in/'.$linkedin.'" target="_blank"><span class="social-icon linkedin '.$style.'" data-type="linkedin"></span></a></li>'."\n";

    if ($lastfm)
        $output .= '<li class="lastfm"><a href="http://www.last.fm/user/'.$lastfm.'" target="_blank"><span class="social-icon lastfm '.$style.'" data-type="lastfm"></span></a></li>'."\n";

    if ($googleplus)
        $output .= '<li class="googleplus"><a href="https://plus.google.com/'.$googleplus.'" target="_blank"><span class="social-icon googleplus '.$style.'" data-type="googleplus"></span></a></li>'."\n";

    if ($flickr)
        $output .= '<li class="flickr"><a href="https://www.flickr.com/photos/'.$flickr.'" target="_blank"><span class="social-icon flickr '.$style.'" data-type="flickr"></span></a></li>'."\n";

    if ($youtube)
        $output .= '<li class="youtube"><a href="http://www.youtube.com/user/'.$youtube.'" target="_blank"><span class="social-icon youtube '.$style.'" data-type="youtube"></span></a></li>'."\n";

    if ($behance)
        $output .= '<li class="behance"><a href="http://www.behance.net/'.$behance.'" target="_blank"><span class="social-icon behance '.$style.'" data-type="behance"></span></a></li>'."\n";

    if ($pinterest)
        $output .= '<li class="pinterest"><a href="'.$pinterest.'" target="_blank"><span class="social-icon pinterest '.$style.'" data-type="pinterest"></span></a></li>'."\n";

    if ($instagram)
        $output .= '<li class="instagram"><a href="http://instagram.com/'.$instagram.'" target="_blank"><span class="social-icon instagram '.$style.'" data-type="instagram"></span></a></li>'."\n";

    if ($yelp)
        $output .= '<li class="yelp"><a href="http://www.yelp.com/user_details?userid='.$yelp.'/" target="_blank"><span class="social-icon yelp '.$style.'" data-type="yelp"></span></a></li>'."\n";


    if ( $twitter || $facebook || $dribbble || $vimeo || $tumblr || $spotify || $skype || $linkedin || $lastfm || $googleplus || $flickr || $youtube || $behance || $pinterest || $instagram || $yelp ) {

        ?><div class="social-icons-wrapper">
             <ul class="social-icons"><?php echo apply_filters( __FUNCTION__, $output ); ?></ul>
        </div><?php

    }

}
add_action('radium_before_sidebar', 'radium_social_account_links', 9);
