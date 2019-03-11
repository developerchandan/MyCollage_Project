<?php

class Radium_Options_multi_typography {
  
    /**
     * Field Constructor.
     *
     * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
     *
     * @since Radium_Options 1.0
    */

    function __construct($field = array(), $value ='', $parent){
    	    	
    	$this->parent = $parent;
    	$this->field = $field;
    	$this->value = $value;
    	 		
    	if($this->value && !class_exists('Radium_Options_typography')){
    		require_once($this->parent->dir.'fields/typography/field_typography.php');
    	}//if
        	
    }//function
    
   /**
    * Field Render Function.
    *
    * Takes the vars and outputs the HTML for the field in the settings
    *
    * @since Radium_Options 1.0
   */
   function render(){
   
   		$field = $this->field;
   		$value = $this->value;

		?>
		
		<fieldset class="title">
		    <div class="inner">
		        <label for="<?php echo $field['id']; ?>" class="selectors-group-title"><?php echo $field['name']; ?></label>
		        <?php if($field['desc']): ?><kbd><?php echo $field['desc']; ?></kbd><?php endif;?>
		    </div>
		</fieldset>
		
		<script type="text/javascript">
		    jQuery(function(){
		        
		        var form = '<?php $this->form_output(null, null); ?>';
		        
		        jQuery('#radium-opts-main p.add_text_list a').on('click', function(e){
		            jQuery(this).parents().find('div.text_list').append(form);
		            jQuery(this).parents().find('input.hiddentext_list').remove();
		            e.preventDefault();
		        });
		        
		        jQuery('#radium-opts-main p.delete_text_list a').on('click', function(e){
		            var parent = jQuery(this).parent();
		            jQuery(parent).parent().fadeOut(function(){
		                jQuery(this).remove();
		            });
		            var textList = jQuery(this).parents().find('div.text_list .entry').length;
		            if(textList == 1){jQuery(this).parents().find('div.text_list').append('<input class="hiddentext_list" type="hidden" name="<?php echo $field['id']; ?>" id="<?php echo $this->parent->args['opt_name']; ?>[<?php echo $field['id']; ?>][]" />');}
		            e.preventDefault();
		        });
		        
		    });
		</script>
		
		<?php
		
		echo '<fieldset class="data">';
		    
		    echo '<div class="inner">';
		    
		        echo '<div class="text_list">';
		            
		            $add_text = isset($field['default_text']) ? $field['default_text'] : __('Add New Field', 'radium');
		            
		            echo '<p class="add_text_list"><a href="#">'.$add_text.'</a></p>';
		            		            
		            if(is_array($value)):
		                
	                    foreach($value as $data ):
	                    	                    	 	
	                    	$this->form_output ($value, $data);
	                    		                    	
 	                   endforeach;
		                
					endif;
		            
		        echo '</div>';
		        
		    echo '</div>';
		    
		echo '</fieldset>';
		
		echo '<div class="typography_'.$field['id'].'">';
			
			//render typography 
			if(is_array($value)) :
									
				$field_class = 'Radium_Options_typography';
														    
			    foreach($value as $data ):
	 
			    	$new_field = array(
			    		"name"			=> $data,
			    		"id" 			=> $field['id'].'_'.$data,
			    	    'type'          => 'typography',
			    	    'title'         => __('Logo Typography', 'radium'),
			    		"desc" 			=> __('Add a new selector group (comma delimited) to generate a font style option below. You must save the options first.', 'radium'),
			    	    'subdesc'      	=> __('Typography option with each property can be called individually.', 'radium'),
			    		"selector" 		=> $data,
			    		'multi_typography' => true, 
			    	    'default'       => array(
			    	        'color'         => '#333',
			    	        'font-style'    => '700',
			    	        'font-family'   => 'Abel',
			    	        'google'        => true,
			    	        'font-size'     => '33px',
			    	        'line-height'   => '40px'
			    	    ),
			    	);
			    	
			    	$new_value = isset($this->parent->options[$field['id'] . '_' . $data]) ? $this->parent->options[$field['id'] . '_' . $data] : '';
			    				    	
			    	if(class_exists($field_class)){
			    		
			    		$typography = null;
			    		$typography = new $field_class( $new_field, $new_value, $this->parent );
			    		$typography->render();
			    		
			    	}//if
			    		    		
			    endforeach;
			    
			endif;
		
		echo '</div>';

   }//function
   
   
   public function form_output ( $value, $data ) { 
   
   		$state = isset($data) ? 'readonly' : null;
    		  		   		
   		echo '<div class="entry">';
   		
   		    echo '<input '. $state .' class="text_list" type="text" name="'.$this->parent->args['opt_name'].'['. $this->field['id'].'][]" id="'. $this->field['id'].'" value="'. $data .'" />';
   		       		    
   		    echo '<p class="delete_text_list"><a href="#"><img src="'.$this->parent->images_url.'/ico_delete.png" alt="Delete Text Field" /></a></p>';
   		    
   		    echo '<div class="clear"></div>';
   		    
   		echo '</div>';
   }
   
   /**
    * Enqueue Function.
    *
    * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
    *
    * @since Radium_Options 1.0.0
    */
   function enqueue() { 
  		
  		$field_class = 'Radium_Options_typography';
   		
   		// Move dev_mode check to a new if/then block
        if ( ! wp_script_is( 'radium-opts-field-multi_typography-js', 'enqueued' ) && class_exists( $field_class ) && method_exists( $field_class, 'enqueue' ) ) {
        
       		$enqueue = null;
        	$enqueue = new $field_class( '', '', $this->parent );
            $enqueue->enqueue();
        }
   		                               					   		   	
	   	wp_enqueue_style('radium-opts-multi-typography', $this->parent->url . 'fields/multi_typography/field_multi_typography.css', array(), time(), 'all' );
   
   }  //function
        

} //class
