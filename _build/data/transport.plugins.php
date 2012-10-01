<?php
/**
 * Package in plugins
 *
 * @package webinex
 * @subpackage build
 */
$plugins = array();

/* create the plugin object */
$plugins[0] = $modx->newObject('modPlugin');
$plugins[0]->set('id',1);
$plugins[0]->set('name','webinexOverThruster');
$plugins[0]->set('description','Pre-processes templates for webinar presentations.');
$plugins[0]->set('plugincode', getSnippetContent($sources['elements'] . 'plugins/plugin.webinexoverthruster.php'));
$plugins[0]->set('category', 0);

$events = include $sources['data'].'events/events.webinexoverthruster.php';
if (is_array($events) && !empty($events)) {
    $plugins[0]->addMany($events);
    $modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in '.count($events).' Plugin Events for webinexOverThruster.'); flush();
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not find plugin events for webinexOverThruster!');
}
unset($events);

return $plugins;