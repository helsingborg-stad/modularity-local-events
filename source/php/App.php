<?php

namespace ModularityLocalEvents;

use WpUtilService\Features\Enqueue\EnqueueManager;

class App
{
    private $postType = 'local-events';

    public function __construct(
        private EnqueueManager $wpEnqueue,
    ) {
        //Register module
        add_action('init', [$this, 'registerModule']);

        //Register post type
        new \ModularityLocalEvents\Entity\PostType(__('Local events', 'modularity-local-events'), __('Local event', 'modularity-local-events'), 'local-events', [
            'description' => __('Locally stored events', 'modularity-local-events'),
            'menu_icon' => 'dashicons-list-view',
            'public' => true,
            'publicly_queriable' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'has_archive' => true,
            'hierarchical' => false,
            'exclude_from_search' => false,
            'rewrite' => [
                'slug' => 'local-events',
                'with_front' => false,
            ],
            'taxonomies' => [],
            'supports' => ['title', 'revisions', 'editor'],
        ]);

        // Add view paths
        add_filter('Municipio/blade/view_paths', [$this, 'addViewPaths'], 1, 1);
        add_filter('Municipio/viewData', [$this, 'singleViewData']);
        add_filter('Municipio/Controller/Archive/getDate', [$this, 'getDate'], 10, 2);

        //Filter & order archive
        add_filter('pre_get_posts', [$this, 'archiveViewFilter']);

        //Add custom css
        $this->wpEnqueue->on('wp_enqueue_scripts')->add('css/modularity-local-events.css', [], '1.0.0');
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
                'LocalEvents',
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
            array_splice($array, 2, 0, [MODULARITYLOCALEVENTS_VIEW_PATH]);
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
        if (get_post_type() !== $this->postType || is_archive()) {
            return $data;
        }

        global $post;

        $dateHelper = new \Modularity\Helper\Date();

        $event = get_fields($post);
        $timestamp = $dateHelper->getTimeStamp($event['date']);

        $formattedDate = wp_date(
            $dateHelper->getDateFormat('date'),
            $timestamp,
        );

        $formattedStartTime = wp_date(
            $dateHelper->getDateFormat('time'),
            $dateHelper->getTimeStamp($event['start_time']),
        );

        $event['day'] = wp_date('j', $timestamp);
        $event['monthShort'] = wp_date('M', $timestamp);
        $event['dateFormatted'] = "{$formattedDate}, {$formattedStartTime}";

        if (!empty($event['end_time'])) {
            $formattedEndTime = wp_date(
                $dateHelper->getDateFormat('time'),
                $dateHelper->getTimeStamp($event['end_time']),
            );
            $event['dateFormatted'] .= " - {$formattedEndTime}";
        }

        $data['event'] = $event;

        return $data;
    }

    public function getDate($date, $post)
    {
        if ($post->postType === 'local-events') {
            $date = mysql2date('Y-m-d H:i:s', get_field('date', $post->id), true);
        }
        return $date;
    }

    /**
     * Filter & order items on the archive page
     *
     * @param WP_Query $query
     * @return WP_Query
     */
    public function archiveViewFilter($query)
    {
        if ($query->is_archive() && !is_admin() && $query->query['post_type'] == $this->postType) {
            $query->set('meta_query', [
                'date' => [
                    'key' => 'date',
                    'value' => date('Ymd'),
                    'compare' => '>=',
                    'type' => 'NUMERIC',
                ],
            ]);

            $query->set('orderby', [
                'date' => 'ASC',
                'start_time' => 'ASC',
            ]);
        }

        return $query;
    }
}
