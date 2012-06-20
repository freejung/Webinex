Webinex.page.UpdateWebinar = function(config) {
    config = config || {record:{}};
    config.record = config.record || {};
    Ext.applyIf(config,{
        panelXType: 'modx-panel-webinar'
    });
    Webinex.page.UpdateWebinar.superclass.constructor.call(this,config);
    Ext.EventManager.on(window, 'load', function(){
    	Ext.getCmp('webinex-superbox-presenters').setValue(config.record.presenter);
    	Ext.getCmp('webinex-superbox-documents').setValue(config.record.document);
    }, this);
};
Ext.extend(Webinex.page.UpdateWebinar,MODx.page.UpdateResource,{});
Ext.reg('webinex-page-webinar-update',Webinex.page.UpdateWebinar);

Webinex.panel.Webinar = function(config) {
    config = config || {};
    Ext.applyIf(config,{
    });
    Webinex.panel.Webinar.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.panel.Webinar,MODx.panel.Resource,{
	
	 getFields: function(config) {
        var it = [];
        it.push({
            title: _(this.classLexiconKey)
            ,id: 'modx-resource-settings'
            ,cls: 'modx-resource-tab'
            ,layout: 'form'
            ,labelAlign: 'top'
            ,labelSeparator: ''
            ,bodyCssClass: 'tab-panel-wrapper main-wrapper'
            ,autoHeight: true
            ,defaults: {
                border: false
                ,msgTarget: 'under'
                ,width: 400
            }
            ,items: this.getMainFields(config)
        });
        it.push({
            id: 'modx-page-settings'
            ,title: _('settings')
            ,cls: 'modx-resource-tab'
            ,layout: 'form'
            ,forceLayout: true
            ,deferredRender: false
            ,labelWidth: 200
            ,bodyCssClass: 'main-wrapper'
            ,autoHeight: true
            ,defaults: {
                border: false
                ,msgTarget: 'under'
            }
            ,items: this.getSettingFields(config)
        });
        if (config.show_tvs && MODx.config.tvs_below_content != 1) {
            it.push(this.getTemplateVariablesPanel(config));
        }
        it.push(this.getRegistrationsTab(config));
        it.push(this.getEmailsTab(config));
        if (MODx.perm.resourcegroup_resource_list == 1) {
            it.push(this.getAccessPermissionsTab(config));
        }
        var its = [];
        its.push(this.getPageHeader(config),{
            id:'modx-resource-tabs'
            ,xtype: 'modx-tabs'
            ,forceLayout: true
            ,deferredRender: false
            ,collapsible: true
            ,animCollapse: false
            ,itemId: 'tabs'
            ,items: it
        });
        var ct = this.getContentField(config);
        if (ct) {
            its.push({
                title: _('resource_content')
                ,id: 'modx-resource-content'
                ,layout: 'form'
                ,bodyCssClass: 'main-wrapper'
                ,autoHeight: true
                ,collapsible: true
                ,animCollapse: false
                ,hideMode: 'offsets'
                ,items: ct
                ,style: 'margin-top: 10px'
            });
        }
        if (MODx.config.tvs_below_content == 1) {
            var tvs = this.getTemplateVariablesPanel(config);
            tvs.style = 'margin-top: 10px';
            its.push(tvs);
        }
        return its;
    }	
    ,getRegistrationsTab: function(config) {
        return {
            id: 'webinex-resource-registrations'
            ,autoHeight: true
            ,title: _('registrations')
            ,layout: 'form'
            ,anchor: '100%'
            ,items: [{
                html: '<p>'+_('registration.desc')+'</p>'
                ,bodyCssClass: 'panel-desc'
                ,border: false
            } ,{
                xtype: 'webinex-grid-registrations'
                ,cls: 'main-wrapper'
                ,preventRender: true
                ,resource: config.resource
                ,presentation: config.record.presentation
                ,mode: config.mode || 'update' 
                ,"parent": config.record["parent"] || 0
                ,"token": config.record.create_resource_token
                ,reloaded: !Ext.isEmpty(MODx.request.reload)
                ,listeners: {
                    'afteredit': {fn:this.fieldChangeEvent,scope:this}
                }
            }]
        };
    }
    ,getEmailsTab: function(config) {
        return {
            id: 'webinex-resource-emails'
            ,autoHeight: true
            ,title: 'Emails'
            ,layout: 'form'
            ,anchor: '100%'
            ,items: [{
                html: '<p>To generate the code for emails relating to this webinar,  select an email template and (optionally) an affiliate. The email code will output in a console window, and you can copy it from there.</p>'
                ,bodyCssClass: 'panel-desc'
                ,border: false
            } ,{
                xtype: 'fieldset'
                ,columnWidth: 0.5
                ,autoheight: true
                ,padding: 10
                ,items: [{
                    xtype: 'webinex-combo-email'
                    ,fieldLabel: 'Email Template'
                    ,description: _('email_template.description')
                    ,name: 'email'
                    ,hiddenName: 'email'
                    ,id: 'webinex-resource-email'
                    ,width: 300
                    ,wbn: config.record.id
                    ,value: ''
                    ,emailTemplates: config.record.emailTemplates
                },{
                    xtype: 'webinex-combo-affiliate'
                    ,fieldLabel: 'Affiliate'
                    ,description: _('email_affiliate.description')
                    ,name: 'affiliate'
                    ,hiddenName: 'affiliate'
                    ,id: 'webinex-resource-affiliate'
                    ,width: 300
                    ,wbn: config.record.id
                    ,value: ''
                },{
                    xtype: 'button'
                    ,text: 'Generate Email'
                    ,handler: this.createEmail
                    ,wbn: config.record.id
                }
              ]
           }]
        };
    }
   ,getMainLeftFields: function(config) {
        config = config || {record:{}};
        return [{
            xtype: 'textfield'
            ,fieldLabel: _('webinar.resource_name')+'<span class="required">*</span>'
            ,description: '<b>[[*pagetitle]]</b><br />'+_('resource_pagetitle_help')
            ,name: 'pagetitle'
            ,id: 'modx-resource-pagetitle'
            ,maxLength: 255
            ,anchor: '80%'
            ,allowBlank: false
            ,enableKeyEvents: true
            ,listeners: {
                'keyup': {scope:this,fn:function(f,e) {
                    var titlePrefix = MODx.request.a == MODx.action['resource/create'] ? _('new_document') : _('document');
                    var title = Ext.util.Format.stripTags(f.getValue());
                    Ext.getCmp('modx-resource-header').getEl().update('<h2>'+title+'</h2>');
                }}
            }

        },{
            xtype: 'textfield'
            ,fieldLabel: _('webinar.title')
            ,description: '<b>[[*longtitle]]</b><br />'+_('resource_longtitle_help')
            ,name: 'longtitle'
            ,id: 'modx-resource-longtitle'
            ,maxLength: 255
            ,anchor: '100%'
            ,value: config.record.longtitle || ''

        },{
            xtype: 'textarea'
            ,fieldLabel: _('webinar.subtitle')
            ,description: '<b>[[*description]]</b><br />'+_('resource_description_help')
            ,name: 'description'
            ,id: 'modx-resource-description'
            ,maxLength: 255
            ,anchor: '100%'
            ,value: config.record.description || ''

        },{
            xtype: 'textarea'
            ,fieldLabel: _('webinar.summary')
            ,description: '<b>[[*introtext]]</b><br />'+_('resource_summary_help')
            ,name: 'introtext'
            ,id: 'modx-resource-introtext'
            ,grow: true
            ,anchor: '100%'
            ,value: config.record.introtext || ''
        },{
            xtype: 'compositefield'
            ,items: [
            {
                xtype: 'webinex-combo-presentation'
                ,fieldLabel: _('presentation_primary')
                ,description: _('presentation_primary.description')
                ,name: 'presentation'
                ,hiddenName: 'presentation'
                ,id: 'webinex-resource-presentation'
                ,width: 180
                ,wbn: config.record.id
                ,value: config.record.presentation || ''
                ,listeners: {
                'select': {fn: this.presentationWarning,scope: this}
                }
            },{
                xtype: 'button'
                ,text: _('presentation.new')
                ,handler: this.createPresentation
                ,wbn: config.record.id
            }
          ]
        },{
            xtype: 'compositefield'
            ,items: [
               {
                  xtype: 'webinex-superbox-presenter'
                  ,fieldLabel: _('presenters.plural_opt')+':'
                  ,name: 'presenter[]'
                  ,id: 'webinex-superbox-presenters'
                  ,width: 400
               },{
                   xtype: 'button'
                   ,text: 'New Presenter'
                   ,handler: this.createPresenter
                   ,width: 110
                   ,wbn: config.record.id
               }
            ]
        },{
            xtype: 'compositefield'
            ,items: [
               {
                  xtype: 'webinex-superbox-document'
                  ,fieldLabel: _('documents.plural_opt')+':'
                  ,name: 'document[]'
                  ,id: 'webinex-superbox-documents'
                  ,width: 400    
               },{
                   xtype: 'button'
                   ,text: _('documents.new')
                   ,handler: this.createDocument
                   ,width: 110
                   ,wbn: config.record.id
               }
            ]
        },{
            xtype: 'modx-combo-browser'
            ,browserEl: 'modx-browser'
            ,prependPath: false
            ,prependUrl: false
            ,hideFiles: true
            ,fieldLabel: _('documents.slides')
            ,description: _('documents.slides_desc')
            ,name: 'slides'
            ,id: 'webinex-resource-slides'
            ,maxLength: 255
            ,anchor: '50%'
            ,value: config.record.slides || ''
            ,listeners: {
                'select':{fn:function(data) {
                    var str = data.fullRelativeUrl;
                    if (MODx.config.base_url != '/') {
                        str = str.replace(MODx.config.base_url,'');
                    }
                    if (str.substring(0,1) == '/') { str = str.substring(1); }
                    Ext.getCmp('webinex-resource-slides').setValue(str);
                    this.markDirty();
                },scope:this}
            }
        },{
            xtype: 'compositefield'
            ,items: [
               {
                  xtype: 'webinex-combo-video'
                  ,fieldLabel: _('video.trailer')
                  ,description: _('video.trailer_desc')
                  ,id: 'webinex-video-trailer'
                  ,name: 'trailer'
                  ,hiddenName: 'trailer'
                  ,width: 400
                  ,value: config.record.trailer || ''
               },{
                   xtype: 'button'
                   ,text: _('video.trailer_new')
                   ,handler: this.createVideo
                   ,width: 110
                   ,wbn: config.record.id
                   ,targ: 'Trailer'
               }
            ]
        },{
            xtype: 'compositefield'
            ,items: [
              {
                  xtype: 'webinex-combo-video'
                  ,fieldLabel: _('video.recording')
                  ,description: _('video.recording_desc')
                  ,id: 'webinex-video-recording'  
                  ,name: 'recording'
                  ,hiddenName: 'recording'
                  ,width: 400
                  ,value: config.record.recording || ''
              },{
                   xtype: 'button'
                   ,text: _('video.recording_new')
                   ,handler: this.createVideo
                   ,width: 110
                   ,wbn: config.record.id
                   ,targ: 'Recording'   
              }
            ]
        }];
        
    },getMainRightFields: function(config) {
        config = config || {};
        return [{
            xtype: 'modx-combo-template'
            ,fieldLabel: _('resource_template')
            ,description: '<b>[[*template]]</b><br />'+_('resource_template_help')
            ,name: 'template'
            ,id: 'modx-resource-template'
            ,anchor: '100%'
            ,editable: false
            ,baseParams: {
                action: 'getList'
                ,combo: '1'
                ,limit: 0
            }
            ,listeners: {
                'select': {fn: this.templateWarning,scope: this}
            }
        },{
            xtype: 'textfield'
            ,fieldLabel: _('resource_alias')
            ,description: '<b>[[*alias]]</b><br />'+_('resource_alias_help')
            ,name: 'alias'
            ,id: 'modx-resource-alias'
            ,maxLength: 100
            ,anchor: '100%'
            ,value: config.record.alias || ''

        },{
            xtype: 'textfield'
            ,fieldLabel: _('resource_menutitle')
            ,description: '<b>[[*menutitle]]</b><br />'+_('resource_menutitle_help')
            ,name: 'menutitle'
            ,id: 'modx-resource-menutitle'
            ,maxLength: 255
            ,anchor: '100%'
            ,value: config.record.menutitle || ''

        },{
            xtype: 'textfield'
            ,fieldLabel: _('resource_link_attributes')
            ,description: '<b>[[*link_attributes]]</b><br />'+_('resource_link_attributes_help')
            ,name: 'link_attributes'
            ,id: 'modx-resource-link-attributes'
            ,maxLength: 255
            ,anchor: '100%'
            ,value: config.record.link_attributes || ''

        },{
            xtype: 'textfield'
            ,fieldLabel: _('webinar.event_type')
            ,description: _('webinar.event_type_desc')
            ,name: 'eventtype'
            ,id: 'modx-resource-eventtype'
            ,maxLength: 255
            ,anchor: '100%'
            ,value: config.record.eventtype || ''

        },{
            xtype: 'xdatetime'
            ,fieldLabel: _('webinar.date')
            ,description: _('webinar.date_desc')
            ,name: 'eventdate'
            ,id: 'modx-resource-event-date'
            ,allowBlank: true
            ,dateFormat: MODx.config.manager_date_format
            ,timeFormat: MODx.config.manager_time_format
            ,dateWidth: 120
            ,timeWidth: 120
            ,value: config.record.eventdate || ''

        },{
            xtype: 'textfield'
            ,fieldLabel: _('webinar.join_url')
            ,description: _('webinar.join_url_desc')
            ,name: 'joinurl'
            ,id: 'modx-resource-joinurl'
            ,maxLength: 255
            ,anchor: '100%'
            ,value: config.record.joinurl || ''

        },{
            xtype: 'textfield'
            ,fieldLabel: _('webinar.gtwid')
            ,description: _('webinar.gtwid_desc')
            ,name: 'gtwid'
            ,id: 'modx-resource-gtwid'
            ,maxLength: 255
            ,anchor: '70%'
            ,value: config.record.gtwid || ''

        },{
            xtype: 'textfield'
            ,fieldLabel: _('webinar.dialin')
            ,description: _('webinar.dialin_desc')
            ,name: 'dialin'
            ,id: 'modx-resource-dialin'
            ,maxLength: 255
            ,anchor: '70%'
            ,value: config.record.dialin || ''

        },{
            xtype: 'textfield'
            ,fieldLabel: _('webinar.accesscode')
            ,description: _('webinar.accesscode_desc')
            ,name: 'accesscode'
            ,id: 'modx-resource-accesscode'
            ,maxLength: 255
            ,anchor: '70%'
            ,value: config.record.accesscode || ''

        },{
            xtype: 'textfield'
            ,fieldLabel: _('webinar.reg')
            ,description: _('webinar.reg_desc')
            ,name: 'reg'
            ,id: 'modx-resource-reg'
            ,maxLength: 255
            ,anchor: '70%'
            ,value: config.record.reg || ''

        },{
            xtype: 'xcheckbox'
            ,boxLabel: _('resource_hide_from_menus')
            ,hideLabel: true
            ,description: '<b>[[*hidemenu]]</b><br />'+_('resource_hide_from_menus_help')
            ,name: 'hidemenu'
            ,id: 'modx-resource-hidemenu'
            ,inputValue: 1
            ,checked: parseInt(config.record.hidemenu) || false

        },{
            xtype: 'xcheckbox'
            ,boxLabel: _('resource_published')
            ,hideLabel: true
            ,description: '<b>[[*published]]</b><br />'+_('resource_published_help')
            ,name: 'published'
            ,id: 'modx-resource-published'
            ,inputValue: 1
            ,checked: parseInt(config.record.published)
        }]
    }
    ,createPresenter: function(b,e) {
        if (!this.createPresenterWindow) {
            this.createPresenterWindow = MODx.load({
                xtype: 'webinex-window-presenter-create'
                ,listeners: {
                    'success': {fn:function() {
                        location.href = '?a='+MODx.action['resource/update']+'&id='+b.wbn;
                    },scope:this}
                }
                ,webinar: b.wbn
                ,baseParams: {action: 'mgr/presenter/createFromResource'}
            });
        }
        this.createPresenterWindow.show(e.target);
    }
    ,createDocument: function(b,e) {
        if (!this.createDocumentWindow) {
            this.createDocumentWindow = MODx.load({
                xtype: 'webinex-window-document-create'
                ,listeners: {
                    'success': {fn:function() {
                        location.href = '?a='+MODx.action['resource/update']+'&id='+b.wbn;
                    },scope:this}
                }
                ,webinar: b.wbn
                ,baseParams: {action: 'mgr/document/createFromResource'}
            });
        }
        this.createDocumentWindow.show(e.target);
    }
    ,createVideo: function(b,e) {
        if (!this.createVideoWindow) {
            this.createVideoWindow = MODx.load({
                xtype: 'webinex-window-video-create'
                ,listeners: {
                    'success': {fn:function() {
                        location.href = '?a='+MODx.action['resource/update']+'&id='+b.wbn;
                    },scope:this}
                }
                ,webinar: b.wbn
                ,targetfield: b.targ
                ,baseParams: {action: 'mgr/video/createFromResource'}
            });
        }
        this.createVideoWindow.show(e.target);
    }
    ,createPresentation: function(b,e) {
        if (!this.createPresentationWindow) {
            this.createPresentationWindow = MODx.load({
                xtype: 'webinex-window-presentation-create'
                ,listeners: {
                    'success': {fn:function() {
                        location.href = '?a='+MODx.action['resource/update']+'&id='+b.wbn;
                    },scope:this}
                }
                ,webinar: b.wbn
            });
        }
        this.createPresentationWindow.show(e.target);
    }
    ,createEmail: function(b,e) {
        var topic = '/webinex/';
        var register = 'mgr';
        var emailfield = Ext.getCmp('webinex-resource-email');
        var affiliatefield = Ext.getCmp('webinex-resource-affiliate');
        if(!this.createEmailConsole) {
            this.createEmailConsole = MODx.load({
               xtype: 'modx-console'
               ,register: register
               ,topic: topic
               ,id: 'webinex-create-email-console'
               ,show_filename: 0
               ,listeners: {
                 'shutdown': {fn:function() {
                     /* do code here when you close the console */
                 },scope:this}
                }
            });
        }
        this.createEmailConsole.show(Ext.getBody());
        
        MODx.Ajax.request({
            url: '/assets/components/webinex/connector.php'
            ,params: {
                action: 'mgr/email/create'
                ,register: register
                ,topic: topic
                ,webinar: b.wbn
                ,email: emailfield.getValue()
                ,affiliate: affiliatefield.getValue()
            }
            ,listeners: {
                'success':{fn:function() {
                    console.fireEvent('complete');
                },scope:this}
            }
        });
    }
    ,presentationWarning: function() {
        var t = Ext.getCmp('webinex-resource-presentation');
        if (!t) { return false; }
        if(t.getValue() !== t.originalValue) {
            Ext.Msg.confirm(_('warning'), _('webinar_change_presentation_confirm'), function(e) {
                if (e == 'yes') {
                    MODx.activePage.submitForm({
                        success: {fn:function(r) {
                            location.href = '?a='+MODx.action['resource/update']+'&id='+r.result.object.id;
                        },scope:this}
                    },{
                        bypassValidCheck: true
                    },{
                        reloadOnly: true
                    });
                } else {
                    t.setValue(this.config.record.presentation);
                }
            },this);
        }
    }
});
Ext.reg('modx-panel-webinar',Webinex.panel.Webinar);

