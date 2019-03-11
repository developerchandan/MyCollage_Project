<?php
/*
 * This file is a part of the RadiumFramework core
 * and contains theme specific settings
 * Please be extremely cautious editing this file,
 *
 * Also note that most functions here can be customized/modified
 *
 * @category RadiumFramework
 * @package  Griddr WP
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 * @since 2.0.0
 */

class Radium_Shortcodes_Register {

	function  __construct() {

        /*Columns Shortcodes*/
        add_shortcode('one_third',          array(&$this, 'one_third'));
        add_shortcode('one_third_last',     array(&$this, 'one_third_last'));
        add_shortcode('two_third',          array(&$this, 'two_third'));
        add_shortcode('two_third_last',     array(&$this, 'two_third_last'));
        add_shortcode('one_half',           array(&$this, 'one_half'));
        add_shortcode('one_half_last',      array(&$this, 'one_half_last'));
        add_shortcode('one_fourth',         array(&$this, 'one_fourth'));
        add_shortcode('one_fourth_last',    array(&$this, 'one_fourth_last'));
        add_shortcode('three_fourth',       array(&$this, 'three_fourth'));
        add_shortcode('three_fourth_last',  array(&$this, 'three_fourth_last'));
        add_shortcode('one_fifth',          array(&$this, 'one_fifth'));
        add_shortcode('one_fifth_last',     array(&$this, 'one_fifth_last'));
        add_shortcode('two_fifth',          array(&$this, 'two_fifth'));
        add_shortcode('two_fifth_last',     array(&$this, 'two_fifth_last'));
        add_shortcode('three_fifth',        array(&$this, 'three_fifth'));
        add_shortcode('three_fifth_last',   array(&$this, 'three_fifth_last'));
        add_shortcode('four_fifth_last',    array(&$this, 'four_fifth_last'));
        add_shortcode('one_sixth',          array(&$this, 'one_sixth'));
        add_shortcode('four_fifth',         array(&$this, 'four_fifth'));
        add_shortcode('one_sixth_last',     array(&$this, 'one_sixth_last'));
        add_shortcode('five_sixth',         array(&$this, 'five_sixth'));
        add_shortcode('five_sixth_last',    array(&$this, 'five_sixth_last'));

		add_shortcode('highlight', 			array(&$this, 'highlight_sc'));

        add_shortcode('hr',                 array(&$this, 'hr_sc'));
        add_shortcode('hr_invisible',       array(&$this, 'hr_sc'));

        add_shortcode('clear',              array(&$this, 'clear'));
        add_shortcode('clearfix',           array(&$this, 'clear'));

		add_shortcode('icon', 				array(&$this, 'icon_sc'));
		add_shortcode('button', 			array(&$this, 'button_sc'));

		add_shortcode('social-icon', 		array(&$this, 'social_icon_sc'));

        add_shortcode('accordion',          array(&$this, 'accordion_sc'));
        add_shortcode('toggle',             array(&$this, 'toggle'));
        add_shortcode('tabs',               array(&$this, 'tabs'));
        add_shortcode('tab',                array(&$this, 'tab'));

        add_shortcode('radium_image',       array(&$this, 'image_sc'));
        add_shortcode('radium_embed_video', array(&$this, 'embed_video_sc'));
        add_shortcode('list',               array(&$this, 'lists_sc'));
        add_shortcode('pre',                array(&$this, 'pre_sc'));
        add_shortcode('banner',             array(&$this, 'banner'));
        add_shortcode('grid',               array(&$this, 'grid'));
        add_shortcode('col',               array(&$this,  'columns'));
        add_shortcode('row',               array(&$this,  'row'));

		if ( !has_filter( 'widget_text', 'do_shortcode') ) {
			add_filter('widget_text', 'shortcode_unautop', 10);
			add_filter('widget_text', 'do_shortcode', 10);
		}

		add_filter('the_content', 			array(&$this, 'the_content_filter'));

	}

    /*-----------------------------------------------------------------------------------*/
    /*  Column Shortcodes
    /*-----------------------------------------------------------------------------------*/
    function one_third( $atts, $content = null ) {
        return '<div class="radium-one-third">' . do_shortcode($content) . '</div>';
    }

    function one_third_last( $atts, $content = null ) {
        return '<div class="radium-one-third radium-column-last">' . do_shortcode($content) . '</div><div class="clearfix"></div>';
    }

    function two_third( $atts, $content = null ) {
        return '<div class="radium-two-third">' . do_shortcode($content) . '</div>';
    }

