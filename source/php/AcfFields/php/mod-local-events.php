<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_607d3a43a526d',
    'title' => __('Dates', 'event-manager'),
    'fields' => array(
        0 => array(
            'key' => 'field_607e83e44b0e7',
            'label' => __('Date', 'event-manager'),
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
            'return_format' => 'd-m-Y',
            'first_day' => 1,
        ),
        1 => array(
            'key' => 'field_607ed2b654b8f',
            'label' => __('Start time', 'event-manager'),
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
            'label' => __('End time', 'event-manager'),
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