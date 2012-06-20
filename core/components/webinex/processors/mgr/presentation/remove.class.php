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
class PresentationRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'wxPresentation';
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.Presentation';
}
return 'PresentationRemoveProcessor';