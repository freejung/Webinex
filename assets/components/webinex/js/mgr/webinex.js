var Webinex = function(config) {
    config = config || {};
    Webinex.superclass.constructor.call(this,config);
};
Ext.extend(Webinex,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},view: {}
});
Ext.reg('Webinex',Webinex);
Webinex = new Webinex();

Webinex.window.CreateVideo = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('webinex.video_create')
        ,url: Webinex.config.connectorUrl
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('videos.title')
            ,name: 'title'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('videos.url')
            ,name: 'url'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-browser'
            ,browserEl: 'modx-browser'
            ,prependPath: false
            ,prependUrl: false
            ,hideFiles: true
            ,fieldLabel: _('videos.imageurl')
            ,name: 'imageurl'
            ,id: 'webinex-video-create-imageurl'
            ,maxLength: 255
            ,anchor: '100%'
            ,listeners: {
                'select':{fn:function(data) {
                    var str = data.fullRelativeUrl;
                    if (MODx.config.base_url != '/') {
                        str = str.replace(MODx.config.base_url,'');
                    }
                    if (str.substring(0,1) == '/') { str = str.substring(1); }
                    Ext.getCmp('webinex-video-create-imageurl').setValue(str);
                    this.markDirty();
                },scope:this}
            }
        },{
            xtype: 'webinex-combo-host'
            ,fieldLabel: _('videos.host')
            ,hiddenName: 'host'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('videos.hostid')
            ,name: 'hostid'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('videos.runtime')
            ,name: 'runtime'
            ,anchor: '100%'
        }/*,{
            xtype: 'xdatetime'
            ,fieldLabel: _('videos.recordedon')
            ,name: 'recordedon'
            ,id: 'modx-resource-recordedon'
            ,allowBlank: true
            ,dateFormat: MODx.config.manager_date_format
            ,timeFormat: MODx.config.manager_time_format
            ,dateWidth: 120
            ,timeWidth: 120

        }*/,{
            xtype: 'textarea'
            ,fieldLabel: _('videos.description')
            ,name: 'description'
            ,anchor: '100%'
        },{
            xtype: 'hidden'
            ,name: 'webinar'
            ,value: config.webinar
        },{
            xtype: 'hidden'
            ,name: 'targetfield'
            ,value: config.targetfield
        }]
    });
    Webinex.window.CreateVideo.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.window.CreateVideo,MODx.Window);
Ext.reg('webinex-window-video-create',Webinex.window.CreateVideo);

Webinex.combo.Host = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0
            ,fields: ['value','text']
            ,data: [
            	    ['Vimeo', 'Vimeo'],
            	    ['YouTube', 'YouTube'],
            ]
        })
        ,mode: 'local'
        ,displayField: 'text'
        ,valueField: 'value'
    });
    Webinex.combo.Host.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.combo.Host,MODx.combo.ComboBox);
Ext.reg('webinex-combo-host',Webinex.combo.Host);

