<?php
/**
 * @package webinex
 * @subpackage controllers
 */
class WebinexHomeManagerController extends WebinexManagerController {
    public function process(array $scriptProperties = array()) {

    }
    public function getPageTitle() { return $this->modx->lexicon('webinex'); }
    public function loadCustomCssJs() {
        $this->addJavascript($this->webinex->config['jsUrl'].'mgr/widgets/presenters.grid.js');
        $this->addJavascript($this->webinex->config['jsUrl'].'mgr/widgets/documents.grid.js');
        $this->addJavascript($this->webinex->config['jsUrl'].'mgr/widgets/companies.grid.js');
        $this->addJavascript($this->webinex->config['jsUrl'].'mgr/widgets/affiliates.grid.js');
        $this->addJavascript($this->webinex->config['jsUrl'].'mgr/widgets/videos.grid.js');
        $this->addJavascript($this->webinex->config['jsUrl'].'mgr/widgets/home.panel.js');
        $this->addLastJavascript($this->webinex->config['jsUrl'].'mgr/sections/index.js');
    }
    public function getTemplateFile() { return $this->webinex->config['templatesPath'].'home.tpl'; }
}