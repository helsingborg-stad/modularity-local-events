<?php

namespace ModularityLocalEvents\Module;



/**
 * Class LocalEvents
 * @package ModularityContact\Module
 */
class LocalEvents extends \Modularity\Module
{
    public $slug = 'local-events';
    public $supports = array();

    public function init()
    {
        $this->nameSingular = __("Local event", 'modularity-local-events');
        $this->namePlural = __("Local events", 'modularity-local-events');
        $this->description = __("Locally stored events", 'modularity-local-events');
    }

    /**
     * Data array
     * @return array $data
     */
    public function data() : array
    {
        $data = array();
        $fields = get_fields();

        $data['archiveLink']            = get_post_type_archive_link('local-events');

        $eventStack                     = $this->getPosts($fields['number_of_events'] ?? 5);
        $data['events']                 = $this->formatEvents($eventStack['posts']);
        $data['totalEvents']            = $eventStack['postcount']; 

        //Translations
        $data['lang'] = (object) array(
            'moreEvents' => __('More events', 'modularity-local-events'),
            'noEvents' => __("No coming events", 'modularity-local-events')
        ); 

        return $data;
    }

    /**
     * Get the posts to show, include max number of posts that can be fetched
     *
     * @param integer $numberOfEvents   The maximum number of items to fetch
     * @return array                    Posts array including maimum number of matching items
     */
    private function getPosts($numberOfEvents = 5) {

        $query = new \WP_Query(array(
            'post_type' => 'local-events',
            'posts_per_page' => $numberOfEvents,
            'post_status' => 'publish',
            'meta_query' => array(array( 'key' => 'date', 'value' => date('Ymd'), 'compare' => '>=' )),
            'meta_key' => 'date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'suppress_filters' => true
        ));

        if(!is_wp_error($query)) {
            return [
                'postcount' => $query->found_posts,
                'posts' => $query->posts
            ];
        }

        return false; 
    }

    /**
     * Format event array
     *
     * @param array $events
     * @return array
     */
    public function formatEvents($events) {

        if(is_array($events) && !empty($events)) {

            foreach ($events as $key => $event) {

                $fields     = get_fields($event->ID);
                $timestamp  = \Modularity\Helper\Date::getTimeStamp($fields['date']);

                $formattedDate = wp_date(\Modularity\Helper\Date::getDateFormat('date'), $timestamp); 
                $formattedStartTime = wp_date(\Modularity\Helper\Date::getDateFormat('time'), \Modularity\Helper\Date::getTimeStamp($fields['start_time']));  
    
                $event->day         = wp_date("j", $timestamp);
                $event->monthShort  = wp_date("M", $timestamp);
                $event->link        = get_permalink($event->ID);
                $event->dateFormatted = "{$formattedDate}, {$formattedStartTime}";
    
                if($fields['end_time']) {
                    $formattedEndTime = wp_date(\Modularity\Helper\Date::getDateFormat('time'), \Modularity\Helper\Date::getTimeStamp($fields['end_time'])); 
                    $event->dateFormatted = $event->dateFormatted . " - {$formattedEndTime}";
                }
    
                $events[$key] = $event;
            }
        }

        return $events;
    }

    /**
     * Blade Template
     * @return string
     */
    public function template() : string
    {
        return "local-events.blade.php";
    }

    /**
     * Style - Register & adding css
     * @return void
     */
    public function style()
    {
        
    }

    /**
     * Available "magic" methods for modules:
     * init()            What to do on initialization
     * data()            Use to send data to view (return array)
     * style()           Enqueue style only when module is used on page
     * script            Enqueue script only when module is used on page
     * adminEnqueue()    Enqueue scripts for the module edit/add page in admin
     * template()        Return the view template (blade) the module should use when displayed
     */
}
