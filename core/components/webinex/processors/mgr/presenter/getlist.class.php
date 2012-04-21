<?php
class PresenterGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'wxPresenter';
    public $languageTopics = array('webinex:default');
    public $defaultSortField = 'firstname';
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
}
return 'PresenterGetListProcessor';