<?php
class CompanyGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'wxCompany';
    public $languageTopics = array('webinex:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'webinex.company';
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $query = $this->getProperty('query');
        if (!empty($query)) {
            $c->where(array(
                'name:LIKE' => '%'.$query.'%',
                'OR:description:LIKE' => '%'.$query.'%',
            ));
        }
        return $c;
    }
}
return 'CompanyGetListProcessor';