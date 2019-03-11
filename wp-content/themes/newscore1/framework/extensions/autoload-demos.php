<?php
/**
 * Radium Importer Auto Load
 * @link https://github.com/FrankM1/radium-one-click-demo-install
 *
 * @package     NewsCore
 * @author      Franklin Gotinga
 * @version     1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if ( !class_exists( 'RadiumOptions_extension_radium_importer' ) ) {

    class RadiumOptions_extension_radium_importer {

        public static $instance;

        static $version = "1.0.0";

        protected $parent;

        private $filesystem = array();

        public $extension_url;

        public $extension_dir;

        public $demo_data_dir;

        public $radium_import_files = array();

        public $active_import_id;

        public $active_import;


        /**
         * Class Constructor
         *
         * @since       1.0
         * @access      public
         * @return      void
         */
        public function __construct( $parent ) {

            $this->parent = $parent;

            if ( !is_admin() ) return;

            //Hides importer section if anything but true returned. Way to abort :)
            if ( true !== apply_filters( 'radium_importer_abort', true ) ) {
                return;
            }

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = get_template_directory_uri() . '/extension/radium_importer/';
                $this->demo_data_dir = apply_filters( "radium_importer_dir_path", $this->extension_dir . 'demo-data/' );
            }
 
            //Delete saved options of imported demos, for dev/testing purpose
            // delete_option('radium_imported_demos');

            $this->getImports();

            $this->field_name = 'radium_importer';

            self::$instance = $this;

            add_filter( 'redux/' . $this->parent->args['opt_name'] . '/field/class/' . $this->field_name, array( &$this,
                    'overload_field_path'
                ) );

            add_action( 'wp_ajax_redux_radium_importer', array(
                    $this,
                    'ajax_importer'
                ) );

            add_filter( 'redux/'.$this->parent->args['opt_name'].'/field/radium_importer_files', array(
                    $this,
                    'addImportFiles'
                ) );

            //Adds Importer section to panel
            $this->add_importer_section();
 
        }


        public function getImports() {

            if ( !empty( $this->radium_import_files ) ) {
                return $this->radium_import_files;
            }

            $this->filesystem = $this->parent->filesystem->execute( 'object' );

            $imports = $this->filesystem->dirlist( $this->demo_data_dir, false, true );

            $imported = get_option( 'radium_imported_demos' );

            if ( !empty( $imports ) ) {
                $x = 1;
                foreach ( $imports as $import ) {

                    if ( !isset( $import['files'] ) || empty( $import['files'] ) ) {
                        continue;
                    }

                    if ( $import['type'] == "d" && !empty( $import['name'] ) ) {
                        $this->radium_import_files['wbc-import-'.$x] = isset( $this->radium_import_files['wbc-import-'.$x] ) ? $this->radium_import_files['wbc-import-'.$x] : array();
                        $this->radium_import_files['wbc-import-'.$x]['directory'] = $import['name'];

                        if ( !empty( $imported ) && is_array( $imported ) ) {
                            if ( array_key_exists( 'wbc-import-'.$x, $imported ) ) {
                                $this->radium_import_files['wbc-import-'.$x]['imported'] = 'imported';
                            }
                        }

                        foreach ( $import['files'] as $file ) {
                            switch ( $file['name'] ) {
                            case 'content.xml':
                                $this->radium_import_files['wbc-import-'.$x]['content_file'] = $file['name'];
                                break;

                            case 'theme-options.txt':
                            case 'theme-options.json':
                                $this->radium_import_files['wbc-import-'.$x]['theme_options'] = $file['name'];
                                break;

                            case 'widgets.json':
                            case 'widgets.txt':
                                $this->radium_import_files['wbc-import-'.$x]['widgets'] = $file['name'];
                                break;

                            case 'screen-image.png':
                            case 'screen-image.jpg':
                            case 'screen-image.gif':
                                $this->radium_import_files['wbc-import-'.$x]['image'] = $file['name'];
                                break;
                            }

                        }

                        if ( !isset( $this->radium_import_files['wbc-import-'.$x]['content_file'] ) ) {
                            unset( $this->radium_import_files['wbc-import-'.$x] );
                            if ( $x > 1 ) $x--;
                        }

                    }

                    $x++;
                }

            }

        }

        public function addImportFiles( $radium_import_files ) {

            if ( !is_array( $radium_import_files ) || empty( $radium_import_files ) ) {
                $radium_import_files = array();
            }

            $radium_import_files = wp_parse_args( $radium_import_files, $this->radium_import_files );

            return $radium_import_files;
        }

        public function ajax_importer() {
            if ( !isset( $_REQUEST['nonce'] ) || !wp_verify_nonce( $_REQUEST['nonce'], "redux_{$this->parent->args['opt_name']}_radium_importer" ) ) {
                die( 0 );
            }
            if ( isset( $_REQUEST['type'] ) && $_REQUEST['type'] == "import-demo-content" && array_key_exists( $_REQUEST['demo_import_id'], $this->radium_import_files ) ) {

                $reimporting = false;

                if( isset( $_REQUEST['radium_import'] ) && $_REQUEST['radium_import'] == 're-importing'){
                    $reimporting = true;
                }

                $this->active_import_id = $_REQUEST['demo_import_id'];

                $import_parts         = $this->radium_import_files[$this->active_import_id];

                $this->active_import = array( $this->active_import_id => $import_parts );

                $content_file        = $import_parts['directory'];
                $demo_data_loc       = $this->demo_data_dir.$content_file;

                if ( file_exists( $demo_data_loc.'/'.$import_parts['content_file'] ) && is_file( $demo_data_loc.'/'.$import_parts['content_file'] ) ) {

                    if ( !isset( $import_parts['imported'] ) || true === $reimporting ) {
                        include $this->extension_dir.'inc/init-installer.php';
                        $installer = new Radium_Theme_Demo_Data_Importer( $this, $this->parent );
                    }else {
                        echo esc_html__( "Demo Already Imported", 'radium' );
                    }
                }

                die();
            }

            die();
        }

        public static function get_instance() {
            return self::$instance;
        }

        // Forces the use of the embeded field path vs what the core typically would use
        public function overload_field_path( $field ) {
            return dirname( __FILE__ ) . '/' . $this->field_name . '/field_' . $this->field_name . '.php';
        }

        function add_importer_section() {
            // Checks to see if section was set in config of redux.
            for ( $n = 0; $n < count( $this->parent->sections ); $n++ ) {
                if ( isset( $this->parent->sections[$n]['id'] ) && $this->parent->sections[$n]['id'] == 'radium_importer_section' ) {
                    return;
                }
            }

            $radium_importer_label = trim( esc_html( apply_filters( 'radium_importer_label', __( 'Demo Importer', 'radium' ) ) ) );

            $radium_importer_label = ( !empty( $radium_importer_label ) ) ? $radium_importer_label : __( 'Demo Importer', 'radium' );

            $this->parent->sections[] = array(
                'id'     => 'radium_importer_section',
                'title'  => $radium_importer_label,
                'desc'   => '<p class="description">'. apply_filters( 'radium_importer_description', esc_html__( 'Works best to import on a new install of WordPress', 'radium' ) ).'</p>',
                'icon'   => 'el-icon-website',
                'fields' => array(
                    array(
                        'id'   => 'radium_demo_importer',
                        'type' => 'radium_importer'
                    )
                )
            );
        }

    } // class
} // if
