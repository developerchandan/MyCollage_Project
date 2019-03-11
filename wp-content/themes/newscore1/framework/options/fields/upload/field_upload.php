<?php
class Radium_Options_upload extends Radium_Options{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @since Radium_Options 1.0
	*/
	function __construct($field = array(), $value ='', $parent = ''){
		
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;
		
	}//function
	
	
	
	/**
	 * Field Render Function.
	 *
	 * Takes the vars and outputs the HTML for the field in the settings
	 *
	 * @since Radium_Options 1.0
	*/
	function render(){
		
		$framework = radium_framework();
		
		$class = (isset($this->field['class']))?$this->field['class']:'regular-text';
		
		
		echo '<input type="hidden" id="'.$this->field['id'].'" name="'.$this->args['opt_name'].'['.$this->field['id'].']" value="'.$this->value.'" class="'.$class.'" />';
		//if($this->value != ''){
			echo '<img class="radium-opts-screenshot" id="radium-opts-screenshot-'.$this->field['id'].'" src="'.$this->value.'" />';
		//}
		
		if($this->value == ''){$remove = ' style="display:none;"';$upload = '';}else{$remove = '';$upload = ' style="display:none;"';}
		echo ' <a href="javascript:void(0);" class="radium-opts-upload button-secondary"'.$upload.' rel-id="'.$this->field['id'].'">'.__('Browse', 'radium').'</a>';
		echo ' <a href="javascript:void(0);" class="radium-opts-upload-remove"'.$remove.' rel-id="'.$this->field['id'].'"><img src="'.$framework->theme_framework_images_url.'/icons/icon-delete-small.png" alt="'.__('Remove Upload', 'radium').'"/></a>';
		
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?'<br/><br/><span class="description">'.$this->field['desc'].'</span>':'';
		
	}//function
	
	
	/**
	 * Enqueue Function.
	 *
	 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
	 *
	 * @since Radium_Options 1.0
	*/
	function enqueue(){
		
     //global $wp_version; //AP: why doesn't this work?!?!
       $wp_version = floatval(get_bloginfo('version'));

        if ( $wp_version < "3.5" ) {
            wp_enqueue_script(
                'radium-opts-field-upload-js', 
                RADIUM_OPTIONS_URL . 'fields/upload/field_upload_3_4.js', 
                array('jquery', 'thickbox', 'media-upload'),
                time(),
                true
            );
            wp_enqueue_style('thickbox');
            
        } else {
            wp_enqueue_script(
                'radium-opts-field-upload-js', 
                RADIUM_OPTIONS_URL . 'fields/upload/field_upload.js', 
                array('jquery'),
                time(),
                true
            );
            wp_enqueue_media();
        }
        wp_localize_script('radium-opts-field-upload-js', 'radium_upload', array('url' => $this->url.'fields/upload/blank.png'));
	}//function
	
}//class
?>