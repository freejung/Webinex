<?php
require_once dirname(__FILE__) . '/../../model/webinex/webinex.class.php';
class wxWebinarUpdateManagerController extends ResourceUpdateManagerController {
	 public $webinex;
    public function initialize() {
        $this->webinex = new Webinex($this->modx);
        return parent::initialize();
    }
    public function getLanguageTopics() {
        return array('resource','webinex:default');
    }
    public function loadCustomCssJs() {
        $managerUrl = $this->context->getOption('manager_url', MODX_MANAGER_URL, $this->modx->_userConfig);
        $this->addJavascript($managerUrl.'assets/modext/util/datetime.js');
        $this->addJavascript($managerUrl.'assets/modext/widgets/element/modx.panel.tv.renders.js');
        $this->addJavascript($managerUrl.'assets/modext/widgets/resource/modx.grid.resource.security.local.js');
        $this->addJavascript($managerUrl.'assets/modext/widgets/resource/modx.panel.resource.tv.js');
        $this->addJavascript($managerUrl.'assets/modext/widgets/resource/modx.panel.resource.js');
        $this->addJavascript($managerUrl.'assets/modext/sections/resource/update.js');
        $this->addJavascript($this->modx->getOption('webinex.assets_url','null',$this->modx->getOption('assets_url','null','/assets/').'components/webinex/').'js/mgr/webinex.js');
        $this->addJavascript($this->modx->getOption('webinex.assets_url','null',$this->modx->getOption('assets_url','null','/assets/').'components/webinex/').'js/mgr/widgets/registrations.grid.js');
        $this->addJavascript($this->modx->getOption('webinex.assets_url','null',$this->modx->getOption('assets_url','null','/assets/').'components/webinex/').'js/mgr/resource/update.js');

        $fullResourceArray = array();
        $primaryPresentationArray = array();
        if($primaryPresentation = $this->resource->primaryPresentation()){
        	   $primaryPresentationId = $primaryPresentation->get('id');
            $primaryPresentationArray = $primaryPresentation->toArray();
            $primaryPresentationArray['presentation'] = $primaryPresentationId;
            $presentedByArray = $primaryPresentation->getMany('PresentedBy');
            if(!empty($presentedByArray)) {
                $presenterIds = array();
                foreach($presentedByArray as $presentedBy) {
                	  $thisPresenter = $presentedBy->getOne('Presenter');
                    $presenterIds[] = $thisPresenter->get('id');
                }
                $presenterString = implode(',', $presenterIds);
                $primaryPresentationArray['presenter'] = $presenterString;
            }
            $attachmentArray = $primaryPresentation->getMany('Attachment');
            if(!empty($attachmentArray)) {
                $documentIds = array();
                foreach($attachmentArray as $attachment) {
                	  $thisDocument = $attachment->getOne('Document');
                    $documentIds[] = $thisDocument->get('id');
                }
                $documentString = implode(',', $documentIds);
                $primaryPresentationArray['document'] = $documentString;
            }
        } 
        $fullResourceArray = array_merge($primaryPresentationArray, $this->resourceArray);
        
        $emailTemplatesArray = array();
        $emailTemplatesCategory = $this->modx->getObject('modCategory', array('category' => $this->modx->getOption('webinex.email_templates_category','null','Webinex Email Templates')));
        $emailTemplates = $this->modx->getCollection('modChunk',array('category' => $emailTemplatesCategory->id));
        foreach($emailTemplates as $emailTemplate) {
        	$emailTemplatesArray[] = array($emailTemplate->name, $emailTemplate->description ? $emailTemplate->description : $emailTemplate->name );
        }
        $fullResourceArray['emailTemplates'] = $emailTemplatesArray;
           
        $this->addHtml('
        <!-- load custom resource update class  -->
        <script type="text/javascript">
        // <![CDATA[
        MODx.request.reload = false;
        MODx.config.publish_document = "'.$this->canPublish.'";
        MODx.onDocFormRender = "'.$this->onDocFormRender.'";
        MODx.ctx = "'.$this->resource->get('context_key').'";
        Ext.onReady(function() {
        	   Webinex.config = '.$this->modx->toJSON($this->webinex->config).';
            MODx.load({
                xtype: "webinex-page-webinar-update"
                ,resource: "'.$this->resource->get('id').'"
                ,record: '.$this->modx->toJSON($fullResourceArray).'
                ,publish_document: "'.$this->canPublish.'"
                ,preview_url: "'.$this->previewUrl.'"
                ,locked: '.($this->locked ? 1 : 0).'
                ,lockedText: "'.$this->lockedText.'"
                ,canSave: '.($this->canSave ? 1 : 0).'
                ,canEdit: '.($this->canEdit ? 1 : 0).'
                ,canCreate: '.($this->canCreate ? 1 : 0).'
                ,canDuplicate: '.($this->canDuplicate ? 1 : 0).'
                ,canDelete: '.($this->canDelete ? 1 : 0).'
                ,show_tvs: '.(!empty($this->tvCounts) ? 1 : 0).'
                ,mode: "update"
            });
        });
        // ]]>
        </script>');
        /* load RTE */
        $this->loadRichTextEditor();
       
    }
}