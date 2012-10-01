<?php
/**
 * Webinex
 *
 * Copyright 2012 by Eli Snyder <freejung@gmail.com>
 */
/**
 * @package webinex
 * @subpackage model
 */
class wxPresentation extends xPDOSimpleObject {

    /* toFullArray returns an array of the presentation and related objects */
    /*
    * @param int $includeTVs
    * @param array $includeTVList
    * @param int $processTVs
    * @param array $processTVList
    * @param int $prepareTVs
    * @param array $prepareTVList
    * @param string $tvPrefix
    */
    public function toFullArray($includeTVs = false, $includeTVList = array(), $processTVs = false, $processTVList = array(), $prepareTVs = false, $prepareTVList = array(), $tvPrefix = 'tv.') {
        $presentationArray = $this->toArray();
        $webinarArray = array();
        $tvs = array();
        $templateVars = array();
        if (!empty($includeTVs) && !empty($includeTVList)) {
            $templateVars = $this->xpdo->getCollection('modTemplateVar', array('name:IN' => $includeTVList));
        }
        if($webinar = $this->getOne('Webinar')) {
            $webinarArray = $webinar->toArray('wbn.');
            if (!empty($includeTVs)) {
                if (empty($includeTVList)) {
                    $templateVars = $webinar->getMany('TemplateVars');
                }
                foreach ($templateVars as $tvId => $templateVar) {
                    if (!empty($includeTVList) && !in_array($templateVar->get('name'), $includeTVList)) continue;
                    if ($processTVs && (empty($processTVList) || in_array($templateVar->get('name'), $processTVList))) {
                        $tvs[$tvPrefix . $templateVar->get('name')] = $templateVar->renderOutput($webinar->get('id'));
                    } else {
                        $value = $templateVar->getValue($webinar->get('id'));
                        if ($prepareTVs && method_exists($templateVar, 'prepareOutput') && (empty($prepareTVList) || in_array($templateVar->get('name'), $prepareTVList))) {
                            $value = $templateVar->prepareOutput($value);
                        }
                        $tvs[$tvPrefix . $templateVar->get('name')] = $value;
                    }
                }
            }
        }
        $recordingArray = array();
        if($recording = $this->getOne('Recording')) {
            $recordingArray = $recording->toArray('rec.');
        }
        $trailerArray = array();
        if($trailer = $this->getOne('Trailer')) {
            $trailerArray = $trailer->toArray('tr.');
        }
        return array_merge($webinarArray, $presentationArray, $recordingArray, $trailerArray, $tvs);
    }

    /* setTemplates processes and stores the three default presentation templates */
    public function setTemplates() {
        $firstTpl = $this->xpdo->getOption('webinex.first_template',null,'wx-first.tpl');
        $secondTpl = $this->xpdo->getOption('webinex.second_template',null,'wx-second.tpl');
        $thirdTpl = $this->xpdo->getOption('webinex.third_template',null,'wx-third.tpl');
        if($webinar = $this->getOne('Webinar')) {
            if($webinar->published) {
                if($modx2 = new modX()) {
                    $modx2->initialize($webinar->get('context_key'));
                    $modx2->getService('error','error.modError');
                    $fullArray = $this->toFullArray(true, array(), true, array(), true, array());
                    $this->set('firsttpl', $modx2->getChunk($firstTpl, $fullArray));
                    $this->set('secondtpl', $modx2->getChunk($secondTpl, $fullArray));
                    $this->set('thirdtpl', $modx2->getChunk($thirdTpl, $fullArray));
                    return $this->save();
                }
            }
        }
        $this->set('firsttpl', '');
        $this->set('secondtpl', '');
        $this->set('thirdtpl', '');
        return $this->save();
    }
}