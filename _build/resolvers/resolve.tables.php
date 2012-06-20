<?php
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;
            $modelPath = $modx->getOption('webinex.core_path',null,$modx->getOption('core_path').'components/webinex/').'model/';
            $modx->addPackage('webinex',$modelPath);
 
            $manager = $modx->getManager();
 
            $manager->createObjectContainer('wxPresentation');
            $manager->createObjectContainer('wxPresenter');
            $manager->createObjectContainer('wxCompany');
            $manager->createObjectContainer('wxDocument');
            $manager->createObjectContainer('vxVideo');
            $manager->createObjectContainer('wxPresentedBy');
			$manager->createObjectContainer('wxAttachment');
			$manager->createObjectContainer('wxAffiliate');
			$manager->createObjectContainer('wxEndorsement');
			$manager->createObjectContainer('wxReferral');
			$manager->createObjectContainer('wxRegistration');
 
            break;
        case xPDOTransport::ACTION_UPGRADE:
            break;
    }
}
return true;