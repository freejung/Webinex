<?php
class PresentationGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'wxPresentation';
    public $languageTopics = array('webinex:default');
    public $defaultSortField = 'eventdate';
    public $defaultSortDirection = 'DESC';
    public $objectType = 'webinex.Presentation';
    public function prepareQueryBeforeCount(xPDOQuery $c) {
       $query = $this->getProperty('wbn');
        if (!empty($query)) {
          $c->where(array(
                'webinar:=' => $query,
            ));
          
        }
        return $c;
    }
}
return 'PresentationGetListProcessor';