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
        $this->nameSingular = __("Local event", 'local-events');
        $this->namePlural = __("Local events", 'local-events');
        $this->description = __("Locally stored events", 'local-events');
    }

    /**
     * Data array
     * @return array $data
     */
    public function data() : array
    {
        $data = array();
        $fieldNamespace = 'mod_localevents_';
        
        //Map module data to camel case vars
        
        $data['events'] = $this->getPosts();
        $data['events'] = $this->formatEvents($data['events']);

        return $data;
    }

    private function getPosts() {
        $today = date('Ymd');
        $args = [
            'post_type' => 'local-events',
            'numberposts' => 5,
            'post_status' => 'publish',
            'meta_query' => array(array( 'key' => 'date', 'value' => $today, 'compare' => '>=' )),
            'meta_key' => 'date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC'
        ];

        return get_posts($args);
    }

    public function formatEvents($events) {
        foreach ($events as $key => $event) {
            $fields     = get_fields($event->ID);
            $timestamp  = strtotime($fields['date']);
            $year       = date("Y", $timestamp);

            $event->day         = date("j", $timestamp);
            $event->monthShort  = __(date("M", $timestamp), 'local-events');
            $event->month       = __(date("F", $timestamp), 'local-events');

            $event->dateFormatted = "{$event->day} {$event->month} {$year}, {$fields['start_time']} - {$fields['end_time']}";

            $events[$key] = $event;
        }

        return $events;
    }

    /**
     * Rename array item
     * @return array
     */
    private function renameArrayKey($from, $to, $array) {
        $array[$to] = $array[$from];
        unset($array[$from]);
        return $array; 
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
