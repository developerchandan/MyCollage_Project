<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

/**
 * Works together with the MetaBox Engine to create the slider manager interface 
 * 
 * @since 2.0.0
 */

if ( ! class_exists( 'RWMB_Slider_Slides_Field' ) ) 
{
	class RWMB_Slider_Slides_Field
	{
		
		/**
		 * Add field actions
		 *
		 * @return	void
		 */
		static function add_actions( ) 	{
			// Add TinyMCE script for WP version < 3.3
			global $wp_version;
	
			if ( version_compare( $wp_version, '3.2.1' ) < 1 ) {
				add_action( 'admin_print_footer-post.php', 'wp_tiny_mce', 25 );
				add_action( 'admin_print_footer-post-new.php', 'wp_tiny_mce', 25 );
			}
		}
		
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts() {
		
			$framework = radium_framework();
		
			wp_enqueue_style( 'rwmb-meta-box-wysiwyg', RWMB_CSS_URL.'wysiwyg.css', RWMB_VER );
			wp_enqueue_style( 'rwmb-slider-slide', $framework->theme_framework_url . '/slider/css/slider-slides.css', array(), RWMB_VER );
 			wp_enqueue_style('farbtastic');	

 			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			
			wp_enqueue_media();
			wp_enqueue_script( 'custom-header' );
				
			$screen = get_current_screen();
				
			if ( $screen->post_type == 'slider' )
 				wp_enqueue_script( 'rwmb-slider-slide', $framework->theme_framework_url . '/slider/js/slider-slides.js', array( 'jquery', 'farbtastic'), RWMB_VER, true );
			
 			wp_enqueue_script( 'jquery-ui-slider', RWMB_JS_URL . "jqueryui/jquery.ui.slider.min.js", array( 'jquery-ui-core' ), '1.8.17', true );
		}

		/**
		 * Show begin HTML markup for fields
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function begin_html( $html, $meta, $field ) {
			$html = '<h2>'. __("Manage Slides","radium").'</h2>';

			return $html;
		}

		/**
		 * Show end HTML markup for fields
		 *
		 * @param string $html
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		static function end_html( $html, $meta, $field ) {
			$html = '';

			return $html;
		}

		/**
		* Get field HTML
		*
		* @param $html
		* @param $field
		* @param $meta
		*
		* @return string
		*/
		static function html( $html, $meta, $field ) {

			global $post, $wp_version;

			$id = $field['id'];

			$slider_slides = get_post_meta( $post->ID, $id, true ) ? get_post_meta( $post->ID, $id, true ) : false;
			
			$counter = 0;
			
			$html = '<ul id="slider-slides">';

				if( $slider_slides ) {
					
 					foreach ( $slider_slides as $i => $slide ) {
						
						$counter ++;
						
						$slide_img_src            	= isset( $slide['slide-img-src'] ) 			? $slide['slide-img-src'] 			: null;
						$slide_title      			= isset( $slide['slide-title'] ) 			? $slide['slide-title'] 			: null;
						$slide_content            	= isset( $slide['slide-content'] ) 			? $slide['slide-content'] 			: null;
						$slide_nav_text        		= isset( $slide['slide-nav-text'] ) 		? $slide['slide-nav-text'] 			: null;
						$slide_nav_icon_src  		= isset( $slide['slide-nav-icon-src'] ) 	? $slide['slide-nav-icon-src'] 		: null;
						$slide_link_url           	= isset( $slide['slide-link-url'] ) 		? $slide['slide-link-url'] 			: null;
						$slide_link_target          = isset( $slide['slide-link-target'] ) 		? $slide['slide-link-target']		: null;
						$slide_video_embed      	= isset( $slide['slide-video-embed'] ) 		? $slide['slide-video-embed'] 		: null;
						$slide_bg_src				= isset( $slide['slide-bg-src'] ) 			? $slide['slide-bg-src'] 			: null;
						$slide_bg_color            	= isset( $slide['slide-bg-color'] ) 		? $slide['slide-bg-color'] 			: null;
						$slide_bg_settings        	= isset( $slide['slide-bg-settings'] )      ? $slide['slide-bg-settings']       : null;
  						
						if ( version_compare( $wp_version, "3.2.1" ) < 1 ) {
								
								$editor = '<textarea name="slide-content[]" class="rwmb-textarea large-text" cols="60" rows="5">' . $slide_content . '</textarea>';
								
						} else {
							
							// Apply filter to wp_editor() settings
							$editor_settings = apply_filters( "rwmb_slide_wysiwyg_settings", array( 
								"editor_class" 		=> "rwmb-wysiwyg", 
								"wpautop" 			=> false,
								"textarea_name" 	=> "slide-content[]",
								"textarea_rows"		=> 10,
								"tinymce"			=> false, //visual mode has a few issues here so its disabled
								"media_buttons" 	=> false,
								'teeny'				=> true,
 							), 10, 1 );
							
							// Using output buffering because wp_editor() echos directly
							ob_start( );
							// Use new wp_editor() since WP 3.3
							wp_editor( $slide_content, $field['id'].'_'.$counter, $editor_settings );
			
							$editor =  ob_get_clean( );
						
						};
							
						$html .= '<li class="slide postbox" id="slide_' . $counter . '" data-slide="'. $counter .'">

									<div class="handlediv" title="' . __('Click to toggle', 'radium') . '">&nbsp;</div>

									<h3 class="hndle"><span>' . __('Slide', 'radium') . '</span></h3>

									<div class="inside">

										<div class="slider-slide-tabs">

											<ul>
												<li class="slide-content-tab"><a href="#slide-content">' . __('Content', 'radium') . '</a></li>
												<li class="slide-nav-tab"><a href="#slide-nav">' . __('Navigation', 'radium') . '</a></li>
												<li class="style-tab"><a href="#slide-style">' . __('Style', 'radium') . '</a></li>
 											</ul>										
												
											<div id="slide-content" class="tabs-content">
											
												<div class="rwmb-field slide-title">
																																		
													<div class="rwmb-label">
														<label>' . __('Slide Title', 'radium') . '</label>
													</div><!-- end .rwmb-label -->
	
													<div class="rwmb-input">
														<input type="text" name="slide-title[]" class="rwmb-text" size="50" value="' . $slide_title . '">
														<p class="description">' . __('Enter a Short slide title here', 'radium') . '.</p>
													</div><!-- end .rwmb-input -->
	
												</div><!-- end .rwmb-field -->
																			
												<div class="rwmb-field">
											  											 			
													<div class="rwmb-input image">
														<div class="preview-image">
															<img class="img-preview" type="text" src="' . $slide_img_src . '"  height="100"/>
														</div>
														<label class="uploaded-image">' . __('Image URL', 'radium') . '</label>
													
														<input type="text" name="slide-img-src[]" class="rwmb-text uploaded-image" size="50" value="' . $slide_img_src . '">
														<input type="button" name="upload-image" class="upload-image button" value="' . __('Upload Image', 'radium') . '">
													</div><!-- end .rwmb-input -->
												
													<div class="rwmb-image-url">
														
														<div class="rwmb-label">
															<label>' . __('Link', 'radium') . '</label>
														</div><!-- end .rwmb-label -->
		
														<div class="rwmb-input">
															<input type="text" name="slide-link-url[]" class="rwmb-text" size="50" value="' . $slide_link_url . '">
															<p class="description">' . __('(optional) Any valid URL is allowed', 'radium') . '.</p>
														</div><!-- end .rwmb-input -->
													
	 													<div class="slide-link-target">
															<label>
																<input type="checkbox" id="slide-link-target-checkbox" name="slide-link-target[]" value="1" '. checked( $slide_link_target, true, false ).'> Open link in a new window/tab
															</label>
														</div>
														
													</div><!-- end .rwmb-image-url -->
														
												</div><!-- end .rwmb-field -->
											
												
												<div class="rwmb-field slide-wysiwyg">

													<div class="rwmb-label slide-wysiwyg">
														<label>' . __('Slide Content', 'radium') . '</label>
													</div><!-- end .rwmb-label -->

													<div class="rwmb-input slide-wysiwyg">
														
														<p class="description">' . __('(optional) HTML tags and WordPress shortcodes are allowed.', 'radium') . '</p>
 														
 														'.$editor.'
														
													</div><!-- end .rwmb-input -->

												</div><!-- end .rwmb-field -->

												<div class="rwmb-field video-embed">

													<div class="rwmb-label">
														<label>' . __('Slide Video Embed', 'radium') . '</label>
													</div><!-- end .rwmb-label -->

													<div class="rwmb-input">
														<textarea name="slide-video-embed[]" class="rwmb-textarea large-text" cols="60" rows="5">' . $slide_video_embed . '</textarea>
														<p class="description">' . __('Paste video embed code here. (Recommended size 940px by 356px)', 'radium') . '</p>
													</div><!-- end .rwmb-input -->

												</div><!-- end .rwmb-field -->

											</div><!-- end #slide-content -->
											
											<div id="slide-nav" class="tabs-content">
												
												<div class="rwmb-field">

 														<div class="preview-image slide-icon">
															<img class="img-preview" type="text" src=""  height="35"/>
														</div>	
													
													<div class="bg-settings">
														
														<div class="rwmb-input bg-image">
														
															<label class="uploaded-image">' . __('Background Image URL', 'radium') . '</label>
												
															<input type="text" name="slide-nav-icon-src[]" class="rwmb-text uploaded-image" size="50" value="' . $slide_nav_icon_src . '">
															<input type="button" name="upload-image" class="upload-image button" value="' . __('Upload Nav Icon', 'radium') . '">
													
														</div><!-- end .rwmb-input -->
													
													</div>
													
												</div><!-- end .rwmb-field -->											
												
												<div class="rwmb-field">
																																													
													<div class="rwmb-label">
														<label>' . __('Slide Navigation Tab Text', 'radium') . '</label>
													</div><!-- end .rwmb-label -->
	
													<div class="rwmb-input">
														<input type="text" name="slide-nav-text[]" class="rwmb-text" size="50" value="' . $slide_nav_text . '">
														<p class="description">' . __('Enter a Short slide description here', 'radium') . '.</p>
													</div><!-- end .rwmb-input -->
	
												</div><!-- end .rwmb-field -->
															
											</div><!-- end #slide-nav-tab -->
																						
											<div id="slide-style" class="tabs-content">
												
													<div class="rwmb-field">
	
	 														<div class="preview-image">
																<img class="img-preview" type="text" src="' . $slide_bg_src . '"  height="100"/>
															</div>	
														
														<div class="bg-settings">
															
															<div class="rwmb-input bg-image">
															
																<label class="uploaded-image">' . __('Background Image URL', 'radium') . '</label>
													
																<input type="text" name="slide-bg-src[]" class="rwmb-text uploaded-image" size="50" value="' . $slide_bg_src . '">
																<input type="button" name="upload-image" class="upload-image button" value="' . __('Upload BG Image', 'radium') . '">
														
															</div><!-- end .rwmb-input -->
														
															<div class="rwmb-input">
															
																<div class="rwmb-label">
																	<label>' . __('Background Image Settings', 'radium') . '</label>
																</div><!-- end .rwmb-label -->
  																
																<select name="slide-bg-settings[]" class="rwmb-select">
																	<option value="" ' 			. selected( $slide_bg_settings, "", false ) 			. '>' 	. __('Repeat', 'radium') 	. '</option>
																	<option value="left" ' 		. selected( $slide_bg_settings, "left", false ) 		. '>' 	. __('Left', 'radium') 		. '</option>
																	<option value="right" ' 	. selected( $slide_bg_settings, "right", false ) 		. '>' 	. __('Right', 'radium') 	. '</option>
																	<option value="center" ' 	. selected( $slide_bg_settings, "center", false ) 		. '>' 	. __('Center', 'radium') 	. '</option>
																	<option value="fullwidth" ' . selected( $slide_bg_settings, "fullwidth", false )	. '>' 	. __('Fullwidth', 'radium') . '</option>
																</select>
																
															</div><!-- end .rwmb-input -->
				
															<div class="rwmb-input bgcolorpicker">
																
																<label class="uploaded-image">' . __('Background Color', 'radium') . '</label>
															
																<div class="farb-popup-wrapper">
																	<input type="text" id="' . $counter . '" name="slide-bg-color[]" value="' . $slide_bg_color . '" class="popup-colorpicker" style="width:70px;"/>
 																	<div class="farb-popup">
																		<div class="farb-popup-inside">
																			<div id="' . $counter . 'picker" class="color-picker">
																		</div>
																	</div>
																</div>
																
 															</div><!-- end .rwmb-input -->
														
														</div>
														
													</div><!-- end .rwmb-field -->											
																
												</div><!-- end #slide-style -->
												
										</div><!-- end .slider-slide-tabs -->

										<button class="remove-slide button-secondary">' . __('Remove Slide', 'radium') . '</button>
										
										<input type="hidden" name="' . $id . '[]" class="rwmb-text" size="50" value="">
								
									</div><!-- end .inside -->
									
								</li>';
 										

					}

				} else {

					if ( version_compare( $wp_version, "3.2.1" ) < 1 ) {
							
							$editor = '<textarea name="slide-content[]" class="rwmb-textarea large-text" cols="60" rows="5"></textarea>';
							
					} else {
						
						// Apply filter to wp_editor() settings
						$editor_settings = apply_filters( "rwmb_slide_wysiwyg_settings", array( 
							"editor_class" 		=> "rwmb-wysiwyg", 
							"wpautop" 			=> false,
							"textarea_name" 	=> "slide-content[]",
							"textarea_rows"		=> 10,
							"tinymce"			=> false, //visual mode has a few issues here so its disabled
							"media_buttons" 	=> false,
							'teeny' 			=> true,
							), 10, 1 );
						
						// Using output buffering because wp_editor() echos directly
						ob_start( );
						// Use new wp_editor() since WP 3.3
						wp_editor( '', $field['id'], $editor_settings );
		
						$editor =  ob_get_clean( );
					
					};

						$html .= '<li class="slide postbox" id="slide_' . $counter . '" data-slide="'. $counter .'">

									<div class="handlediv" title="' . __('Click to toggle', 'radium') . '">&nbsp;</div>

									<h3 class="hndle"><span>' . __('Slide', 'radium') . '</span></h3>

									<div class="inside">

										<div class="slider-slide-tabs">

											<ul>
												<li class="slide-content-tab"><a href="#slide-content">' . __('Content', 'radium') . '</a></li>
												<li class="slide-nav-tab"><a href="#slide-nav">' . __('Navigation', 'radium') . '</a></li>
												<li class="style-tab"><a href="#slide-style">' . __('Style', 'radium') . '</a></li>
 											</ul>										
												
											<div id="slide-content" class="tabs-content">
											
												<div class="rwmb-field slide-title">
																																		
													<div class="rwmb-label">
														<label>' . __('Slide Title', 'radium') . '</label>
													</div><!-- end .rwmb-label -->
	
													<div class="rwmb-input">
														<input type="text" name="slide-title[]" class="rwmb-text" size="50" value="">
														<p class="description">' . __('Enter a Short slide title here', 'radium') . '.</p>
													</div><!-- end .rwmb-input -->
	
												</div><!-- end .rwmb-field -->
																			
												<div class="rwmb-field">
											  											 			
													<div class="rwmb-input image">
														<div class="preview-image">
															<img class="img-preview" type="text" src=""  height="100"/>
														</div>
														<label class="uploaded-image">' . __('Image URL', 'radium') . '</label>
													
														<input type="text" name="slide-img-src[]" class="rwmb-text uploaded-image" size="50" value="">
														<input type="button" name="upload-image" class="upload-image button" value="' . __('Upload Image', 'radium') . '">
													</div><!-- end .rwmb-input -->
												
													<div class="rwmb-image-url">
														
														<div class="rwmb-label">
															<label>' . __('Link', 'radium') . '</label>
														</div><!-- end .rwmb-label -->
		
														<div class="rwmb-input">
															<input type="text" name="slide-link-url[]" class="rwmb-text" size="50" value="">
															<p class="description">' . __('(optional) Any valid URL is allowed', 'radium') . '.</p>
														</div><!-- end .rwmb-input -->
													
	 													<div class="slide-link-target">
															<label>
																<input type="checkbox" id="slide-link-target-checkbox" name="slide-link-target[]" value="1"> Open link in a new window/tab
															</label>
														</div>
														
													</div><!-- end .rwmb-image-url -->
														
												</div><!-- end .rwmb-field -->
											
												
												<div class="rwmb-field slide-wysiwyg">

													<div class="rwmb-label slide-wysiwyg">
														<label>' . __('Slide Content', 'radium') . '</label>
													</div><!-- end .rwmb-label -->

													<div class="rwmb-input slide-wysiwyg">
														
														<p class="description">' . __('(optional) HTML tags and WordPress shortcodes are allowed.', 'radium') . '</p>
 														
 														'.$editor.'
														
													</div><!-- end .rwmb-input -->

												</div><!-- end .rwmb-field -->

												<div class="rwmb-field video-embed">

													<div class="rwmb-label">
														<label>' . __('Slide Video Embed', 'radium') . '</label>
													</div><!-- end .rwmb-label -->

													<div class="rwmb-input">
														<textarea name="slide-video-embed[]" class="rwmb-textarea large-text" cols="60" rows="5"></textarea>
														<p class="description">' . __('Paste video embed code here. (Recommended size 940px by 356px)', 'radium') . '</p>
													</div><!-- end .rwmb-input -->

												</div><!-- end .rwmb-field -->

											</div><!-- end #slide-content -->
											
											<div id="slide-nav" class="tabs-content">
												
												<div class="rwmb-field">

 														<div class="preview-image slide-icon">
															<img class="img-preview" type="text" src=""  height="35"/>
														</div>	
													
													<div class="bg-settings">
														
														<div class="rwmb-input bg-image">
														
															<label class="uploaded-image">' . __('Background Image URL', 'radium') . '</label>
												
															<input type="text" name="slide-nav-icon-src[]" class="rwmb-text uploaded-image" size="50" value="">
															<input type="button" name="upload-image" class="upload-image button" value="' . __('Upload Nav Icon', 'radium') . '">
													
														</div><!-- end .rwmb-input -->
													
													</div>
													
												</div><!-- end .rwmb-field -->											
												
												<div class="rwmb-field">
																																													
													<div class="rwmb-label">
														<label>' . __('Slide Navigation Tab Text', 'radium') . '</label>
													</div><!-- end .rwmb-label -->
	
													<div class="rwmb-input">
														<input type="text" name="slide-nav-text[]" class="rwmb-text" size="50" value="">
														<p class="description">' . __('Enter a Short slide description here', 'radium') . '.</p>
													</div><!-- end .rwmb-input -->
	
												</div><!-- end .rwmb-field -->
															
											</div><!-- end #slide-nav -->
																						
											<div id="slide-style" class="tabs-content">
												
													<div class="rwmb-field">
	
	 														<div class="preview-image">
																<img class="img-preview" type="text" src=""  height="100"/>
															</div>	
														
														<div class="bg-settings">
															
															<div class="rwmb-input bg-image">
															
																<label class="uploaded-image">' . __('Background Image URL', 'radium') . '</label>
													
																<input type="text" name="slide-bg-src[]" class="rwmb-text uploaded-image" size="50" value="">
																<input type="button" name="upload-image" class="upload-image button" value="' . __('Upload BG Image', 'radium') . '">
														
															</div><!-- end .rwmb-input -->
														
															<div class="rwmb-input">
															
																<div class="rwmb-label">
																	<label>' . __('Background Image Settings', 'radium') . '</label>
																</div><!-- end .rwmb-label -->
  																
																<select name="slide-bg-settings[]" class="rwmb-select">
																	<option value="">' 	. __('Repeat', 'radium') 	. '</option>
																	<option value="left">' 	. __('Left', 'radium') 		. '</option>
																	<option value="right" >' 	. __('Right', 'radium') 	. '</option>
																	<option value="center">' 	. __('Center', 'radium') 	. '</option>
																	<option value="fullwidth">' 	. __('Fullwidth', 'radium') . '</option>
																</select>
																
															</div><!-- end .rwmb-input -->
				
															<div class="rwmb-input bgcolorpicker">
																
																<label class="uploaded-image">' . __('Background Color', 'radium') . '</label>
															
																<div class="farb-popup-wrapper">
																	<input type="text" id="' . $counter . '" name="slide-bg-color[]" value="" class="popup-colorpicker" style="width:70px;"/>
 																	<div class="farb-popup">
																		<div class="farb-popup-inside">
																			<div id="' . $counter . 'picker" class="color-picker">
																		</div>
																	</div>
																</div>
																
 															</div><!-- end .rwmb-input -->
														
														</div>
														
													</div><!-- end .rwmb-field -->											
																
												</div><!-- end #slide-style -->
												
										</div><!-- end .slider-slide-tabs -->

										<button class="remove-slide button-secondary">' . __('Remove Slide', 'radium') . '</button>
										
										<input type="hidden" name="' . $id . '[]" class="rwmb-text" size="50" value="">
								
									</div><!-- end .inside -->
									
								</li>';

				}

				$html .= '</ul><!-- end #slider-slides -->

				<p> <button id="add-slider-slide" class="button-primary">' . __('+ Add New Slide', 'radium') . '</button> </p>

				<input type="hidden" name="slider-meta-info" value="' . $post->ID . '|' . $id . '">';

			return $html;
		}

		/**
		 * Save slides
		 *
		 * @param mixed $new
		 * @param mixed $old
		 * @param int $post_id
		 * @param array $field
		 *
		 * @return void
		 */
		static function save( $new, $old, $post_id, $field ) {
				
			$name = $field['id'];

			$slider_slides = array();
			
			foreach( $_POST[$name] as $k => $v ) {
				
				$checkbox_value = empty( $_POST['slide-link-target'][$k] ) ? 0 : 1;
				
				$slider_slides[] = array(
					'slide-title'            	=> $_POST['slide-title'][$k],
					'slide-img-src'            	=> $_POST['slide-img-src'][$k],
					'slide-content'            	=> $_POST['slide-content'][$k],
					'slide-nav-text'            => $_POST['slide-nav-text'][$k],
					'slide-nav-icon-src'        => $_POST['slide-nav-icon-src'][$k],
 					'slide-link-url'           	=> $_POST['slide-link-url'][$k],
 					'slide-link-target'        	=> $checkbox_value,
					'slide-video-embed'        	=> $_POST['slide-video-embed'][$k],
 					'slide-bg-src'			   	=> $_POST['slide-bg-src'][$k],
 					'slide-bg-settings'		   	=> $_POST['slide-bg-settings'][$k],
 					'slide-bg-color'		   	=> $_POST['slide-bg-color'][$k],
  				);

			}

			$new = $slider_slides;

			update_post_meta( $post_id, $name, $new );

		}
	}
}