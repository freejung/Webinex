<?php
$properties = array(
    array(
        'name' => 'tpl',
        'desc' => 'prop_webinex.tpl_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'wx-presentations.tpl',
        'lexicon' => 'webinex:properties',
    ),
    array(
        'name' => 'sort',
        'desc' => 'prop_webinex.sort_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'eventdate',
        'lexicon' => 'webinex:properties',
    ),
    array(
        'name' => 'dir',
        'desc' => 'prop_webinex.dir_desc',
        'type' => 'list',
        'options' => array(
            array('text' => 'prop_webinex.ascending','value' => 'ASC'),
            array('text' => 'prop_webinex.descending','value' => 'DESC'),
        ),
        'value' => 'ASC',
        'lexicon' => 'webinex:properties',
    ),
    array(
        'name' => 'dateFormat',
        'desc' => 'prop_webinex.dateFormat_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'l F j, Y',
        'lexicon' => 'webinex:properties',
    ),
    array(
        'name' => 'timeFormat',
        'desc' => 'prop_webinex.timeFormat_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'g:ia',
        'lexicon' => 'webinex:properties',
    ),
    array(
        'name' => 'where',
        'desc' => 'prop_webinex.where_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '{}',
        'lexicon' => 'webinex:properties',
    ),
    array(
        'name' => 'parents',
        'desc' => 'prop_webinex.parents_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '0',
        'lexicon' => 'webinex:properties',
    ),
);
return $properties;