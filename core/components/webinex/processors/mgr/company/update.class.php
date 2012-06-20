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
class CompanyUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'wxCompany';
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.company';
}
return 'CompanyUpdateProcessor';