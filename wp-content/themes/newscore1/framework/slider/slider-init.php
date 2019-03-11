<?php 
	
/* ---------------------------------------------------------------------- */
/*	Slider
/* ---------------------------------------------------------------------- */

// Register Custom Post Type: 'Slider'
function radium_register_post_type_slider() {

	$framework = radium_framework();

	$labels = array(
		'name' => __( 'Sliders', 'radium' ),
		'singular_name'      => __( 'Slider', 'radium' ),
		'add_new' => __( 'Add New', 'radium' ),
		'add_new_item' => __( 'Add New Slider', 'radium' ),
		'edit_item' => __( 'Edit Slider', 'radium' ),
		'new_item' => __( 'New Slider', 'radium' ),
		'view_item' => __( 'View Slider', 'radium' ),
		'search_items' => __( 'Search Sliders', 'radium' ),
		'not_found' => __( 'No sliders found', 'radium' ),
		'not_found_in_trash' => __( 'No sliders found in Trash', 'radium' ),
		'parent_item_colon' => __( 'Parent Slider:', 'radium' ),
		'menu_name' => __( 'Sliders', 'radium' ),
	);

	$args = array(
		'labels' => $labels,
		'hierarchical' => false,
		'supports' => array('title'),
		'taxonomies' => array(''),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => false,
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'has_archive' => false,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => array( 'slug' => 'slider' ),
		'capability_type' => 'post',
		'menu_position' => null,
		'menu_icon' => $framework->theme_framework_url . '/slider/images/icon-slider.png'
	);

	register_post_type( 'slider', $args );

} 
add_action('init', 'radium_register_post_type_slider');

// Custom columns for 'Slider'
function radium_edit_slider_columns() {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Name', 'radium' ),
		'slider_type' => __( 'Slider Type', 'radium' ),	
		'slide_count' => __( 'Slide Count', 'radium' ),
		'slider_shortcode' => __( 'Shortcode', 'radium' )
	);

	return $columns;

}
add_action('manage_edit-slider_columns', 'radium_edit_slider_columns');

// Custom columns content for 'Slider'
function radium_manage_slider_columns( $column, $post_id ) {

	global $post;
	
	$column_key = null;
	
	switch ( $column ) {

		case 'slide_count':

			$slider_slides = get_post_meta( $post->ID, $column_key, true ) ? get_post_meta( $post->ID, $column_key, true ) : false;

			$slide_count = count( unserialize( $slider_slides['_radium_slider_slides'][0] ) );
			
			echo $slide_count;
						
			break;
			
		case 'slider_type':
		
			$slider_type = radium_get_custom_field('_radium_slider_type', $post->ID ); 
			
			echo $slider_type;
			
			break;
			
		case 'slider_shortcode':
			
			echo '<span class="shortcode-field">[slider id="'. $post->post_name . '"]</span>';

			break;
		
		default:
			break;
	}

}
add_action('manage_slider_posts_custom_column', 'radium_manage_slider_columns', 10, 2);

// Sortable custom columns for 'Slider'
function radium_sortable_slider_columns( $columns ) {

	$columns['slide_count'] = 'slide_count';

	return $columns;

}
add_action('manage_edit-slider_sortable_columns', 'radium_sortable_slider_columns');

// Change default title for 'Slider'
function radium_change_slider_title( $title ){

	$screen = get_current_screen();

	if ( $screen->post_type == 'slider' )
		$title = __('Enter slider name here', 'radium');

	return $title;

}

add_filter('enter_title_here', 'radium_change_slider_title');


/* -------------------------------------------------- */
/*	Slider
/* -------------------------------------------------- */

function radium_slider_sc( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'id' => ''
		), $atts ) );

	global $post;
	
	$framework = radium_framework();

	$args = array(
				'name'           => esc_attr( $id ),
				'post_type'      => 'slider',
				'posts_per_page' => '1'
			);
	
	$slidertype = null;
	$output = null;
		
	query_posts( $args );

		if( have_posts() ) while ( have_posts() ) : the_post();
		
			$slidertype = radium_get_custom_field('_radium_slider_type', $post->ID ); 
  			
  			if ( $slidertype === "content-carousel" ) {
  				
  				$output = radium_load_template_part( $framework->theme_slider_location . '/slider', 'content-carousel' );
  				 
  			} elseif ( $slidertype === "featured-content" ) {
  		
  				$output = radium_load_template_part( $framework->theme_slider_location . '/slider', 'featured-content' );
  			
  			} else {
  				
  				$output = radium_load_template_part( $framework->theme_slider_location . '/slider', $slidertype );
    			
   			}
  			
		endwhile;

	wp_reset_query();
		
	return $output;

}
add_shortcode('slider', 'radium_slider_sc');


 /**
  * Removes WordPress autop and invalid nesting of p tags, as well as br tags
  *
  * @param string $text html content by the WordPress editor
  * @return string $text
  */
 
 
