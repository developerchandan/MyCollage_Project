<?php

/*
 * This file is a part of the RadiumFramework core.
 * Please be extremely cautious editing this file,
 *
 * @category RadiumFramework
 * @package  Carlton WP
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 */
 
/**
 *Builder Interface functions
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
 
class Radium_Builder_Interface {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() { /* Do nothing here */ }
	 
 	/**
 	 *
 	 * Builds out the header for all builder pages. 
 	 *
	 * @access public
	 * @return void
 	 */
	public function page_header() {
		
		$framework = radium_framework();
		
		screen_icon( 'themes' ); ?>
		
		<h2 id="radium-opts-heading"><?php _e('Layout Builder','radium'); ?></h2>
		
		<div id="radium_builder">
		
			<div id="radium_panel_opt" class="wrap">
			
				<div id="radium-opts-header">
					<h3 id="radium-opts-theme-heading">
						<span id="opts-theme-heading"><?php echo $framework->theme_title; ?></span>
						<span id="radium-opts-theme-ver"><?php _e( 'Version: ', 'radium' ); echo $framework->theme_version; ?></span>
					</h3>
					<div id="radium-builder-current-page">
						<h2 style="display: none;"><?php _e( 'Editing: <span></span>', 'radium' ); ?></h2>
					</div>
					<div id="radium-builder-status-messages"></div>
					<div class="clearfix"></div><!--clearfix-->
				</div>
				
				<div id="radium-opts-sidebar">		    
				    <ul id="radium-opts-group-menu" class="layout-nav-tab-wrapper">
				        <li id="manage_layouts-tab" class="radium-opts-group-tab-link-li">
				        	<a href="#manage_layouts" class="layout-nav-tab radium-opts-group-tab-link-a" title="<?php _e( 'Manage Layouts', 'radium' ); ?>">
				        		<div class="section-tab-icon"><img src="<?php echo  $framework->theme_framework_images_url.'/icons/icon-layout.png'; ?>"></div>
				        		<span><?php _e( 'Manage Layouts', 'radium' ); ?></span>
				        	</a>
				        </li>
				        <li id="add_layout-tab"  class="radium-opts-group-tab-link-li">
				        	<a href="#add_layout" class="layout-nav-tab radium-opts-group-tab-link-a" title="<?php _e( 'Add New Layout', 'radium' ); ?>">
				        		<div class="section-tab-icon"><img src="<?php echo  $framework->theme_framework_images_url.'/icons/icon-layout.png'; ?>"></div>
				        		<span><?php _e( 'Add New Layout', 'radium' ); ?></span>
				        	</a>
				        </li>
				        <li  id="edit_layout-tab" class="radium-opts-group-tab-link-li nav-edit-builder" style="display: none;">
				        	<a href="#edit_layout" class="layout-nav-tab radium-opts-group-tab-link-a " title="<?php _e( 'Edit Layout', 'radium' ); ?>">
				        		<div class="section-tab-icon"><img src="<?php echo  $framework->theme_framework_images_url.'/icons/icon-layout.png'; ?>"></div>
				        		<span><?php _e( 'Edit Layout', 'radium' ); ?></span>
				        	</a>
				        </li>
				    </ul>
			    </div>
	    <?php
	}	
	
	/**
	 * Builds out the full admin page. 
  	 * 
	 * @access public
	 * @return void
	 */
	public function page() {

		$this->page_header();
		?>
    	<div class="builder_content">
	    	<div id="manage_layouts" class="group">
	    		<form id="manage_builder">	
		    		<?php 
		    		$manage_nonce = wp_create_nonce( 'radium_panel_opt_manage_builder' );
					echo '<input type="hidden" name="option_page" value="radium_panel_opt_manage_builder" />';
					echo '<input type="hidden" name="_wpnonce" value="'.$manage_nonce.'" />';
					?>
					<div class="builder-ajax-container"><?php $this->manage_layout(); ?></div>
				</form><!-- #manage_builder  -->
			</div><!-- #manage  -->
			<!-- /Manage Layout  -->
			
			<div id="add_layout" class="group">
				<form id="add_new_builder">
					<?php
					$add_nonce = wp_create_nonce( 'radium_panel_opt_new_builder' );
					echo '<input type="hidden" name="option_page" value="radium_panel_opt_add_builder" />';
					echo '<input type="hidden" name="_wpnonce" value="'.$add_nonce.'" />';
					$this->add_layout( null );
					?>
				</form><!-- #add_new_builder  -->
			</div><!-- #manage  -->
			<!-- Add Layout  -->
			
			<div id="edit_layout" class="group">
				<form id="edit_builder" method="post">
					<?php
					$edit_nonce = wp_create_nonce( 'radium_panel_opt_save_builder' );
					echo '<input type="hidden" name="action" value="update" />';
					echo '<input type="hidden" name="option_page" value="radium_panel_opt_edit_builder" />';
					echo '<input type="hidden" name="_wpnonce" value="'.$edit_nonce.'" />';
					?>
					<div class="builder-ajax-container"><!-- AJAX inserts edit builder page here. --></div>				
				</form>
			</div><!-- #manage  -->
		</div>
		<!-- /Edit Layout  -->
		<?php
		
		$this->page_footer();
	}
	
	/**
	 * Generates the the interface to add a new layout.
	 *
	 * @access public
	 * @return void
	 */
	
	public function add_layout() {
		 	
		// Setup sample layouts
		$samples = radium_builder_samples();
		$sample_layouts = array();
		foreach( $samples as $sample ) {
			$sample_layouts[$sample['id']] = $sample['name'];
			$sample_layouts[$sample['id']] = array( 
				$sample['name'], 
				$sample['preview'] 
			);
		}	
		
		// Setup options array to display form
		$options = array(
			array( 
				'name' 		=> __( 'Layout Name', 'radium' ),
				'desc' 		=> __( 'Enter a user-friendly name for your layout. You will not be able to change this after you\'ve created the layout.', 'radium' ),
				'id' 		=> 'layout_name',
				'type' 		=> 'add_layout'
			),
			array( 
				'name' 		=> __( 'Starting Point', 'radium' ),
				'desc' 		=> __( 'Select if you\'d like to start building your layout from scratch or from a pre-built sample layout.', 'radium' ),
				'id' 		=> 'layout_start',
				'type' 		=> 'radio_img',
				'options' 	=> $sample_layouts,
				'class'		=> 'builder_samples'
			),
	 	);
		
	 	$options = apply_filters( 'radium_add_layout', $options );
		
		// Build form
		$form = radium_panel_opt_fields( 'options', $options, null, false );
		?>
		<div class="builder-metabox-holder">
			<div class="builder-postbox">
	 			<form id="add_new_slider">
					<div class="inner-group">
						<?php echo $form[0]; ?>
					</div><!-- .group  -->
				</form><!-- #add_new_slider  -->
			</div><!-- .builder-postbox  -->
		</div><!-- .metabox-holder  -->
		<?php
	}
	
	/**
	 * Generates the an individual panel to edit an element. 
	 *
	 * @param string $element_type type of element
	 * @param string $element_id ID for individual slide
	 * @param array $element_settings any current options for current element
	 */
	 
	public function edit_element( $element_type, $element_id, $element_settings = null, $element_width = null, $element_style = null, $visibility = null ) {
		
		$styles_form = null;
		
		$elements = radium_builder_elements();
		$element_option_settings = $element_settings['options'];
		$element_style_settings = $element_settings['style'];
				
		$form = radium_panel_opt_fields( 'elements['.$element_id.'][options]', $elements[$element_type]['options'], $element_option_settings, false );
		$styles_form = isset($elements[$element_type]['style']) ? radium_panel_opt_fields( 'elements['.$element_id.'][style]', $elements[$element_type]['style'], $element_style_settings, false ) : null;
		
	 	if (!$element_width) { $element_width = 'element1-1'; }
	 	$element_width_shorthand = preg_replace('/element/', '', $element_width);
	 	$element_width_shorthand = preg_replace('/-/', '/', $element_width_shorthand);
	 	
	 	//Setup variables
	 	$elements_element_type_info_name = isset($elements[$element_type]['info']['name']) ? $elements[$element_type]['info']['name'] : null;
	 	$element_type_info_query = isset($elements[$element_type]['info']['query']) ? $elements[$element_type]['info']['query'] : null;
		$element_cache = isset($elements[$element_type]['info']['cache']) ? $elements[$element_type]['info']['cache'] : false;
		$element_cache_id = isset($elements[$element_type]['info']['cache']) ? 'rm_' . $element_id : '';
	
	 	?>
		<div id="<?php echo $element_id; ?>" class="page-element element-options <?php echo $element_width; ?>" rel="<?php echo $element_type; ?>" <?php if( $visibility == 'hide' ) echo ' style="display:none"'; ?>>					
			<div id="page-element-item" class="page-element-item"> 
				<div class="item-bar-left">
					<a title="Edit" class="edit-element"><div class="edit-element"></div></a>
					<a title="Delete"><div class="delete-element"></div></a>
				</div>
				<span class="page-element-item-text"><?php echo $elements_element_type_info_name; ?></span>
				<div class="item-bar-right">
					<?php if( isset($elements[$element_type]['style']) ) { ?><div class="element-style"></div><?php } ?>
					<div class="element-size-text"><?php echo $element_width_shorthand; ?></div>
					<div class="change-element-size">
						<div class="add-element-size"></div>
						<div class="sub-element-size"></div>
					</div>
				</div>
				<div class="clearfix"></div><!--clearfix-->
			</div><!-- .element-name  -->
			<div id="<?php echo $element_id; ?>-content" class="page-element-content">
				<input type="hidden" class="element-style" name="elements[<?php echo $element_id; ?>][style]" value="<?php echo $element_style; ?>" />
				<input type="hidden" class="element-type" name="elements[<?php echo $element_id; ?>][type]" value="<?php echo $element_type; ?>" />
				<input type="hidden" class="element-query" name="elements[<?php echo $element_id; ?>][query_type]" value="<?php echo $element_type_info_query; ?>" />
				<input type="hidden" class="element-cache-id" name="elements[<?php echo $element_id; ?>][cache_id]" value="<?php echo $element_cache_id; ?>" />
				<input type="hidden" class="element-cache" name="elements[<?php echo $element_id; ?>][cache]" value="<?php echo $element_cache; ?>" />
				<input type="hidden" class="element-width" name="elements[<?php echo $element_id; ?>][width]" value="<?php echo $element_width; ?>" />
				<?php echo $form[0]; ?>
				<div class="submitbox page-element-footer">
					<a href="#<?php echo $element_id; ?>" class="submitdelete delete-me" title="<?php _e( 'Are you sure you want to delete this element?', 'radium' ); ?>"><?php _e( 'Delete Module', 'radium' ); ?></a>
				</div><!-- .page-element-footer  -->
			</div><!-- .element-content  -->
			<?php if ( $styles_form ) { ?> 
				
	 			<div id="<?php echo $element_id; ?>-style" class="page-element-style">
					<?php echo $styles_form[0]; ?>
	 			</div><!-- .element-content  -->
				
			<?php } ?>
		</div>
		<?php
	}
	
	
	/**
	 * Generates the the interface for managing layouts.
	 *
	 * @access public
	 * @return void
	 */
	
	public function manage_layout() {
		
		// Setup columns for management table
		$columns = array(
			array(
				'name' 		=> __( 'Layout Title', 'radium' ),
				'type' 		=> 'title',
			),
			
			array(
				'name' 		=> __( 'Layout Slug', 'radium' ),
				'type' 		=> 'slug',
			),
			array(
				'name' 		=> __( 'Layout ID', 'radium' ),
				'type' 		=> 'id',
			)
			
		);
		$columns = apply_filters( 'radium_manage_layouts', $columns );
		
		echo '<div class="metabox-holder">';
		echo $this->manage_layout_layouts_table( 'radium_layout', $columns );
		echo '</div><!-- .metabox-holder  -->';
	}
	
	
	/**
	 * Generates the the interface to edit the layout.
	 *
	 * @param $id string ID of layout to edit
	 */
	 
	public function edit_layout( $id ) {
		
		$elements = radium_builder_elements();
		
		$layout = get_post($id);
		$layout_elements = get_post_meta( $id, 'elements', true );
		$layout_settings = get_post_meta( $id, 'settings', true );
		?>
		<input type="hidden" name="layout_id" value="<?php echo $id; ?>" />
		<div id="poststuff" class="metabox-holder">
			<div id="post-body">
				<div id="post-body-content">
				<div class="submitbox">
					<div id="major-publishing-actions">
						<div id="publishing-action">
							<input class="button-primary button" value="<?php _e( 'Update Layout', 'radium' ); ?>" type="submit" />
							<img src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" class="ajax-loading" />
						</div>
						<div class="clearfix"></div>
					</div>
				</div><!-- .submitbox  -->
					<div id="titlediv">
						<div class="ajax-overlay"></div>
						<h2><?php _e( 'Manage Modules', 'radium' ); ?></h2>
						<select>
							<?php
							foreach( $elements as $element )
								echo '<option value="'.$element['info']['id'].'=>'.$element['info']['query'].'">'.$element['info']['name'].'</option>';
							?>
						</select>
						<a href="#" id="add_new_element" class="button-secondary"><?php _e( 'Add New Module', 'radium' ); ?></a>
						<img src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" class="ajax-loading" id="ajax-loading">
						<div class="clearfix"></div>
					</div><!-- #titlediv  -->
					<div id="builder">
						<div id="featured">
							<div id="elements-container-setting">
								<a href="#"><span class="label"><?php _e( 'Featured Area Settings', 'radium' ); ?></span></a>
								<div class="setting-block">
									<select type="text" class="of-select" name="options[settings][featured][layout]" value="<?php if(isset( $layout_settings['settings']['featured']['layout']) ) echo esc_html( $layout_settings['settings']['featured']['layout'] ); ?>" >
										<option value="wide"><?php _e('Wide', 'radium'); ?></option>
										<option value="boxed"><?php _e('Boxed', 'radium'); ?></option>
									</select>
									<label><?php _e('Featured Area Layout', 'radium'); ?></label>
								</div>
								<div class="setting-block">
									<input type="text" class="of-color" name="options[settings][featured][background][color]" value="<?php if(isset( $layout_settings['settings']['featured']['background']['color'] ) ) echo esc_html( $layout_settings['settings']['featured']['background']['color'] ); ?>" />
									<label><?php _e('Background color', 'radium'); ?></label>
								</div>
								<div class="setting-block">
									<!--<label><?php _e('Background Image', 'radium'); ?></label>-->
									<input type="text" name="options[settings][featured][background][url]" value="<?php if(isset( $layout_settings['settings']['featured']['background']['url'] ) ) echo esc_url( $layout_settings['settings']['featured']['background']['url'] ); ?>" class="rwmb-text uploaded-image" /> 
									<input type="button" name="upload-image" class="upload-image button" value="<?php _e('Upload Image', 'radium') ?>">
	 							</div>
							</div>
							<div class="clearfix"></div><!--clearfix-->
							<div class="sortable">
								<?php
								if( ! empty( $layout_elements['featured'] ) ) {
									foreach( $layout_elements['featured'] as $id => $element ) {
										//setup variables
										$element_type = isset($element['type']) ? $element['type'] : null;
										$element_width = isset($element['width']) ? $element['width'] : null;										
										$this->edit_element( $element_type, $id, $element, $element_width );
									}
								}
								?>
							</div><!-- .sortable  -->
							<br class="clear">
						</div><!-- #featured  -->
						<div id="primary">
							<input type="hidden" name="elements[divider]" value="" />
							<!--<span class="label"><?php _e( 'Content Area', 'radium' ); ?></span> -->
							<div class="sortable">
								<?php
								if( ! empty( $layout_elements['primary'] ) ) {
									foreach( $layout_elements['primary'] as $id => $element ) {
										
										//setup variables
										$element_type = isset($element['type']) ? $element['type'] : null;
										$element_width = isset($element['width']) ? $element['width'] : null;
											
										$this->edit_element( $element_type, $id, $element, $element_width );
									}
								}
								?>
							</div><!-- .sortable  -->
							<br class="clear">
							<div id="delete-action">
								<a class="submitdelete delete_layout" href="#<?php echo $id; ?>" title="<?php _e( 'Are you sure you want to delete this layout?', 'radium' ); ?>"><?php _e( 'Delete', 'radium' ); ?></a>
							</div>
						</div><!-- #primary  -->
					</div><!-- #builder  -->
				</div><!-- .post-body-content  -->
			</div><!-- #post-body  -->
		</div><!-- #poststuff  -->
		<?php
	}
	
	/**
	 * Generates a table for generated layouts.
	 *
	 * @since 2.1.0
	 *
	 * @param $post_type string post type id
	 * @param $columns array columns for table
	 * @return $output string HTML output for table
	 */
	 
	function manage_layout_layouts_table( $post_type, $columns ) {
		
		// Grab some details for post type
		$post_type_object = get_post_type_object($post_type);
		$name = $post_type_object->labels->name;
		$singular_name = $post_type_object->labels->singular_name;
		
		// Get posts
		$posts = get_posts( array( 'post_type' => $post_type, 'numberposts' => -1 ) );
	
		// Setup header/footer
		$header = '<tr>';
		$header .= '<th scope="col" id="cb" class="manage-column column-cb check-column checker"><input type="checkbox"></th>';
		foreach( $columns as $column ) {
			$header .= '<th>'.$column['name'].'</th>'; 
		}
		$header .= '</tr>';
		
		// Start main output
		$output = '<table class="widefat">';
	
		$output .= '<tbody>';
		if( ! empty( $posts ) ) {
			foreach( $posts as $post ) {
				$output .= '<tr id="row-'.$post->ID.'">';
	 			foreach( $columns as $column ){
					switch( $column['type'] ) {
						case 'title' :
							$output .= '<td class="post-title page-title column-title">';
							$output .= '<strong><a href="#'.$post->ID.'" class="title-link edit-'.$post_type.'" title="'.__( 'Edit', 'radium' ).'">'.$post->post_title.'</strong></a>';
							$output .= '<div class="row-actions">';
							$output .= '<span class="edit">';
							$output .= '<a href="#'.$post->ID.'" class="edit-post edit-'.$post_type.'" title="'.__( 'Edit', 'radium' ).'">'.__( 'Edit', 'radium' ).'</a> | ';
							$output .= '</span>';
							$output .= '<span class="trash">';
							$output .= '<a title="'.__( 'Delete', 'radium' ).'" href="#'.$post->ID.'">'.__( 'Delete', 'radium' ).'</a>';
							$output .= '</span>';
							$output .= '</div>';
							break;
							
						case 'id' :
							$output .= '<td class="post-id">';
							$output .= $post->ID;
							break;
						
						case 'slug' :
							$output .= '<td class="post-slug">';
							$output .= $post->post_name;
							break;
							
						case 'meta' :
							$output .= '<td class="post-meta-'.$column['config'].'">';
							$meta = get_post_meta( $post->ID, $column['config'], true );
							if( isset( $column['inner'] ) ) {
								if( isset( $meta[$column['inner']] ) )
									$output .= $meta[$column['inner']];
							} else {
								$output .= $meta;
							}
							break;
							
						case 'shortcode' :
							$output .= '<td class="post-shortcode-'.$column['config'].'">';
							$output .= '['.$column['config'].' id="'.$post->post_name.'"]';
							break;
							
					}
					$output .= '</td>';
				}
				$output .= '</tr>';
			}
		} else {
			$num = count( $columns ) + 1; // number of columns + the checkbox column
			$output .= '<tr><td colspan="'.$num.'">'.__('No layouts have been created yet. Click the Add New Layout tab to get started.', 'radium').'</td></tr>';
		}
		$output .= '</tbody>';
		$output .= '</table>';
		return $output;
	}
	
	/**
	 * Footer for all builder pages.
	 * 
	 * @access public
	 * @return void
	 */
	public function page_footer() {
		?>		<div class="clearfix"></div><!--clearfix-->
			</div><!-- #radium_panel_opt  -->
		</div><!-- #radium_builder  -->
	    <?php
	}	
}
 
