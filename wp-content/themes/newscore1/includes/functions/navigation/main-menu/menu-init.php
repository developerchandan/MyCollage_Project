<?php
/**
 * This file holds various classes and methods necessary to hijack the wordpress menu and improve it with mega menu capabilities
 */

if( !class_exists('Radium_Megamenu') ) :

/**
 * The radium megamenu class contains various methods necessary to create mega menus out of the admin backend
 */
class Radium_Megamenu {

    /**
     * radium_megamenu constructor
     * The constructor uses WordPress hooks and filters provided and
     * replaces the default menu with custom functions and classes within this file
     */
    public function __construct() {

        //adds stylesheet and javascript to the menu page
        add_action('admin_menu', array(&$this,'radium_menu_header'));

        //exchange argument for backend menu walker
        add_filter( 'wp_edit_nav_menu_walker', array(&$this,'modify_backend_walker') , 100);

        //save radium options:
        add_action( 'wp_update_nav_menu_item', array(&$this,'update_menu'), 100, 3);

        //add first and last class
        add_filter('wp_nav_menu_objects', array(&$this, 'first_and_last_menu_class') );

        //add child menu items
        add_filter( 'wp_nav_menu_objects', array(&$this,'add_menu_child_items') );

    }

    /**
     * If we are on the nav menu page add javascript and css for the page
     */
    public function radium_menu_header() {
        global $pagenow;

        $framework = radium_framework();

        if( $pagenow == "nav-menus.php" ) {
            wp_enqueue_style( 'radium_admin', $framework->theme_includes_url  . '/functions/navigation/main-menu/css/radium_admin.css' );

            wp_enqueue_script( 'radium_mega_menu', $framework->theme_includes_url. '/functions/navigation/main-menu/js/radium_mega_menu.js', array('jquery', 'jquery-ui-sortable'), false, true );
        }
    }

    //Deletes all CSS classes and id's, except for those listed in the array below
    public function custom_wp_nav_menu($var) {
        return is_array($var) ? array_intersect($var, array(
            //List of allowed menu classes
            'current_page_item',
            'current_page_parent',
            'current_page_ancestor',
            'first',
            'last',
            'vertical',
            'horizontal',
            'menu-parent-item'
            )
        ) : '';
    }

    //Replaces "current-menu-item" with "active"
    public function current_to_active($text){

        $replace = array(
            //List of menu item classes that should be changed to "active"
            'current_page_item' => 'menu-item-active',
            'current_page_parent' => 'menu-item-active',
            'current_page_ancestor' => 'menu-item-active',
        );

        $text = str_replace(array_keys($replace), $replace, $text);

        return $text;
    }

    //Add first and last class
    public function first_and_last_menu_class($items) {
        $items[1]->classes[] = 'menu-item-first';
        $items[count($items)]->classes[] = 'menu-item-last';
        return $items;
    }

    /**
     * [add_menu_child_items description]
     * @param  [type] $items [description]
     * @return [type]        [description]
     */
    public function add_menu_child_items( $items ) {

        $parents = array();

        foreach ( $items as $item ) {

            $item->children = array();

            if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
                $parents[] = $item->menu_item_parent;
			}

        }

        foreach ( $items as $item ) {

            if ( in_array( $item->ID, $parents ) ) {

                $item->classes[] = 'menu-parent-item';

                foreach ( $items as $citem ) {

                    if ( $citem->menu_item_parent && $citem->menu_item_parent == $item->ID ) {
                        $item->children[] = $citem;
					}

                }

            }

        }

        return $items;
    }

    /**
     * Tells wordpress to use our backend walker instead of the default one
     */
    public function modify_backend_walker($name) {
        return 'Radium_Backend_Walker';
    }

    /*
     * Save and Update the Custom Navigation Menu Item Properties by checking all $_POST vars with the name of $check
     * @param int $menu_id
     * @param int $menu_item_db
     */
    public function update_menu($menu_id, $menu_item_db) {

        $check = array(
            'megamenu',
            'cat-megamenu',
            'icon',
            'division',
            'textarea'
        );

        foreach ( $check as $key ) {

            if(!isset($_POST['menu-item-radium-'.$key][$menu_item_db]))
                $_POST['menu-item-radium-'.$key][$menu_item_db] = "";

            $value = $_POST['menu-item-radium-'.$key][$menu_item_db];
            update_post_meta( $menu_item_db, '_menu-item-radium-'.$key, $value );

        }
    }
}

