<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

/**
 * New Metabox Fields By Radium Themes
 *
 * @since 2.1.6
 *
 * @return void
 */
function radium_metaboxes_styling() {

    $framework = radium_framework();

    wp_dequeue_style( 'rwmb' );
    wp_enqueue_style( 'radium-rwmb', $framework->theme_framework_css_url . '/metabox-style.css' );
    wp_enqueue_script( 'radium-rwmb-radium-image', $framework->theme_framework_js_url . '/radio-image.js' );

}
add_action( 'admin_enqueue_scripts', 'radium_metaboxes_styling', 100);

/**
 * New Radio Image Field
 *
 * @since 2.1.6
 *
 * Requires metabox Plugin by Rilwis
 */
if ( ! class_exists( 'RWMB_Radio_Image_Field' ) )
{
    class RWMB_Radio_Image_Field
    {
        /**
         * Get field HTML
         *
         * @param mixed  $meta
         * @param array  $field
         *
         * @return string
         */
        static function html( $meta, $field )
        {
            $html = array();
            $tpl = '<label class="rwmb-label-radio-image"><input type="radio" class="rwmb-radio-image" name="%s" value="%s"%s> %s</label>';

            foreach ( $field['options'] as $value => $label )
            {
                $html[] = sprintf(
                    $tpl,
                    $field['field_name'],
                    $value,
                    checked( $value, $meta, false ),
                    $label
                );
            }

            return implode( ' ', $html );
        }
    }
}
