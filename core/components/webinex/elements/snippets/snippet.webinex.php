<?php

$webinex = $modx->getService('webinex','Webinex',$modx->getOption('webinex.core_path',null,$modx->getOption('core_path').'components/webinex/').'model/webinex/',$scriptProperties);
if (!($webinex instanceof Webinex)) return 'could not instantiate webinex';

/* setup default properties */
$tpl = $modx->getOption('tpl',$scriptProperties,'rowTpl');
$sort = $modx->getOption('sort',$scriptProperties,'eventdate');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
 
$output = '';

$m = $modx->getManager();
//$created = $m->createObjectContainer('wxPresentation');
//$created = $m->createObjectContainer('wxPresentedBy');
//$created = $m->createObjectContainer('wxAttachment');
//$created = $m->createObjectContainer('wxPresenter');
//$created = $m->createObjectContainer('wxCompany');
//$created = $m->createObjectContainer('wxDocument');
//$created = $m->createObjectContainer('vxVideo');
//$created = $m->createObjectContainer('wxEndorsement');
//$created = $m->createObjectContainer('wxDocument');
//$created = $m->createObjectContainer('wxAffiliate');

//$output = $created;
//$modx->addExtensionPackage('webinex',$modx->getOption('webinex.core_path','null','corepath').'model/');

//$modx->removeExtensionPackage('webinex);

return $output;