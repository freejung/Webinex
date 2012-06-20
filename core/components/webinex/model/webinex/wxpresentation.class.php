<?php
class wxPresentation extends xPDOSimpleObject {

    /* toFullArray returns an array of the presentation and related objects */
    public function toFullArray() {
        $presentationArray = $this->toArray();
        $webinarArray = array();
        if($webinar = $this->getOne('Webinar')) {
            $webinarArray = $webinar->toArray('wbn.');
        }
        $recordingArray = array();
        if($recording = $this->getOne('Recording')) {
            $recordingArray = $recording->toArray('rec.');
        }
        $trailerArray = array();
        if($trailer = $this->getOne('Trailer')) {
            $trailerArray = $trailer->toArray('tr.');
        }
        return array_merge($webinarArray, $presentationArray, $recordingArray, $trailerArray);
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
	                $fullArray = $this->toFullArray();
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