Webinex.combo.Presenters = function (config) {
    config = config || {};
    Ext.applyIf(config, {
      xtype:'superboxselect'
        ,triggerAction: 'all'
   ,mode: 'remote'
        ,valueField: 'id'
        ,displayField: 'fullname'
        ,resizable: true
   ,store: new Ext.data.JsonStore({ 
      id:'id',
      autoLoad: true,
      root:'results',
      fields: ['fullname', 'id'],
      url: Webinex.config.connectorUrl,
      baseParams:{
         action: 'mgr/presenter/getList'
         ,limit: 0
      }
   })
    });
    Webinex.combo.Presenters.superclass.constructor.call(this, config);
};
Ext.extend(Webinex.combo.Presenters, Ext.ux.form.SuperBoxSelect);
Ext.reg('webinex-superbox-presenter', Webinex.combo.Presenters );

Webinex.combo.Documents = function (config) {
    config = config || {};
    Ext.applyIf(config, {
      xtype:'superboxselect'
        ,triggerAction: 'all'
   ,mode: 'remote'
        ,valueField: 'id'
        ,displayField: 'title'
        ,resizable: true
   ,store: new Ext.data.JsonStore({
      id:'id',
      autoLoad: true,
      root:'results',
      fields: ['title', 'id'],
      url: Webinex.config.connectorUrl,
      baseParams:{
         action: 'mgr/document/getList'
      }
   })
    });
    Webinex.combo.Documents.superclass.constructor.call(this, config);
};
Ext.extend(Webinex.combo.Documents, Ext.ux.form.SuperBoxSelect);
Ext.reg('webinex-superbox-document', Webinex.combo.Documents );

