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
class AffiliateCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'wxAffiliate';
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.affiliate';

    public function beforeSet() {
        $beforeSet = parent::beforeSet();
        $random = mt_rand(1000000,10000000);
        $affiliates = $this->modx->getCollection('wxAffiliate');
        $unique = TRUE;
        do {
            $unique = TRUE;
            foreach ($affiliates as $affiliate) {
                if($affiliate->code == $random) { 
                    $unique = FALSE;
                    $random = mt_rand(1000000,10000000);
                }
            }
        } while ($unique == FALSE);
        $this->setProperty('code',$random);
        return $beforeSet;
    }
 
    public function beforeSave() {
        $name = $this->getProperty('name');
        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('webinex.affiliate_err_ns_name'));
        }
        return parent::beforeSave();
    }
}
return 'AffiliateCreateProcessor';