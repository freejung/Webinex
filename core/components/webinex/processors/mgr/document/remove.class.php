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
class DocumentRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'wxDocument';
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.document';
}
return 'DocumentRemoveProcessor';