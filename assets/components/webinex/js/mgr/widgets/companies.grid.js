Webinex.grid.Companies = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'webinex-grid-companies' 
        ,url: Webinex.config.connectorUrl
        ,baseParams: { action: 'mgr/company/getList' }
        ,save_action: 'mgr/company/updateFromGrid'
        ,fields: ['id','name','logo','description']
        ,paging: true
        ,remoteSort: true
        ,autosave: true
        ,anchor: '97%'
        ,autoExpandColumn: 'description'
        ,columns: [{
            header: _('id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 40
        },{
            header: _('companies.name')
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 350
            ,editor: { xtype: 'textfield' }
        },{
            header: _('companies.logo')
            ,dataIndex: 'logo'
            ,sortable: true
            ,width: 350
            ,editor: { xtype: 'textfield' }
        },{
            header: _('companies.description')
            ,dataIndex: 'description'
            ,sortable: true
            ,width: 350
            ,editor: { xtype: 'textfield' }
        }],tbar:[{
            text: _('webinex.company_create')
            ,handler: { xtype: 'webinex-window-company-create' ,blankValues: true }
        },'->',{
            xtype: 'textfield'
            ,id: 'companies-search-filter'
            ,emptyText: _('companies.search...')
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
    Webinex.grid.Companies.superclass.constructor.call(this,config)
};
Ext.extend(Webinex.grid.Companies,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,getMenu: function() {
        return [{
            text: _('webinex.company_update')
            ,handler: this.updateCompany
        },'-',{
            text: _('webinex.company_remove')
            ,handler: this.removeCompany
        }];
    }
    ,updateCompany: function(btn,e) {
        if (!this.updateCompanyWindow) {
            this.updateCompanyWindow = MODx.load({
                xtype: 'webinex-window-company-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.updateCompanyWindow.setValues(this.menu.record);
        this.updateCompanyWindow.show(e.target);
    }

    ,removeCompany: function() {
        MODx.msg.confirm({
            title: _('webinex.company_remove')
            ,text: _('webinex.company_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/company/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
});

Ext.reg('webinex-grid-companies',Webinex.grid.Companies);


Webinex.window.CreateCompany = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('webinex.company_create')
        ,url: Webinex.config.connectorUrl
        ,baseParams: {
            action: 'mgr/company/create'
        }
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('companies.name')
            ,name: 'name'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-browser'
            ,browserEl: 'modx-browser'
            ,prependPath: false
            ,prependUrl: false
            ,hideFiles: true
            ,fieldLabel: _('companies.logo')
            ,name: 'logo'
            ,id: 'webinex-create-company-logo'
            ,maxLength: 255
            ,anchor: '100%'
            ,listeners: {
                'select':{fn:function(data) {
                    var str = data.fullRelativeUrl;
                    if (MODx.config.base_url != '/') {
                        str = str.replace(MODx.config.base_url,'');
                    }
                    if (str.substring(0,1) == '/') { str = str.substring(1); }
                    Ext.getCmp('webinex-create-company-logo').setValue(str);
                    this.markDirty();
                },scope:this}
            }
        },{
            xtype: 'textfield'
            ,fieldLabel: _('companies.description')
            ,name: 'description'
            ,anchor: '100%'
        }]
    });
    Webinex.window.CreateCompany.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.window.CreateCompany,MODx.Window);
Ext.reg('webinex-window-company-create',Webinex.window.CreateCompany);


Webinex.window.UpdateCompany = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('webinex.company_update')
        ,url: Webinex.config.connectorUrl
        ,baseParams: {
            action: 'mgr/company/update'
        }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('companies.name')
            ,name: 'name'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-browser'
            ,browserEl: 'modx-browser'
            ,prependPath: false
            ,prependUrl: false
            ,hideFiles: true
            ,fieldLabel: _('companies.logo')
            ,name: 'logo'
            ,id: 'webinex-company-logo'
            ,maxLength: 255
            ,anchor: '100%'
            ,listeners: {
                'select':{fn:function(data) {
                    var str = data.fullRelativeUrl;
                    if (MODx.config.base_url != '/') {
                        str = str.replace(MODx.config.base_url,'');
                    }
                    if (str.substring(0,1) == '/') { str = str.substring(1); }
                    Ext.getCmp('webinex-company-logo').setValue(str);
                    this.markDirty();
                },scope:this}
            }
        },{
            xtype: 'textfield'
            ,fieldLabel: _('companies.description')
            ,name: 'description'
            ,anchor: '100%'
        }]
    });
    Webinex.window.UpdateCompany.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.window.UpdateCompany,MODx.Window);
Ext.reg('webinex-window-company-update',Webinex.window.UpdateCompany);