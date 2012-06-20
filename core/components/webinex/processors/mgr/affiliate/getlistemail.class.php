<?php
class AffiliateGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'wxAffiliate';
    public $languageTopics = array('webinex:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'webinex.affiliate';
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
    public function afterIteration(array $list) {
        array_unshift($list, array(
            'id' => 0,
            'name' => 'None',
        ));
        return $list;
    }
}
return 'AffiliateGetListProcessor';