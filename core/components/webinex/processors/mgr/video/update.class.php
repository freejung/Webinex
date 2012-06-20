<?php
/**
 * Webinex
 *
 * Copyright 2012 by Eli Snyder <freejung@gmail.com>
 */
/**
 * @package webinex
 * @subpackage processors
 */
class VideoUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'vxVideo';  
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.video';
}
return 'VideoUpdateProcessor';