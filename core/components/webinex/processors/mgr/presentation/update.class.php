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
class PresentationUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'wxPresentation';
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.Presentation';
}
return 'PresentationUpdateProcessor';