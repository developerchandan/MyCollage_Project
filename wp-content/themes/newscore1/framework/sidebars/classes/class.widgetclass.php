<?php
/*
 * This file is a part of the RadiumFramework core.
 * Please be extremely cautious editing this file,
 *
 * @category RadiumFramework
 * @package  Carlton WP
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 */

/**
 * This lets you add a custom class to each widget instance.
 * Useful when styling widgets
 *
 * @since 2.1.0
 *
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class Radium_WidgetClass {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {

		global $wp_version;

		add_filter('widget_form_callback', 		array($this, 'filter_widget_form_callback'), 10, 2);
		add_filter('widget_update_callback', 	array($this, 'filter_widget_update_callback'), 10, 2);
		add_filter('dynamic_sidebar_params', 	array($this, 'filter_dynamic_sidebar_params'));

	}

	/**
	 * filter widget form callback
	 *
	 * @access public
	 * @return string
	 */
	public function filter_widget_form_callback($instance, $widget) {

		if (!isset($instance['radium_widget_class']))
			$instance['radium_widget_class'] = null;
		?>

		<p>
		<label for='widget-<?php echo $widget->id_base?>-<?php echo $widget->number?>-radium_widget_class'><?php _e('Widget Class: ', 'radium') ?></label>
		<input type='text' name='widget-<?php echo $widget->id_base?>[<?php echo $widget->number?>][radium_widget_class]' id='widget-<?php echo $widget->id_base?>-<?php echo $widget->number?>-radium_widget_class' size='15' value='<?php echo $instance['radium_widget_class']?>'/>
		</p>

		<?php
		return $instance;

	}

	/**
	 * filter_dynamic_sidebar_params
	 *
	 * @access public
	 * @return string
	 */
	public function filter_widget_update_callback($instance, $new_instance) {

		$instance['radium_widget_class'] = $new_instance['radium_widget_class'];
		return $instance;

	}

	/**
		 * filter_dynamic_sidebar_params
		 *
	 * @access public
	 * @return string
	 */
	public function filter_dynamic_sidebar_params($params) {

		global $wp_registered_widgets;

		$widget_id = $params[0]['widget_id'];
		$widget = $wp_registered_widgets[$widget_id];

		if (!($widgetlogicfix = $widget['callback'][0]->option_name)) {
			# we do this because the Widget Logic plugin changes this structure
			$widgetlogicfix = $widget['callback_wl_redirect'][0]->option_name;
		}

		$option_name = get_option($widgetlogicfix);

		$number = $widget['params'][0]['number'];

		if (isset($option_name[$number]['radium_widget_class']) && !empty($option_name[$number]['radium_widget_class'])) {
			# add our class to the start of the existing class declaration
			
			$custom_class = strtolower($option_name[$number]['radium_widget_class']);
			
			$params[0]['before_widget'] = preg_replace('/class="/', "class=\"{$custom_class} custom-class ", $params[0]['before_widget'], 1);
		}

		return $params;

	}

}
