<?php

/**
 * Plugin Name:       Modularity local events
 * Plugin URI:        (#plugin_url#)
 * Description:       A plugin for creating and displaying events locally on a site
 * Version:           1.0.0
 * Author:            Eric Rosenborg
 * Author URI:        (#plugin_author_url#)
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       mod-local-events
 * Domain Path:       /languages
 */

 // Protect agains direct file access
if (! defined('WPINC')) {
    die;
}

define('MODULARITYLOCALEVENTS_PATH', plugin_dir_path(__FILE__));
define('MODULARITYLOCALEVENTS_URL', plugins_url('', __FILE__));
define('MODULARITYLOCALEVENTS_TEMPLATE_PATH', MODULARITYLOCALEVENTS_PATH . 'templates/');
define('MODULARITYLOCALEVENTS_MODULE_VIEW_PATH', plugin_dir_path(__FILE__) . 'source/php/Module/views');
define('MODULARITYLOCALEVENTS_MODULE_PATH', MODULARITYLOCALEVENTS_PATH . 'source/php/Module/');

load_plugin_textdomain('modularity-local-events', false, plugin_basename(dirname(__FILE__)) . '/languages');

require_once MODULARITYLOCALEVENTS_PATH . 'source/php/Vendor/Psr4ClassLoader.php';
require_once MODULARITYLOCALEVENTS_PATH . 'Public.php';

// Instantiate and register the autoloader
$loader = new ModularityLocalEvents\Vendor\Psr4ClassLoader();
$loader->addPrefix('ModularityLocalEvents', MODULARITYLOCALEVENTS_PATH);
$loader->addPrefix('ModularityLocalEvents', MODULARITYLOCALEVENTS_PATH . 'source/php/');
$loader->register();

// Acf auto import and export
$acfExportManager = new \AcfExportManager\AcfExportManager();
$acfExportManager->setTextdomain('modularity-local-events');
$acfExportManager->setExportFolder(MODULARITYLOCALEVENTS_PATH . 'source/php/AcfFields/');
$acfExportManager->autoExport(array(
    'mod-local-events' => 'group_607d3a43a526d'
));
$acfExportManager->import();

// Modularity 3.0 ready - ViewPath for Component library
add_filter('/Modularity/externalViewPath', function ($arr) {
    $arr['mod-local-events'] = MODULARITYLOCALEVENTS_MODULE_VIEW_PATH;
    return $arr;
}, 10, 3);

// Start application
new ModularityLocalEvents\App();