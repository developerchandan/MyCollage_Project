<?php
/**
 * Extension-Boilerplate
 * @link https://github.com/ReduxFramework/extension-boilerplate
 *
 * Radium Importer - Modified For ReduxFramework
 * @link https://github.com/FrankM1/radium-one-click-demo-install
 *
 * @package     radium_Importer - Extension for Importing demo content
 * @author      Webcreations907
 * @version     1.0.1
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if ( !class_exists( 'Radium_Options_radium_importer' ) ) {

    /**
     * Main ReduxFramework_radium_importer class
     *
     * @since       1.0.0
     */
    class Radium_Options_radium_importer {

        /**
         * Field Constructor.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent ) {
            
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

            $class = ReduxFramework_extension_radium_importer::get_instance();

            if ( !empty( $class->demo_data_dir ) ) {
                $this->demo_data_dir = $class->demo_data_dir;
                $this->demo_data_url = get_template_directory_uri() . '/extensions/radium_importer/demo-data/';
            }

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_field_url = get_template_directory_uri() . '/extensions/radium_importer/radium_importer';
            }
        }

        /**
         * Field Render Function.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {

            echo '</fieldset></td></tr><tr><td colspan="2"><fieldset class="radium_opts-field radium_importer">';

            $nonce = wp_create_nonce( "radium_opts_{$this->parent->args['opt_name']}_radium_importer" );

            // No errors please
            $defaults = array(
                'id'        => '',
                'url'       => '',
                'width'     => '',
                'height'    => '',
                'thumbnail' => '',
            );

            $this->value = wp_parse_args( $this->value, $defaults );

            $imported = false;

            $this->field['radium_demo_imports'] = apply_filters( "radium_opts/{$this->parent->args['opt_name']}/field/radium_importer_files", array() );

            echo '<div class="theme-browser"><div class="themes">';

            if ( !empty( $this->field['radium_demo_imports'] ) ) {

                foreach ( $this->field['radium_demo_imports'] as $section => $imports ) {

                    if ( empty( $imports ) ) {
                        continue;
                    }

                    if ( !array_key_exists( 'imported', $imports ) ) {
                        $extra_class = 'not-imported';
                        $imported = false;
                        $import_message = esc_html__( 'Import Demo', 'radium' );
                    }else {
                        $imported = true;
                        $extra_class = 'active imported';
                        $import_message = esc_html__( 'Demo Imported', 'radium' );
                    }
                    echo '<div class="wrap-importer theme '.$extra_class.'" data-demo-id="'.esc_attr( $section ).'"  data-nonce="' . $nonce . '" id="' . $this->field['id'] . '-custom_imports">';

                    echo '<div class="theme-screenshot">';

                    if ( isset( $imports['image'] ) ) {
                        echo '<img class="radium_image" src="'.esc_attr( esc_url( $this->demo_data_url.$imports['directory'].'/'.$imports['image'] ) ).'"/>';

                    }
                    echo '</div>';

                    echo '<span class="more-details">'.$import_message.'</span>';
                    echo '<h3 class="theme-name">'. esc_html( apply_filters( 'radium_importer_directory_title', $imports['directory'] ) ) .'</h3>';

                    echo '<div class="theme-actions">';
                    if ( false == $imported ) {
                        echo '<div class="radium-importer-buttons"><span class="spinner">'.esc_html__( 'Please Wait...', 'radium' ).'</span><span class="button-primary importer-button import-demo-data">' . __( 'Import Demo', 'radium' ) . '</span></div>';
                    }else {
                        echo '<div class="radium-importer-buttons button-secondary importer-button">'.esc_html__( 'Imported', 'radium' ).'</div>';
                        echo '<span class="spinner">'.esc_html__( 'Please Wait...', 'radium' ).'</span>';
                        echo '<div id="radium-importer-reimport" class="radium-importer-buttons button-primary import-demo-data importer-button">'.esc_html__( 'Re-Import', 'radium' ).'</div>';
                    }
                    echo '</div>';
                    echo '</div>';


                }

            } else {
                echo "<h5>".esc_html__( 'No Demo Data Provided', 'radium' )."</h5>";
            }

            echo '</div></div>';
            echo '</fieldset></td></tr>';

        }

        /**
         * Enqueue Function.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue() {

            wp_enqueue_script(
                'radium_opts-field-radium-importer-js',
                RADIUM_OPTIONS_URL . 'field/importer/field_importer.js',
                array( 'jquery' ),
                time(),
                true
            );

            wp_enqueue_style(
                'radium_opts-field-radium-importer-css',
                RADIUM_OPTIONS_URL . 'field/importer/field_importer.css',
                time(),
                true
            );

        }
    }
}