    function two_third_last( $atts, $content = null ) {
        return '<div class="radium-two-third radium-column-last">' . do_shortcode($content) . '</div><div class="clearfix"></div>';
    }

    function one_half( $atts, $content = null ) {
        return '<div class="radium-one-half">' . do_shortcode($content) . '</div>';
    }

    function one_half_last( $atts, $content = null ) {
        return '<div class="radium-one-half radium-column-last">' . do_shortcode($content) . '</div><div class="clearfix"></div>';
    }

    function one_fourth( $atts, $content = null ) {
       return '<div class="radium-one-fourth">' . do_shortcode($content) . '</div>';
    }

    function one_fourth_last( $atts, $content = null ) {
        return '<div class="radium-one-fourth radium-column-last">' . do_shortcode($content) . '</div><div class="clearfix"></div>';
    }

    function three_fourth( $atts, $content = null ) {
        return '<div class="radium-three-fourth">' . do_shortcode($content) . '</div>';
    }

    function three_fourth_last( $atts, $content = null ) {
        return '<div class="radium-three-fourth radium-column-last">' . do_shortcode($content) . '</div><div class="clearfix"></div>';
    }

    function one_fifth( $atts, $content = null ) {
        return '<div class="radium-one-fifth">' . do_shortcode($content) . '</div>';
    }

    function one_fifth_last( $atts, $content = null ) {
        return '<div class="radium-one-fifth radium-column-last">' . do_shortcode($content) . '</div><div class="clearfix"></div>';
    }

    function two_fifth( $atts, $content = null ) {
        return '<div class="radium-two-fifth">' . do_shortcode($content) . '</div>';
    }

    function two_fifth_last( $atts, $content = null ) {
        return '<div class="radium-two-fifth radium-column-last">' . do_shortcode($content) . '</div><div class="clearfix"></div>';
    }

    function three_fifth( $atts, $content = null ) {
        return '<div class="radium-three-fifth">' . do_shortcode($content) . '</div>';
    }

    function three_fifth_last( $atts, $content = null ) {
        return '<div class="radium-three-fifth radium-column-last">' . do_shortcode($content) . '</div><div class="clearfix"></div>';
    }

    function four_fifth( $atts, $content = null ) {
        return '<div class="radium-four-fifth">' . do_shortcode($content) . '</div>';
    }

    function four_fifth_last( $atts, $content = null ) {
        return '<div class="radium-four-fifth radium-column-last">' . do_shortcode($content) . '</div><div class="clearfix"></div>';
    }

    function one_sixth( $atts, $content = null ) {
        return '<div class="radium-one-sixth">' . do_shortcode($content) . '</div>';
    }

    function one_sixth_last( $atts, $content = null ) {
        return '<div class="radium-one-sixth radium-column-last">' . do_shortcode($content) . '</div><div class="clearfix"></div>';
    }

    function five_sixth( $atts, $content = null ) {
        return '<div class="radium-five-sixth">' . do_shortcode($content) . '</div>';
    }

    function five_sixth_last( $atts, $content = null ) {
        return '<div class="radium-five-sixth radium-column-last">' . do_shortcode($content) . '</div><div class="clearfix"></div>';
    }

    #-----------------------------------------------------------------
    // SEPARATORS
    #-----------------------------------------------------------------
    function hr_sc($atts, $content = "", $shortcodename = "") {
        extract(shortcode_atts(array(
            'link'       => '',
            'text'       => '',
        ), $atts));

        $top = $toplink = false;

        if (isset($atts[0]) && trim($atts[0]) == 'top')  $top = 'top';
        if($top == 'top') $toplink = '<a href="#top" class="skip">top</a>';

        if($shortcodename != "hr_invisible") {
            $output = '<div class="'.$shortcodename.'"></div>';

             if ($toplink) {

                $output  = '<div class="hr totop">'.$toplink.'</div>';

             } elseif ($link) {

                $output  = '<div class="hr headline solid"><a class="skip" href="'.$link.'">'.$text.'</a></div>';

             } else {

                $output  = '<div class="hr"></div>';

             }

        } else {

            $output  = '<div class="hr_invisible"></div>';

        }

        return $output;
    }

    function clear( $atts ) {
       return '<div class="clearfix"></div>';
    }

