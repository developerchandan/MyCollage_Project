<?php
class Radium_Options_google_webfonts extends Radium_Options{	
	
	  /**
	     * Field Constructor.
	     *
	     * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	     *
	     * @since radium_Options 1.0.0
	    */
	    function __construct($field = array(), $value ='', $parent) {
	        $this->field = $field;
			$this->value = $value;
			$this->args = $parent->args;
	    }
	
	    /**
	     * Field Render Function.
	     *
	     * Takes the vars and outputs the HTML for the field in the settings
	     *
	     * @since radium_Options 1.0.0
	    */
	    function render() {
	    	
	        echo '<input type="text" id="' . $this->field['id'] . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . ']" class="font"  ' . 'value="' . esc_attr($this->value) . '" />';
	
			echo '<h3 id="' . $this->field['id'] . '" class="example">Lorem Ipsum is simply dummy text</h3>';
	
	        echo (isset($this->field['desc']) && !empty($this->field['desc'])) ? ' <span class="description">' . $this->field['desc'] . '</span>' : '';
	    }
	
	    /**
	     * Enqueue Function.
	     *
	     * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
	     *
	     * @since radium_Options 1.0.0
	    */
	    function enqueue() {
	        wp_enqueue_script(
	            'radium-opts-googlefonts-js', 
	            RADIUM_OPTIONS_URL . 'fields/google_webfonts/jquery.fontselect.js', 
	            array('jquery'),
	            time(),
	            true
	        );
	    }
	
}//class
?>