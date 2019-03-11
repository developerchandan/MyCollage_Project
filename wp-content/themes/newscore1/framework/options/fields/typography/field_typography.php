<?php

/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - render()
 * - enqueue()
 * - makeGoogleWebfontLink()
 * - makeGoogleWebfontString()
 * - output()
 * - getGoogleArray()
 * - getSubsets()
 * - getVariants()
 * Classes list:
 * - Radium_Options_typography
 */

if (!class_exists('Radium_Options_typography')) {
    class Radium_Options_typography {

      	private $std_fonts = array(
            "'Helvetica Neue', HelveticaNeue, Helvetica-Neue, Helvetica, Arial, sans-serif" => "'Helvetica Neue', HelveticaNeue, Helvetica-Neue, Helvetica, Arial, sans-serif",
            "Arial, Helvetica, sans-serif"                          => "Arial, Helvetica, sans-serif",
            "'Arial Black', Gadget, sans-serif"                     => "'Arial Black', Gadget, sans-serif",
            "'Bookman Old Style', serif"                            => "'Bookman Old Style', serif",
            "'Comic Sans MS', cursive"                              => "'Comic Sans MS', cursive",
            "Courier, monospace"                                    => "Courier, monospace",
            "Garamond, serif"                                       => "Garamond, serif",
            "Georgia, serif"                                        => "Georgia, serif",
            "Impact, Charcoal, sans-serif"                          => "Impact, Charcoal, sans-serif",
            "'Lucida Console', Monaco, monospace"                   => "'Lucida Console', Monaco, monospace",
            "'Lucida Sans Unicode', 'Lucida Grande', sans-serif"    => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
            "'MS Sans Serif', Geneva, sans-serif"                   => "'MS Sans Serif', Geneva, sans-serif",
            "'MS Serif', 'New York', sans-serif"                    => "'MS Serif', 'New York', sans-serif",
            "'Palatino Linotype', 'Book Antiqua', Palatino, serif"  => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
            "Tahoma,Geneva, sans-serif"                             => "Tahoma, Geneva, sans-serif",
            "'Times New Roman', Times,serif"                        => "'Times New Roman', Times, serif",
            "'Trebuchet MS', Helvetica, sans-serif"                 => "'Trebuchet MS', Helvetica, sans-serif",
            "Verdana, Geneva, sans-serif"                           => "Verdana, Geneva, sans-serif",
        );

        private $user_fonts = true;

        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since Radium_Options 1.0
        */
        function __construct($field = array(), $value ='', $parent){

        	$this->parent = $parent;
        	$this->field = $field;
        	$this->value = $value;

            // Set field array defaults.  No errors please
            $defaults = array(
            	'name' 				=> '',
            	'class' 			=> '',
                'customize-options' => true,
                'font-family'       => true,
                'font-size'         => true,
                'font-weight'       => true,
                'font-style'        => true,
                'font-backup'       => true,
                'name_suffix' 		=> '',
                'subsets'           => true,
                'selector'          => '',
                'custom_fonts'      => true,
                'text-align'        => true,
                'text-transform'    => true,
                'font-variant'      => true,
                'text-decoration'   => true,
                'text-shadow'   	=> true,
                'color'             => true,
                'preview'           => true,
                'line-height'       => true,
                'word-spacing'      => true,
                'letter-spacing'    => true,
                'google'            => true,
                'all_styles' 		=> true,
                'update_weekly'     => true,    // Enable to force updates of Google Fonts to be weekly
                'units' 			=> 'px',
                'multi_typography' => false,
            );

            $this->field = wp_parse_args($this->field, $defaults);

            // Set value defaults.
            $defaults = array(
                'font-family'       => '',
                'font-options'      => '',
                'font-backup'       => '',
                'text-align'        => '',
                'text-transform'    => '',
                'text-shadow'    	=> '',
                'font-variant'      => '',
                'text-decoration'   => '',
                'line-height'       => '',
                'word-spacing'      => '',
                'letter-spacing'    => '',
                'subsets'           => '',
                'google'            => false,
                'font-script'       => '',
                'font-weight'       => '',
                'font-style'        => '',
                'color'             => '',
                'font-size'         => '',
                'show_selector'     => '',
                'customize-options' => array(),
                'selector' 			=> '',
                'custom-selector'  => ''
            );

            $this->value = wp_parse_args($this->value, $defaults);

            // Get the google array
            $this->getGoogleArray();

            if (empty($this->field['fonts'])) {
                $this->user_fonts = false;
                $this->field['fonts'] = $this->std_fonts;
            }

            // Localize std fonts
            $this->localizeStdFonts();

            $this->output();

        }

        function localize($field, $value = "") {

            $params = array();

            if ($this->user_fonts) {
                $params['std_font'] = $this->field['fonts'];
            }

            return $params;
        }

        /**
	     * makeGoogleWebfontLink Function.
	     *
	     * Creates the google fonts link.
	     *
	     * @since ReduxFramework 3.0.0
	     */
	    function makeGoogleWebfontLink($fonts) {
	        $link       = "";
	        $subsets    = array();

	        foreach ($fonts as $family => $font) {
	            if (!empty($link)) {
	                $link.= "%7C"; // Append a new font to the string
	            }
	            $link.= $family;

	            if (!empty($font['font-style'])) {
	                $link.= ':';
	                if (!empty($font['all-styles'])) {
	                    $link.= implode(',', $font['all-styles']);
	                } else if (!empty($font['font-style'])) {
	                    $link.= implode(',', $font['font-style']);
	                }
	            }

	            if (!empty($font['subset'])) {
	                foreach ($font['subset'] as $subset) {
	                    if (!in_array($subset, $subsets)) {
	                        array_push($subsets, $subset);
	                    }
	                }
	            }
	        }

	        if (!empty($subsets)) {
	            $link.= "&amp;subset=" . implode(',', $subsets);
	        }

	        return '//fonts.googleapis.com/css?family=' . str_replace( '|','%7C', $link );
	    }

        /**
         * makeGoogleWebfontString Function.
         *
         * Creates the google fonts link.
         *
         * @since ReduxFramework 3.1.8
         */
        function makeGoogleWebfontString($fonts) {
            $link       = "";
            $subsets    = array();

            foreach ($fonts as $family => $font) {
                if (!empty($link)) {
                    $link.= "', '"; // Append a new font to the string
                }
                $link.= $family;

                if (!empty($font['font-style'])) {
                    $link.= ':';
                    if (!empty($font['all-styles'])) {
                        $link.= implode(',', $font['all-styles']);
                    } else if (!empty($font['font-style'])) {
                        $link.= implode(',', $font['font-style']);
                    }
                }

                if (!empty($font['subset'])) {
                    foreach ($font['subset'] as $subset) {
                        if (!in_array($subset, $subsets)) {
                            array_push($subsets, $subset);
                        }
                    }
                }
            }

            if (!empty($subsets)) {
                $link.= "&amp;subset=" . implode(',', $subsets);
            }

            return "'" . $link . "'";
        }

       public function output() {
            $font = $this->value;

            // Check for font-backup.  If it's set, stick it on a variabhle for
            // later use.
            if (!empty($font['font-family']) && !empty($font['font-backup'])) {
                $font['font-family'] = str_replace(', ' . $font['font-backup'], '', $font['font-family']);
                $fontBackup = ',' . $font['font-backup'];
            }

            $style = '';
            if (!empty($font)) {
                foreach ($font as $key => $value) {
                    if ($key == 'font-options') {
                        continue;
                    }
                    // Check for font-family key
                    if ('font-family' == $key) {

                        // Ensure fontBackup isn't empty (we already option
                        // checked this earlier.  No need to do it again.
                        if (!empty($fontBackup)) {

                            // Apply the backup font to the font-family element
                            // via the saved variable.  We do this here so it
                            // doesn't get appended to the Google stuff below.
                            $value.= $fontBackup;
                        }
                    }

                    if (empty($value) && in_array($key, array(
                                'font-weight',
                                'font-style'
                            ))) {
                        $value = "normal";
                    }

                    if ($key == "google" || $key == "subsets" || $key == "font-backup" || empty($value)) {
                        continue;
                    }
                    $style.= $key . ':' . $value . ';';
                }
                if ( isset( $this->parent->args['async_typography'] ) && $this->parent->args['async_typography'] ) {
                    $style .= 'visibility: hidden;';
                }
            }

            if (!empty($style)) {
                if (!empty($this->field['output']) && is_array($this->field['output'])) {
                    $keys = implode(",", $this->field['output']);
                    $this->parent->outputCSS.= $keys . "{" . $style . '}';
                }

                if (!empty($this->field['compiler']) && is_array($this->field['compiler'])) {
                    $keys = implode(",", $this->field['compiler']);
                    $this->parent->compilerCSS.= $keys . "{" . $style . '}';
                }
            }
            // Google only stuff!
            if (!empty($font['font-family']) && !empty($this->field['google']) && filter_var($this->field['google'], FILTER_VALIDATE_BOOLEAN)) {

                // Added standard font matching check to avoid output to Google fonts call - kp
                // If no custom font array was supplied, the load it with default
                // standard fonts.
                if (empty($this->field['fonts'])) {
                    $this->field['fonts'] = $this->std_fonts;
                }

                // Ensure the fonts array is NOT empty
                if (!empty($this->field['fonts'])) {

                    //Make the font keys in the array lowercase, for case-insensitive matching
                    $lcFonts = array_change_key_case($this->field['fonts']);

                    // Rebuild font array with all keys stripped of spaces
                    $arr = array();
                    foreach ($lcFonts as $key => $value) {
                        $key = str_replace(', ', ',', $key);
                        $arr[$key] = $value;
                    }
                    $lcFonts = $arr;
                    unset($arr);

                    // lowercase chosen font for matching purposes
                    $lcFont = strtolower($font['font-family']);

                    // Remove spaces after commas in chosen font for mathcing purposes.
                    $lcFont = str_replace(', ', ',', $lcFont);

                    // If the lower cased passed font-family is NOT found in the standard font array
                    // Then it's a Google font, so process it for output.
                    if (!array_key_exists($lcFont, $lcFonts)) {
                        $family = $font['font-family'];

                        // Strip out spaces in font names and replace with with plus signs
                        // TODO?: This method doesn't respect spaces after commas, hence the reason
                        // for the std_font array keys having no spaces after commas.  This could be
                        // fixed with RegEx in the future.
                        $font['font-family'] = str_replace(' ', '+', $font['font-family']);

                        // Push data to parent typography variable.
                        if (empty($this->parent->typography[$font['font-family']])) {
                            $this->parent->typography[$font['font-family']] = array();
                        }

                        if (isset($this->field['all_styles'])) {
                            if (!isset($font['font-options']) || empty($font['font-options'])) {
                                $this->getGoogleArray();

                                if (isset($this->parent->googleArray) && !empty($this->parent->googleArray) && isset($this->parent->googleArray[$family])) {
                                    $font['font-options'] = $this->parent->googleArray[$family];
                                }
                            } else {
                                $font['font-options'] = json_decode($font['font-options'], true);
                            }
                        }

                        if (isset($font['font-options']) && !empty($font['font-options']) && isset($this->field['all_styles']) && filter_var($this->field['all_styles'], FILTER_VALIDATE_BOOLEAN)) {
                            if (isset($font['font-options']) && !empty($font['font-options']['variants'])) {
                                if (!isset($this->parent->typography[$font['font-family']]['all-styles']) || empty($this->parent->typography[$font['font-family']]['all-styles'])) {
                                    $this->parent->typography[$font['font-family']]['all-styles'] = array();
                                    foreach ($font['font-options']['variants'] as $variant) {
                                        $this->parent->typography[$font['font-family']]['all-styles'][] = $variant['id'];
                                    }
                                }
                            }
                        }

                        if (!empty($font['font-weight'])) {
                            if (empty($this->parent->typography[$font['font-family']]['font-weight']) || !in_array($font['font-weight'], $this->parent->typography[$font['font-family']]['font-weight'])) {
                                $style = $font['font-weight'];
                            }

                            if (!empty($font['font-style'])) {
                                $style.= $font['font-style'];
                            }

                            if (empty($this->parent->typography[$font['font-family']]['font-style']) || !in_array($style, $this->parent->typography[$font['font-family']]['font-style'])) {
                                $this->parent->typography[$font['font-family']]['font-style'][] = $style;
                            }
                        }

                        if (!empty($font['subsets'])) {
                            if (empty($this->parent->typography[$font['font-family']]['subset']) || !in_array($font['subsets'], $this->parent->typography[$font['font-family']]['subset'])) {
                                $this->parent->typography[$font['font-family']]['subset'][] = $font['subsets'];
                            }
                        }
                    } // !array_key_exists
                } //!empty fonts array
            } // Typography not set
        }

       private function localizeStdFonts() {
	       if (false == $this->user_fonts) {
	           if (isset($this->parent->fonts['std']) && !empty($this->parent->fonts['std'])) {
	               return;
	           }

	           $this->parent->font_groups['std'] = array(
	               'text'      => __('Standard Fonts', 'radium'),
	               'children'  => array(),
	           );

	           foreach($this->field['fonts'] as $font => $extra){
	               $this->parent->font_groups['std']['children'][] = array(
	                   'id'            => $font,
	                   'text'          => $font,
	                   'data-google'   => 'false',
	               );
	           }
	       }

	       if ($this->field['custom_fonts'] !== false) {
	           $this->field['custom_fonts'] = apply_filters("radium_opts_{$this->parent->args['opt_name']}_field_typography_custom_fonts", array());

	            if (!empty($this->field['custom_fonts'])) {
	               foreach ($this->field['custom_fonts'] as $group => $fonts) {
	                   $this->parent->font_groups['customfonts'] = array(
	                       'text'      => $group,
	                       'children'  => array(),
	                   );

	                   foreach ($fonts as $family => $v) {
	                       $this->parent->font_groups['customfonts']['children'][] = array(
	                           'id'            => $family,
	                           'text'          => $family,
	                           'data-google'   => 'false',
	                       );
	                   }
	               }
	           }
	       }
	   }

        /**
         * Construct the google array from the stored JSON/HTML
         */
       public function getGoogleArray() {
 
            // Is already present?
            if (isset($this->parent->fonts['google']) && !empty($this->parent->fonts['google'])) {
                return;
            }

            if (!isset($this->parent->fonts['google']) || empty($this->parent->fonts['google'])) {
                $fonts = json_decode(file_get_contents('googlefonts.json', true), true);
 
                if (isset($fonts) && !empty($fonts) && is_array($fonts) && $fonts != false) {
                    $this->parent->fonts['google'] = $fonts;
                    $this->parent->googleArray = $fonts;

                    // optgroup
                    $this->parent->font_groups['google'] = array(
                        'text'      => __('Google Webfonts', 'radium'),
                        'children'  => array(),
                    );

                    // options
                    foreach ($this->parent->fonts['google'] as $font => $extra) {
                        $this->parent->font_groups['google']['children'][] = array(
                            'id'            => $font,
                            'text'          => $font,
                            'data-google'   => 'true'
                        );
                    }

                }
            }

        }

        /**
	     * getSubsets Function.
	     *
	     * Clean up the Google Webfonts subsets to be human readable
	     *
	     * @since radiumFramework 0.2.0
	     */
	    private function getSubsets($var) {
	        $result = array();

	        foreach ($var as $v) {
	            if (strpos($v, "-ext")) {
	                $name = ucfirst(str_replace("-ext", " Extended", $v));
	            } else {
	                $name = ucfirst($v);
	            }

	            array_push($result, array(
	                'id'    => $v,
	                'name'  => $name
	            ));
	        }
	        return array_filter($result);
	    }  //function

	    /**
	     * getVariants Function.
	     *
	     * Clean up the Google Webfonts variants to be human readable
	     *
	     * @since radiumFramework 0.2.0
	     */
	    private function getVariants($var) {
	        $result = array();
	        $italic = array();

	        foreach ($var as $v) {
	            $name = "";
	            if ($v[0] == 1) {
	                $name = 'Ultra-Light 100';
	            } else if ($v[0] == 2) {
	                $name = 'Light 200';
	            } else if ($v[0] == 3) {
	                $name = 'Book 300';
	            } else if ($v[0] == 4 || $v[0] == "r" || $v[0] == "i") {
	                $name = 'Normal 400';
	            } else if ($v[0] == 5) {
	                $name = 'Medium 500';
	            } else if ($v[0] == 6) {
	                $name = 'Semi-Bold 600';
	            } else if ($v[0] == 7) {
	                $name = 'Bold 700';
	            } else if ($v[0] == 8) {
	                $name = 'Extra-Bold 800';
	            } else if ($v[0] == 9) {
	                $name = 'Ultra-Bold 900';
	            }

	            if ($v == "regular") {
	                $v = "400";
	            }

	            if (strpos($v, "italic") || $v == "italic") {
	                $name.= " Italic";
	                $name = trim($name);
	                if ($v == "italic") {
	                    $v = "400italic";
	                }
	                $italic[] = array(
	                    'id'    => $v,
	                    'name'  => $name
	                );
	            } else {
	                $result[] = array(
	                    'id'    => $v,
	                    'name'  => $name
	                );
	            }
	        }

	        foreach ($italic as $item) {
	            $result[] = $item;
	        }

	        return array_filter($result);
	    }   //function

        /**
         * Field Render Function.
         *
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since Radium_Options 1.0.0
         */
        function render() {

        	$fonts = $this->parent->fonts;
        	$field = $this->field;
        	$value = $this->value;

            if (empty($this->field['units']) && !empty($this->field['default']['units'])) {
                $this->field['units'] = $this->field['default']['units'];
            }

            if (empty($this->field['units']) || !in_array($this->field['units'], array( 'px', 'em', 'rem', '%' ))) {
                $this->field['units'] = 'px';
            }

            $unit 			= $this->field['units'];
        	$color 			= isset($value['color']) 			? $this->value['color'] 			: $field['default']['color'] ;
        	$family  		= isset($value['font-family']) 		? $this->value['font-family'] 	: $field['default']['font-family'];
        	$fontsize  		= isset($value['font-size']) 		? $this->value['font-size']		: $field['default']['font-size'];
        	$fontstyle  	= isset($value['font-style']) 		? $this->value['font-style']		: $field['default']['font-style'];
        	$fontweight  	= isset($value['font-weight']) 		? $this->value['font-weight']		: $field['default']['font-weight'];
        	$lineheight 	= isset($value['line-height']) 		? $this->value['line-height'] 	: $field['default']['line-height'];
        	$texttransform 	= isset($value['text-transform']) 	? $this->value['text-transform'] 	: $field['default']['text-transform'];
        	$fontweight 	= isset($value['font-weight']) 		? $this->value['font-weight'] 	: $field['default']['font-weight'];
        	$textdecoration = isset($value['text-decoration']) 	? $this->value['text-decoration'] : $field['default']['text-decoration'];
        	$textshadow 	= isset($value['text-shadow']) 		? $this->value['text-shadow'] 	: $field['default']['text-shadow'];
        	$letterspacing 	= isset($value['letter-spacing']) 	? $this->value['letter-spacing'] 	: $field['default']['letter-spacing'];
        	$wordspacing 	= isset($value['word-spacing']) 	? $this->value['word-spacing'] 	: $field['default']['word-spacing'];

			$title = $field['multi_typography'] ? $field['selector'] : $field['title'];
        	$selector 		= isset($value['selector']) 		? $this->value['selector'] 		: $field['default']['selector'];
        	$customize 		= isset($value['customize-options'])? $this->value['customize-options'] : $field['default']['customize-options'];

         	$field_save_name = $this->parent->args['opt_name'].'['. $field['id'] .']'; //replace commas characters with a |
        	$field_id = preg_replace("/[^a-zA-Z0-9]+/", "_",  $field['id']); //replace non-alphenumeric characters with a underscore

    	   if ( $field['multi_typography'] && $value['custom-selector'] == '') {

    	   		$custom_selectors = $field['selector'];

    	   } elseif ( $field['multi_typography'] && isset( $value['custom-selector'] )  ) {

      	   		$custom_selectors = $value['custom-selector'];

     	   }

        	ob_start();

			echo '<div id="' . $field_id . '" class="feature-set" data-id="' . $field_id . '" data-units="' . $unit . '">';

				echo '<fieldset class="title typography-open">';
					echo '<div class="inner">';
						echo '<label class="selector-title">'. $title .'</label>';
						if(!$field['multi_typography']) echo '<kbd>'. $field['desc'].'</kbd>';
					echo '</div>';
				echo '</fieldset>';

				echo '<div class="type-typography radium-opts-typography-container compact" id="container-'.$field['id'].'" data-id="'.$field['id'].'">';

				?>

					<fieldset class="data">
						<div class="inner">
							<div class="type_fields">

								<input class="font-selector" type="hidden" id="<?php echo $field_id; ?>_selector" name="<?php echo $field_save_name; ?>[selector]" value="<?php echo $field['selector']; ?>">

				                <?php if ( $this->field['customize-options'] ) : ?>

								<fieldset class="customizer">

									<h4><?php _e('Choose what to parameter to customize', 'radium'); ?></h4>

									<div class="customizer-field">
								 		<?php

				 		            	$values = array(
				 		                    'font-family',
				 		                    'font-style',
				 		                    'font-weight',
				 		                    'text-align',
				 		                    'text-decoration',
				 		                    'text-shadow',
				 		                    'text-transform',
				 		                    'color',
				 		                    'font-size',
				 		                    'line-height',
				 		                    'letter-spacing',
				 		                    'word-spacing',
				 		                );
  										
				 		                foreach ($values as $v) :
											
											if( $this->field[$v] !== true ) continue;
											
				 		                	$customize_value = isset( $customize[$v] ) ? checked( $customize[$v], '1', false ) : '';

				 		                	?>
				 		                    <div class="customize-checkbox-wrapper">
				 		                    	<label class="switch_wrap">
				 		                    		<input name="<?php echo $field_save_name; ?>[customize-options][<?php echo $v; ?>]" id="customize_<?php echo $v; ?>" class="radium-opts-typography radium-opts-typography-customize" value="1" <?php echo $customize_value; ?> type="checkbox" data-select="<?php echo $v; ?>" />
				 		                    		<div class="switch"><span class="bullet"></span></div>
				 		                    	</label>
				 		                    	<label for="customize_<?php echo $v; ?>"><?php echo ucwords(str_replace('-', ' ', $v)); ?></label>
				 		                    </div>

				 		                <?php endforeach; ?>

 										<div class="clear"></div>

									</div>

					        	</fieldset>
					        	<?php endif; ?>

					        	<fieldset>

			 		                <?php

			 		               	if ( $field['multi_typography'] ) {

				 		            	echo '<div class="typography-custom-selectors" original-title="' . __('Custom Selectors', 'radium') . '">';

				 		                echo '<label for="custome-'. $field_id  .'">'. __('Custom Selectors', 'radium') .'</label>';

										echo '<kbd>You can customize the css selectors to use here. Comma delimited.</kbd>';

	  					                echo '<textarea id="custome-'. $field_id  .'" class="radium-opts-typography-custom-selector ' . $this->field['class'] . '" name="' . $field_save_name . '[custom-selector]' . $this->field['name_suffix'] . '" rows="5" cols="75" >' . $custom_selectors . '</textarea>';

	  					                echo '</div>';

			 		                } ?>

			 		                <div class="clear"></div>

					        	</fieldset>

					        	<fieldset>

                					<?php

                				echo '<div class="field-group">';

                				    echo '<div class="">';

                					 if (isset($this->field['select2'])) { // if there are any let's pass them to js
    					                $select2_params = json_encode($this->field['select2']);
    					                $select2_params = htmlspecialchars($select2_params, ENT_QUOTES);

    					                echo '<input type="hidden" class="select2_params" value="' . $select2_params . '">';
    					            }

                					if ( $this->field['font-family'] ) :

                					    if (filter_var($this->value['google'], FILTER_VALIDATE_BOOLEAN)) :
    					                    $fontFamily = explode(', ', $this->value['font-family'], 2);
    					                    if (empty($fontFamily[0]) && !empty($fontFamily[1])) :
    					                        $fontFamily[0] = $fontFamily[1];
    					                        $fontFamily[1] = "";
    					                    endif;
    					                endif;

    					                if (!isset($fontFamily)) :
    					                    $fontFamily = array();
    					                    $fontFamily[0] = $this->value['font-family'];
    					                    $fontFamily[1] = "";
    					                endif;

    					                $userFonts = '0';
    					                if (true == $this->user_fonts) :
    					                    $userFonts = '1';
    					                endif;

    					                $isGoogleFont = '0';
    					                if (isset($this->parent->fonts['google'][$fontFamily[0]])) :
    					                    $isGoogleFont = '1';
    					                endif;

    					                echo '<input type="hidden" class="radium-opts-typography-font-family ' . $this->field['class'] . '" data-user-fonts="' . $userFonts . '" name="' . $field_save_name . '[font-family]' . $this->field['name_suffix'] . '" value="' . $this->value['font-family'] . '" data-id="' . $field_id . '"  />';
    					                echo '<input type="hidden" class="radium-opts-typography-font-options ' . $this->field['class'] . '" name="' . $field_save_name . '[font-options]' . $this->field['name_suffix'] . '" value="' . $this->value['font-options'] . '" data-id="' . $field_id . '"  />';

    					                echo '<input type="hidden" class="radium-opts-typography-google-font" value="' . $isGoogleFont . '" id="' . $field_id . '-google-font">';

    					                echo '<div class="select_wrapper typography-family">';
    					                	echo '<label>' . __('Font Family', 'radium') . '</label>';
    					                	$placeholder = $fontFamily[0] ? $fontFamily[0] : __('Font family', 'radium');

	    					                echo '<div class=" radium-opts-typography radium-opts-typography-family select2-container ' . $this->field['class'] . '" id="' . $field_id . '-family" placeholder="' . $placeholder . '" data-id="' . $field_id . '" data-value="' . $fontFamily[0] . '">';
	    					                echo '</div>';

    					                echo '</div>';

    					                $googleSet = false;

    					                if ($this->field['google'] === true) :

    					                    // Set a flag so we know to set a header style or not
    					                    echo '<input type="hidden" class="radium-opts-typography-google' . $this->field['class'] . '" id="' . $field_id . '-google" name="' . $field_save_name . '[google]' . $this->field['name_suffix'] . '" type="text" value="' . $this->field['google'] . '" data-id="' . $field_id . '" />';
    					                    $googleSet = true;

    					                endif;

                				 	endif;

	        					/* Backup Font */
						            if ($this->field['font-family'] === true && $this->field['google'] === true) : ?>

						                <?php if (false == $googleSet) :

						                    // Set a flag so we know to set a header style or not
						                    echo '<input type="hidden" class="radium-opts-typography-google' . $this->field['class'] . '" id="' . $field_id . '-google" name="' . $field_save_name . '[google]' . $this->field['name_suffix'] . '" type="text" value="' . $this->field['google'] . '" data-id="' . $field_id . '"  />';

						                endif;

						                if ($this->field['font-backup'] === true) :
						                    echo '<div class="select_wrapper typography-family-backup">';
						                    echo '<label>' . __('Backup Font Family', 'radium') . '</label>';
						                    echo '<select
						                    	data-placeholder="' . __('Backup Font Family', 'radium') . '"
						                    	name="' . $field_save_name . '[font-backup]' . $this->field['name_suffix'] . '"
						                    	class="radium-opts-typography radium-opts-typography-family-backup ' . $this->field['class'] . '"
						                    	id="' . $field_id . '-family-backup"
						                    	data-id="' . $field_id . '"
						                    	data-value="' . $this->value['font-backup'] . '"
						                    	>';
						                    echo '<option data-google="false" data-details="" value=""></option>';

						                    foreach ($this->field['fonts'] as $i => $family) :
						                        echo '<option data-google="true" value="' . $i . '"' . selected($this->value['font-backup'], $i, false) . '>' . $family . '</option>';
						                    endforeach;

						                    echo '</select></div>';
						                endif;
						            endif;

    					          /* Font Style/Weight */
    					            if ($this->field['font-style'] === true || $this->field['font-weight'] === true){

    					                echo '<div class="select_wrapper typography-style" original-title="' . __('Font style', 'radium') . '">';
    					                echo '<label>' . __('Font Weight &amp; Style', 'radium') . '</label>';

    					                $style = $this->value['font-weight'] . $this->value['font-style'];

    					                echo '<input type="hidden" class="typography-font-weight" name="' . $field_save_name . '[font-weight]' . $this->field['name_suffix'] . '" value="' . $this->value['font-weight'] . '" data-id="' . $field_id . '"  /> ';
    					                echo '<input type="hidden" class="typography-font-style" name="' . $field_save_name . '[font-style]' . $this->field['name_suffix'] . '" value="' . $this->value['font-style'] . '" data-id="' . $field_id . '"  /> ';
    					                echo '<select data-placeholder="' . __('Style', 'radium') . '" class="radium-opts-typography radium-opts-typography-style select' . $this->field['class'] . '" original-title="' . __('Font style', 'radium') . '" id="' . $field_id . '_style" data-id="' . $field_id . '" data-value="' . $style . '">';

    					                if (empty($this->value['subset'])) {
    					                    echo '<option value=""></option>';
    					                }

    					                $nonGStyles = array(
    					                    '200' => 'Lighter',
    					                    '400' => 'Normal',
    					                    '700' => 'Bold',
    					                    '900' => 'Bolder'
    					                );

    					                if (isset($gfonts[$this->value['font-family']])) {
    					                    foreach ($gfonts[$this->value['font-family']]['variants'] as $v) {
    					                        echo '<option value="' . $v['id'] . '" ' . selected($this->value['subset'], $v['id'], false) . '>' . $v['name'] . '</option>';
    					                    }
    					                } else {
    					                    foreach ($nonGStyles as $i => $style) {
    					                        if (!isset($this->value['subset']))
    					                            $this->value['subset'] = false;
    					                        echo '<option value="' . $i . '" ' . selected($this->value['subset'], $i, false) . '>' . $style . '</option>';
    					                    }
    					                }

    					                echo '</select></div>';
    					            }

			                     /* Font Script */
			                        if ($this->field['font-family'] === true && $this->field['subsets'] === true && $this->field['google'] === true){
			                            echo '<div class="select_wrapper typography-script" original-title="' . __('Font subsets', 'radium') . '">';
			                            echo '<label>' . __('Font Subsets', 'radium') . '</label>';
			                            echo '<select data-placeholder="' . __('Subsets', 'radium') . '" class="radium-opts-typography radium-opts-typography-subsets' . $this->field['class'] . '" original-title="' . __('Font script', 'radium') . '"  id="' . $field_id . '-subsets" name="' . $field_save_name . '[subsets]' . $this->field['name_suffix'] . '" data-value="' . $this->value['subsets'] . '" data-id="' . $field_id . '" >';

			                            if (empty($this->value['subsets'])) {
			                                echo '<option value=""></option>';
			                            }

			                            if (isset($gfonts[$this->value['font-family']])) {
			                                foreach ($gfonts[$this->value['font-family']]['subsets'] as $v) {
			                                    echo '<option value="' . $v['id'] . '" ' . selected($this->value['subset'], $v['id'], false) . '>' . $v['name'] . '</option>';
			                                }
			                            }

			                            echo '</select></div>';
			                        }

			                   		echo '</div>';

			                   	echo '</div>';

			                 	echo '<div class="field-group">';

			                      /* Font Align */
			                        if ($this->field['text-align'] === true){
			                            echo '<div class="select_wrapper typography-align customize-text-align" original-title="' . __('Text Align', 'radium') . '">';
			                            echo '<label>' . __('Text Align', 'radium') . '</label>';
			                            echo '<select data-placeholder="' . __('Text Align', 'radium') . '" class="radium-opts-typography radium-opts-typography-align' . $this->field['class'] . '" original-title="' . __('Text Align', 'radium') . '"  id="' . $field_id . '-align" name="' . $field_save_name . '[text-align]' . $this->field['name_suffix'] . '" data-value="' . $this->value['text-align'] . '" data-id="' . $field_id . '" >';
			                            echo '<option value=""></option>';

			                            $align = array(
			                                'inherit',
			                                'left',
			                                'right',
			                                'center',
			                                'justify',
			                                'initial'
			                            );

			                            foreach ($align as $v) {
			                                echo '<option value="' . $v . '" ' . selected($this->value['text-align'], $v, false) . '>' . ucfirst($v) . '</option>';
			                            }

			                            echo '</select></div>';
			                        }

			                      /* Text Decoration */
                                    if ($this->field['text-decoration'] === true) {
                                        echo '<div class="select_wrapper typography-decoration customize-text-decoration" original-title="' . __('Text Decoration',  'radium') . '">';
                                        echo '<label>' . __('Text Decoration',  'radium') . '</label>';
                                        echo '<select data-placeholder="' . __('Text Decoration',  'radium') . '" class="radium-opts-typography radium-opts-typography-decoration' . $this->field['class'] . '" original-title="' . __('Text Decoration',  'radium') . '"  id="' . $field_id . '-decoration" name="' . $field_save_name . '[text-decoration]' . $this->field['name_suffix'] . '" data-value="' . $this->value['text-decoration'] . '" data-id="' . $field_id . '" >';
                                        echo '<option value=""></option>';

                                        $values = array(
                                            'none',
                                            'inherit',
                                            'underline',
                                            'overline',
                                            'line-through',
                                            'blink'
                                        );

                                        foreach ($values as $v) {
                                            echo '<option value="' . $v . '" ' . selected($this->value['text-decoration'], $v, false) . '>' . ucfirst($v) . '</option>';
                                        }

                                        echo '</select></div>';
                                    }

                        		/* Text Transform */
	            		            if ($this->field['text-transform'] === true) {
	            		                echo '<div class="select_wrapper typography-transform customize-text-transform" original-title="' . __('Text Transform', 'radium') . '">';
	            		                echo '<label>' . __('Text Transform', 'radium') . '</label>';
	            		                echo '<select data-placeholder="' . __('Text Transform', 'radium') . '" class="radium-opts-typography radium-opts-typography-transform' . $this->field['class'] . '" original-title="' . __('Text Transform', 'radium') . '"  id="' . $field_id . '-transform" name="' . $field_save_name . '[text-transform]' . $this->field['name_suffix'] . '" data-value="' . $this->value['text-transform'] . '" data-id="' . $field_id . '" >';
	            		                echo '<option value=""></option>';

	            		                $values = array(
	            		                    'none',
	            		                    'capitalize',
	            		                    'uppercase',
	            		                    'lowercase',
	            		                    'initial',
	            		                    'inherit'
	            		                );

	            		                foreach ($values as $v) {
	            		                    echo '<option value="' . $v . '" ' . selected($this->value['text-transform'], $v, false) . '>' . ucfirst($v) . '</option>';
	            		                }

	            		                echo '</select></div>';
	            		            }

	            		       	/* Text Shadow */
	            		            if ( $this->field['text-shadow'] ) :
	            		    	    	echo '<div class="select_wrapper typography-text-shadow customize-text-shadow" original-title="' . __('Text Transform', 'radium') . '">';
	            		         	       	echo '<label>' . __('Text Shadow', 'radium') . '</label>';
											echo '<select data-placeholder="' . __('Text Shadow', 'radium') . '" class="radium-opts-typography radium-opts-typography-shadow' . $this->field['class'] . '" original-title="' . __('Text Shadow', 'radium') . '"  id="' . $field_id . '-shadow" name="' . $field_save_name . '[text-shadow]' . $this->field['name_suffix'] . '" data-value="' . $this->value['text-shadow'] . '" data-id="' . $field_id . '" >';
											echo '<option value=""></option>';

	            		                 	$values = array(
	            		                 		'none',
	            		                         '3px 3px 0 rgba(0,0,0,0.1)',
	            		                         '1px 1px 4px rgba(0,0,0,0.3)',
	            		                         '0 1px 0 rgba(255,255,255,1)',
	            		                         '2px -2px 0 rgba(0,0,0,0.2)',
	            		                         '-2px 2px 0 rgba(0,0,0,0.2)',
	            		                         '3px 0 0 rgba(0,0,0,0.2)',
	            		                         '0 2px 0 rgba(0,0,0,0.2)'
	            		                     );

	            		            		$i = 0;

	            		                    foreach ($values as $v) {

	            		                     	$i++;

	            		                     	$title = ( $v == 'none' ) ? __("No Shadow", "radium") : __("Style #", "radium") . $i ;

	            		                         echo '<option value="' . $v . '" ' . selected($this->value['text-shadow'], $v, false) . '>'. $title . '</option>';
	            		                    }

	            		                echo '</select></div>';

	            		           	endif;

	            		  	echo '</div>';

							echo '<div class="field-color customize-color">';

	                             /* Font Color */
	                                if ($this->field['color'] === true){
	                                    $default = "";

	                                    if (empty($this->field['default']['color']) && !empty($this->field['color'])) {
	                                        $default = $this->value['color'];
	                                    } else if (!empty($this->field['default']['color'])) {
	                                        $default = $this->field['default']['color'];
	                                    }

	                                    echo '<div class="picker-wrapper">';
	                                    echo '<label>' . __('Font Color', 'radium') . '</label>';
	                                    echo '<div id="' . $field_id . '_color_picker" class="colorSelector typography-color"><div style="background-color: ' . $this->value['color'] . '"></div></div>';
	                                    echo '<input data-default-color="' . $default . '" class="radium-opts-color radium-opts-typography-color' . $this->field['class'] . '" original-title="' . __('Font color', 'radium') . '" id="' . $field_id . '-color" name="' . $field_save_name . '[color]' . $this->field['name_suffix'] . '" type="text" value="' . $this->value['color'] . '" data-id="' . $field_id . '" />';
	                                    echo '</div>';
	                                }

                        	  	echo '</div>';

                        	    echo '<div class="clear"></div>';

                        	    echo '<div class="field-sliders">';

                                    /* Font Size */
                                    if ($this->field['font-size'] === true){
                                        echo '<div class="input_wrapper font-size customize-font-size radium-opts-container-typography">';
										echo '<label class="font-size-label" for="'.$field_id.'_font_size">'. __('Font Size', 'radium') .': <span class="'. $field_id.'_font_size_preview">'. $fontsize . $unit .'</span></label>';
										echo '<div id="'.$field_id.'_font_size" class="font-slider" data-font-size="'. $fontsize .'"></div>';
                                        echo '<input id="' . $field_id .'_font_size_input" type="hidden" class="radium-opts-typography-font-size typography-font-size" name="' . $field_save_name . '[font-size]' . $this->field['name_suffix'] .'" value="' . $fontsize .'" data-id="' . $field_id . '"  />';
                                        echo '</div>';
                                    }

                                    /* Line Height */
                        			if ($this->field['line-height'] === true){
                        			    echo '<div class="input_wrapper line-height customize-line-height radium-opts-container-typography">';
                        				echo '<label class="line-height-label" for="'.$field_id.'_line_height">'. __('Line Height', 'radium') .': <span class="'. $field_id.'_line_height_preview">'. $lineheight . $unit .'</span></label>';
                        				echo '<div id="'.$field_id.'_line_height" class="font-slider" data-line-height="'. $this->value['line-height'] .'"></div>';
                        			    echo '<input id="' . $field_id .'_line_height_input" type="hidden" class="radium-opts-typography-line-height typography-line-height" name="' . $field_save_name . '[line-height]' . $this->field['name_suffix'] .'" value="' . $lineheight .'" data-id="' . $field_id . '"  />';
                        			    echo '</div>';
                        			}

                                    /* Word Spacing */
                                    if ($this->field['word-spacing'] === true){
                                        echo '<div class="input_wrapper word-spacing customize-word-spacing radium-opts-container-typography">';
                                    	echo '<label class="word-spacing-label" for="'.$field_id.'_word_spacing">'. __('Word Spacing', 'radium') .': <span class="'. $field_id.'_word_spacing_preview">'. $wordspacing . $unit .'</span></label>';
                                    	echo '<div id="'.$field_id.'_word_spacing" class="font-slider" data-word-spacing="'. $wordspacing .'"></div>';
                                        echo '<input id="' . $field_id .'_word_spacing_input" type="hidden" class="radium-opts-typography-word-spacing typography-word-spacing" name="' . $field_save_name . '[word-spacing]' . $this->field['name_suffix'] .'" value="' . $wordspacing .'" data-id="' . $field_id . '"  />';
                                        echo '</div>';
                                    }

                                    /* Letter Spacing */
                                    if ($this->field['letter-spacing'] === true){
                                        echo '<div class="input_wrapper letter-spacing customize-letter-spacing radium-opts-container-typography">';
                                    	echo '<label class="letter-spacing-label" for="'.$field_id.'_letter_spacing">'. __('Letter Spacing', 'radium') .': <span class="'. $field_id.'_letter_spacing_preview">'. $letterspacing . $unit . '</span></label>';
                                    	echo '<div id="'.$field_id.'_letter_spacing" class="font-slider" data-letter-spacing="'. $letterspacing .'"></div>';
                                        echo '<input id="' . $field_id .'_letter_spacing_input" type="hidden" class="radium-opts-typography-letter-spacing typography-letter-spacing" name="' . $field_save_name . '[letter-spacing]' . $this->field['name_suffix'] .'" value="' . $letterspacing .'" data-id="' . $field_id . '"  />';
                                        echo '</div>';
                                    }

	                            echo '</div>';

	                                /* Font Preview */
	                                if (!isset($this->field['preview']) || $this->field['preview'] !== false){
	                                    if (isset($this->field['preview']['text'])) {
	                                        $g_text = $this->field['preview']['text'];
	                                    } else {
	                                        $g_text = 'The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. 1234567890';
	                                    }

	                                    $style = '';
	                                    if (isset($this->field['preview']['always_display'])) {
	                                        if (true === filter_var( $this->field['preview']['always_display'], FILTER_VALIDATE_BOOLEAN )) {

	                                            $this->parent->typography_preview[$fontFamily[0]] = array(
	                                                'font-style'    => array($this->value['font-weight'] . $this->value['font-style']),
	                                                'subset'        => array($this->value['subset'])
	                                            );

	                                            $protocol = ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 ) ? "https:" : "http:";

	                                            wp_deregister_style('radium-opts-typography-preview');
	                                            wp_dequeue_style('radium-opts-typography-preview');

	                                            wp_register_style( 'radium-opts-typography-preview', $protocol . $this->makeGoogleWebfontLink( $this->parent->typography_preview ), '', time() );
	                                            wp_enqueue_style( 'radium-opts-typography-preview' );

	                                            $style = '
	                                            	color: ' . $color .';
	                                            	font-family: ' . $family .';
	                                            	font-weight: ' . $fontweight . $unit .';
	                                            	text-shadow: '. $textshadow . ';
	                                            	font-size: ' . $fontsize . $unit .';
	                                            	font-style: ' . $fontstyle . ';
	                                            	font-weight: ' . $fontweight . ';
	                                            	letter-spacing: ' . $letterspacing. $unit .';
	                                            	word-spacing: ' . $wordspacing. $unit .';
	                                            	line-height: ' . $lineheight . $unit .';
	                                            	text-transform: ' . $texttransform . ';
	                                            	text-decoration: ' . $textdecoration. '
	                                            	text-shadow: ' . $textshadow . ';
	                                            	-moz-text-shadow:' . $textshadow . ';
	                                            	-webkit-text-shadow:' . $textshadow . ';
	                                            ';
	                                        }
	                                    }

	                                    if (isset($this->field['preview']['font-size'])) {
	                                        $style .= 'font-size: ' . $this->field['preview']['font-size'] . ';';
	                                        $inUse = '1';
	                                    } else {
	                                        //$g_size = '';
	                                        $inUse = '0';
	                                    }

	                                    echo '<p data-preview-size="' . $inUse . '" class="clear ' . $field_id . '_previewer typography-preview" ' . 'style="' . $style . '">' . $g_text . '</p>';
	                                }

                					?>
								</fieldset>
							</div>
						</div>
					</fieldset>

					<div class="clear"></div>

				</div>

				</div>

				<?php

					$font_size = isset($value['font-size']) ? $value['font-size'] : '7';
					$letter_spacing = isset($value['letter-spacing']) ? $value['letter-spacing'] : '0';

				?>
		        <script type="text/javascript">
		            jQuery(function($){

		            	var font_size = jQuery( "#<?php echo $field_id; ?>_font_size_input" ).val();
               		     	font_size = parseInt(font_size, 10 ) ? font_size : 0;

		                /* Font Size Slider */
		                jQuery( "#<?php echo $field_id; ?>_font_size" ).slider({
		                        range: "min",
		                        value: font_size,
		                        min: 7,
		                        max: 59,
		                        slide: function( event, ui ) {

		                        	if ( ui.value ) {
		                        		$("#<?php echo $field_id; ?>_font_size_input").val(ui.value);
		                        		$("#<?php echo $field_id; ?> .typography-preview").css('font-size', ui.value + "px");
		                        		$(".<?php echo $field_id; ?>_font_size_preview").text(ui.value + "px");
		                        	}

		                        }
		                });

		               var letter_spacing = jQuery( "#<?php echo $field_id; ?>_letter_spacing_input" ).val();
		                   letter_spacing = parseInt(letter_spacing, 10 ) ? letter_spacing : 0;

		               /* Letter Spacing Slider */
		               jQuery( "#<?php echo $field_id; ?>_letter_spacing" ).slider({
							range: "min",
							value: letter_spacing,
							min: -5,
							max: 20,
							slide: function( event, ui ) {

								if ( ui.value ) {
									$("#<?php echo $field_id; ?>_letter_spacing_input").val(ui.value);
									$("#<?php echo $field_id; ?> .typography-preview").css('letter-spacing', ui.value + "px");
									$(".<?php echo $field_id; ?>_letter_spacing_preview").text(ui.value + "px");
								}

							}
		               });

		               /* Line Height Slider */
		               var line_height = jQuery( "#<?php echo $field_id; ?>_line_height_input" ).val();
		                   line_height = parseInt(line_height, 10 ) ? line_height : 0;

		               jQuery( "#<?php echo $field_id; ?>_line_height" ).slider({
		               		range: "min",
		               		value: line_height,
		               		min: 0,
		               		max: 80,
		               		slide: function( event, ui ) {

		               			if ( ui.value ) {
		               				$("#<?php echo $field_id; ?>_line_height_input").val(ui.value);
		               				$("#<?php echo $field_id; ?> .typography-preview").css('line-height', ui.value + "px");
		               				$(".<?php echo $field_id; ?>_line_height_preview").text(ui.value + "px");
		               			}

		               		}
		               });

		               /* Word Spacing Slider */
		               var word_spacing = jQuery( "#<?php echo $field_id; ?>_word_spacing_input" ).val();
		                   word_spacing = parseInt(word_spacing, 10 ) ? word_spacing : 0;

		               jQuery( "#<?php echo $field_id; ?>_word_spacing" ).slider({
		               		range: "min",
		               		value: word_spacing,
		               		min: -5,
		               		max: 50,
		               		slide: function( event, ui ) {

		               			if ( ui.value ) {
		               				$("#<?php echo $field_id; ?>_word_spacing_input").val(ui.value);
		               				$("#<?php echo $field_id; ?> .typography-preview").css('word-spacing', ui.value + "px");
		               				$(".<?php echo $field_id; ?>_word_spacing_preview").text(ui.value + "px");
		               			}

		               		}
		               });

		 			});
		        </script><?php

        echo ob_get_clean();

        }  //function

        /**
         * Enqueue Function.
         *
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since Radium_Options 1.0.0
         */
        function enqueue() {

			wp_enqueue_script( 'radium-opts-field-slider-js', $this->parent->url.'fields/slider/field_slider.js', array( 'jquery', 'jquery-ui-slider' ), time(), true );

			wp_enqueue_script( 'radium-opts-field-typography-js', $this->parent->url.'fields/typography/field_typography.js', array( 'jquery' ), time(), true );

			wp_localize_script(
			    'radium-opts-field-typography-js',
			    'radium_opts_ajax_script',
			    array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) )
			);

			wp_enqueue_style('radium-opts-typography', $this->parent->url . 'fields/typography/field_typography.css', array(), time(), 'all' );

			wp_enqueue_style('radium-opts-jquery-ui-css');

            wp_enqueue_script( 'webfontloader', 'https://ajax.googleapis.com/ajax/libs/webfont/1.5.0/webfont.js', array( 'jquery' ), '1.5.0', true );

            if(get_bloginfo('version') >= '3.5') {
                wp_enqueue_style('wp-color-picker');

                wp_enqueue_script( 'radium-opts-field-color-js', $this->parent->url . 'fields/color/field_color.js', array('wp-color-picker'),                     time(), true );

            } else {
                wp_enqueue_script( 'radium-opts-field-color-js', $this->parent->url . 'fields/color/field_color_farb.js', array('jquery', 'farbtastic'), time(), true );
            }

        }  //function


    }       //class
}           //class exists