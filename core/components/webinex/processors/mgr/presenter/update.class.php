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
class PresenterUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'wxPresenter';
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.presenter';
}
return 'PresenterUpdateProcessor';