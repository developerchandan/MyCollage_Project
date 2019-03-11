<?php
/**
 * Add option section for theme customizer
 * added in WP 3.4
 *
 * @since 2.1.0
 *
 * @param string $section_id ID for section
 * @param string $section_name Name for section
 * @param array $options Options to register for WP theme customizer
 * @param int $priority Priority for section
 */

if( ! function_exists( 'radium_add_customizer_section' ) ) {
    function radium_add_customizer_section( $section_id, $section_name, $options, $priority = null ){

        global $_radium_customizer_sections;

        $_radium_customizer_sections[$section_id] = array(
            'id' 		=> $section_id,
            'name' 		=> $section_name,
            'options' 	=> $options,
            'priority'	=> $priority
        );

    }
}

add_action( 'customize_register', 'radium_customizer_init' );
/**
 * Setup everything we need for WordPress customizer.
 *
 * All custom controls used in this function can be
 * found in the following file:
 *
 * @since 2.1.0
 */

if( ! function_exists( 'radium_customizer_init' ) ) {
    function radium_customizer_init( $wp_customize ){

        global $_radium_customizer_sections;

        $framework = radium_framework();

        // Global option name
        $option_name = $framework->customizer_option_name;

        // Alter current theme options and only modify our select
        // options controlled with the customizer.
        $theme_options = get_option( $option_name );

        $wp_customize->add_panel( 'radium_theme_options', array(
            'capability'     => 'edit_theme_options',
            'title'          => sprintf(__('%s Theme Colors', 'radium'), $framework->theme_title),
            'description'    => sprintf(__('Several color settings pertaining to %s', 'radium'), $framework->theme_title),
        ) );

        // Register sections of options
        if( $_radium_customizer_sections ) {
            foreach( $_radium_customizer_sections as $section ){

                // Add section
                $wp_customize->add_section( $section['id'] , array(
                    'title'    => $section['name'],
                    'priority' => $section['priority'],
                    'panel'  => 'radium_theme_options',
                ) );

                // Add Options
                if( $section['options'] ){
                    foreach( $section['options'] as $option ) {

                        // Default
                        $default = isset( $theme_option_defaults[$option['id']] ) ? $theme_option_defaults[$option['id']] : '';

                        // Transport
                        $transport  = isset( $option['transport'] ) ? $option['transport']  : '';
                        $priority   = isset( $option['priority'] )  ? $option['priority']   : '';

                        // Register option
                        $wp_customize->add_setting( $option_name.'['.$option['id'].']', array(
                            'default'    	=> esc_attr( $default ),
                            'type'       	=> 'option',
                            'capability' 	=> 'edit_theme_options',
                            'transport'		=> $transport
                        ) );

                        // Add controls
                        switch( $option['type'] ) {

                            // Standard text option
                            case 'logo' :
                            case 'main_bg' :
                                $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $option['id'].'_image', array(
                                    'priority'		=> 4,
                                    'settings'		=> $option_name.'['.$option['id'].']',
                                    'label'			=> $option['name'],
                                    'section'		=> $section['id']
                                ) ) );
                                break;

                            // Standard text option
                            case 'text' :
                            case 'textarea' :
                                $wp_customize->add_control( $option['id'], array(
                                    'priority'		=> $priority,
                                    'settings'		=> $option_name.'['.$option['id'].']',
                                    'label'   		=> $option['name'],
                                    'section' 		=> $section['id']
                                ) );
                                break;
                            // Select box
                            case 'select' :
                            case 'radio' :
                                $wp_customize->add_control( $option['id'], array(
                                    'priority'		=> $priority,
                                    'settings'		=> $option_name.'['.$option['id'].']',
                                    'label'			=> $option['name'],
                                    'section'		=> $section['id'],
                                    'type'			=> $option['type'],
                                    'choices'		=> $option['options']
                                ) );
                                break;
                            // Color
                            case 'color' :
                                $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $option['id'], array(
                                    'priority'		=> $priority,
                                    'settings'		=> $option_name.'['.$option['id'].']',
                                    'label'			=> $option['name'],
                                    'section'		=> $section['id']
                                ) ) );
                                break;
                        }

                    }
                }
            }
        }
    }
}

/**
 * Styles for WordPress customizer.
 *
 * @since 2.1.0
 */

