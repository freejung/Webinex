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
class AffiliateRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'wxAffiliate';
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.affiliate';
}
return 'AffiliateRemoveProcessor';