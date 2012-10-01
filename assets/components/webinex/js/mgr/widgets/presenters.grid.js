Webinex.grid.Presenters = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'webinex-grid-presenters'
        ,url: Webinex.config.connectorUrl
        ,baseParams: { action: 'mgr/presenter/getList' }
        ,save_action: 'mgr/presenter/updateFromGrid'
        ,fields: ['id','sortorder','firstname','lastname','title','company','email','phone','longbio','shortbio','url','pic','linkedin','twitter']
        ,paging: true
        ,remoteSort: true
        ,autosave: true
        ,anchor: '97%'
        ,autoExpandColumn: 'company'
        ,columns: [{
            header: _('id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 40
        },{
            header: _('presenters.sortorder')
            ,dataIndex: 'sortorder'
            ,sortable: true
            ,width: 100
            ,editor: { xtype: 'textfield' }
        },{
            header: _('presenters.firstname')
            ,dataIndex: 'firstname'
            ,sortable: true
            ,width: 250
            ,editor: { xtype: 'textfield' }
        },{
            header: _('presenters.lastname')
            ,dataIndex: 'lastname'
            ,sortable: true
            ,width: 250
            ,editor: { xtype: 'textfield' }
        },{
            header: _('presenters.title')
            ,dataIndex: 'title'
            ,sortable: true
            ,width: 350
            ,editor: { xtype: 'textfield' }
        },{
            header: _('company')
            ,dataIndex: 'company'
            ,sortable: false
            ,width: 350
            ,editor: { xtype: 'webinex-combo-company' ,renderer:true}
        },{
            header: _('presenters.email')
            ,dataIndex: 'email'
            ,sortable: true
            ,width: 350
            ,editor: { xtype: 'textfield' }
        },{
            header: _('presenters.phone')
            ,dataIndex: 'phone'
            ,sortable: true
            ,width: 250
            ,editor: { xtype: 'textfield' }
        }],tbar:[{
            text: _('webinex.presenter_create')
            ,handler: { xtype: 'webinex-window-presenter-create' ,blankValues: true ,baseParams: {action: 'mgr/presenter/create'} }
        },'->',{
            xtype: 'textfield'
            ,id: 'presenters-search-filter'
            ,emptyText: _('presenters.search...')
            ,listeners: {
                'change': {fn:this.search,scope:this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this);
                            this.blur();
                            return true;
                        }
                        ,scope: cmp
                    });
                },scope:this}
            }
        }]
    });
    Webinex.grid.Presenters.superclass.constructor.call(this,config)
};
Ext.extend(Webinex.grid.Presenters,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,getMenu: function() {
        return [{
            text: _('webinex.presenter_update')
            ,handler: this.updatePresenter
        },'-',{
            text: _('webinex.presenter_remove')
            ,handler: this.removePresenter
        }];
    }
    ,updatePresenter: function(btn,e) {
        if (!this.updatePresenterWindow) {
            this.updatePresenterWindow = MODx.load({
                xtype: 'webinex-window-presenter-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.updatePresenterWindow.setValues(this.menu.record);
        this.updatePresenterWindow.show(e.target);
    }

    ,removePresenter: function() {
        MODx.msg.confirm({
            title: _('webinex.presenter_remove')
            ,text: _('webinex.presenter_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/presenter/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
});

Ext.reg('webinex-grid-presenters',Webinex.grid.Presenters);

Webinex.window.UpdatePresenter = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('webinex.presenter_update')
        ,url: Webinex.config.connectorUrl
        ,baseParams: {
            action: 'mgr/presenter/update'
        }
        ,width: 800  
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },            {
            xtype: 'fieldset'
            ,title: '' 
            ,autoheight: true
            ,layout: 'column'
            ,width: 770
            ,style: 'border:0'
            ,items: [ 
                {
                xtype: 'fieldset'
                ,columnWidth: 0.5
                ,title: '' 
                ,autoheight: true
                ,padding: 5
                ,style: 'border:0'
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
				            ,id: 'webinex-presenters-pic'
				            ,maxLength: 255
				            ,anchor: '100%'
				            ,listeners: 
				            {
				                'select':
				                {
				                	fn:function(data) 
				                	{
				                    	var str = data.fullRelativeUrl;
				                    	if (MODx.config.base_url != '/') {
				                        	str = str.replace(MODx.config.base_url,'');
				                    	}
				                    	if (str.substring(0,1) == '/') { str = str.substring(1); }
				                    Ext.getCmp('webinex-presenters-pic').setValue(str);
				                    this.markDirty();
				                	}
				                	,scope:this
				                }
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
                ,style: 'border:0'
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
                           ,name: 'url'
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
    Webinex.window.UpdatePresenter.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.window.UpdatePresenter,MODx.Window);
Ext.reg('webinex-window-presenter-update',Webinex.window.UpdatePresenter);