if( ! function_exists( 'radium_customizer_styles' ) ) {
    function radium_customizer_styles(){
        wp_register_style( 'radium_skin_customizer', get_template_directory_uri().'/framework/assets/css/customizer.css', false, '1.0' );
        wp_enqueue_style( 'radium_skin_customizer' );
    }
}
add_action( 'customize_controls_print_styles', 'radium_customizer_styles' );

/**
 * Scripts for WordPress customizer.
 *
 * @since 2.1.0
 */

if( ! function_exists( 'radium_customizer_scripts' ) ) {
    function radium_customizer_scripts(){
        wp_enqueue_script( 'radium_skin_customizer', get_template_directory_uri().'/framework/assets/js/customizer.js', array('jquery'), '1.0');
    }
}
add_action( 'customize_controls_enqueue_scripts', 'radium_customizer_scripts' );

 /**
  * radium_generate_customize_css Autogenerate css used by customizer
  * @return null
  */
function radium_generate_customize_css() {

      $register_customizer_options = radium_get_theme_customizer_options();

      if ( $register_customizer_options ) :

        foreach( $register_customizer_options as $options ) :

            foreach( $options as $option ) :

                  if ( radium_get_customizer_option($option['id']) ) :

                     radium_generate_customizer_properties($option['id'], $option['selectors']);

                endif;

             endforeach;

        endforeach;

       endif;

}

/**
 * radium_generate_customizer_properties Autogenerate css used by customizer
 * @param  string $option_id    options id used to store data
 * @param  array $css_selector array conatinig the css selectors to be used
 * @return null
 */
function radium_generate_customizer_properties( $id, $selectors ) {

    foreach ( $selectors as $property => $selector) {

        if ( !$selector ) continue;

        echo $selector ." { ". $property .": ". radium_get_customizer_option($id) ."; } ";
    }

}

/**
 * radium_generate_customize_preview_js Autogenerate js used by customizer
 * @return null
 */
function radium_generate_customize_preview_js() {

      $register_customizer_options = radium_get_theme_customizer_options();

      if ( $register_customizer_options ) :

        foreach( $register_customizer_options as $options ) :

            foreach( $options as $option ) :

                  if ( $option['id'] && isset($option['selectors']) && is_array($option['selectors'])) :

                     radium_get_customizer_preview_selector_js($option['id'], $option['selectors']);

                endif;

             endforeach;

        endforeach;

       endif;

}

/**
 * radium_get_customizer_preview_selector_js Autogenerate js used by customizer
 * @param  string $option_id    options id used to store data
 * @param  array $css_selector array conatinig the css selectors to be used
 * @return null
 */
function radium_get_customizer_preview_selector_js ( $option_id, $css_selector ) {

    /* color properties
        - border-color
        - color
        - background-color
    */
    $framework = radium_framework();

    $option_name = $framework->customizer_option_name;

    echo "wp.customize('".$option_name."[". $option_id ."]', function( value ) { value.bind(function(color) {";

    echo "var css = '";

    foreach ( $css_selector as $property => $selector) {

        if ( !isset($selector) || empty($selector) ) continue;

        echo radium_customizer_esc_js($selector) ."{". $property .": '+color+' !important; } ";
    }

    echo "';";

    echo "jQuery('.preview_". $option_id . "').remove();";

    echo "jQuery('head').append('<style class=\"preview_" . $option_id . "\">'+css+'</style>');";

    echo "});});";

}

/**
 * Escape single quotes, new lines and fix line endings.
 *
 * Escapes text strings for echoing in JS. It is intended to be used for inline JS
 * (in a tag attribute, for example onclick="..."). Note that the strings have to
 * be in single quotes. The filter 'js_escape' is also applied here.
 *
 * @since 2.2.2
 *
 * @param string $text The text to be escaped.
 * @return string Escaped text.
 */
function radium_customizer_esc_js( $text ) {
    $safe_text = wp_check_invalid_utf8( $text );
    $safe_text = preg_replace( '/&#(x)?0*(?(1)27|39);?/i', "'", stripslashes( $safe_text ) );
    $safe_text = str_replace( "\r", '', $safe_text );
    $safe_text = str_replace( "\n", '\\n', addslashes( $safe_text ) );
    /**
     * Filter a string cleaned and escaped for output in JavaScript.
     *
     * Text passed to esc_js() is stripped of invalid or special characters,
     * and properly slashed for output.
     *
     * @param string $safe_text The text after it has been escaped.
      * @param string $text      The text prior to being escaped.
     */
    return apply_filters( 'radium_customizer_esc_js', $safe_text, $text );
}
