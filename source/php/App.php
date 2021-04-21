<?php

namespace ModularityLocalEvents;

class App
{
    public function __construct()
    {
        add_action('plugins_loaded', array($this, 'registerModule'));
        
        $postType = new \ModularityLocalEvents\Entity\PostType(__('Local events', 'modularity-local-events'), __('Local event', 'modularity-local-events'), 'local-events', array(
            'description' => __('Locally stored events', 'modularity-local-events'),
            'menu_icon' => 'dashicons-list-view',
            'public' => true,
            'publicly_queriable' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'has_archive' => true,
            'hierarchical' => false,
            'exclude_from_search' => false,
            'rewrite' => array(
                'slug' => 'lokala evenemang',
                'with_front' => false
            ),
            'taxonomies' => array(),
            'supports' => array('title', 'revisions', 'editor')
        ));

       /*  $postType->addTableColumn(
            'occasion',
            __('Occasion', 'local-events'),
            false,
            function ($columnKey, $postId) {
                $occasions = $this->getPostOccasions($postId);
                if (!$occasions) {
                    return;
                }
                echo($occasions);
            }
        ); */

    }

    /**
     * Register the module
     * @return void
     */
    public function registerModule()
    {
        if (function_exists('modularity_register_module')) {
            modularity_register_module(
                MODULARITYLOCALEVENTS_MODULE_PATH,
                'LocalEvents'
            );
        }
    }
}
