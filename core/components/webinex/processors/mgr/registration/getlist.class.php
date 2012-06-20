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
class RegistrationGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'wxRegistration';  
    public $languageTopics = array('webinex:default');
    public $defaultSortField = 'createdon';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'webinex.registration';
    public function prepareQueryBeforeCount(xPDOQuery $c) { 
        $presentation = $this->getProperty('presentation');
        if (!empty($presentation)) {
            $c->where(array(
                'presentation:=' => $presentation,
            ));
        }
        return $c;
    }
    
    public function prepareRow(xPDOObject $object) {
        $registrationArray = $object->toArray();
        $registrationArray['createdon'] = date($this->modx->getOption('manager_date_format',NULL,'m-d-y').' '.$this->modx->getOption('manager_time_format',NULL,'h:m:s'), strtotime($registrationArray['createdon']));
        //get values from associated prospect and referrer
        $profileArray = array();
        if($prospect = $object->getOne('Prospect')) {
            if($profile = $prospect->getOne('Profile')) {
                $profileArray = $profile->toArray();
            }
        }
        $referrer = array();
        if($referral = $object->getOne('Referral')) {
            $affiliate = $referral->getOne('Affiliate');
            $referrer = array(
                'referrer' => $affiliate->get('name'),
            );
        }
        return array_merge($referrer, $profileArray, $registrationArray);
    }
    
    public function afterIteration(array $list) {
        $all = $this->getProperty('all');
        if($all) {
            return $list;
        }else{
            //dedup by email address, keeping any referrers
            $uniqueRows = array();
            $output = array();
            foreach ($list as $row) {
                $uniqueRow = $row;
                $email = $row['email'];
                foreach ($list as $anotherRow) {
                    if ($email == $anotherRow['email']) {
                        if (empty($row['referrer'])) {
                            $uniqueRow = array_merge($row, $anotherRow);
                        }else{
                            $uniqueRow = array_merge($anotherRow, $row);
                        }
                    }
                }
                if(!empty($uniqueRow['referrer'])){
                    $uniqueRows[$email] = $uniqueRow;
                }else{
                    if(empty($uniqueRows[$email])){
                        $uniqueRows[$email] = $uniqueRow;
                    }else{
                        $uniqueRows[$email] = array_merge($uniqueRow,$uniqueRows[$email]);
                    }
                }
            }
            foreach($uniqueRows as $row) {
                $output[]=$row;
            }
            return $output;
        }
    }
}
return 'RegistrationGetListProcessor';