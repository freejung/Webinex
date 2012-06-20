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
class CompanyRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'wxCompany';
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.company';
}
return 'CompanyRemoveProcessor';