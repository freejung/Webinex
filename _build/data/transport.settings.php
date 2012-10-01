<?php

$settings = array();

$settings['webinex.first_template']= $modx->newObject('modSystemSetting');
$settings['webinex.first_template']->fromArray(array(
    'key' => 'webinex.first_template',
    'value' => 'wx-first.tpl',
    'xtype' => 'textfield',
    'namespace' => 'webinex',
    'area' => 'templates',
),'',true,true);

$settings['webinex.second_template']= $modx->newObject('modSystemSetting');
$settings['webinex.second_template']->fromArray(array(
    'key' => 'webinex.second_template',
    'value' => 'wx-second.tpl',
    'xtype' => 'textfield',
    'namespace' => 'webinex',
    'area' => 'templates',
),'',true,true);

$settings['webinex.third_template']= $modx->newObject('modSystemSetting');
$settings['webinex.third_template']->fromArray(array(
    'key' => 'webinex.third_template',
    'value' => 'wx-third.tpl',
    'xtype' => 'textfield',
    'namespace' => 'webinex',
    'area' => 'templates',
),'',true,true);

$settings['webinex.default_prospect_group']= $modx->newObject('modSystemSetting');
$settings['webinex.default_prospect_group']->fromArray(array(
    'key' => 'webinex.default_prospect_group',
    'value' => 'Prospects',
    'xtype' => 'textfield',
    'namespace' => 'webinex',
    'area' => 'groups',
),'',true,true);

$settings['webinex.registration_thanks_page']= $modx->newObject('modSystemSetting');
$settings['webinex.registration_thanks_page']->fromArray(array(
    'key' => 'webinex.registration_thanks_page',
    'value' => '1',
    'xtype' => 'textfield',
    'namespace' => 'webinex',
    'area' => 'pages',
),'',true,true);

$settings['webinex.ical_resource_id']= $modx->newObject('modSystemSetting');
$settings['webinex.ical_resource_id']->fromArray(array(
    'key' => 'webinex.ical_resource_id',
    'value' => '1',
    'xtype' => 'textfield',
    'namespace' => 'webinex',
    'area' => 'pages',
),'',true,true);

$settings['webinex.email_templates_category']= $modx->newObject('modSystemSetting');
$settings['webinex.email_templates_category']->fromArray(array(
    'key' => 'webinex.email_templates_category',
    'value' => 'Webinex Email Templates',
    'xtype' => 'textfield',
    'namespace' => 'webinex',
    'area' => 'templates',
),'',true,true);

return $settings;