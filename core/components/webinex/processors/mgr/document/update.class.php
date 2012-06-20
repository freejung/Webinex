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
class DocumentUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'wxDocument';
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.document';
}
return 'DocumentUpdateProcessor';