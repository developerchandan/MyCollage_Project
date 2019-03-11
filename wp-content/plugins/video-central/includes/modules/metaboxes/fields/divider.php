<?php
/**
 * Divider field class.
 */
class Video_Central_Metaboxes_Divider_Field extends Video_Central_Metaboxes_Field {

	/**
	 * Enqueue scripts and styles
	 *
	 * @return void
	 */
	static function admin_enqueue_scripts() {
		wp_enqueue_style( 'video-central-metaboxes-divider', Video_Central_Metaboxes_CSS_URL . 'divider.css', array(), Video_Central_Metaboxes_VER );
	}

	/**
	 * Show begin HTML markup for fields
	 *
	 * @param mixed $meta
	 * @param array $field
	 *
	 * @return string
	 */
	static function begin_html( $meta, $field ) {
		$attributes = empty( $field['id'] ) ? '' : " id='{$field['id']}'";
		return "<hr$attributes>";
	}

	/**
	 * Show end HTML markup for fields
	 *
	 * @param mixed $meta
	 * @param array $field
	 *
	 * @return string
	 */
	static function end_html( $meta, $field ) {
		return '';
	}
}