new Radium_Megamenu();

endif;


/**
* Frontend Menu classes
*/

if( !class_exists( 'Radium_Walker' ) ) {

    /**
     * The radium walker is the frontend walker and necessary to display the menu, this is a advanced version of the WordPress menu walker
     * @package WordPress
     * @since 1.0.0
     * @uses Walker
     */
    class Radium_Walker extends Walker {

        /**
         * @see Walker::$tree_type
         * @var string
         */
        public $tree_type = array( 'post_type', 'taxonomy', 'custom' );

        /**
         * @see Walker::$db_fields
         * @todo Decouple this.
         * @var array
         */
        public $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

        /**
         * @var int $columns
         */
        public $columns = 0;

        /**
         * @var int $max_columns maximum number of columns within one mega menu
         */
        public $max_columns = 0;

        /**
         * @var int $rows holds the number of rows within the mega menu
         */
        public $rows = 1;

        /**
         * @var array $rowsCounter holds the number of columns for each row within a multidimensional array
         */
        public $rowsCounter = array();

        /**
         * @var string $mega_active hold information whatever we are currently rendering a mega menu or not
         */
        public $mega_active = false;

        /**
         * @var string $cat_mega_active hold information whatever we are currently rendering a category mega menu or not
         */
        public $cat_mega_active = true; //on by default

        /**
         * $in_sub_menu Detect if in submenu
         * @var integer
         */
        private $in_sub_menu = 0;

        /**
         * @see Walker::start_lvl()
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int $depth Depth of page. Used for padding.
         */
        public function start_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat("\t", $depth);
            if($depth === 0) $output .= "\n{replace_one}\n";
            $output .= "\n$indent<ul class=\"sub-menu\">\n";
        }

        /**
         * @see Walker::end_lvl()
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int $depth Depth of page. Used for padding.
         */
        public function end_lvl( &$output, $depth = 0, $args = array() ) {

            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";

            if($depth === 0) {

                if($this->mega_active) {

                    $output .= "\n</div>\n";
                    $output = str_replace("{replace_one}", "<div class='radium-mega-div sub-mega-wrap radium_mega".$this->max_columns."'>", $output);

                    foreach($this->rowsCounter as $row => $columns) {
                        $output = str_replace("{current_row_".$row."}", "radium-mega-menu-columns radium_mega_menu_columns_".$columns, $output);
                    }

                    $this->columns = 0;
                    $this->max_columns = 0;
                    $this->rowsCounter = array();

                } else {

                    $output = str_replace("{replace_one}", "", $output);

                }
            }
        }

        /**
         * @see Walker::start_el()
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $item Menu item data object.
         * @param int $depth Depth of menu item. Used for padding.
         * @param int $current_page Menu item ID.
         * @param object $args
         */
        public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

            global $wp_query;

			$this->cat_mega_active = false;

            //set maxcolumns
            if(!isset($args->max_columns)) $args->max_columns = 7;

            $item_output = $li_text_block_class = $column_class = "";

            if($depth === 0) $this->mega_active = get_post_meta( $item->ID, '_menu-item-radium-megamenu', true);

            if($depth === 0 && ($item->object == 'category' || $item->object == 'video_category') ) {

            	$this->cat_mega_active = get_post_meta( $item->ID, '_menu-item-radium-cat-megamenu', true) ? false : true;

			}

            // Detect first child of submenu then add class active
            if( $depth == 1 ) {
                if( ! $this->in_sub_menu ) {
                    $classes[] = 'active';
                    $this->in_sub_menu = 1;
                }
            }

            if( $depth == 0 ) $this->in_sub_menu = 0; // End addition of active class for first item

            if( $depth === 1 && $this->mega_active ) {

                $this->columns ++;

                //check if we have more than $args['max_columns'] columns or if the user wants to start a new row
                if($this->columns > $args->max_columns || (get_post_meta( $item->ID, '_menu-item-radium-division', true) && $this->columns != 1)) {

                    $this->columns = 1;
                    $this->rows ++;
                    $output .= "\n<li class='radium-mega-hr'></li>\n";

                }

                $this->rowsCounter[$this->rows] = $this->columns;

                if($this->max_columns < $this->columns) $this->max_columns = $this->columns;

                $title = apply_filters( 'the_title', $item->title, $item->ID );

                if ( $title[0] == '_') $title = substr ($title, 1);

                if ( ( $title != "-" && $title != '"-"' ) || $title[0] !== '_' ) $item_output .= "<h4 class='mega-title'>".$title."</h4>"; //fallback for people who copy the description o_O

                $column_class  = ' {current_row_'.$this->rows.'}';

                if ( $this->columns == 1 ) $column_class  .= " radium-mega-menu-columns-first";

                if ( $title[0] == '_') $classes .=' hide-menu-text';

            } else if($depth >= 2 && $this->mega_active && get_post_meta( $item->ID, '_menu-item-radium-textarea', true) ) {

                $li_text_block_class = 'radium-mega-text-block ';

                $item_output.= do_shortcode($item->post_content);

            } else {

                $icon_class  = get_post_meta( $item->ID, '_menu-item-radium-icon', true);
                $icon        = ! empty( $icon_class ) ? $icon_class : '';
                $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
                $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
                $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
                $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
                $attributes .= ! empty( $icon )             ? ' class="has-icon"'                              : '';

                $prepend    = null;
                if( $icon ) $prepend    .= '<span class="icon"><i class="'. $icon .'"></i></span>';
                if( $depth < 1 ) $prepend .= '<span class="menu-title-outer">';
                $prepend    .= '<span class="menu-title">';
                $append      = '</span>';
                if( $depth < 1 ) $append .= '</span>';
                $description = ! empty( $item->description ) ? '<span class="menu-desc">'.esc_attr( $item->description ).'</span>' : '';

                if( $depth != 0 ) $description = null;

                $menu_text = $item->title;

                if ( isset( $menu_text[0] ) && $menu_text[0] == '_') $menu_text = substr ($menu_text, 1);

                $item_output .= $args->before;
                $item_output .= '<a'. $attributes .' itemprop="name">';
                $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $menu_text, $item->ID ).$append;
                $item_output .= $description.$args->link_after;
                $item_output .= '</a>';
                $item_output .= $args->after;

            }

            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
            $class_names = $value = '';

            $classes = empty( $item->classes ) ? array() : (array) $item->classes;

            $menu_text = $item->title;
            if ( isset( $menu_text[0] ) && $menu_text[0] == '_') $classes[] ='hide-menu-text';

            //cat megamenu class
            if( $this->cat_mega_active && $depth == 0 && ($item->object == 'category' || $item->object == 'video_category')) {
            	$classes[] = 'has-cat-megamenu';
			}

			//normal drop down class
            if( $depth == 0 && !$this->cat_mega_active && !$this->mega_active ) {
              	$classes[] = 'has-one-col-dropdown';
			}

            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
            $class_names = ' class="'.$li_text_block_class. esc_attr( $class_names ) . $column_class.'"';

            $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .' itemprop="name">';

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

            if( $this->cat_mega_active && $depth == 0 && ($item->object == 'category' || $item->object == 'video_category') && $item->children ) {
                $output .= "<div class=\"sub-mega-wrap radium-mega-div\">\n";

          	}

        }

        /**
         * @see Walker::end_el()
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $item Page data object.
         * @param int $depth Depth of page.
         */
        public function end_el( &$output, $item, $depth = 0, $args = array() ) {

            global $post;

            $item_output = $class = null;

			$grid_class = radium_get_option('header_news') ? 'large-block-grid-4' : 'large-block-grid-5';
			$numberposts = radium_get_option('header_news') ? 4 : 5;

            $image_size = radium_framework_add_image_sizes();
            $image_size = radium_get_option('header_news') ? $image_size['megamenu_cat_thumb_larger'] : $image_size['megamenu_cat_thumb_smaller'];

            $thumb_w = $image_size['width']; //Define width
            $thumb_h = $image_size['height'];

            $img_url = false;
            $crop    = true;

  			 if($depth === 0 && ($item->object == 'category' || $item->object == 'video_category') ) {

  				$this->cat_mega_active = get_post_meta( $item->ID, '_menu-item-radium-cat-megamenu', true) ? false : true;

  			}

            if( $this->cat_mega_active && $depth == 0 && ($item->object == 'category' || $item->object == 'video_category') && count( $item->children ) == 0 ) {

                $cat = $item->object_id;

				$cache_id = 'rdm_mega_cat_'.$cat;

                $class .= radium_get_option('header_search') ? ' has-search' : null;
                $class .= radium_get_option('header_random') ? ' has-random' : null;
                $class .= radium_get_option('header_trending') ? ' has-trending' : null;

				if ( $item->object == 'category' ) :

					$post_args = apply_filters('radium_menu_cat_posts_args', array(
						'numberposts' => $numberposts,
						'offset'=> 0,
						'category' => $cat,
						'no_found_rows' => true
					));

	                $menuposts = Radium_Theme_WP_Query::get_posts_cached( $post_args, $cache_id );

	                if ( $menuposts ) :

	                    $item_output .= '<div class="sub-mega-wrap radium-mega-div cat-menu single-cat">';

	                        $item_output .= '<ul class="sub-posts subcat sub-menu '. $grid_class.'">';

	                        foreach( $menuposts as $post ) : setup_postdata( $post );

	                            //Check if post has a featured image set else get the first image from the gallery and use it. If both statements are false display fallback image.
	                            if ( has_post_thumbnail() ) {

	                                //get featured image
	                                $thumb = get_post_thumbnail_id();
	                                $img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the image is too big)

	                                $image = $img_url ? radium_resize( $img_url, $thumb_w, $thumb_h, $crop ) : false ;
	                                $class = "has-thumbnail";
	                            }

	                            //add thumbnail fallback
	                            if(empty($image) || !has_post_thumbnail() ) {
	                                $image = get_radium_first_post_image(true);
	                                $class = 'no-thumb';
	                            }

	                            $item_output .= '<li class="cat-post ' . $class . ' clearfix">';

	                                $item_output.= "<div class='subcat-thumbnail entry-content-media'>";

		                                $item_output.= "<div class='post-thumb zoom-img-in'>";

		                                    $item_output.= "<a href='".get_permalink()."' title='".get_the_title()."'>";

		                                        $item_output .= '<img src="' . $image . '" alt="' . get_the_title() . '" width="'. $thumb_w .'" height="'. $thumb_h .'"/>';

		                                    $item_output.= "</a>";

		                                $item_output.= "</div>";

		                                $item_output .= '<div class="entry-meta">';

		                                	$item_output .= radium_get_post_grid_date();

		                                $item_output.= "</div>";

		                                $item_output .= '<div class="entry-extras">';

		                                	$item_output .= radium_get_post_grid_featured();

		                                $item_output.= "</div>";

	                                $item_output.= "</div>";

	                                $item_output.= "<h4 class='subcat-title'>";

	                                    $item_output.= "<a href='".get_permalink()."' title='".get_the_title()."'>" . get_the_title() ."</a>";

	                                $item_output.= "</h4>";

	                            $item_output .= '</li>';

	                        endforeach;

	                        $item_output .= '</ul>';

	                    $item_output .= "</div><!-- .sub-mega-wrap -->\n";

					endif;

					wp_reset_postdata();

				elseif( $item->object == 'video_category' ) :

					$image_size = array();

					$image_size['width'] = $thumb_w;
					$image_size['height'] = $thumb_h;

					$video_megamenu_post_args_single_cat = apply_filters('video_megamenu_post_args_single_cat', array(
						'post_type'      		=> video_central_get_video_post_type(), // Narrow query down to videos
						'ignore_sticky_posts' 	=> true,
						'orderby'             	=> 'menu_order title',
						'order'               	=> 'ASC',
						'post_status'       	=> 'publish',
						'order'          		=> 'DESC',
						'posts_per_page'		=> $numberposts,
						'no_found_rows' 		=> true,
						'tax_query' => array(
							array(
								'taxonomy' => video_central_get_video_category_tax_id(),
								'field' => 'id',
								'terms' => $item->object_id
							)
						),
					));

	            	$query = new WP_Query( $video_megamenu_post_args_single_cat );

					if ( $query ) :

	                    $item_output .= '<div class="sub-mega-wrap radium-mega-div cat-menu single-cat single-video-cat">';

	                        $item_output .= '<ul class="sub-posts subcat sub-menu '. $grid_class.' video-central-list">';

    						while ( $query->have_posts() ) : $query->the_post();

	                            $item_output .= '<li class="cat-post ' . $class . ' video-central-item preload image-loading clearfix">';

	                                $item_output.= "<div class='subcat-thumbnail entry-content-media'>";

		                                $item_output.= "<div class='post-thumb zoom-img-in'>";

		                                    $item_output.= "<a class='video-central-thumb' href='".video_central_get_video_permalink( get_the_ID() )."' title='".video_central_get_video_title( get_the_ID() )."'>";

		                                        $item_output .= '<img src="' . video_central_get_featured_image_url(get_the_ID(), $image_size) . '" alt="' . video_central_get_video_title( get_the_ID() ) . '" width="'. $thumb_w .'" height="'. $thumb_h .'"/>';

												 $item_output .= '<span class="video-icon-wrapper"><span class="icon icon-play"></span></span>';

												 $item_output .= '<div class="video-entry-meta duration">'. video_central_get_video_duration(get_the_ID()).'</div>';

		                                    $item_output.= "</a>";

		                                $item_output.= "</div>";

	                                $item_output.= "</div>";

	                                $item_output.= "<h4 class='subcat-title'>";

	                                    $item_output.= "<a href='".video_central_get_video_permalink(get_the_ID())."' title='".video_central_get_video_title(get_the_ID())."'>" . video_central_get_video_short_title(get_the_ID()) ."</a>";

	                                $item_output.= "</h4>";

	                            $item_output .= '</li>';

	                        endwhile;

	                        $item_output .= '</ul>';

	                    $item_output .= "</div><!-- .sub-mega-wrap -->\n";

					endif;

                endif;

               	wp_reset_postdata();

            } elseif( $this->cat_mega_active && $depth == 0 && ($item->object == 'category' || $item->object == 'video_category') && $item->children ) {

                $item_output .= "<ul class='subcat sub-cat-list'>";
				$video_cat_class = '';

                for ( $i=0; $i < count( $item->children ); $i++ ) {

                    $child = $item->children[$i];

                    $active_class = ( $i===0 ) ? 'active': '';

                    $item_output .="<li id='cat-latest-".$child->ID."' class='".$active_class." cat-latest-".$child->ID."'>";

                    if($child->object == 'category' || $child->object == 'video_category') :

                    	if( $child->object == 'video_category')
                    		$video_cat_class ='video-central-list';

                        $item_output .="<ul class='". $grid_class." ". $video_cat_class ." cat-tab-content cat-tab-content-".$child->ID."' data-child_object_id='" . $child->object_id ."'>";

						$cache_id = 'rdm_mega_cat_'.$child->object_id;

						if ( $child->object == 'category' ) :

                            $args = array(
                                'posts_per_page' => $numberposts,
                                'no_found_rows'  => true,
                                'post_status'    => 'publish',
                                'cat'            => $child->object_id,
                            );

                           	$cat_posts = Radium_Theme_WP_Query::get_posts_cached( apply_filters( 'radium_menu_posts_args', $args) , $cache_id );

                            if ( $cat_posts ) :

                                foreach( $cat_posts as $post ) : setup_postdata( $post );

                                    //Check if post has a featured image set else get the first image from the gallery and use it. If both statements are false display fallback image.
                                    if ( has_post_thumbnail() ) {

                                        //get featured image
                                        $thumb = get_post_thumbnail_id();
                                        $img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the image is too big)

                                        $image = $img_url ? radium_resize( $img_url, $thumb_w, $thumb_h, $crop ) : false ;
                                        $class = "has-thumbnail";
                                    }

                                    //add thumbnail fallback
                                    if(empty($image) || !has_post_thumbnail() ) {
                                        $image = get_radium_first_post_image(true);
                                        $class = 'no-thumb';
                                    }

                                    $item_output.= "<li class='" . $class . " clearfix'>";

                                        $item_output.= "<div class='subcat-thumbnail entry-content-media'>";

	                                		$item_output.= "<div class='post-thumb zoom-img-in'>";

	                                            $item_output.= "<a href='".get_permalink()."' title='".get_the_title()."'>";

	                                                $item_output .= '<img src="' . $image . '" alt="' . get_the_title() . '" width="'. $thumb_w .'" height="'. $thumb_h .'"/>';

	                                            $item_output.= "</a>";

	                                        $item_output.= "</div>";

	                                  	    $item_output .= '<div class="entry-meta">';

	                                			$item_output .= radium_get_post_grid_date();

											$item_output.= "</div>";

											$extras = '';

											$item_output .= '<div class="entry-extras">';

												$item_output .= radium_get_post_grid_featured();

											$item_output.= "</div>";

                                        $item_output.= "</div>";

                                        $item_output.= "<h4 class='subcat-title'>";

                                        	$item_output.= "<a href='".get_permalink()."' title='".get_the_title()."'>" . get_the_title() ."</a>";

                                        $item_output.= "</h4>";

                                    $item_output.= "</li>";

                                endforeach; //get_posts

                            endif; //end $cat_posts

                           	wp_reset_postdata();

						elseif( $child->object == 'video_category' ) :

							$image_size = array();

							$image_size['width'] = $thumb_w;
							$image_size['height'] = $thumb_h;

							$video_megamenu_post_args_single_cat = apply_filters('video_megamenu_post_args_single_cat', array(
								'post_type'      		=> video_central_get_video_post_type(), // Narrow query down to videos
								'ignore_sticky_posts' 	=> true,
								'orderby'             	=> 'menu_order title',
								'order'               	=> 'ASC',
								'post_status'       	=> 'publish',
								'order'          		=> 'DESC',
								'posts_per_page'		=> $numberposts,
								'no_found_rows' 		=> true,
								'tax_query' => array(
									array(
										'taxonomy' => video_central_get_video_category_tax_id(),
										'field' => 'id',
										'terms' => $child->object_id
									)
								),
							));

			            	$query = new WP_Query( $video_megamenu_post_args_single_cat );

							if ( $query ) :

	    						while ( $query->have_posts() ) : $query->the_post();

		                            $item_output .= '<li class="' . $class . ' video-central-item preload image-loading clearfix">';

		                                $item_output.= "<div class='subcat-thumbnail entry-content-media'>";

			                                $item_output.= "<div class='post-thumb zoom-img-in'>";

			                                    $item_output.= "<a class='video-central-thumb' href='".video_central_get_video_permalink( get_the_ID() )."' title='".video_central_get_video_title( get_the_ID() )."'>";

			                                        $item_output .= '<img src="' . video_central_get_featured_image_url(get_the_ID(), $image_size) . '" alt="' . video_central_get_video_title( get_the_ID() ) . '" width="'. $thumb_w .'" height="'. $thumb_h .'"/>';

													 $item_output .= '<span class="video-icon-wrapper"><span class="icon icon-play"></span></span>';

													 $item_output .= '<div class="video-entry-meta duration">'. video_central_get_video_duration(get_the_ID()).'</div>';

			                                    $item_output.= "</a>";

			                                $item_output.= "</div>";

		                                $item_output.= "</div>";

		                                $item_output.= "<h4 class='subcat-title'>";

		                                    $item_output.= "<a href='".video_central_get_video_permalink(get_the_ID())."' title='".video_central_get_video_title(get_the_ID())."'>" . video_central_get_video_short_title(get_the_ID()) ."</a>";

		                                $item_output.= "</h4>";

		                            $item_output .= '</li>';

		                        endwhile;

 							endif; //$query

                       		wp_reset_postdata();

	                    endif; //end $child->object == 'video_category'

                        $item_output .= "</ul>";

                    endif;  //end $child->object == 'category' || $child->object == 'video_category'

                  //  $item_output .= "<a href='".$child->url."' title='".$child->attr_title."' class='cat-link'>".__('View all', 'radium')."</a>";

                    $item_output .= "</li><!-- #cat-latest-".$child->ID." -->\n";

                } //end for loop

                $item_output .= "</ul><!-- .subcat -->\n";

                $item_output .= "</div><!-- .sub-mega-wrap -->\n";

            } //end if main

            $output .= $item_output ;

            $output .= "</li>\n";

        }

    }

}

