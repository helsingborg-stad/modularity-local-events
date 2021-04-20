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
        $data['sessions'] = $this->getSessions();
        $data['posts'] = $this->getPosts();
        $fields = json_decode(json_encode(get_fields($this)));
        
        return $data;
    }

    private function getPosts() {
        $args = [
            'post_type' => 'local-events',
            'numberposts' => 5,
            'order' => 'DESC'
        ];

        return get_posts($args);
    }


    private function getSessions(){
        $events = $this->getPosts();
        $sessions = [];

        foreach($events as $event) {
            $sessionField = get_field('sessions', $event->ID);            
            $tmp = [];
            
            foreach( $sessionField as $session ) {
                $tmp[] = $session['date'];
            }

            usort($tmp, [$this, "sortDate"]);

            $sessions[$event->ID] = $tmp[0];
        }

        return $sessions;        
    }

    private function sortDate($a, $b) {
        return strtotime($a) - strtotime($b);            
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
