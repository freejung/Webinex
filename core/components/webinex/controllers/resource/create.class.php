<?php
require_once dirname(__FILE__) . '/../../model/webinex/webinex.class.php';
class wxWebinarCreateManagerController extends ResourceCreateManagerController {
    public function getLanguageTopics() {
        return array('resource','webinex:default');
    }
    public function initialize() {
        $this->webinex = new Webinex($this->modx);
        return parent::initialize();
    }
    public function loadCustomCssJs() {
        $mgrUrl = $this->modx->getOption('manager_url',null,MODX_MANAGER_URL);
        $this->addJavascript($mgrUrl.'assets/modext/util/datetime.js');
        $this->addJavascript($mgrUrl.'assets/modext/widgets/element/modx.panel.tv.renders.js');
        $this->addJavascript($mgrUrl.'assets/modext/widgets/resource/modx.grid.resource.security.local.js');
        $this->addJavascript($mgrUrl.'assets/modext/widgets/resource/modx.panel.resource.tv.js');
        $this->addJavascript($mgrUrl.'assets/modext/widgets/resource/modx.panel.resource.js');
        $this->addJavascript($mgrUrl.'assets/modext/sections/resource/create.js');
        $this->addJavascript($this->modx->getOption('webinex.assets_url','null',$this->modx->getOption('assets_url','null','/assets/').'components/webinex/').'js/mgr/webinex.js');
        $this->addJavascript($this->modx->getOption('webinex.assets_url','null',$this->modx->getOption('assets_url','null','/assets/').'components/webinex/').'js/mgr/resource/create.js');        
        
        $this->resourceArray['template'] = $this->modx->getOption('webinex.default_webinar_template','null',0);
        $this->addHtml('
        <script type="text/javascript">
        // <![CDATA[
        MODx.config.publish_document = "'.$this->canPublish.'";
        MODx.onDocFormRender = "'.$this->onDocFormRender.'";
        MODx.ctx = "'.$this->ctx.'";
        Ext.onReady(function() {
        	   Webinex.config = '.$this->modx->toJSON($this->webinex->config).';
            MODx.load({
                xtype: "webinex-page-webinar-create"
                ,record: '.$this->modx->toJSON($this->resourceArray).'
                ,publish_document: "'.$this->canPublish.'"
                ,canSave: "'.($this->modx->hasPermission('save_document') ? 1 : 0).'"
                ,show_tvs: '.(!empty($this->tvCounts) ? 1 : 0).'
                ,mode: "create"
            });
        });
        // ]]>
        </script>');
        /* load RTE */
        $this->loadRichTextEditor();
       
    }
}