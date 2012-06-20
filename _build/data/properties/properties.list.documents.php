<?php
$properties = array(
    array(
        'name' => 'tpl',
        'desc' => 'prop_webinex.tpl_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'wx-documents.tpl',
        'lexicon' => 'webinex:properties',
    ),
    array(
        'name' => 'sort',
        'desc' => 'prop_webinex.sort_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'title',
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
        'value' => 'DESC',
        'lexicon' => 'webinex:properties',
    ),
    array(
        'name' => 'presentation',
        'desc' => 'prop_webinex.presentation_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '0',
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
        'name' => 'limit',
        'desc' => 'prop_webinex.limit_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '0',
        'lexicon' => 'webinex:properties',
    ),
    array(
        'name' => 'offset',
        'desc' => 'prop_webinex.offset_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '0',
        'lexicon' => 'webinex:properties',
    ),
);
return $properties;