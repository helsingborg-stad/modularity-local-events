<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_607d3a43a526d',
    'title' => __('Event', 'modularity-local-events'),
    'fields' => array(
        0 => array(
            'key' => 'field_607e83e44b0e7',
            'label' => __('Date', 'modularity-local-events'),
            'name' => 'date',
            'type' => 'date_picker',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'display_format' => 'd-m-Y',
            'return_format' => 'Y-m-d',
            'first_day' => 1,
        ),
        1 => array(
            'key' => 'field_607ed2b654b8f',
            'label' => __('Start time', 'modularity-local-events'),
            'name' => 'start_time',
            'type' => 'time_picker',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'display_format' => 'H:i',
            'return_format' => 'H:i',
        ),
        2 => array(
            'key' => 'field_607ed2eb54b90',
            'label' => __('End time', 'modularity-local-events'),
            'name' => 'end_time',
            'type' => 'time_picker',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'display_format' => 'H:i',
            'return_format' => 'H:i',
        ),
        3 => array(
            'key' => 'field_608178daad186',
            'label' => __('Place', 'modularity-local-events'),
            'name' => 'place',
            'type' => 'text',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'local-events',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
));
}