function radium_slider_content_filter($content) {
 
	// array of custom shortcodes requiring the fix 
	$block = join("|",array( 'slider' ));
 
	// opening tag
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
		
	// closing tag
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
 
	return $rep;
 
}
add_filter("the_content", "radium_slider_content_filter");
 
/**
 * Add a slider button to the post composition screen
 * uses the button added to the media buttons above TinyMCE.
 *
 * @since 2.0.0
 *
 * @global string $pagenow The current page slug
 */
add_filter( 'media_buttons_context', 'radium_slider_media_button');
function radium_slider_media_button($context) {

	global $pagenow;
	
	$framework = radium_framework();
	
	$output = '';

	/** Only run in post/page creation and edit screens */
	if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) {
		
		$title = esc_attr( __( 'Add a slider', 'radium' ) );
 		$img 	= '<img src="' . esc_url( $framework->theme_framework_url ) . '/slider/images/icon-slider.png" alt="' . $title . '" width="13" height="12" />';
 		$output = '<a href="#TB_inline?width=640&inlineId=choose-radium-slider" class="thickbox" title="' . $title . '">' . $img . '</a>';
	}

	return $context . $output;

}


/**
 * Outputs the jQuery and HTML necessary to insert a slider when the user
 * uses the button added to the media buttons above TinyMCE.
 *
 * @since 2.0.0
 *
 * @global string $pagenow The current page slug
 */
add_action( 'admin_footer', 'radium_slider_admin_footer');
 
function radium_slider_admin_footer() {

	global $pagenow;
	
	$framework = radium_framework();
	
	$plugin_icon_url = esc_url( $framework->theme_framework_url );
	
	/** Only run in post/page creation and edit screens */
	if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) {
		/** Get all published sliders */
		$sliders = get_posts( array( 'post_type' => 'slider', 'posts_per_page' => -1, 'post_status' => 'publish' ) );

		?>
		<script type="text/javascript">
			function insertSlider() {
				var id = jQuery('#select-radium-slider').val();

				/** Return early if no slider is selected */
				if ( '' == id ) {
					alert('<?php echo esc_js( 'Please select a slider.' ); ?>');
					return;
				}

				/** Send the shortcode to the editor */
				window.send_to_editor('[slider id="' + id + '"]');
			}
		</script>

		<div id="choose-radium-slider" style="display: none;">
			<div class="wrap" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
				<div id="icon-radium" class="icon32" style="background: url(<?php echo $plugin_icon_url.'/slider/images/icon-slider.png'; ?>) no-repeat scroll 0 50%; width: 16px;"><br></div>
				<h2><?php _e('Choose Your Slider', 'radium'); ?></h2>
				<?php do_action( 'radium_before_slider_insertion', $sliders ); ?>
				<p style="font-weight: bold; padding-bottom: 10px;"><?php _e('Select a slider below from the list of available sliders and then click \'Insert\' to place the slider into the editor.', 'radium'); ?></p>
				<select id="select-radium-slider" style="clear: both; display: block; margin-bottom: 1em;">
				<?php
					foreach ( $sliders as $slider )
						echo '<option value="' . $slider->post_name . '">' . esc_attr( $slider->post_title ) . '</option>';
				?>
				</select>
				<input type="button" id="radium-insert-slider" class="button-primary" value="<?php echo esc_attr( 'Insert Slider' ); ?>" onclick="insertSlider();" />
				<a id="radium-cancel-slider" class="button-secondary" onclick="tb_remove();" title="<?php echo esc_attr( 'Cancel Slider Insertion' ); ?>"><?php _e('Cancel Slider Insertion' , 'radium'); ?></a>
				<?php do_action( 'radium_after_slider_insertion', $sliders ); ?>
			</div>
		</div>
		<?php
	}

}