    /*-----------------------------------------------------------------------------------*/
    /*  Toggle Shortcodes
    /*-----------------------------------------------------------------------------------*/
    function toggle( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'title'      => 'Title goes here',
            'state'      => 'closed'
        ), $atts));

        return "<div data-id='".$state."' class=\"radium-toggle\"><span class=\"radium-toggle-title\">". $title ."</span><div class=\"radium-toggle-inner\"><div class=\"target\">". do_shortcode($content) ."</div></div></div>";
    }

    /*-----------------------------------------------------------------------------------*/
    /*  Tabs Shortcodes
    /*-----------------------------------------------------------------------------------*/
    function tabs( $atts, $content = null ) {
        $defaults = array(
            'type'       => 'horizontal', //vertical or horizontal
        );
        extract( shortcode_atts( $defaults, $atts ) );

        // Extract the tab titles for use in the tab widget.
        preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );

        $tab_titles = array();
        if( isset($matches[1]) ){ $tab_titles = $matches[1]; }

        $output = '';

        if( count($tab_titles) ){
            $output .= '<div id="radium-tabs-'. rand(1, 100) .'" class="clearfix radium-tabs radium-tabs-'.$type.'"><div class="radium-tab-inner">';
            $output .= '<ul class="radium-nav">';

            foreach( $tab_titles as $tab ){
                $output .= '<li><a href="#radium-tab-'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a><span class="sidebar_tab_shadow" style="height: 280px;"></span></li>';
            }

            $output .= '</ul>';
            $output .= '<div class="tabs-content">' . do_shortcode( $content ) . '</div>';
            $output .= '</div></div>';
        } else {
            $output .= do_shortcode( $content );
        }

        return $output;
    }


    function tab( $atts, $content = null ) {

        $defaults = array( 'title' => 'Tab' );
        extract( shortcode_atts( $defaults, $atts ) );

        return '<div id="radium-tab-'. sanitize_title( $title ) .'" class="radium-tab">'. do_shortcode( $content ) .'</div>';
    }

    /* ----------------------------------------------------- */
    /* Accordion Shortcode
    /* ----------------------------------------------------- */
    function accordion_sc($atts, $content, $code) {
        extract(shortcode_atts(array(
            'style' => false
        ), $atts));
        if (!preg_match_all("/(.?)\[(tab)\b(.*?)(?:(\/))?\](?:(.+?)\[\/tab\])?(.?)/s", $content, $matches)) {
            return do_shortcode($content);
        } else {
            $output = '';
            for($i = 0; $i < count($matches[0]); $i++) {
                $matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
                if($i == 0){$first = 'class="firsttitle"';}else{$first = '';}
                $output .= '<div class="title"><a href="#acc-' . $i . '" '.$first.'><span class="ui-accordion-header-icon"></span>' . $matches[3][$i]['title'] . '</a></div><div class="inner" id="acc-' . $i . '">' . do_shortcode(trim($matches[5][$i])) .'</div>';
            }
            return '<div class="accordion">' . $output . '</div>';

        }
    }
	/*-----------------------------------------------------------------------------------*/
	/* Highlight - [highlight][/highlight]
	/*-----------------------------------------------------------------------------------*/

	function highlight_sc ( $atts, $content = null ) {

		$defaults = array();

		extract( shortcode_atts( $defaults, $atts ) );

		return '<span class="highlight">' . $content . '</span>';

	}

    /*-----------------------------------------------------------------------------------*/
    /*  Icons
    /*-----------------------------------------------------------------------------------*/
    function icon_sc( $atts, $content = null ) {

        extract(shortcode_atts(array(
            'title_tag' => 'h4',
            'size' => '',           // small, medium, large (16px, 24px, 32px)
            'type' => '',           // the type of icon image to use
            'style' => 'style3',    // style1, style2, style3
            'icon' => '',   // style1, style2, style3
            'link' => '#',          // if a link is provided
            'title' => '',          // the link title attribute
            'link' => false,        // if a link is provided
            'title' => false,       // the link title attribute
            'target' => '_blank',   // the link target
            'container' => 'div',   // the container type (span, div, li, etc...)
            'return' => ''          // if you don't want the element, rather the class to be returned
        ), $atts));

        $class = null;

                // icon image
            $class .= ' '. $type;

            // if return is set to class (otherwise continue with image)
            if ($return == 'class') return $class;

            // icon
            $output = null;

            // link
            if ($link) {

                $link = trim($link);

                // target setup
                if      ($target == 'blank' || $target == '_blank' || $target == 'new' )    { $target = ' target="_blank"'; }
                elseif  ($target == 'parent')   { $target = ' target="_parent"'; }
                elseif  ($target == 'self')     { $target = ' target="_self"'; }
                elseif  ($target == 'top')      { $target = ' target="_top"'; }
                else    { $target = ''; }

            }

            $output .= '<div class="feature-wrapper effect-content '.$type.' '. $style .'">';

            $output .= '<div class="feature-icon"><span class="'.$icon.' '. $style .'"></span></div>';

            $output .= '<'.$title_tag.' class="feature-title">';

                 $output .= '<span>' .$title .'</span>';

            $output .= '</'.$title_tag.'>';

            if ( $content ) $output .= '<div class="feature-content">' . do_shortcode( $content ) .'</div>';

            $output .= '</div>';

            return $output;

    }


	#-----------------------------------------------------------------
	# Social Icons
	#-----------------------------------------------------------------

	// Single Icon
	//...............................................
	function social_icon_sc( $atts, $content = null ) {

		extract(shortcode_atts(array(
			'size' 		=> '',			// small, medium, large (16px, 24px, 32px)
			'link' 		=> '#',			// if a link is provided
			'target' 	=> '_blank',	// the link target
			'type' 		=> '',
			'style' 	=> '',
	     ), $atts));

		$icon = $class = null;

		// Icon size
		switch ($size) {
			case 'large':
				$class .= 'large';
				break;
			case 'medium':
				$class .= 'medium';
				break;
			default:
				$class .= 'small';
		}

		// set class for icon image source
		$class .= '';

		// link
		if ($link) {

			$link = trim($link);

			// target setup
			if		($target == 'blank' || $target == '_blank' || $target == 'new' )	{ $target = ' target="_blank"'; }
			elseif	($target == 'parent')	{ $target = ' target="_parent"'; }
			elseif	($target == 'self')		{ $target = ' target="_self"'; }
			elseif	($target == 'top')		{ $target = ' target="_top"'; }
			else	{ $target = ''; }

			$output = '<a href="'.$link.'" title="" '.$target.' class="'. $class  .' social-icons"><span class="social-icon ' . $type . ' '.$style.' data-type="' . $type . '"></span></a>';
		}

		return $output;

	}

	/*-----------------------------------------------------------------------------------*/
	/*	Buttons
	/*-----------------------------------------------------------------------------------*/
 	function button_sc( $atts, $content = null ) {
	    extract(shortcode_atts(array(
			'id'		=> false,
			'title'		=> false,
			'url'		=> '#',
            'link'      => '#',
 			'target'	=> '',
			'style'		=> '',
			'type'      => '',
			'size'      => '',
			'onclick'	=> false,
			'icon'	    => '',
            'text'      => '',
	    ), $atts));

		// variable setup
        $url =  $url ? $url : $link;
        $content = $content ? $content : $text;
		$title = ($title) ? ' title="'.$title .'"' : '';
 		$id = ($id) ? ' id="'.$id .'"' : '';

 		if ($style) $style = $style;
 		if ($type) $type = $type;
 		if ($size) $size = $size;

		$onclick = ($onclick) ? ' onclick="'.$onclick .'"' : '';

		$icon = ($icon) ? '<span class="'.$icon.'"></span>': null;

		// target setup
		if		($target == 'blank' || $target == '_blank' || $target == 'new' ) { $target = ' target="_blank"'; }
		elseif	($target == 'parent')	{ $target = ' target="_parent"'; }
		elseif	($target == 'self')		{ $target = ' target="_self"'; }
		elseif	($target == 'top')		{ $target = ' target="_top"'; }
		else	{$target = '';}

		$button = '<a' .$target. ' ' .$onclick. '  ' .$title. '  ' .$id. ' class="button ' .$style. ' '.$type.' '.$size.'" href="' .$url. '">'.$icon.'<span>' .do_shortcode($content). '</span></a>';

	    return $button;
	}

	/**
	 * Outputs Video file data in a shortcode called '[radium_audio]'.
	 *
	 * @since 2.1.3
	 *
	 * Audio Shortcode
	 * @Supports mp3, m4a, ogg, webma, wav
	 * @usage [audio href="#" hide_title="false"]
	 * @param href= link to file
	 * @param hide_title bool
	 * @return string $output Concatenated string
	 */
	function media_player_sc($atts, $title = null) {

		extract(shortcode_atts(array(
			'href' => '',
			'poster' => '',
			'height' => '',
			'title' => ''
		), $atts));

	 	$info = array( 'title' => $title );

	 	$html = null;

	 	if ( function_exists( 'get_radium_player' )) $html = get_radium_player( null,  'audio', $href, $poster, $height, $info );

		return $html;

	}

	/**
	 * Define the shortcode: [map] and its attributes
	 */
	function map_sc($atts) {
	    // Enque the stylesheet file
	    wp_enqueue_style('responsive_map_css');

	    // Enque the neccessary jquery files
	    wp_enqueue_script("jquery");
	    wp_enqueue_script('geogooglemap');
	    wp_enqueue_script('responsive_gmap');

	    // Extract the attributes user gave in the shortcode
	    $atts = shortcode_atts(array(
	      'width'		=> '', // Leave blank for 100% (responsive map), or use a width in 'px' or '%'
	      'height'	=> '500px', // Use a height in 'px' or '%'
	      'maptype' 	=> 'roadmap', // Possible values: roadmap, satellite, terrain or hybrid
	      'zoom'		=> 14, // Use values between 1-19
	      'address'	=> 'usa', // Markers addresses in this format: street, city, country | street, city, country | street, city, country
	      'description'		=> '', // Markers descriptions in this format: description1 | description2 | description3 (one for each marker address above)
	      'popup'		=> 'false', // true or false
	      'pancontrol' => 'false', // true or false
	      'zoomcontrol' => 'false', // true or false
	      'typecontrol' => 'false', // true or false
	      'scalecontrol' => 'false', // true or false
	      'streetcontrol' => 'false', // true or false
	      'center' => '', // the point where the map should be centered (latitude, longitude) for instance: center="38.980288, 22.145996"
	      'icon' => 'blue', // Possible color values: black, blue, gray, green, magenta, orange, purple, red, white, yellow
	      'style' => '2' // Use values between 1-20
	    ), $atts);

	    // Generate an unique identifier for the map
	    $mapid = rand();

	    // Extract the map type
	    $atts['maptype'] = strtoupper($atts['maptype']);

	    // If width or height were specified in the shortcode, extract them too
	    $dimensions = 'height:'.$atts['height'];

	    if($atts['width']) $dimensions .= ';width:'.$atts['width'];

	    // Get the correct icon image based on icon color given in the shortcode
	    $atts['icon'] = Radium_Shortcodes::get_url().'/assets/frontend/icons/blue.png';

	    // Set the pre-defined style which corresponds to the number given in the shortcode
	    $atts['style'] = '[ { "stylers": [ { "featureType": "all" }, { "saturation": -100 }, { "gamma": 0.50 }, {"lightness": 30 } ] } ]';

	    // Extract the langitude and longitude for the map center
	    if (trim($atts['center'])  != "") {
	        sscanf($atts['center'], '%f, %f', $lat, $long);
	    } else {
	        $lat = 'null'; $long = 'null';
	    }

	    // Split the addresses and descriptions (by | delimiter) and build markers JSON list
	    if ($atts['address'] != '')
			{
				$addresses = explode("|",$atts['address']);
				$descriptions = explode("|",$atts['description']);

				// Build a marker for each address
				$markers = '[';

	      for($i = 0;$i < count($addresses);$i ++) {
	        $address=$addresses[$i];

	        // If multiple markers, hide popup, else show popup according to parameter from shortcode
	        if (count($addresses) > 1) {
	            $atts['popup'] = "no";
	        }

	        // if it's empty, set the default description equal to the the address
	        if(isset($descriptions[$i]) && strlen(trim($descriptions[$i])) != 0) {
	            $html = $descriptions[$i];
	        }
	        else
	            $html = $address;

	        // Prepare the description html
 	        $html = str_replace(array("\n", '"', "'"), array(' ', '\"', "\'"), $html);
	        if (substr_count($html, '|') == 1) {
	          $tmp = explode('|', $html);
	          $html = '<strong>' . $tmp[0] . '</strong><br />' . $tmp[1];
	        }

	        // If more markers, add the neccessary "," delimiter between markers
	        if ($i > 0) $markers .= ",";
	        $markers .= '{
	                    address: "'. $address .'",
	                    html:"'. $html .'",
	                    popup: '. $atts['popup'] .',
	                    flat: true,
	                    icon: {
	                        image: "'. $atts['icon'] .'",
                            iconsize: [60, 60],
                            iconanchor: [12,46],
                        }
                    }';
	      }
	      $markers .= ']';
	    }
	    // Tell PHP to start output buffering
	    ob_start();
	    ?>
	    <script type="text/javascript">
	     jQuery(document).ready(function($) {
    	   $("#responsive_map_<?php echo $mapid; ?>").gMap({
                maptype: google.maps.MapTypeId.<?php echo $atts['maptype']; ?>,
                zoom: <?php echo $atts['zoom']; ?>,
                markers: <?php echo $markers; ?>,
                panControl: true,
                zoomControl: true,
                mapTypeControl: true,
                scaleControl: true,
                streetViewControl: true,
                overviewMapControl: true,
                styles: <?php echo $atts['style']; ?>,
                scrollwheel: false,
                latitude: <?php echo $lat; ?>,
                longitude: <?php echo $long; ?>,
                onComplete: function() {}
    	   });
	    });
	  </script>
	  <div id="responsive_map_<?php echo $mapid; ?>" class="responsive-map" style="<?php echo $dimensions; ?>;"></div>
	  <?php
	  return ob_get_clean();
	}

    /**
     *  Radium Image Shortcode
     *
     * @param  array $atts  Shortcode Settings
     * @return string $output ShortcodeOutput
     *
     * @since 1.0.4
     */
    function image_sc($atts){

        extract(shortcode_atts(array(
            'image_id' => '',
            'image_size' => '',
            'frame' => '',
            'lightbox' => '',
            'image_link' => '',
            'link_target' => '',
            'caption' => '',
            'style' => ''
        ), $atts));

        if ($image_size == "") { $image_size = "large"; }

        $output = $content = null;

        $img = Radium_Shortcodes_Functions::get_image_by_size(array( 'attach_id' => preg_replace('/[^\d]/', '', $image_id), 'thumb_size' => $image_size ));

        $img_url = wp_get_attachment_image_src($image_id, 'large');

        $output .= "\n\t".'<div class="radium_single_image '. $frame .'">';

        if ($lightbox == "yes") {

            $output .= '<figure class="lightbox">';

        } else {

            $output .= '<figure>';

        }

        if ($image_link) {

            $output .= "\n\t\t\t".'<a class="img-link" href="'.$image_link.'" target="'.$link_target.'">';

            $output .= $img['thumbnail'];

            $output .= '</a>';

        } else if ($lightbox == "yes") {

            $icon = null;

            $output .= "\n\t\t\t".'<a class="radium-image" href="'.$img_url[0].'" rel="lightbox">';

            $output .= $img['thumbnail'];

            $output .= apply_filters( 'radium_image_sc_after_image', $icon );

            $output .= '</a>';

        } else {

            $output .= "\n\t\t\t".$img['thumbnail'];

        }

        if ($caption) {

            $output .= '<figcaption>'.$caption.'</figcaption>';

        }

        $output .= '</figure>';

        $output .= "\n\t".'</div>';

        return $output;


    }

    /**
     *  Radium Embed Video Shortcode
     *
     * @param  array $atts
     * @param  string $content
     * @return string
     *
     * @since 1.0.4
     */
    function embed_video_sc( $atts, $content = null ) {

        $title = $link = $size = $full_width = $classes = $output = $video_h = null;

        extract(shortcode_atts(array(
            'title'     => '',
            'link'      => '',
            'size'      => ( isset($content_width) ) ? $content_width : 500,
            'fullwidth' => true,
            'lightbox'  => false,
            'thumbnail' => '',
        ), $atts));

        if ( $link == '' ) return null;

        $remote_video_url = $link;

        if ( strpos($remote_video_url, 'youtu') > 0 ) {

            if (preg_match('%(?:youtube\.com/(?:user/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $remote_video_url, $result))
                $video_id = $result[1];

            if( isset( $video_id ) )
                $image = Radium_Shortcodes_Functions::get_youtube_video_image($video_id);

        } elseif (strpos($remote_video_url, 'vimeo') > 0) {

            sscanf(parse_url($remote_video_url, PHP_URL_PATH), '/%d', $video_id);

            if( isset( $video_id ) )
                $image = Radium_Shortcodes_Functions::get_vimeo_video_image($video_id);

        } elseif ( $thumbnail ) {

            $image = $thumbnail;

        }

        $size = str_replace(array( 'px', ' ' ), array( '', '' ), $size);

        $size = explode("x", $size);

        $video_w = $size[0];

        if ( count($size) > 1 )
            $video_h = ' height="'.$size[1].'"';

        global $wp_embed;

        $embed = $wp_embed->run_shortcode('[embed width="'.$video_w.'"'.$video_h.']'.$link.'[/embed]');

        if ($full_width == "yes" || $full_width == "true")
                $classes .= "\n\t".'fullwidth';

        $output .= "\n\t".'<div class="radium_embed_video '.$classes.'">';

        $output .= $title ? "\n\t\t\t".'<h4 class="radium_embed_video_heading"><span>'.$title.'</span></h4>' : '';

        if ( $lightbox === "yes" || $lightbox == "true") {

            $output .= '<a href="'.$remote_video_url.'" rel="lightbox" title="'.$title.'"><img src="'.$image.'" alt="'.$title.'"/></a>';

        } else {

            $output .= $embed;

        }

        $output .= "\n\t".'</div>';

        return $output;
    }

    /**
     *  Radium Lists Shortcode
     *
     * @param  array $atts
     * @param  string $content
     * @return string
     *
     * @since 1.0.4
     */
    function lists_sc($atts, $content = null) {
        extract( shortcode_atts( array(
            'icon' => 'icon-forward',
            'style' => ''
        ), $atts ) );

         $content = do_shortcode($content);

         $content = str_replace('<li>', '<li><span class="'.$icon.'"></span>', $content);

        return '<div class="list '.$style.'">'.$content.'</div>';
    }

    /**
     *  Radium PrettyPrint Shortcode
     *
     * @param  array $atts
     * @param  string $content
     * @return string
     *
     * @since 1.0.4
     */
    function pre_sc ( $atts, $content = null ) {
        $defaults = array();
        extract( shortcode_atts( $defaults, $atts ) );
        return '<pre class="prettyprint">' . $content . '</pre>';
    }

    /**
     *  Radium Banner Shortcode
     *
     * @param  array $atts
     * @param  string $content
     * @return string
     *
     * @since 1.0.5
     */
    function banner( $atts, $content = null ){

        extract( shortcode_atts( array(
            'text_pos'  => 'center',
            'height'    => '300px',
            'text_color' => 'light',
            'link' => '',
            'text_width' => '60%',
            'text_align' => 'center',
            'text_box' => '',
            'animation' => 'fadeIn',
            'effect' => '',
            'video_mp4' => '',
            'video_ogg' => '',
            'video_webm' => '',
            'video_sound' => 'false',
            'hover' => '',
            'bg' => '',
            'parallax' => ''
        ), $atts ) );

        $animated = $start_link = $end_link = $background = $background_color = $textalign = $parallax_class = null;

        ob_start();

        // replace ___ (3 underscores) with a nice divider
        $fix = array (
            '_____' => '<div class="tx-div large"></div>',
            '____' => '<div class="tx-div medium"></div>',
            '___' => '<div class="tx-div small"></div>',
        );

        $content = strtr($content, $fix);

        $content = do_shortcode( $content );

        if($text_color == 'light')
            $color = "dark";
        else
            $color = "light";

        if($hover) $hover = 'hover_'.$hover;

        if($animation != "none") $animated = "animated-content";

        if($link) {$start_link = '<a href="'.$link.'">'; $end_link = '</a>';};

        if ( strpos($bg, 'http://') !== false || strpos($bg, 'https://') !== false) {

            $background = $bg;

        } elseif ( strpos($bg, '#') !== false ) {

            $background_color = 'background-color:'.$bg.'!important';

        } else {

            $bg = wp_get_attachment_image_src($bg, 'large');
            $background = $bg[0];

        }

        if($text_align) {$textalign = "text-".$text_align;}

        if($parallax){$parallax_class = 'ux_parallax'; $parallax='data-velocity="0.'.$parallax.'"';}

        ?>
        <div class="radium-banner <?php echo $effect; ?> <?php if($text_box)echo 'banner-textbox-'.$text_box; ?> <?php echo $color; ?> <?php echo $hover; ?>"  style="height:<?php echo $height; ?>" data-height="<?php echo $height; ?>" role="banner">
            <?php echo $start_link; ?>
            <div class="banner-bg <?php echo $parallax_class; ?>" <?php echo $parallax; ?> style="background-image:url(<?php echo $background; ?>); <?php echo $background_color; ?>"></div>
            <?php if($video_mp4 || $video_webm || $video_ogg){ ?>
                <div class="video-overlay" style="position:absolute;top:0;bottom:0;right:0;left:0;z-index:2;background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAIAAAACCAYAAABytg0kAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBNYWNpbnRvc2giIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6N0IxQjNGRDQ0QUMxMTFFMzhBQzM5OUZBMEEzN0Y1RUUiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6N0IxQjNGRDU0QUMxMTFFMzhBQzM5OUZBMEEzN0Y1RUUiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpFN0M5QzFENzRBQTcxMUUzOEFDMzk5RkEwQTM3RjVFRSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpFN0M5QzFEODRBQTcxMUUzOEFDMzk5RkEwQTM3RjVFRSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PhPF5GwAAAAYSURBVHjaYmJgYPD6//8/AyOIAAGAAAMAPRIGSKhmMMMAAAAASUVORK5CYII=');"></div>
                <video class="radium-banner-video hide-for-small" style="position:absolute;top:0;left:0;bottom:0;right:0;min-width: 100%;min-height: 100%;z-index:1;" poster="<?php echo $background; ?>" preload="auto" autoplay="" loop="loop" <?php if($video_sound == 'false') echo "muted='muted'"; ?>>
                    <source src="<?php echo $video_mp4; ?>" type="video/mp4">
                    <source src="<?php echo $video_webm; ?>" type="video/webm">
                    <source src="<?php echo $video_ogg; ?>" type="video/ogg">
                </video>
            <?php } ?>
            <?php if($effect){ ?>
                <div class="banner-effect"></div>
            <?php } ?>
                <div class="row">
                    <div class="inner <?php echo $text_pos; ?>  <?php echo $animated; ?>  <?php echo $textalign; ?> " data-animate="<?php echo $animation; ?>" style="width:<?php echo $text_width; ?>">
                        <?php echo $content; ?>
                    </div>
                </div>
            <?php echo $end_link; ?>

        </div><!-- end .radium-banner -->
        <?php

        $content = ob_get_contents();

        ob_end_clean();

        return $content;

    }

    /**
     *  Row Shortcode
     *
     * @param  array $atts
     * @param  string $content
     * @return string
     *
     * @since 1.0.5
     */
    function row ($params = array(), $content = null) {
        $content    = do_shortcode($content);
        $container  = '<div class="row inner-container">'.$content.'</div>';
        return $container;
    }

    /**
     *  Columns Shortcode
     *
     * @param  array $atts
     * @param  string $content
     * @return string
     *
     * @since 1.0.5
     */
    function columns($atts, $content = null) {
        extract( shortcode_atts( array(
        'span' => '3',
        ), $atts ) );

        switch ($span) {
        case "1/4":
            $span = '3'; break;
        case "2/4":
             $span ='6'; break;
        case "3/4":
            $span = '9'; break;
        case "1/3":
            $span = '4'; break;
        case "2/3":
             $span = '8'; break;
        case "1/2":
            $span = '6'; break;
        case "1/6":
            $span = '2'; break;
        case "2/6":
             $span = '4'; break;
        case "3/6":
            $span = '6'; break;
        case "4/6":
            $span = '8'; break;
        case "5/6":
            $span = '10'; break;
        }

        $content = do_shortcode($content);
        $column = '<div class="large-'.$span.' columns">'.$content.'</div>';
        return $column;
    }


    /**
     *  Radium Grid Shortcode
     *
     * @param  array $atts
     * @param  string $content
     * @return string
     *
     * @since 1.0.5
     */
    function grid($params = array(), $content = null) {
        $content = do_shortcode($content);
        $container = '<div class="row"><div class="large-12 columns"><div class="row collapse radium-banner-grid">'.$content.'</div></div></div>
        <script>
        /* Start PACKERY grid */
        jQuery(document).ready(function ($) {
            var $container = $(".radium-banner-grid");
            $container.packery({
              itemSelector: ".columns",
              gutter: 0
            });
         });
        </script>';
        return $container;
    }

    /**
     * Strip Spaces and p tags from shortcodes
     * @param  string $content Wordpress Content
     * @return string
     *
     * @since 1.0.0
     */
	function the_content_filter($content) {

		// array of custom shortcodes requiring the fix
		$block = join("|",array(

            /* Columns */
            'one_third',
            'one_third_last',
            'two_third',
            'two_third_last',
            'one_half',
            'one_half_last',
            'one_fourth',
            'one_fourth_last',
            'three_fourth',
            'three_fourth_last',
            'one_fifth',
            'one_fifth_last',
            'two_fifth',
            'two_fifth_last',
            'three_fifth',
            'three_fifth_last',
            'four_fifth_last',
            'one_sixth',
            'four_fifth',
            'one_sixth_last',
            'five_sixth',
            'five_sixth_last',
            /* end Columns */

		 	'button',
	   	 	'social-icon',
            'radium_image',
            'radium_embed_video',
            'list',
            'pre',
            'banner',
            'grid',
            'col',
            'row',
            'hr',
            'hr_invisible',
            'clear',
            'clearfix',

            'accordion',
            'tab',
            'tabs',
            'toggle',

		));

		// opening tag
		$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);

		// closing tag
		$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);

		return $rep;

	}

}
?>
