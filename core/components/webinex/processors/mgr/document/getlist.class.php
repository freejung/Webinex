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
class DocumentGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'wxDocument';
    public $languageTopics = array('webinex:default');
    public $defaultSortField = 'title';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'webinex.document';
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $query = $this->getProperty('query');
        if (!empty($query)) {
            $c->where(array(
                'title:LIKE' => '%'.$query.'%',
                'OR:description:LIKE' => '%'.$query.'%',
                'OR:url:LIKE' => '%'.$query.'%',
            ));
        }
        return $c;
    }
}
return 'DocumentGetListProcessor';