/**
 * There is no need to apply SEO to the slider post type, so we check to 
 * see if some popular SEO plugins are installed, and if so, remove the inpost
 * meta boxes from view.
 *
 * This method also has a filter that can be used to remove any unwanted metaboxes
 * from the Radium Slider screen - radium_remove_slider_metaboxes.
 *
 * @uses remove_meta_box()
 * @since 2.0.0
 */
add_action( 'add_meta_boxes', 'radium_remove_slider_seo_support', 99 );
 
function radium_remove_slider_seo_support() {

	$plugins = array(
		array( 'WPSEO_Metabox', 'wpseo_meta', 'normal' ),
		array( 'All_in_One_SEO_Pack', 'aiosp', 'advanced' ),
		array( 'Platinum_SEO_Pack', 'postpsp', 'normal' ),
 		array( 'SEO_Ultimate', 'su_postmeta', 'normal' )
	);
	$plugins = apply_filters( 'radium_remove_slider_metaboxes', $plugins );

	/** Loop through the arrays and remove the metaboxes */
	foreach ( $plugins as $plugin )
		if ( class_exists( $plugin[0] ) )
			remove_meta_box( $plugin[1], convert_to_screen( 'slider' ), $plugin[2] );

}


/**
* Customize Media Uploader  
* Remove Upload from Url tab and Library tab
*
* @since 2.0.0
*/

function radium_remove_slider_media_library_tab($tabs) {
  
	if (isset($_REQUEST['post_id'])) {
		
		$post_type = get_post_type($_REQUEST['post_id']);
		
		if ('slider' == $post_type) {
			unset($tabs['library']);
			unset($tabs['type_url']);
		}
		
	}	
	return $tabs;
   
}
add_filter('media_upload_tabs', 'radium_remove_slider_media_library_tab');


/**
* Customize Media Uploader  
* Remove Unnecessary media  upload fields from uploader tabs
* Useful link http://goo.gl/9QbzZ
* 
* @since 2.0.0
*/

function radium_slider_atachment_fields($form_fields, $post) {
	
	$post_id = !empty( $_GET['post_id'] ) ? (int) $_GET['post_id'] : 0;
	$post_type = get_post_type($post_id);
	
	$attachment_parent_id = !empty($post->post_parent) ? $post->post_parent : 0;
	$attachment_post_type = get_post_type($attachment_parent_id);
	
	//var_dump( $attachment_parent_id );
	
	if ( 'slider' == $post_type || 'slider' == $attachment_post_type ) {
	
		// remove unnecessary fields
		//unset( $form_fields['image-size'] );
		unset( $form_fields['post_excerpt'] );
		unset( $form_fields['post_content'] );
 		unset( $form_fields['image_url'] );
		unset( $form_fields['align'] );
	  	unset( $form_fields['post_title'] ); //image title
	  	unset( $form_fields['image_alt'] ); //alt text
	  	
 		//Modify the image url Field 
 		//get image url
		$file = wp_get_attachment_url($post->ID);
 		
		$form_fields['url'] = array(
			'label'      => __('Image URL', 'radium'),
			'input'      => 'html',
			'html'       => "<input type='text' class='text urlfield' name='attachments[$post->ID][url]' value='" . esc_attr($file) . "' />",
			'helps'      => __('', 'radium')
		);
		
		//Modify Button
	    $form_fields['buttons'] = array(
	        'label' => '', // Put a label in?
	        'value' => '', // Doesn't need one
	        'html' => "<input type='submit' class='button' name='send[$post->ID]' value='" . esc_attr__( 'Insert into Slider', 'radium' ) . "' />",
	        'input' => 'html'
	    );
	}
	
    return $form_fields;
}
// Hook on after priority 10, because WordPress adds a couple of filters to the same hook
add_filter('attachment_fields_to_edit', 'radium_slider_atachment_fields', 15, 2 );


/**
* Add body Class to Slider Edit Page 
**/
  
function radium_slider_edit_body_class() { 
 	 	
 	$admin_body_class = null;
 	 	
	$screen = get_current_screen();
 	
 	if ( $screen->post_type == 'slider' )
		$admin_body_class .= 'slider-edit';
		  
	return $admin_body_class;
}
add_filter('admin_body_class','radium_slider_edit_body_class');