<?php 

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_6153072da2c66',
	'title' => 'Display local events',
	'fields' => array(
		array(
			'key' => 'field_6153077c29c67',
			'label' => __('Number of events', 'modularity-local-events'),
			'name' => 'number_of_events',
			'type' => 'number',
			'instructions' => 'The number of events to display in the module/block.',
			'required' => 0,
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
			'min' => '',
			'max' => '',
			'step' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'mod-local-events',
			),
		),
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/local-events',
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

endif;