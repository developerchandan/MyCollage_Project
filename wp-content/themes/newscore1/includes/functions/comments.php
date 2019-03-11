<?php
/*
 * This file is a part of the RadiumFramework core.
 * Please be extremely cautious editing this file,
 *
 * @category RadiumFramework
 * @package  NewsCore
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 */

/*-----------------------------------------------------------------------------------
	Switch off Comments on Pages by default. Thanks to http://wordpress.org/support/topic/turn-page-comments-off-by-default-311#post-2433904
-----------------------------------------------------------------------------------*/
function radium_default_comments_off( $data ) {

    if( $data['post_type'] == 'page' && $data['post_status'] == 'auto-draft' ) {
        $data['comment_status'] = 0;
    }

    return $data;
}
add_filter( 'wp_insert_post_data', 'radium_default_comments_off' );


/*--------------------------------------------------------------------*/
/*  CUSTOM COMMENT STRUCTURE
/*--------------------------------------------------------------------*/
function radium_theme_comments($comment, $args, $depth) {

		$GLOBALS['comment'] = $comment;
		
		extract($args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
	?>
	<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">

	<?php if ( 'div' != $args['style'] ) : ?>

		<div id="div-comment-<?php comment_ID() ?>" class="comment-body">

	<?php endif; ?>

	<div class="comment-avatar">
		<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment ); ?>
	</div>

	<div class="comment-wrapper">
		<div class="comment-author">
			<h6><?php printf(__('<cite itemprop="name">%s</cite>', 'radium'), get_comment_author_link()) ?></h6>
			<div class="comment-meta commentmetadata">
			<?php 
				$isByAuthor = false;
			    if($comment->comment_author_email == get_the_author_meta('email')) {
			        $isByAuthor = true;
				}
				 
			 	if($isByAuthor) { ?><span class="author-tag"><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php _e('Author','radium') ?></a><span class="meta-sep">-</span></span><?php } ?><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf( __('%1$s', 'radium'), comment_date('F j, Y') ); ?></a><?php edit_comment_link(__('Edit', 'radium'), '<span class="meta-sep">-</span>','') ?>
			 		<meta itemprop="commentTime" content="<?php echo comment_date('c'); ?>"/>
			</div>
		</div>

		<?php if ($comment->comment_approved == '0') : ?>
			<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation', 'radium'); ?></em>
			<br />
		<?php endif; ?>

		<div itemprop="commentText"><?php comment_text(); ?></div>
		
		<?php comment_reply_link(
				array_merge( $args, array(
					'add_below' => $add_below, 
					'depth' 	=> $depth,
					'max_depth' => $args['max_depth']
				)
			)); ?>

		<?php if ( 'div' != $args['style'] ) : ?></div><?php endif; ?>
	</div>
<?php
}


/*-----------------------------------------------------------------------------------
	Comments
-----------------------------------------------------------------------------------*/
// Custom callback to list pings
function radium_custom_pings($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment;
    ?>
	<li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
	    <div class="comment-author">
	    	<?php printf(__('By %1$s on %2$s at %3$s', 'radium'),
	        get_comment_author_link(),
	        get_comment_date(),
	        get_comment_time() );
	        edit_comment_link(__('[ edit ]', 'radium'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?>
	    </div>
	<?php
    if ($comment->comment_approved == '0') _e('\t\t\t\t\t<span class="unapproved">Your trackback is awaiting moderation</span>\n', 'radium') ?>
	    <div class="comment-content">
	     	<?php comment_text() ?>
	    </div>

<?php } // end custom_pings


add_filter( 'comment_form_default_fields', 'radium_comment_form_default_fields' );
/**
 * Filter the default comment form fields, used by `comment_form()`.
 *
 * Uses default HTML5 comment form.
 *
 * @since 1.8.1
 *
 * @global string $user_identity Display name of the user.
 *
 * @param array $defaults Comment form defaults.
 *
 * @return array Filterable array.
 */
 function radium_comment_form_default_fields( $args = array() ) {

	$commenter = wp_get_current_commenter();

	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
    $html_req = ( $req ? " required='required'" : '' );

	$fields =  array(
		'author' => '
			<div class="comment-form-author clearfix">
			<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req  . $html_req . ' />
			<h6><label for="author">' . __( 'Name', 'radium' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label></h6>
			</div>',

		'email'  => '
			<div class="comment-form-email clearfix">
			<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req  . $html_req . ' />
			<h6><label for="email">' . __( 'Email', 'radium' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label></h6>
			</div>',

		'url'    => '
			<div class="comment-form-url clearfix">
			<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />
			<h6><label for="url">' . __( 'Website', 'radium') . '</label></h6>
			</div>',

	);

    return $fields;

}

add_filter( 'comment_form_defaults', 'radium_comment_form_defaults' );
/**
 * Filter the default comment form arguments, used by `comment_form()`.
 *
 * Uses default HTML5 comment form.
 *
 * @since 1.8.1
 *
 * @global string $user_identity Display name of the user.
 *
 * @param array $defaults Comment form defaults.
 *
 * @return array Filterable array.
 */
 function radium_comment_form_defaults( $args = array() ) {

    $post_id = get_the_ID();

    $user = wp_get_current_user();
    $user_identity = $user->exists() ? $user->display_name : '';

	$defaults = array(
		'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'radium' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'radium' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'title_reply'          => __( 'Leave a Comment', 'radium' ),
		'title_reply_to'       => __( 'Leave a Reply to %s', 'radium' ),
		'cancel_reply_link'    => __( 'Cancel', 'radium' ),
		'label_submit'         => __( 'Submit Comment', 'radium' ),
	);

    //unset afew items
    $args['comment_notes_before'] = '';
    $args['comment_notes_after']  = '';

    $args = wp_parse_args( $args, $defaults );

	return $args;

}

add_filter( 'comment_form_field_comment', 'radium_comment_form_comment_field' );
/**
 * Filter the default comment form field, used by `comment_form()`.
 *
 * @since 1.8.1
 *
 * @param string $comment_field Comment form field.
 *
 * @return string $comment_field comment field.
 */
 function radium_comment_form_comment_field( $comment_field ) {
	
	$comment_field = '<textarea id="comment" name="comment" cols="45" rows="8" aria-describedby="form-allowed-tags" aria-required="true" required="required"></textarea>';
	
	return $comment_field;
 }