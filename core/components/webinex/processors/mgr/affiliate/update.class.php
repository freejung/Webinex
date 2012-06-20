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
class AffiliateUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'wxAffiliate';
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.affiliate';
}
return 'AffiliateUpdateProcessor';