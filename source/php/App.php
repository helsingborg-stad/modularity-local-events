<?php

namespace ModularityLocalEvents;

use ModularityLocalEvents\Helper\CacheBust;

class App
{

    private $postType = 'local-events'; 

    public function __construct()
    {
        add_action('plugins_loaded', array($this, 'registerModule'));
        
        new \ModularityLocalEvents\Entity\PostType(
            __('Local events', 'modularity-local-events'), 
            __('Local event', 'modularity-local-events'), 
            $this->postType, 
            array(
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
                    'slug' => 'event',
                    'with_front' => false
                ),
                'taxonomies' => array(),
                'supports' => array('title', 'revisions', 'editor')
            )
        );

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

        // Add view paths
        add_filter('Municipio/blade/view_paths', array($this, 'addViewPaths'), 1, 1);
        add_filter('Municipio/viewData', array($this, 'singleViewData')); 

        wp_register_style('modularity_local_event', MODULARITYLOCALEVENTS_URL . '/dist/'. CacheBust::name('css/modularity-local-events.css'), null, '1.0.0');
        wp_enqueue_style('modularity_local_event');
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

    /**
     * Add searchable blade template paths
     * @param array  $array Template paths
     * @return array        Modified template paths
     */
    public function addViewPaths($array)
    {
        // If child theme is active, insert plugin view path after child views path.
        if (is_child_theme()) {
            array_splice( $array, 2, 0, array(MODULARITYLOCALEVENTS_VIEW_PATH) );
        } else {
            // Add view path first in the list if child theme is not active.
            array_unshift($array, MODULARITYLOCALEVENTS_VIEW_PATH);
        }

        return $array;
    }

    /**
     * Add event data to single view
     * @param array $data Default view data
     * @return array Modified view data
     */
    public function singleViewData($data)
    {
        // Bail if not event
        if (get_post_type() !== $this->postType && !is_archive()) {
            return $data;
        }

        global $post;

        $event      = get_fields($post);
        $timestamp  = strtotime($event['date']);
        $year       = date("Y", $timestamp);

        $event['day']         = date("j", $timestamp);
        $event['monthShort']  = __(date("M", $timestamp), 'local-events');
        $event['month']       = __(date("F", $timestamp), 'local-events');

        $event['dateFormatted'] = "{$event['day']} {$event['month']} {$year}, {$event['start_time']} - {$event['end_time']}";
        $data['event'] = $event;

        return $data;
    }

}
