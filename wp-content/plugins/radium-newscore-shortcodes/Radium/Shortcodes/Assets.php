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
class Radium_Shortcodes_Assets {

	public $tinymce_url;
	public $tinymce_dir;

    function __construct() {

     	$this->tinymce_url = Radium_Shortcodes::get_url().'/tinymce';
     	$this->tinymce_dir = Radium_Shortcodes::get_dir().'/tinymce';

        add_action('admin_enqueue_scripts', array(&$this, 'action_admin_scripts_init'));
        add_action('wp_enqueue_scripts', array(&$this, 'action_frontend_scripts'));

	}

	/**
	 * Registers Scripts
	 *
	 * @return	void
	 */
	function action_frontend_scripts() {
    }

	/**
	 * Enqueue Scripts and Styles
	 *
	 * @return	void
	 */
	function action_admin_scripts_init() {

 		// css
		wp_enqueue_style( 'radium-popup', $this->tinymce_url . '/css/popup.css', false, '1.0', 'all' );

		// js
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-livequery', 	$this->tinymce_url . '/js/jquery.livequery.js', false, '1.1.1', false );
		wp_enqueue_script( 'jquery-appendo', 	$this->tinymce_url . '/js/jquery.appendo.js', false, '1.0', false );
		wp_enqueue_script( 'base64', 		$this->tinymce_url . '/js/base64.js', false, '1.0', false );
		wp_enqueue_script( 'radium-popup', 	$this->tinymce_url . '/js/popup.js', false, '1.0', false );
		wp_localize_script( 'jquery', 'RadiumShortcodes', array(
            'plugin_folder' => $this->tinymce_url,
            'wp_root_path' => get_home_path()
        ) );
	}

}