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

/*--------------------------------------------------------------------*/
/*  THEME CUSTOMIZER STYLES
/*--------------------------------------------------------------------*/
if ( !function_exists('radium_customize_css') ) {
    function radium_customize_css() {

$framework = radium_framework();

$theme_accent_color = radium_get_customizer_option('accent_color') ? radium_get_customizer_option('accent_color') : '#ff5a00';
$header_menu_top_level_bg_color = radium_get_customizer_option('header_menu_top_level_bg_color');
?><style>
<?php if ( radium_get_option('loading_bar', false, false) ) { ?>
.pace {
  -webkit-pointer-events: none;
  pointer-events: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none;
}

.pace-inactive {
  display: none;
}

.pace .pace-progress {
  background: <?php echo $theme_accent_color; ?>;
  position: fixed;
  z-index: 2000;
  top: 0;
  left: 0;
  height: 2px;

  -webkit-transition: width 1s;
  -moz-transition: width 1s;
  -o-transition: width 1s;
  transition: width 1s;
}

.pace .pace-progress-inner {
  display: block;
  position: absolute;
  right: 0px;
  width: 100px;
  height: 100%;
  box-shadow: 0 0 10px <?php echo $theme_accent_color; ?>, 0 0 5px <?php echo $theme_accent_color; ?>;
  opacity: 1.0;
  -webkit-transform: rotate(3deg) translate(0px, -4px);
  -moz-transform: rotate(3deg) translate(0px, -4px);
  -ms-transform: rotate(3deg) translate(0px, -4px);
  -o-transform: rotate(3deg) translate(0px, -4px);
  transform: rotate(3deg) translate(0px, -4px);
}

.pace .pace-activity {
  display: block;
  position: fixed;
  z-index: 2000;
  top: 15px;
  right: 15px;
  width: 14px;
  height: 14px;
  border: solid 2px transparent;
  border-top-color: <?php echo $theme_accent_color; ?>;
  border-left-color: <?php echo $theme_accent_color; ?>;
  border-radius: 10px;
  -webkit-animation: pace-spinner 400ms linear infinite;
  -moz-animation: pace-spinner 400ms linear infinite;
  -ms-animation: pace-spinner 400ms linear infinite;
  -o-animation: pace-spinner 400ms linear infinite;
  animation: pace-spinner 400ms linear infinite;
}

@-webkit-keyframes pace-spinner {
  0% { -webkit-transform: rotate(0deg); transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); transform: rotate(360deg); }
}
@-moz-keyframes pace-spinner {
  0% { -moz-transform: rotate(0deg); transform: rotate(0deg); }
  100% { -moz-transform: rotate(360deg); transform: rotate(360deg); }
}
@-o-keyframes pace-spinner {
  0% { -o-transform: rotate(0deg); transform: rotate(0deg); }
  100% { -o-transform: rotate(360deg); transform: rotate(360deg); }
}
@-ms-keyframes pace-spinner {
  0% { -ms-transform: rotate(0deg); transform: rotate(0deg); }
  100% { -ms-transform: rotate(360deg); transform: rotate(360deg); }
}
@keyframes pace-spinner {
  0% { transform: rotate(0deg); transform: rotate(0deg); }
  100% { transform: rotate(360deg); transform: rotate(360deg); }
}
<?php

} //end if

if ( radium_get_option('custom_colors') ) :

	radium_generate_customize_css();

endif;

$bg_css = null;
$bg_pattern 	= radium_get_option('body_bg_pattern');
$bg_css_check 	= radium_check_background_settings('main_bg');

if ( $bg_css_check || $bg_pattern ) : ?>
html { background-color: transparent; }

body.boxed,
body.narrow {<?php

if ( $bg_css_check ) {

	$bg_css = radium_get_background_settings('main_bg');

} elseif ( $bg_pattern ) {

	$bg_css = 'background-image: url('.$framework->theme_images_url.'/patterns/'.$bg_pattern .'); background-repaeat:repeat;';

}

echo $bg_css;

?>}<?php endif;

//CSS FOR CUSTOM CSS
$custom_css = radium_get_option( 'user_custom_styles') ? radium_get_option( 'user_custom_styles') : '';
echo $custom_css; ?>

</style>
<?php

}
add_action( 'wp_head', 'radium_customize_css', 90 );

} //if

/**
 * radium_get_background_settings
 * @param  string   $bg_key     option key for the background settings
 * @return string   the background css
 */
function radium_get_background_settings($bg_key) {

	$value = radium_get_option($bg_key);

	$css = '';

	if ( ! empty( $value ) && is_array( $value ) ) {
	    foreach ( $value as $key => $value ) {
	        if ( ! empty( $value ) && $key != "media" ) {
	            if ( $key == "background-image" ) {
	                $css .= $key . ":url('" . $value . "');";
	            } else {
	                $css .= $key . ":" . $value . ";";
	            }
	        }
	    }
	}

	return $css;

}

/**
 * radium_check_background_settings check if background image is set
 * @param  strind $bg_key [description]
 * @return bool
 */
function radium_check_background_settings($bg_key) {

	$value = radium_get_option($bg_key);

	if ( ! empty( $value ) && is_array( $value ) ) {
	    foreach ( $value as $key => $value ) {
	        if ( ! empty( $value ) && $key != "media" ) {
	            if ( $key == "background-image" ) {
	                return true;
	            }
	        }
	    }
	}

	return false;

}

