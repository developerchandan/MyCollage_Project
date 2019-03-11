<?php
/**
 * This file holds the admin class and methods necessary to hijack the WordPress menu and improve it with mega menu capabilities
 */

if( !class_exists( 'Radium_Backend_Walker' ) ) {
/**
 * Create HTML list of navigation menu input items. 
 * This walker is a clone of the WordPress edit menu walker with some options appended, so the user can choose to create mega menus
 *
 * @uses Walker_Nav_Menu
 */
class Radium_Backend_Walker extends Walker_Nav_Menu	{

	/**
	 * @see Walker_Nav_Menu::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int $depth Depth of page.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {}

	/**
	 * @see Walker_Nav_Menu::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int $depth Depth of page.
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	 
		global $_wp_nav_menu_max_depth;
		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		ob_start();
		$item_id = esc_attr( $item->ID );
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		);

		$original_title = '';
		if ( 'taxonomy' == $item->type ) {
			$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
		} elseif ( 'post_type' == $item->type ) {
			$original_object = get_post( $item->object_id );
			$original_title = $original_object->post_title;
		}

		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
		);

		$title = $item->title;

		if ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( __('%s (Pending)', 'radium'), $item->title );
		}

		$title = empty( $item->label ) ? $title : $item->label;
		
		$itemValue = $catitemValue = "";
		if($depth == 0) {
			$itemValue = get_post_meta( $item->ID, '_menu-item-radium-megamenu', true);
			if($itemValue != "") $itemValue = 'radium_mega_active ';
		}
		
		if($depth == 0 && ($item->object == 'category' ||  $item->object == 'video_category') ) {
			$catitemValue = get_post_meta( $item->ID, '_menu-item-radium-cat-megamenu', true);
			if($catitemValue != "") $catitemValue = 'radium_cat_mega_inactive ';
		} 
				
		?>
			<li id="menu-item-<?php echo $item_id; ?>" class="<?php echo $itemValue; echo $catitemValue; echo implode(' ', $classes ); ?>">
				<dl class="menu-item-bar">
					<dt class="menu-item-handle">
						<span class="item-title"><?php echo esc_html( $title ); ?></span>
						<span class="item-controls">
						
							<span class="item-type item-type-default"><?php echo esc_html( $item->type_label ); ?></span>
							<span class="item-type item-type-radium"><?php _e('Column', 'radium'); ?></span>
							<span class="item-type item-type-megafied"><?php _e('(Mega Menu)', 'radium'); ?></span>
							<a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php _e('Edit Menu Item', 'radium'); ?>" href="<?php
								echo esc_url( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) ) );
							?>"><?php _e( 'Edit Menu Item', 'radium'); ?></a>
							
						</span>
					</dt>
				</dl>
	
				<div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
					<?php if( 'custom' == $item->type ) : ?>
						<p class="field-url description description-wide">
							<label for="edit-menu-item-url-<?php echo $item_id; ?>">
								<?php _e( 'URL', 'radium' ); ?><br />
								<input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
							</label>
						</p>
					<?php endif; ?>
					<p class="description description-thin description-label radium_label_desc_on_active">
						<label for="edit-menu-item-title-<?php echo $item_id; ?>">
						<span class='radium_default_label'><?php _e( 'Navigation Label', 'radium'); ?></span>
						<span class='radium_mega_label'><?php _e( 'Mega Menu Column Title <span class="radium_supersmall">(if you don\'t want to display a title just enter a single dash: "-" )</span>', 'radium' ); ?></span>
							
							<br />
							<input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
						</label>
					</p>
					<p class="description description-thin description-title">
						<label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
							<?php _e( 'Title Attribute', 'radium' ); ?><br />
							<input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
						</label>
					</p>
					<p class="field-link-target description description-thin">
						<label for="edit-menu-item-target-<?php echo $item_id; ?>">
							<?php _e( 'link Target', 'radium' ); ?><br />
							<select id="edit-menu-item-target-<?php echo $item_id; ?>" class="widefat edit-menu-item-target" name="menu-item-target[<?php echo $item_id; ?>]">
								<option value="" <?php selected( $item->target, ''); ?>><?php _e('Same window or tab', 'radium'); ?></option>
								<option value="_blank" <?php selected( $item->target, '_blank'); ?>><?php _e('New window or tab', 'radium'); ?></option>
							</select>
						</label>
					</p>
					<p class="field-css-classes description description-thin">
						<label for="edit-menu-item-classes-<?php echo $item_id; ?>">
							<?php _e( 'CSS Classes (optional)', 'radium' ); ?><br />
							<input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
						</label>
					</p>
					
					<!-- Custom addition -->
					<?php
					$title = __('Menu Icon (optional)', 'radium');
					$key = "menu-item-radium-icon"; 
					$value = get_post_meta( $item->ID, '_'.$key, true);
					?>
					<p class="field-css-icon description description-thin">
						<label for="edit-menu-item-radium-icon-<?php echo $item_id; ?>">
							<?php echo $title; ?><br />
							<input type="text" id="edit-<?php echo $key.'-'.$item_id; ?>" class="widefat code edit-<?php echo $key.'-'.$item_id; ?>" name="<?php echo $key . "[". $item_id ."]";?>" value="<?php echo $value; ?>" />
						</label>
					</p>
					<!--End custom addition -->
					
					<p class="field-xfn description description-thin">
						<label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
							<?php _e( 'link Relationship (XFN)', 'radium' ); ?><br />
							<input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
						</label>
					</p>
					<p class="field-description description description-wide">
						<label for="edit-menu-item-description-<?php echo $item_id; ?>">
							<?php _e( 'Description', 'radium' ); ?><br />
							<textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->post_content ); ?></textarea>
						</label>
					</p>
					
					<div class='radium_mega_menu_options'>
					<!-- radium custom code here -->
						<?php
						$title = __('Disable the category megamenu', 'radium');
						$key = "menu-item-radium-cat-megamenu";
						$value = get_post_meta( $item->ID, '_'.$key, true);
						
						if($value != "") $value = "checked='checked'";
						?>
						
						<p class="description description-wide radium_checkbox radium_mega_menu radium_mega_menu_d4">
							<label for="edit-<?php echo $key.'-'.$item_id; ?>"><input type="checkbox" value="active" id="edit-<?php echo $key.'-'.$item_id; ?>" class=" <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>" <?php echo $value; ?> /><?php echo $title; ?></label>
						</p>
						<!-- end item  -->
						
					<!-- radium custom code here -->
						<?php
						$title = __('Make drop down a megamenu', 'radium');
						$key = "menu-item-radium-megamenu";
						$value = get_post_meta( $item->ID, '_'.$key, true);
						
						if($value != "") $value = "checked='checked'";
						?>
						
						<p class="description description-wide radium_checkbox radium_mega_menu radium_mega_menu_d0">
							<label for="edit-<?php echo $key.'-'.$item_id; ?>"><input type="checkbox" value="active" id="edit-<?php echo $key.'-'.$item_id; ?>" class=" <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>" <?php echo $value; ?> /><?php echo $title; ?></label>
						</p>
						<!-- end item  -->
					
						<?php
						$title = __('This column should start a new row', 'radium');
						$key = "menu-item-radium-division";
						$value = get_post_meta( $item->ID, '_'.$key, true);
						
						if($value != "") $value = "checked='checked'";
						?>
						
						<p class="description description-wide radium_checkbox radium_mega_menu radium_mega_menu_d1">
							<label for="edit-<?php echo $key.'-'.$item_id; ?>">
								<input type="checkbox" value="active" id="edit-<?php echo $key.'-'.$item_id; ?>" class=" <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>" <?php echo $value; ?> /><?php echo $title; ?>
							</label>
						</p>
						<!-- end item -->
						
						<?php
						$title = 'Use the description to create a Text Block. Don\'t display this item as a link. (note: don\'t remove the label text, otherwise WordPress will delete the item)';
						$key = "menu-item-radium-textarea";
						$value = get_post_meta( $item->ID, '_'.$key, true);
						
						if($value != "") $value = "checked='checked'";
						?>
						
						<p class="description description-wide radium_checkbox radium_mega_menu radium_mega_menu_d2">
							<label for="edit-<?php echo $key.'-'.$item_id; ?>">
								<input type="checkbox" value="active" id="edit-<?php echo $key.'-'.$item_id; ?>" class=" <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>" <?php echo $value; ?> /><span class='radium_long_desc'><?php echo $title; ?></span>
							</label>
						</p>
						<!-- /end item -->
					
					</div>
					<!-- end radium custom code here -->
				
					<div class="menu-item-actions description-wide submitbox">
						<?php if( 'custom' != $item->type ) : ?>
							<p class="link-to-original">
								<?php printf( __('Original: %s', 'radium'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
							</p>
						<?php endif; ?>
						<a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
						echo wp_nonce_url(
							esc_url( add_query_arg(
								array(
									'action' => 'delete-menu-item',
									'menu-item' => $item_id,
								),
								remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
							),
							'delete-menu_item_' . $item_id
						) ); ?>"><?php _e('Remove', 'radium'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php	echo esc_url ( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
							?>#menu-item-settings-<?php echo $item_id; ?>">Cancel</a>
					</div>
	
					<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
					<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
					<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
					<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
					<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
					<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
				</div><!-- .menu-item-settings-->
				<ul class="menu-item-transport"></ul>
			<?php
			$output .= ob_get_clean();
		}
	}

}


/**
 * This function is a clone of the admin-ajax.php files case:"add-menu-item" with modified walker. 
 * We call this function by hooking into wordpress generic "wp_".$_POST['action'] hook. 
 * To execute this script rather than the default add-menu-items a javascript overwrites default request with the request for this script
 */
if(!function_exists('radium_ajax_switch_menu_walker'))
{
	function radium_ajax_switch_menu_walker()
	{	
		if ( ! current_user_can( 'edit_theme_options' ) )
		die('-1');

		check_ajax_referer( 'add-menu_item', 'menu-settings-column-nonce' );
	
		require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
	
		$item_ids = wp_save_nav_menu_items( 0, $_POST['menu-item'] );
		if ( is_wp_error( $item_ids ) )
			die('-1');
	
		foreach ( (array) $item_ids as $menu_item_id ) {
			$menu_obj = get_post( $menu_item_id );
			if ( ! empty( $menu_obj->ID ) ) {
				$menu_obj = wp_setup_nav_menu_item( $menu_obj );
				$menu_obj->label = $menu_obj->title; // don't show "(pending)" in ajax-added items
				$menu_items[] = $menu_obj;
			}
		}
	
		if ( ! empty( $menu_items ) ) {
			$args = array(
				'after' => '',
				'before' => '',
				'link_after' => '',
				'link_before' => '',
				'walker' => new radium_backend_walker,
			);
			echo walk_nav_menu_tree( $menu_items, 0, (object) $args );
		}
		
		die('end');
	}
	
	//hook into wordpress admin.php
	add_action('wp_ajax_radium_ajax_switch_menu_walker', 'radium_ajax_switch_menu_walker');
}

add_filter( 'get_user_option_managenav-menuscolumnshidden', 'radium_nav_menus_columns_hidden' );
function radium_nav_menus_columns_hidden( $result ) {
	if ( is_array( $result ) && in_array( 'description', $result ) )
		unset( $result[ array_search( 'description', $result ) ] );
	return $result;
}

