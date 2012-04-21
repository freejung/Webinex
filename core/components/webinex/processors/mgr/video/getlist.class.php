<?php
class VideoGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'vxVideo';  
    public $languageTopics = array('webinex:default');
    public $defaultSortField = 'title';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'webinex.video';
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $query = $this->getProperty('query');
        if (!empty($query)) {
            $c->where(array(
                'title:LIKE' => '%'.$query.'%',
                'OR:description:LIKE' => '%'.$query.'%',
                'OR:url:LIKE' => '%'.$query.'%',
                'OR:hostid:LIKE' => '%'.$query.'%',
            ));
        }
        return $c;
    }
}
return 'VideoGetListProcessor';