<?php

namespace ModularityLocalEvents;

class App
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueueStyles'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));
    }

    /**
     * Enqueue required style
     * @return void
     */
    public function enqueueStyles()
    {
        wp_register_style('mod-local-events-css', MODULARITYLOCALEVENTS_URL . '/dist/' . \ModularityLocalEvents\Helper\CacheBust::name('css/mod-local-events.css'));
    }

    /**
     * Enqueue required scripts
     * @return void
     */
    public function enqueueScripts()
    {
        wp_register_script('mod-local-events-js', MODULARITYLOCALEVENTS_URL . '/dist/' . \ModularityLocalEvents\Helper\CacheBust::name('js/mod-local-events.js'));
    }
}
