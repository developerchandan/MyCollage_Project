<?php

/**
 * Helper class for Radium_HTML5Media.
 *
 * @since 1.0.0
 *
 * @package	Radium_HTML5Media
 * @author	Franklin M Gitonga
 */
class Radium_HTML5Media_Integrate {
	
  /**
  	 * Holds a copy of the object for easy reference.
  	 *
  	 * @since 1.0.0
  	 *
  	 * @var object
  	 */
  	private static $instance;
  
  	/**
  	 * Constructor. Hooks all interactions to initialize the class.
  	 *
  	 * @since 1.0.0
  	 */
  	public function __construct() {
  	
  		self::$instance = $this;
   		
   		add_action('after_setup_theme', array(&$this, 'add_theme_support'), 10);
   				
   	}
   	
	/**
	 * Echo Video HTML
	 *
	 * @since 1.0.0
	 * @returns string
	 */
	public function add_theme_support($postid) { 
			
		if ( function_exists('is_radium_theme') && is_radium_theme() ) add_theme_support( 'post-formats', array( 'audio', 'video' ) );
		
 	}
	
	/**
	 * Getter method for retrieving the object instance.
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {
	
		return self::$instance;
	
	}
}   	