/**
 * radium_mega_menu cache the megamenu for performance boost
 *
 * @param  array $args nav menu arguments
 * @return string       return cached menu
 */
function radium_mega_menu( $args ) {
    $menu = wp_nav_menu( $args );
    return apply_filters(__FUNCTION__, $menu);
}

/**
 * radium_update_mega_menu clear menu cacher on update
 * @return null
 */
function radium_update_mega_menu() {
    delete_transient('radium_main_menu_cache');
}
add_action( 'wp_update_nav_menu', 'radium_update_mega_menu' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since 1.0.0
 */
function radium_page_menu_args( $args ) {

    $args['show_home'] = true;

    return $args;

}
add_filter( 'wp_page_menu_args', 'radium_page_menu_args' );

if( !function_exists( 'radium_fallback_menu' ) ) {
    /**
     * Create a navigation out of pages if the user didn't create a menu in the backend
     *
     */
    function radium_fallback_menu() {
        $current = "";
        if (is_front_page()){$current = "class='current-menu-item'";}

        echo "<div id='main-menu' class='main_menu fallback_menu'>";
        echo "<ul id='menu-main-menu' class='radium_mega menu dl-menu'>";

       $args = array(
            'title_li' 		=> null,
            'depth' 		=> 3,
            'sort_column'	=>'menu_order',
            'child_of' 		=> 0,
            'walker' 		=> new Radium_Fallback_Menu_Walker,
        );

        wp_list_pages($args);

        echo "</ul></div>";
    }
}

/**
 * Custom Walker for the fallback menu
 *
 * @since 2.2.3
 **/
class Radium_Fallback_Menu_Walker extends Walker_Page {

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);

            $output .= "\n$indent<ul class='sub-menu'>\n";
     }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);

       	$output .= "$indent</ul>\n";
     }
}

/**
 * Get options of category
 * @param  int $category_id ID of category
 * @return array              An array of category options
 */
if( ! function_exists('radium_get_category_option') ) {

    function radium_get_category_option($category_id){
        return get_option(  'radium_category_option_'.$category_id, array(
                'style'         => 'none',
                'logo'          => '',
                'background'    => ''
            ) );
    }

}

/**
 * [radium_special_category_menu_class description]
 * @param  [type] $classes [description]
 * @param  [type] $item    [description]
 * @return [type]          [description]
 */
function radium_special_category_menu_class( $classes, $item ) {
    if( 'category' == $item->object ) {
        $options = radium_get_category_option( $item->object_id );
        $classes[] = 'color-'.$options['style'];
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'radium_special_category_menu_class', 10, 2 );

/**
 * [radium_category_color_class description]
 * @param  [type] $classes [description]
 * @return [type]          [description]
 */
function radium_category_color_class($classes) {
    if( is_archive() ) {
        $classes[] = 'color-category';
    }
    return $classes;
}
add_filter('post_class', 'radium_category_color_class');
add_filter('body_class', 'radium_category_color_class');

