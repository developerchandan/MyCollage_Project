<?php

/**
 * Registering meta sections for post taxonomies
 *
 * All the definitions of meta sections are listed below with comments, please read them carefully.
 * Note that each validation method of the Validation Class MUST return value.
 *
 * You also should read the changelog to know what has been changed
 *
 */

// Hook to 'admin_init' to make sure the class is loaded before
// (in case using the class in another plugin)
add_action( 'admin_init', 'radium_register_post_taxonomy_meta_boxes' );

/**
 * Register meta boxes
 *
 * @return void
 */
function radium_register_post_taxonomy_meta_boxes()
{
	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( !class_exists( 'RW_Taxonomy_Meta' ) )
		return;

	$meta_sections = array();

	// First meta section
	$meta_sections[] = array(
		'title'      => 'Standard Fields',             // section title
		'taxonomies' => array('category', 'post_tag'), // list of taxonomies. Default is array('category', 'post_tag'). Optional
		'id'         => 'radium_post_category',                 // ID of each section, will be the option name

		'fields' => array(                             // List of meta fields
		 
			// SELECT
			array(
				'name'    => __('Select', 'radium'),
				'id'      => 'sidebar',
				'type'    => 'select',
				'options' => array(                     // Array of value => label pairs for radio options
					'left' => __('Left', 'radium'),
					'right' => __('Right', 'radium'),
					'none' => __('None', 'radium'),
				),
			),
			
			// SELECT
			array(
				'name'    => __('Style', 'radium'),
				'id'      => 'style',
				'type'    => 'select',
				'options' => array(                     // Array of value => label pairs for radio options
					'left' => __('Red', 'radium'),
					'right' => __('Blue', 'radium'),
					'none' => __('Green', 'radium'),
				),
			),
			
			// IMAGE
			array(
				'name' => __('Logo', 'radium'),
				'id'   => 'logo',
				'type' => 'image',
			),
			
			
		),
	);

	foreach ( $meta_sections as $meta_section ) {
		new RW_Taxonomy_Meta( $meta_section );
	}
	
}

if( ! function_exists('radium_category_generate_html_add_form_fields') ) {
    /**
     * Generate html option in edit tag page
     * @return void
     */
    function radium_category_generate_html_add_form_fields(){

        $framework = radium_framework();

    ?>
    <div class="form-field">
        <label for="tag-style"><?php _e('Category Style', 'radium') ?></label>
        <select name="tag-style" id="">
            <option value="none"><?php _e('none','radium') ?></option>
            <?php
            if ($handle = opendir($framework->theme_css_dir . '/colors/') ) {

                /* This is the correct way to loop over the directory. */
                while (false !== ($entry = readdir($handle))) {

                    if( $entry == '.' || '..' == $entry ) {
                        continue;
                    }

                    if( is_dir($framework->theme_css_dir . '/colors/'.$entry) ) {
                        echo '<option value="'.$entry.'">'.$entry.'</option>';
                    }

                }

                closedir($handle);
            }
            ?>
        </select>
        <p class="description"><?php _e('Change style for this category', 'radium'); ?></p>
    </div>

    <div class="form-field">
        <label for="cat-layout"><?php _e('Category layout', 'radium') ?></label>
        <select name="cat-layout" id="">
            <!--<option value="one-column"><?php _e('One Column', 'radium'); ?></option>-->
            <option value="two-columns"><?php _e('Two Columns', 'radium'); ?></option>
            <option value="small-thumbs"><?php _e('Small Thumbs', 'radium'); ?></option>
            <!--<option value="modern"><?php _e('Modern Grid', 'radium'); ?></option>-->
        </select>
        <p class="description"><?php _e('Change layout for this category', 'radium'); ?></p>
    </div>

    <div class="form-field">
        <label for="cat-sidebar"><?php _e('Category sidebar', 'radium') ?></label>
        <select name="cat-sidebar" id="">
            <option value="left"><?php _e('Left', 'radium'); ?></option>
            <option value="right"><?php _e('Right', 'radium'); ?></option>
            <option value="none"><?php _e('FullWidth', 'radium'); ?></option>
        </select>
        <p class="description"><?php _e('Change sidebar for this category', 'radium'); ?></p>
    </div>

    <?php
    }
    add_action( 'category_add_form_fields', 'radium_category_generate_html_add_form_fields' );
}

