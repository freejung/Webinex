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
class PresenterGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'wxPresenter';
    public $languageTopics = array('webinex:default');
    public $defaultSortField = 'lastname';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'webinex.presenter';
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $query = $this->getProperty('query');
        if (!empty($query)) {
            $c->where(array(
                'firstname:LIKE' => '%'.$query.'%',
                'OR:lastname:LIKE' => '%'.$query.'%',
                'OR:title:LIKE' => '%'.$query.'%',
                'OR:company:LIKE' => '%'.$query.'%',
            ));
        }
        return $c;
    }
    public function prepareRow(xPDOObject $object) {
    	$output = $object->toArray();
    	$output['fullname'] = $output['firstname'] . ' ' . $output['lastname'];
        return $output;
    }
}
return 'PresenterGetListProcessor';