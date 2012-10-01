<?php
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            /** @var modX $modx */
            $modx =& $object->xpdo;
            $modelPath = $modx->getOption('webinex.core_path');
            if (empty($modelPath)) {
                $modelPath = '[[++core_path]]components/webinex/';
            }
            $modelPath = rtrim($modelPath,'/').'/model/';
            if ($modx instanceof modX) {
                $modx->addExtensionPackage('webinex',$modelPath);
            }
            break;
        case xPDOTransport::ACTION_UNINSTALL:
            $modx =& $object->xpdo;
            if ($modx instanceof modX) {
                $modx->removeExtensionPackage('webinex');
            }
            break;
    }
}
return true;