//Custom typography css
/**
 * Load fonts stored in theme options
 *
 * @since 2.1.3
 */
function radium_theme_load_fonts() {
	
	$field_id = 'user_font_selectors';
	$selectors = radium_get_option($field_id);
	$custom_fonts = $family = $fontstyle = $fontweight = $link = null;
	$fonts = array();
	$all_styles = $font_styles = $subsets = array();

	if(is_array($selectors)) :

	    foreach($selectors as $selector) :

 	    	$value = radium_get_option($field_id.'_'.$selector);

 			if ( !isset($value['font-family']) ) continue;

 			if (filter_var($value['google'], FILTER_VALIDATE_BOOLEAN)) :
                $fontFamily = explode(', ', $value['font-family'], 2);
                if (empty($fontFamily[0]) && !empty($fontFamily[1])) :
                    $fontFamily[0] = $fontFamily[1];
                    $fontFamily[1] = "";
                endif;

            else:

            	continue;

            endif;

            if (!isset($fontFamily)) :
                $fontFamily = array();
                $fontFamily[0] = $value['font-family'];
                $fontFamily[1] = "";
            endif;

			$family = $fontFamily[0];

			if (!$family) continue;

 			$all_styles 	= isset( $value['all-styles'] ) ? $value['all-styles']  : null;
 			$font_weight 	= isset( $value['font-weight'] )? $value['font-weight'] : null;
	 		$font_style 	= isset( $value['font-style'])	? $value['font-style']  : null;
	 		$subsets	 	= isset( $value['subsets'] )	? $value['subsets'] 	: null;

	 		$fonts[$family] = array(
	 			'all-styles' => $all_styles,
	 			'font-style' => $font_weight,
	 			'subset' => $subsets
	 		);

	    endforeach; 
	    
	endif;
	   	    
    //Primary typography
	$field_ids = array(
		'primary_typeface',
	 	'secondary_typeface',
	);    	
		 
	foreach ($field_ids as $field_id ) {
	
    	$value = radium_get_option($field_id);
    	
		if ( isset($value['font-family']) ) :
	
			if (filter_var($value['google'], FILTER_VALIDATE_BOOLEAN)) :
	            $fontFamily = explode(', ', $value['font-family'], 2);
	            if (empty($fontFamily[0]) && !empty($fontFamily[1])) :
	                $fontFamily[0] = $fontFamily[1];
	                $fontFamily[1] = "";
	            endif;
	
	        endif;
	
	        if (!isset($fontFamily)) :
	            $fontFamily = array();
	            $fontFamily[0] = $value['font-family'];
	            $fontFamily[1] = "";
	        endif;
	
			$family = $fontFamily[0];
	
			if ($family) {
	
				$all_styles 	= isset( $value['all-styles'] ) ? $value['all-styles']  : null;
				$font_weight 	= isset( $value['font-weight'] )? $value['font-weight'] : null;
		 		$font_style 	= isset( $value['font-style'])	? $value['font-style']  : null;
		 		$subsets	 	= isset( $value['subsets'] )	? $value['subsets'] 	: null;
		
		 		$fonts[$family] = array (
		 			'all-styles' => $all_styles,
		 			'font-style' => $font_weight,
		 			'subset' 	 => $subsets
		 		);
		 		
	 		}
 		
 		endif;
 		
	}
 		
	if ( !empty($fonts)) :
 	
?><script>
    /* You can add more configuration options to webfontloader by previously defining the WebFontConfig with your options */
    if ( typeof WebFontConfig === "undefined" ) {
        WebFontConfig = new Object();
    }
    WebFontConfig['google'] = {families: [<?php echo radium_make_google_web_fontstring( $fonts )?>]};

    (function() {
        var wf = document.createElement( 'script' );
        wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.5.0/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName( 'script' )[0];
        s.parentNode.insertBefore( wf, s );
    })();
</script><?php

endif;

}
add_action( 'wp_head', 'radium_theme_load_fonts', 91 );

//Custom typography css
function radium_theme_custom_typography_css() {

	$field_id = 'user_font_selectors';
	$selectors = radium_get_option($field_id);

	?><style><?php

	//render typography
	if(is_array($selectors)) :

	    foreach($selectors as $selector) :

			$value = radium_get_option($field_id . '_' . $selector);

			$selector = isset($value['custom-selector']) ? $value['custom-selector'] : $selector;

			echo radium_create_custom_css ( $selector, $value );

		endforeach;

	endif;
  	
	?></style><?php

}
add_action( 'wp_head', 'radium_theme_custom_typography_css', 92 );

//Custom typography css
function radium_theme_predefined_typography_css() {

	$field_ids = array(
		'primary_typeface',
		'secondary_typeface',
		'logotext',
	);
	
	?><style><?php
	
	foreach ($field_ids as $field_id) {
	
		$value = radium_get_option($field_id);
		
		if ( !isset($value['selector']) ) continue;
		
		//render typography
		radium_create_custom_css ( $value['selector'], $value );
							
	}
	
	?></style><?php

}
add_action( 'wp_head', 'radium_theme_predefined_typography_css', 93 );