<?php
$webinex = $modx->getService('webinex','Webinex',$modx->getOption('webinex.core_path',null,$modx->getOption('core_path').'components/webinex/').'model/webinex/',$scriptProperties);
if (!($webinex instanceof Webinex)) return 'could not instantiate Webinex';

/* setup default properties */
$tpl = $modx->getOption('tpl',$scriptProperties,'rowTpl');
$sort = $modx->getOption('sort',$scriptProperties,'eventdate');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$dateFormat = $modx->getOption('dateFormat',$scriptProperties,'l F j, Y');
$timeFormat = $modx->getOption('timeFormat',$scriptProperties,'g:ia');

/* build query */
$c = $modx->newQuery('wxPresentation');
$c->sortby($sort,$dir);
$c->where(array(
    'eventdate:>=' => date('Y-m-d H:i:s',time()),
));
$presentations = $modx->getCollection('wxPresentation',$c);
 
/* iterate */
$output = '';
$previousWebinarIds = array();

foreach ($presentations as $presentation) {
    $webinar = $presentation->getOne('Webinar');
    $thisWebinarId = $webinar->get('id');
    /*return the soonest presentation, and only published webinars*/
    if(!in_array($thisWebinarId, $previousWebinarIds) && $webinar->get('published')){
        $presentationArray = $presentation->toArray();
        $eventdate = $presentationArray[eventdate];
        $presentationArray[eventdate] = date($dateFormat, strtotime($eventdate));
        $presentationArray[starttime] = date($timeFormat, strtotime($eventdate));
        $webinarArray = $webinar->toArray();
        
        $output .= $webinex->getChunk($tpl,array_merge($presentationArray,$webinarArray));
    }
    $previousWebinarIds[] = $thisWebinarId;
}
 
return $output;