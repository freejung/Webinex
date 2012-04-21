<?php
class CompanyRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'wxCompany';
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.company';
}
return 'CompanyRemoveProcessor';