Webinex.combo.Presentation = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: Webinex.config.connectorUrl
        ,baseParams: { action: 'mgr/presentation/getList'
            ,wbn: config.wbn
        }
        ,fields: ['id', 'eventdate']
        ,displayField: 'eventdate'
        ,valueField: 'id'
    });
    Webinex.combo.Presentation.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.combo.Presentation,MODx.combo.ComboBox);
Ext.reg('webinex-combo-presentation',Webinex.combo.Presentation);

Webinex.window.CreatePresentation = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('presentation_create')
        ,url: Webinex.config.connectorUrl
        ,baseParams: {
            action: 'mgr/presentation/create'
        }
        ,fields: [{
            xtype: 'xdatetime'
            ,fieldLabel: _('presentations.date')
            ,name: 'eventdate'
            ,id: 'webinex-presentation-create-window-date'
            ,allowBlank: true
            ,dateFormat: MODx.config.manager_date_format
            ,timeFormat: MODx.config.manager_time_format
            ,dateWidth: 120
            ,timeWidth: 120
        },{
            xtype: 'hidden'
            ,name: 'webinar'
            ,value: config.webinar
        }]
    });
    Webinex.window.CreatePresentation.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.window.CreatePresentation,MODx.Window);
Ext.reg('webinex-window-presentation-create',Webinex.window.CreatePresentation);

Webinex.combo.Video = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: Webinex.config.connectorUrl
        ,baseParams: { action: 'mgr/video/getList' }
        ,fields: ['id', 'title']
        ,displayField: 'title'
        ,pageSize: 20
        ,valueField: 'id'
    });
    Webinex.combo.Video.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.combo.Video,MODx.combo.ComboBox);
Ext.reg('webinex-combo-video',Webinex.combo.Video);

Webinex.combo.Affiliate = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: Webinex.config.connectorUrl
        ,baseParams: { action: 'mgr/affiliate/getListEmail' }
        ,fields: ['id', 'name']
        ,displayField: 'name'
        ,pageSize: 20
        ,valueField: 'id'
    });
    Webinex.combo.Affiliate.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.combo.Affiliate,MODx.combo.ComboBox);
Ext.reg('webinex-combo-affiliate',Webinex.combo.Affiliate);

Webinex.combo.Email = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0
            ,fields: ['value','text']
            ,data: config.emailTemplates
        })
        ,mode: 'local'
        ,displayField: 'text'
        ,valueField: 'value'
    });
    Webinex.combo.Email.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.combo.Email,MODx.combo.ComboBox);
Ext.reg('webinex-combo-email',Webinex.combo.Email);