Webinex.window.CreatePresenter = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('webinex.presenter_create')
        ,url: Webinex.config.connectorUrl
        ,width: 800
        ,fields: [ 
         {
            xtype: 'hidden'
            ,name: 'webinar'
            ,value: config.webinar
         },{
            xtype: 'fieldset'
            ,title: '' 
            ,autoheight: true
            ,layout: 'column'
            ,width: 770
            ,items: [ 
                {
                xtype: 'fieldset'
                ,columnWidth: 0.5
                ,title: '' 
                ,autoheight: true
                ,padding: 5
                ,items: 
                    [
                       {
                           xtype: 'textfield'
                           ,fieldLabel: _('presenters.firstname')
                           ,name: 'firstname'
                           ,anchor: '100%'
                       },{
                           xtype: 'textfield'
                           ,fieldLabel: _('presenters.lastname')
                           ,name: 'lastname'
                           ,anchor: '100%'
                       },{
                           xtype: 'textfield'
                           ,fieldLabel: _('presenters.title')
                           ,name: 'title'
                           ,anchor: '100%'
                       },{
                           xtype: 'webinex-combo-company'
                           ,fieldLabel: _('company')
                           ,name: 'company'
                           ,hiddenName: 'company'
                           ,anchor: '100%'
                       },{
					            xtype: 'modx-combo-browser'
					            ,browserEl: 'modx-browser'
					            ,prependPath: false
					            ,prependUrl: false
					            ,hideFiles: true
					            ,fieldLabel: _('presenters.pic')
					            ,name: 'pic'
					            ,id: 'webinex-create-presenters-pic'
					            ,maxLength: 255
					            ,anchor: '100%'
					            ,listeners: {
					                'select':{fn:function(data) {
					                    var str = data.fullRelativeUrl;
					                    if (MODx.config.base_url != '/') {
					                        str = str.replace(MODx.config.base_url,'');
					                    }
					                    if (str.substring(0,1) == '/') { str = str.substring(1); }
					                    Ext.getCmp('webinex-create-presenters-pic').setValue(str);
					                    this.markDirty();
					                },scope:this}
					            }
					        },{
                           xtype: 'textarea'
                           ,fieldLabel: _('presenters.shortbio')
                           ,name: 'shortbio'
                           ,anchor: '100%'
                       }
                    ]
                },
                {
                xtype: 'fieldset'
                ,columnWidth: 0.5
                ,title: '' 
                ,autoheight: true
                ,padding: 5
                ,items: 
                    [
                       {
                           xtype: 'textfield'
                           ,fieldLabel: _('presenters.email')
                           ,name: 'email'
                           ,anchor: '100%'
                       },{
                           xtype: 'textfield'
                           ,fieldLabel: _('presenters.phone')
                           ,name: 'phone'
                           ,anchor: '100%'
                       },{
                           xtype: 'textfield'
                           ,fieldLabel: _('presenters.linkedin')
                           ,name: 'linkedin'
                           ,anchor: '100%'
                       },{
                           xtype: 'textfield'
                           ,fieldLabel: _('presenters.twitter')
                           ,name: 'twitter'
                           ,anchor: '100%'
                       },{
                           xtype: 'textfield'
                           ,fieldLabel: _('presenters.url')
                           ,name: 'pic'
                           ,anchor: '100%'
                       },{
                           xtype: 'textarea'
                           ,fieldLabel: _('presenters.longbio')
                           ,name: 'longbio'
                           ,anchor: '100%'
                       }
                    ]
                }
            ]
        }]
    });
    Webinex.window.CreatePresenter.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.window.CreatePresenter,MODx.Window);
Ext.reg('webinex-window-presenter-create',Webinex.window.CreatePresenter);

Webinex.combo.Company = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: Webinex.config.connectorUrl
        ,baseParams: { action: 'mgr/company/getList' }
        ,fields: ['id', 'name']
        ,displayField: 'name'
        ,valueField: 'id'
    });
    Webinex.combo.Company.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.combo.Company,MODx.combo.ComboBox);
Ext.reg('webinex-combo-company',Webinex.combo.Company);

Webinex.window.CreateDocument = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('webinex.document_create')
        ,url: Webinex.config.connectorUrl
        ,fields: [{
            xtype: 'hidden'
            ,name: 'webinar'
            ,value: config.webinar
         },{
            xtype: 'textfield'
            ,fieldLabel: _('documents.title')
            ,name: 'title'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-browser'
            ,browserEl: 'modx-browser'
            ,prependPath: false
            ,prependUrl: false
            ,hideFiles: true
            ,fieldLabel: 'Document File'
            ,name: 'url'
            ,id: 'webinex-create-document-url'
            ,maxLength: 255
            ,anchor: '100%'
            ,listeners: {
                'select':{fn:function(data) {
                    var str = data.fullRelativeUrl;
                    if (MODx.config.base_url != '/') {
                        str = str.replace(MODx.config.base_url,'');
                    }
                    if (str.substring(0,1) == '/') { str = str.substring(1); }
                    Ext.getCmp('webinex-create-document-url').setValue(str);
                    this.markDirty();
                },scope:this}
            }
        },{
            xtype: 'webinex-combo-doctype'
            ,fieldLabel: _('documents.doctype')
            ,hiddenName: 'doctype'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('documents.description')
            ,name: 'description'
            ,anchor: '100%'
        }]
    });
    Webinex.window.CreateDocument.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.window.CreateDocument,MODx.Window);
Ext.reg('webinex-window-document-create',Webinex.window.CreateDocument);

Webinex.combo.Doctype = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0
            ,fields: ['value','text']
            ,data: [
            	    ['pdf', 'Adobe PDF'],
            	    ['docx', 'Word Document'],
            	    ['xlsx', 'Excel Spreadsheet'],
            	    ['wmv', 'WMV Video'],
            	    ['other', 'Other'],
            ]
        })
        ,mode: 'local'
        ,displayField: 'text'
        ,valueField: 'value'
    });
    Webinex.combo.Doctype.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.combo.Doctype,MODx.combo.ComboBox);
Ext.reg('webinex-combo-doctype',Webinex.combo.Doctype);
