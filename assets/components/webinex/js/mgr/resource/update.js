Webinex.page.UpdateWebinar = function(config) {
    config = config || {record:{}};
    config.record = config.record || {};
    Ext.applyIf(config,{
        panelXType: 'modx-panel-webinar'
    });
    Webinex.page.UpdateWebinar.superclass.constructor.call(this,config);
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
   getMainLeftFields: function(config) {
        config = config || {record:{}};
        return [{
            xtype: 'textfield'
            ,fieldLabel: 'Resource Name'+'<span class="required">*</span>'
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
            ,fieldLabel: 'Webinar Title'
            ,description: '<b>[[*longtitle]]</b><br />'+_('resource_longtitle_help')
            ,name: 'longtitle'
            ,id: 'modx-resource-longtitle'
            ,maxLength: 255
            ,anchor: '100%'
            ,value: config.record.longtitle || ''

        },{
            xtype: 'textarea'
            ,fieldLabel: 'Webinar Subtitle'
            ,description: '<b>[[*description]]</b><br />'+_('resource_description_help')
            ,name: 'description'
            ,id: 'modx-resource-description'
            ,maxLength: 255
            ,anchor: '100%'
            ,value: config.record.description || ''

        },{
            xtype: 'textarea'
            ,fieldLabel: 'Summary'
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
                ,text: 'New Presentation'
                ,handler: this.createPresentation
                ,wbn: config.record.id
            }
          ]
        },{
            xtype: 'compositefield'
            ,items: [
               {
                  xtype: 'webinex-superbox-presenter'
                  ,fieldLabel: 'Presenter(s): '+config.record.presenter+'. To change presenter, select below.'
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
                  ,fieldLabel: 'Document(s): '+config.record.document+'. To change documents, select below.'
                  ,name: 'document[]'
                  ,id: 'webinex-superbox-documents'
                  ,width: 400    
               },{
                   xtype: 'button'
                   ,text: 'New Document'
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
            ,fieldLabel: 'Slides'
            ,description: 'The webinar slide presentation.'
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
                  ,fieldLabel: 'Trailer'
                  ,description: 'Video trailer promoting the webinar.'
                  ,id: 'webinex-video-trailer'
                  ,name: 'trailer'
                  ,hiddenName: 'trailer'
                  ,width: 400
                  ,value: config.record.trailer || ''
               },{
                   xtype: 'button'
                   ,text: 'New Trailer'
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
                  ,fieldLabel: 'Webinar Recording'
                  ,description: 'Video recording of the webinar.'
                  ,id: 'webinex-video-recording'  
                  ,name: 'recording'
                  ,hiddenName: 'recording'
                  ,width: 400
                  ,value: config.record.recording || ''
              },{
                   xtype: 'button'
                   ,text: 'New Recording'
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
            ,fieldLabel: 'Event Type'
            ,description: 'The displayed event type - can be changed to call the event something else, e.g. &ldquo;Seminar&rdquo;'
            ,name: 'eventtype'
            ,id: 'modx-resource-eventtype'
            ,maxLength: 255
            ,anchor: '100%'
            ,value: config.record.eventtype || ''

        },{
            xtype: 'xdatetime'
            ,fieldLabel: 'Date'
            ,description: 'The date of the live webinar.'
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
            ,fieldLabel: 'Join URL'
            ,description: 'The URL to which attendees should go to join the webinar.'
            ,name: 'joinurl'
            ,id: 'modx-resource-joinurl'
            ,maxLength: 255
            ,anchor: '100%'
            ,value: config.record.joinurl || ''

        },{
            xtype: 'textfield'
            ,fieldLabel: 'GoToWebinar ID'
            ,description: 'The GoToWebinar ID Number for this webinar.'
            ,name: 'gtwid'
            ,id: 'modx-resource-gtwid'
            ,maxLength: 255
            ,anchor: '70%'
            ,value: config.record.gtwid || ''

        },{
            xtype: 'textfield'
            ,fieldLabel: 'Dial In Number'
            ,description: 'The GoToWebinar dial in number for this webinar.'
            ,name: 'dialin'
            ,id: 'modx-resource-dialin'
            ,maxLength: 255
            ,anchor: '70%'
            ,value: config.record.dialin || ''

        },{
            xtype: 'textfield'
            ,fieldLabel: 'Access Code'
            ,description: 'The GoToWebinar Access Code for this webinar.'
            ,name: 'accesscode'
            ,id: 'modx-resource-accesscode'
            ,maxLength: 255
            ,anchor: '70%'
            ,value: config.record.accesscode || ''

        },{
               xtype: 'textfield'
               ,fieldLabel: 'Recording Running Time'
               ,description: 'The time length of the recorded webinar.'
               ,name: 'runningtime'
               ,id: 'modx-resource-runningtime'
               ,maxLength: 255
               ,value: config.record.runningtime || ''

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
        ,displayField: 'lastname'
   ,store: new Ext.data.JsonStore({
      id:'id',
      autoLoad: true,
      root:'results',
      fields: ['lastname', 'id'],
      url: Webinex.config.connectorUrl,
      baseParams:{
         action: 'mgr/presenter/getList'
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