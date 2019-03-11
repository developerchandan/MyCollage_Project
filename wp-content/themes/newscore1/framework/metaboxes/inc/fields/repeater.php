<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'RWMB_Repeater_Field' ) )
{
	class RWMB_Repeater_Field
	{

        /**
         * Add actions
         *
         * @return void
         */
        static function add_actions() {}

        /**
         * Enqueue scripts and styles
         *
         * @return void
         */
        static function admin_enqueue_scripts() {

            wp_enqueue_style( 'rwmb-repeater', RWMB_CSS_URL . 'repeater.css' );
            wp_enqueue_script( 'rwmb-repeater', RWMB_JS_URL . 'repeater.js', array( 'jquery' ), RWMB_VER, true );

            //The radium_framework_globals object contains information and settings about the framework
            wp_localize_script('rwmb-repeater', 'rwmb_repeater_globals', array(
                'min'    => __('Minimum Limit of {min} rows reached', 'radium'),
                'max'    => __('Maximum Limit of {max} rows reached', 'radium')
            )); //create globals for front-end AJAX calls;

        }

        /**
         * Show field HTML
         *
         * @param array $field
         * @param bool  $saved
         *
         * @return string
         */
        static function show( $field, $saved )
        {
            global $post;

            $meta = call_user_func( self::get_method_callback($field, 'meta' ), $post->ID, $saved, $field );

            $group = '';    // Empty the clone-group field
            $type = $field['type'];
            $id   = $field['id'];

            $begin = call_user_func( self::get_method_callback($field, 'begin_html' ), $meta, $field );

            // Apply filter to field begin HTML
            // 1st filter applies to all fields
            // 2nd filter applies to all fields with the same type
            // 3rd filter applies to current field only
            $begin = apply_filters( 'rwmb_begin_html', $begin, $field, $meta );
            $begin = apply_filters( "rwmb_{$type}_begin_html", $begin, $field, $meta );
            $begin = apply_filters( "rwmb_{$id}_begin_html", $begin, $field, $meta );

            // Separate code for cloneable and non-cloneable fields to make easy to maintain
           if ( isset( $field['clone-group'] ) )
               $group = " clone-group='{$field['clone-group']}'";

            $meta = !is_array( $meta ) ? (array) $meta : $meta ;

            $field_html = '';

            foreach ( $meta as $index => $sub_meta ) {

                $sub_field = $field;
                $sub_field['field_name'] = $field['field_name'] . "[{$index}][]";

                // Call separated methods for displaying each type of field
                $input_html = call_user_func( self::get_method_callback($field, 'html' ), $index, $sub_meta, $sub_field );

                // Apply filter to field HTML
                // 1st filter applies to all fields with the same type
                // 2nd filter applies to current field only
                $input_html = apply_filters( "rwmb_{$type}_html", $input_html, $field, $sub_meta );
                $input_html = apply_filters( "rwmb_{$id}_html", $input_html, $field, $sub_meta );

                $field_html .= $input_html;

           }

            $end = call_user_func( self::get_method_callback($field, 'end_html' ), $meta, $field );

            // Apply filter to field end HTML
            // 1st filter applies to all fields
            // 2nd filter applies to all fields with the same type
            // 3rd filter applies to current field only
            $end = apply_filters( 'rwmb_end_html', $end, $field, $meta );
            $end = apply_filters( "rwmb_{$type}_end_html", $end, $field, $meta );
            $end = apply_filters( "rwmb_{$id}_end_html", $end, $field, $meta );

            // Apply filter to field wrapper
            // This allow users to change whole HTML markup of the field wrapper (i.e. table row)
            // 1st filter applies to all fields with the same type
            // 2nd filter applies to current field only
            $html = apply_filters( "rwmb_{$type}_wrapper_html", "{$begin}{$field_html}{$end}", $field, $meta );
            $html = apply_filters( "rwmb_{$id}_wrapper_html", $html, $field, $meta );

            // Display label and input in DIV and allow user-defined classes to be appended
            $classes = array( 'rwmb-field', "rwmb-{$type}-wrapper" );

            if ( 'hidden' === $field['type'] )
                $classes[] = 'hidden';

            if ( !empty( $field['class'] ) )
                $classes[] = $field['class'];

            printf(
                $field['before'] . '<div class="%s"%s>%s</div>' . $field['after'],
                implode( ' ', $classes ),
                $group,
                $html
            );
        }

        /**
         * Get field HTML
         *
         * @param mixed  $meta
         * @param array  $field
         *
         * @return string
         */
        static function html( $index, $meta, $field )
        {

            $field_label = isset($meta['field_label']) ? $meta['field_label'] : '';

            $html = '<tr class="row" style="">
                        <td class="order">'. $index .'</td>
                        <td>
                            <div class="rwmb-input-wrap">
                                <input type="text" id="rwmb-field-' . $field['id'] . '_' . $index . '_field_label" class="text" name="' . $field['id'] . '[' . $index . '][field_label]" value="' . $field_label . '" placeholder="">
                            </div>
                        </td>
                        <td>
                            <select id="rwmb-field-field_'. $field['id'] . '_' . $index . '_field_text" class="select" name="'. $field['id'] . '[' . $index . '][field_text]">

                                '. self::options_html( $index, $field, $meta ) . '

                            </select>
                        </td>
                        <td class="remove">
                            <a class="rwmb-button-add add-row-before" href="javascript:;" style="margin-top: -22.5px;"></a>
                            <a class="rwmb-button-remove" href="javascript:;"></a>
                        </td>
                </tr>';

            return $html;
        }

        /**
         * Creates html for options
         *
         * @param array $field
         * @param mixed $meta
         *
         * @return array
         */
        static function options_html( $index, $field, $meta )
        {
            $html = '';

            //if ( $field['placeholder'] )
            //   $html = 'select' == $field['type'] ? "<option value=''>{$field['placeholder']}</option>" : '<option></option>';

            $option = '<option value="%s"%s>%s</option>';

            foreach ( $field['options'] as $value => $label )
            {
                $html .= sprintf(
                    $option,
                    $value,
                    selected( in_array( $value, (array) $meta ), true, false ),
                    $label
                );
            }

            return $html;
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

            $html = '<div class="rwmb-repeater-clone">
                        <div class="repeater" data-min_rows="1" data-max_rows="10">
                            <table class="widefat rwmb-input-table ">
                                <thead>
                                    <tr>
                                        <th class="order"></th>
                                        <th class="rwmb-th-score_label" width="60%">
                                            <span>Label</span>
                                            <span class="sub-field-instructions"></span>
                                        </th>
                                        <th class="rwmb-th-score_number" width="40%">
                                            <span>Score</span>
                                            <span class="sub-field-instructions"></span>
                                        </th>
                                    <th class="remove"></th>
                                </tr>
                            </thead>
                            <tbody class="ui-sortable" style="">';

            return $html;
        }

        /**
         * Show end HTML markup for fields
         *
         * @param mixed $meta
         * @param array $field
         *
         * @return string
         */
        static function end_html( $meta, $field )
        {

            $html = null;

            $id = $field['id'];

            $clone_html = '
                <tr class="row-repeater-clone">
                    <td class="order"></td>
                    <td>
                        <div class="rwmb-input-wrap">
                            <input type="text" id="rwmb-field-field_id_rwmbcloneindex_field_label" class="text" name="'. $field['id'] .'[rwmbcloneindex][field_label]" value="" placeholder="">
                        </div>
                    </td>
                    <td>
                        <select id="rwmb-field-field_id_rwmbcloneindex_field_text" class="select" name="'. $field['id'] .'[rwmbcloneindex][field_text]">
                            <option value="1" selected="selected">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </td>
                    <td class="remove">
                        <a class="rwmb-button-add add-row-before" href="javascript:;"></a>
                        <a class="rwmb-button-remove" href="javascript:;"></a>
                    </td>
                </tr>';

            // Closes the container
          $html .= $clone_html;

        $html .= '</tbody>
            </table>

            <ul class="hl clearfix repeater-footer">
                <li class="right">
                    <a href="javascript:;" class="add-row-end rwmb-button">Add Score Row</a>
                </li>
            </ul></div></div>';

            return $html;
        }

        /**
         * Get meta value
         *
         * @param int   $post_id
         * @param bool  $saved
         * @param array $field
         *
         * @return mixed
         */
        static function meta( $post_id, $saved, $field )
        {
            $meta = get_post_meta( $post_id, $field['id'], true );

            // Use $field['std'] only when the meta box hasn't been saved (i.e. the first time we run)
            $meta = ( !$saved && '' === $meta || array() === $meta ) ? $field['std'] : $meta;

            $meta = apply_filters( "rwmb_{$field['type']}_meta", $meta );
            $meta = apply_filters( "rwmb_{$field['id']}_meta", $meta );

            return $meta;
        }

        /**
         * Set value of meta before saving into database
         *
         * @param mixed $new
         * @param mixed $old
         * @param int   $post_id
         * @param array $field
         *
         * @return int
         */
        static function value( $new, $old, $post_id, $field )
        {
            return $new;
        }

        /**
         * Save meta value
         *
         * @param $new
         * @param $old
         * @param $post_id
         * @param $field
         */
        static function save( $new, $old, $post_id, $field )
        {

            $name = $field['id'];

            if ( '' === $new || array() === $new )
            {
                delete_post_meta( $post_id, $name );
                return;
            }

            $fields_array = array();

            foreach( $_POST[$name] as $k => $v ) {

                if ( $v['field_label'] ) { //check if a label is set else skip

                    $fields_array[] = array(
                        'field_text'   => $_POST[$name][$k]['field_text'],
                        'field_label'   => $_POST[$name][$k]['field_label'],
                    );

                }

            }

            unset( $fields_array['rwmbcloneindex'] );

            $new_value = $fields_array;

            update_post_meta( $post_id, $name, $new_value );

        }

        /**
         * Normalize parameters for field
         *
         * @param array $field
         *
         * @return array
         */
        static function normalize_field( $field )
        {

            /*$field = wp_parse_args( $field, array(
                'size'        => 30,
                'datalist'    => false,
                'placeholder' => '',
            ) );*/


            return $field;
        }
        
        /**
         * PHP 5.2 fallback
         *
         * @param array $field
         *
         * @return array
         */
        static function get_method_callback($field, $method)
        {
            if (version_compare(PHP_VERSION, '5.3') >= 0)
                return array(get_called_class(), $method);
            return array(RW_Meta_Box::get_class_name($field), $method);
        }

	}
}
