<?php
function radium_get_sidebars_id($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}

/*-----------------------------------------------------------------------------------*/
/*	REGISTER BASE WIDGET AREAS
/*-----------------------------------------------------------------------------------*/
if ( function_exists('register_sidebar') &&  !function_exists('radium_register_sidebars') ) {

    function radium_register_sidebars() {

        $framework = radium_framework();

        $options = $framework->options;

        $allWidgetizedAreas = array(
            __( 'Main Sidebar', 'radium' ),
            __( 'Home Sidebar 1', 'radium' ),
            __( 'Home Sidebar 2', 'radium' ),
            __( 'Woocommerce Sidebar', 'radium' ),
            __(	'Video', 'radium')
        );
		
		$i = 0;
        foreach ($allWidgetizedAreas as $WidgetAreaName) {
            $i++;
            register_sidebar(array(
               'id' => radium_get_sidebars_id($WidgetAreaName),
               'name'			=> $WidgetAreaName,
               'before_widget' 	=> '<div class="widget %2$s clearfix">',
               'after_widget' 	=> '</div>',
               'before_title' 	=> '<h5 class="widget-title"><span>',
               'after_title' 	=> '</span></h5>',
            ));
        }

        // Woocommerce Footer widgetized area
        $woocommerce_footer_widget_count = null;
        $woocommerce_footer_widget_left_count = null;
        $woocommerce_footer_widget_right_count = null;
        $woocommerce_footer_layout = null;

        if(isset($options['woocommerce_footer_layout']))
        	$woocommerce_footer_layout = $options['woocommerce_footer_layout'];

        if ( $woocommerce_footer_layout == '50-25-25' ) {

        	$woocommerce_footer_widget_left_count = 1;
        	$woocommerce_footer_widget_right_count = 2;

        	/* Dynamic Widget Areas */
        	for($i = 1; $i<= $woocommerce_footer_widget_left_count; $i++) {
				
				$sidebar_title = __('Shop Footer Widgets Left', 'radium');
				
        		register_sidebar(array(
        			'id'=> radium_get_sidebars_id($sidebar_title),
        			'name' => $sidebar_title,
        			'before_widget' => '<div class="widget woocommerce_footer_widget %2$s clearfix">',
        			'after_widget' => '</div><!-- END "div.woocommerce_footer_widget" -->',
        			'before_title' => '<h4 class="widget-title"><span>',
        			'after_title' => '</span></h4>',
        		));
        	}

        	/* Dynamic Widget Areas */
        	for($i = 1; $i<= $woocommerce_footer_widget_right_count; $i++) {

        		register_sidebar(array(
        			'id'=> radium_get_sidebars_id( sprintf( __('Shop Footer Widget Right %d', 'radium'), $i ) ),
        			'name' => sprintf( __('Shop Footer Widget Right %d', 'radium'), $i ),
        			'before_widget' => '<div class="widget woocommerce_footer_widget %2$s clearfix">',
        			'after_widget' => '</div><!-- END "div.woocommerce_footer_widget" -->',
        			'before_title' => '<h4 class="widget-title"><span>',
        			'after_title' => '</span></h4>',
        		));
        	}

        } else {

        		if ( $woocommerce_footer_layout == '100' ) {

        			$woocommerce_footer_widget_count = 1;

        		} elseif ( $woocommerce_footer_layout == '50-50' ) {

        			$woocommerce_footer_widget_count = 2;

        		} elseif ($woocommerce_footer_layout == '33-33-33' ) {

        			$woocommerce_footer_widget_count = 3;

        		} elseif ($woocommerce_footer_layout == '25-25-25-25' ) {

        			$woocommerce_footer_widget_count = 4;

        		}

        		 /* Dynamic Widget Areas */
        	     for($i = 1; $i<= $woocommerce_footer_widget_count; $i++) {

        	         register_sidebar(array(
        				 'id'=> radium_get_sidebars_id( sprintf( __('Shop Footer Widgets %d', 'radium'), $i ) ),
        	             'name' => sprintf( __('Shop Footer Widgets %d', 'radium'), $i ),
        	             'before_widget' => '<div class="widget woocommerce_footer_widget %2$s">',
        	             'after_widget' => '</div><!-- END "div.woocommerce_footer_widget" -->',
        	             'before_title' => '<h4 class="widget-title"><span>',
        	             'after_title' => '</span></h4>',
        	         ));
        	     }
        }

        // Footer widgetized area
        $footer_widget_count = null;
        $footer_widget_left_count = null;
        $footer_widget_right_count = null;
        $footer_layout = null;

        if(isset($options['footer_layout']))
        	$footer_layout = $options['footer_layout'];

        if ( $footer_layout == '50-25-25' ) {

        	$footer_widget_left_count = 1;
        	$footer_widget_right_count = 2;

        	/* Dynamic Widget Areas */
        	for($i = 1; $i<= $footer_widget_left_count; $i++) {

        		register_sidebar(array(
        			'id'=> radium_get_sidebars_id( sprintf( __('Footer Widget Left %d', 'radium'), $i ) ),
        			'name' => sprintf( __('Footer Widget Left %d', 'radium'), $i ),
        			'before_widget' => '<div class="widget footer_widget %2$s clearfix">',
        			'after_widget' => '</div><!-- END "div.footer_widget" -->',
        			'before_title' => '<h4 class="widget-title"><span>',
        			'after_title' => '</span></h4>',
        		));
        	}

        	/* Dynamic Widget Areas */
        	for($i = 1; $i<= $footer_widget_right_count; $i++) {

        		register_sidebar(array(
        			'id'=> radium_get_sidebars_id( sprintf( __('Footer Widget Right %d', 'radium'), $i ) ),
        			'name' => sprintf( __('Footer Widget Right %d', 'radium'), $i ),
        			'before_widget' => '<div class="widget footer_widget %2$s clearfix">',
        			'after_widget' => '</div><!-- END "div.footer_widget" -->',
        			'before_title' => '<h4 class="widget-title"><span>',
        			'after_title' => '</span></h4>',
        		));
        	}

        } else {

        		if ( $footer_layout == '100' ) {

        			$footer_widget_count = 1;

        		} elseif ( $footer_layout == '50-50' ) {

        			$footer_widget_count = 2;

        		} elseif ($footer_layout == '33-33-33' ) {

        			$footer_widget_count = 3;

        		} elseif ($footer_layout == '25-25-25-25' ) {

        			$footer_widget_count = 4;

        		}

        		 /* Dynamic Widget Areas */
        	     for($i = 1; $i<= $footer_widget_count; $i++) {

        	         register_sidebar(array(
        				 'id'=> radium_get_sidebars_id( sprintf( __('Footer Widget %d', 'radium'), $i ) ),
        	             'name' => sprintf( __('Footer Widgets %d', 'radium'), $i ),
        	             'before_widget' => '<div class="widget footer_widget %2$s">',
        	             'after_widget' => '</div><!-- END "div.footer_widget" -->',
        	             'before_title' => '<h4 class="widget-title"><span>',
        	             'after_title' => '</span></h4>',
        	         ));
        	     }
        }

    }
    add_action( 'widgets_init', 'radium_register_sidebars' );
}

?>