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
/*  THEME CUSTOMIZER PREVIEW STYLES
/*--------------------------------------------------------------------*/

/**
 * Setup javascript needed for customizer to link up
 * to real-time edit options.
 */

if( ! function_exists( 'radium_customizer_preview' ) ) {
    function radium_customizer_preview() {
 
         $framework = radium_framework();

        // Global option name
        $option_name = $framework->customizer_option_name;

        ?>
        <script type="text/javascript">
        window.onload = function() {

            (function($) {
                <?php
                radium_customizer_preview_logo();
                radium_customizer_preview_styles();
   			 	radium_generate_customize_preview_js();
   			 	?>
             })(jQuery);
        }
        </script>
        <?php
    }
}

/**
 * Add specific theme elements previews to customizer.
 */
function radium_customizer_preview_init( $wp_customize ) {
    if ( $wp_customize->is_preview() && !is_admin() ) {
        add_action( 'wp_footer', 'radium_customizer_preview', 21 );
    }
}
add_action( 'customize_register', 'radium_customizer_preview_init' );

/**
 * Logo Customizer Preview
 *
 * Since the Javascript for the logo will get repeated in
 * many themes, its being placed here so it can be easily
 * placed in each theme that requires it.
 *
 * @since 2.1.0
 */

if( ! function_exists( 'radium_customizer_preview_logo' ) ) {
    function radium_customizer_preview_logo(){

        $framework = radium_framework();

        // Global option name
        $option_name = $framework->theme_option_name;;

        // Setup for logo
        $logo = radium_get_option('logo');

        // Begin output
        ?>
        // Logo object
        Logo = new Object();
        Logo.image = '<?php echo $logo; ?>';
        Logo.site_title = '<?php echo bloginfo( 'name' ); ?>';

        /* Logo */
        wp.customize('<?php echo $option_name; ?>[logo]',function( value ) {
            value.bind(function(value) {

                // Set global marker
                Logo.image = value;

                // Only do if anything if the proper logo
                // type is currently selected.
                var html;

                if(value){
                    html = '<a href="'+Logo.site_url+'" title="'+Logo.title+'" rel="home"><img src="'+Logo.image+'" alt="'+Logo.title+'" /></a>';
                } else {
                    html = '<h1>'+Logo.site_title+'</h1>';
                }

                $('#branding #logo').html(html);

            });
        });
        <?php
    }
}

/**
 * Custom CSS Customizer Preview
 *
 * Since the Javascript for the fonts will get repeated in
 * many themes, its being placed here so it can be easily
 * placed in each theme that requires it.
 *
 * @since 2.1.0
 */

if( ! function_exists( 'radium_customizer_preview_styles' ) ) {
    function radium_customizer_preview_styles(){

        $framework = radium_framework();

        // Global option name
        $option_name = $framework->theme_option_name;

        // Output
        ?>
        /* Custom CSS */
        wp.customize('<?php echo $option_name; ?>[custom_styles]',function( value ) {
            value.bind(function(css) {
                $('.preview_custom_styles').remove();
                $('head').append('<style class="preview_custom_styles">'+css+'</style>');
            });
        });
        <?php
    }
}
