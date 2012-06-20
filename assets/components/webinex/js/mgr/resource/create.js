Webinex.page.CreateWebinar = function(config) {
    config = config || {record:{}};
    config.record = config.record || {};
    Ext.applyIf(config,{
        panelXType: 'modx-panel-webinar'
    });
    Webinex.page.CreateWebinar.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.page.CreateWebinar,MODx.page.CreateResource,{});
Ext.reg('webinex-page-webinar-create',Webinex.page.CreateWebinar);

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
            xtype: 'webinex-superbox-presenter'
            ,fieldLabel: 'Presenter(s): '+config.record.presenter+'. To change presenter, select below.'
            ,name: 'presenter[]'
            ,id: 'webinex-superbox-presenters'
            ,anchor: '80%'
        },{
            xtype: 'webinex-superbox-document'
            ,fieldLabel: 'Document(s): '+config.record.document+'. To change documents, select below.'
            ,name: 'document[]'
            ,id: 'webinex-superbox-documents'
            ,anchor: '80%'
        },{
            xtype: 'textfield'
            ,fieldLabel: 'Join URL'
            ,description: 'The URL to which attendees should go to join the webinar.'
            ,name: 'joinurl'
            ,id: 'modx-resource-joinurl'
            ,maxLength: 255
            ,anchor: '80%'
            ,value: config.record.joinurl || ''

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
        }];
        
    },getMainRightFields: function(config) {
        config = config || {};
        return [{
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
            ,value: 'Webinar'

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
            ,fieldLabel: 'Registration Form Identifier'
            ,description: 'A code uniquely identifying the registration form to the marketing automation system.'
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
});
Ext.reg('modx-panel-webinar',Webinex.panel.Webinar);

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