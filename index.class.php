<?php
/**
 * @package webinex
 * @subpackage controllers
 */
require_once dirname(__FILE__) . '/model/webinex/webinex.class.php';
abstract class WebinexManagerController extends modExtraManagerController {
    /** @var Webinex $webinex */
    public $webinex;
    public function initialize() {
        $this->webinex = new Webinex($this->modx);

        $this->addCss($this->webinex->config['cssUrl'].'mgr.css');
        $this->addJavascript($this->webinex->config['jsUrl'].'mgr/webinex.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            Webinex.config = '.$this->modx->toJSON($this->webinex->config).';
        });
        </script>');
        return parent::initialize();
    }
    public function getLanguageTopics() {
        return array('webinex:default');
    }
    public function checkPermissions() { return true;}
}
/**
 * @package webinex
 * @subpackage controllers
 */
class IndexManagerController extends WebinexManagerController {
    public static function getDefaultController() { return 'home'; }
}