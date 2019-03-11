<?php
/*
 * This file is a part of the RadiumFramework core
 * and contains theme specific settings .
 * Please be extremely cautious editing this file,
 *
 * @category RadiumFramework
 * @package  Griddr WP
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 * @since 2.1.0
 */

 class Radium_Shortcodes_Integrate {

	public $tinymce_url;
	public $tinymce_dir;

    function __construct() {

        $this->tinymce_url = Radium_Shortcodes::get_url().'/tinymce';
        $this->tinymce_dir = Radium_Shortcodes::get_dir().'/tinymce';

        add_action('admin_head', array( $this, 'add_mce_button'));

    }

    // Hooks your functions into the correct filters
    function add_mce_button() {

        // check user permissions
        if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
            return;
        }

        // check if WYSIWYG is enabled
        if ( 'true' == get_user_option( 'rich_editing' ) ) {
            add_filter( 'mce_external_plugins', array(&$this, 'add_rich_plugins') );
			add_filter( 'mce_buttons', array(&$this, 'register_rich_buttons') );
		}

	}

	// --------------------------------------------------------------------------

	/**
	 * Defines TinyMCE rich editor js plugin
	 *
	 * @return	void
	 */
	function add_rich_plugins( $plugin_array ) {

        $plugin_array['radium_button'] = $this->tinymce_url . '/mce-button.js';

        return $plugin_array;

	}

	// --------------------------------------------------------------------------

	/**
	 * Adds TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function register_rich_buttons( $buttons ) {

        array_push( $buttons, "|", 'radium_button' );

        return $buttons;

	}

}

