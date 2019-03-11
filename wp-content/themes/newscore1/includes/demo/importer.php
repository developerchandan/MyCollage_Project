<?php
/*
 * This file is a part of the RadiumFramework core.
 * Please be extremely cautious editing this file,
 *
 * @category RadiumFramework
 * @package  NewsCore WP
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 */
 
/**
 * Version 0.1.0
 */

class Radium_Theme_Demo_Data_Importer extends Radium_Theme_Importer {

    /**
     * Holds a copy of the object for easy reference.
     *
     * @since 0.0.1
     *
     * @var object
     */
    private static $instance;
        
	/**
	 * Set name of the content file
	 *
	 * @since 0.0.2
	 *
	 * @var array 
	 */
	public $content_demos  = array(
		'Newscore 1' => array('newscore1', 'http://newscore.radiumthemes.com'), 
		'Newscore 2' => array('newscore2', 'http://newscore2.radiumthemes.com'),
		'Newscore 3' => array('newscore3', 'http://newscore3.radiumthemes.com'),
		'Newscore 4' => array('newscore4', 'http://newscore5.radiumthemes.com')
	);
 	
    /**
     * Constructor. Hooks all interactions to initialize the class.
     *
     * @since 0.0.1
     */
    public function __construct() {
    	
    	$this->theme_option_name = radium_framework()->theme_option_name;

    	$this->theme_options_framework = 'radium_framework';
    	
		$this->demo_files_path = dirname(__FILE__);

        self::$instance = $this;
        
		parent::__construct();

    }
	
	/**
	 * Add menus
	 *
	 * @since 0.0.1
	 */
	public function set_demo_menus(){
		
		// Menus to Import and assign - you can remove or add as many as you want. Check the theme's register_nav_menus() for registered menus
		$top_menu = get_term_by('name', 'Top Menu', 'nav_menu');
		$main_menu = get_term_by('name', 'Main Menu', 'nav_menu');
		$footer_menu = get_term_by('name', 'Footer Menu', 'nav_menu');
		
		$top_menu_term_id = isset($top_menu->term_id) ? $top_menu->term_id : null;
		$main_menu_term_id = isset($main_menu->term_id) ? $main_menu->term_id : null;
		$footer_menu_term_id = isset($footer_menu->term_id) ? $footer_menu->term_id : null;
	
		set_theme_mod( 'nav_menu_locations', array( 
			'top-menu' => $top_menu_term_id, 
			'primary' => $main_menu_term_id, 
			'footer-menu' => $footer_menu_term_id 
			) 
		);

	}

}

new Radium_Theme_Demo_Data_Importer;