if( ! function_exists('radium_category_generate_html_edit_form_fields') ) {
    /**
     * Generate html for radium category option in edit tag page
     * @return void
     */
    function radium_category_generate_html_edit_form_fields($tag){
    
        $options = radium_get_category_option($tag->term_id);

        $framework = radium_framework();
    ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="tag-style">
                    <?php _e('Category Style','radium'); ?>
                </label>
            </th>
            <td>
                <select name="tag-style" id="tag-style">
                    <option <?php selected( $options['style'], 'none' ); ?> value="none"><?php _e('none', 'radium'); ?></option>
                    <?php
                    if ($handle = opendir($framework->theme_css_dir . '/colors/') ) {
						
                        /* This is the correct way to loop over the directory. */
                        while (false !== ($entry = readdir($handle))) {

                            if( $entry == '.' || '..' == $entry ) {
                                continue;
                            }

                            if( is_dir($framework->theme_css_dir . '/colors/'.$entry) ) {
                                echo '<option '.selected( $options['style'], $entry, false ).' value="'.$entry.'">'.$entry.'</option>';
                            }

                        }

                        closedir($handle);
                    }
                    ?>
                </select>
                <br>
                <span class="description">
                    <?php _e('Change style for this category','radium'); ?>
                </span>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="cat-layout">
                    <?php _e('Category Layout','radium') ?>
                </label>
            </th>
            <td>
                <select name="cat-layout" id="cat-layout">
                
                	<?php $layout = isset($options['layout']) ? $options['layout'] : ''; ?>
                    <!--<option <?php selected( $options['layout'], 'one-column' ); ?> value="one-column"><?php _e('One Column', 'radium'); ?></option>-->
                    <option <?php selected( $layout, 'two-columns' ); ?> value="two-columns"><?php _e('Two Columns', 'radium'); ?></option>
                    <option <?php selected( $layout, 'small-thumbs' ); ?> value="small-thumbs"><?php _e('Small Thumbs', 'radium'); ?></option>
                    <!---<option <?php selected( $options['layout'], 'modern' ); ?> value="modern"><?php _e('Modern Grid', 'radium'); ?></option>-->

                </select>
                <br>
                <span class="description">
                    <?php _e('Change layout for this category','radium'); ?>
                </span>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="cat-sidebar">
                    <?php _e('Category sidebar','radium') ?>
                </label>
            </th>
            <td>
                <select name="cat-sidebar" id="cat-sidebar">
                    
                    <?php $sidebar = isset($options['sidebar']) ? $options['sidebar'] : ''; ?>
                
                    <option <?php selected( $sidebar, 'left' ); ?> value="left"><?php _e('left', 'radium'); ?></option>
                    <option <?php selected( $sidebar, 'right' ); ?> value="right"><?php _e('right', 'radium'); ?></option>
                    <option <?php selected( $sidebar, 'none' ); ?> value="none"><?php _e('none', 'radium'); ?></option>
                </select>
                <br>
                <span class="description">
                    <?php _e('Change sidebar for this category','radium'); ?>
                </span>
            </td>
        </tr>
    <?php
    }
    add_action( 'category_edit_form_fields', 'radium_category_generate_html_edit_form_fields' );
}

if( ! function_exists('radium_enqueue_thickbox_for_edit_tag_page') ) {
    //Init upload thickbox script
    function radium_enqueue_thickbox_for_edit_tag_page(){
        global $pagenow;

        $framework = radium_framework();

        if( 'edit-tags.php' == $pagenow ) {
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');

            wp_register_script('radium-category-upload', $framework->theme_framework_js_url.'/edit-tags.js', array('jquery','media-upload','thickbox') );

            wp_enqueue_script('radium-category-upload');
        }
    }
    add_action( 'admin_print_scripts', 'radium_enqueue_thickbox_for_edit_tag_page' );
 }

 if( ! function_exists('radium_enqueue_style_thickbox_for_edit_tag_page') ) {
    //Init upload thickbox Style
     function radium_enqueue_style_thickbox_for_edit_tag_page(){
        wp_enqueue_style('thickbox');
     }
     add_action( 'admin_print_styles', 'radium_enqueue_style_thickbox_for_edit_tag_page' );
 }


if( ! function_exists('radium_save_category_option') ) {
    /**
     * Save category options
     * @param  int $category_id ID of category what was saved
     * @return void
     */
    function radium_save_category_option($category_id){
        $category_options = array();
        if( isset($_POST['tag-style']) ) {
            $category_options['style'] = $_POST['tag-style'];
            $category_options['layout'] = $_POST['cat-layout'];
            $category_options['sidebar'] = $_POST['cat-sidebar'];

        }
        if( ! empty($category_options) ) {
            update_option( 'radium_category_option_'.$category_id, $category_options );
        }
    }
    add_action( 'create_category', 'radium_save_category_option' );
    add_action( 'edit_category', 'radium_save_category_option' );
}
