<?php

namespace ModularityLocalEvents;

use ModularityLocalEvents\Helper\CacheBust;

class App
{

    private $postType = 'local-events';

    public function __construct()
    {
        //Register module
        add_action('plugins_loaded', array($this, 'registerModule'));

        //Register post type
        new \ModularityLocalEvents\Entity\PostType(__('Local events', 'modularity-local-events'), __('Local event', 'modularity-local-events'), 'local-events', array(
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
                'slug' => 'local-events',
                'with_front' => false
            ),
            'taxonomies' => array(),
            'supports' => array('title', 'revisions', 'editor')
        ));

        // Add view paths
        add_filter('Municipio/blade/view_paths', array($this, 'addViewPaths'), 1, 1);
        add_filter('Municipio/viewData', array($this, 'singleViewData')); 
        add_filter('Municipio/Controller/Archive/Data', array($this, 'archiveViewData'));

        //Filter & order archive
        add_filter('pre_get_posts', array($this, 'archiveViewFilter'));

        //Add custom css
        wp_register_style('modularity_local_event', MODULARITYLOCALEVENTS_URL . '/dist/' . CacheBust::name('css/modularity-local-events.css'), null, '1.0.0');
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
        $timestamp  = \Modularity\Helper\Date::getTimeStamp($event['date']);

        $formattedDate = wp_date(\Modularity\Helper\Date::getDateFormat('date'), $timestamp); 
        $formattedStartTime = wp_date(\Modularity\Helper\Date::getDateFormat('time'), \Modularity\Helper\Date::getTimeStamp($event['start_time']));          

        $event['day']         = wp_date("j", $timestamp);
        $event['monthShort']  = wp_date("M", $timestamp);
        $event['dateFormatted'] = "{$formattedDate}, {$formattedStartTime}";

        if($event['end_time']) {
            $formattedEndTime = wp_date(\Modularity\Helper\Date::getDateFormat('time'), \Modularity\Helper\Date::getTimeStamp($event['end_time'])); 
            $event['dateFormatted'] = $event['dateFormatted']. " - {$formattedEndTime}";            
        }

        $data['event'] = $event;

        return $data;
    }

    /**
     * Add data to archive view
     *
     * @param [type] $data
     * @return void
     */
    public function archiveViewData($data) {

        if(isset($data['posts']) && is_array($data['posts']) && !empty($data['posts'])) {
            foreach($data['posts'] as &$post) {
                $eventDate = mysql2date('D d M Y', get_field('date', $post->id), true);
                $startTime = get_field('start_time', $post->id);

                if($post->postType === 'local-events') {
                    $post->startDate = $eventDate . ' ' . $startTime;
                }
            }
        }

        return $data;
    }

    /**
     * Filter & order items on the archive page 
     *
     * @param WP_Query $query
     * @return WP_Query
     */
    public function archiveViewFilter($query) {

        if($query->is_archive() && !is_admin() && $query->query['post_type'] == $this->postType) {
            $query->set('meta_query', 
                array(
                    'date' => array(
                        'key' => 'date', 
                        'value' => date('Ymd'), 
                        'compare' => '>=',
                        'type' => 'NUMERIC'
                    )
                )
            ); 

            $query->set('orderby', array(
                'date' => 'ASC',
                'start_time' => 'ASC'
            )); 
        }
        
        return $query;
    }

}
