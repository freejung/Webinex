Webinex.grid.Affiliates = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'webinex-grid-affiliates'
        ,url: Webinex.config.connectorUrl
        ,baseParams: { action: 'mgr/affiliate/getList' }
        ,save_action: 'mgr/affiliate/updateFromGrid'
        ,fields: ['id','name','logo','state','code','description','notes']
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
            header: _('affiliates.name')
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 350
            ,editor: { xtype: 'textfield' }
        },{
            header: _('affiliates.logo')
            ,dataIndex: 'logo'
            ,sortable: true
            ,width: 350
            ,editor: { xtype: 'textfield' }
        },{
            header: _('affiliates.state')
            ,dataIndex: 'state'
            ,sortable: false
            ,width: 200
            ,editor: { xtype: 'webinex-combo-state' ,renderer: true}
        },{
            header: _('affiliates.code')
            ,dataIndex: 'code'
            ,sortable: true
            ,width: 150
            ,editor: { xtype: 'textfield' }
        },{
            header: _('affiliates.description')
            ,dataIndex: 'description'
            ,sortable: true
            ,width: 350
            ,editor: { xtype: 'textfield' }
        },{
            header: _('affiliates.notes')
            ,dataIndex: 'notes'
            ,sortable: true
            ,width: 350
            ,editor: { xtype: 'textfield' }
        }],tbar:[{
            text: _('webinex.affiliate_create')
            ,handler: { xtype: 'webinex-window-affiliate-create' ,blankValues: true }
        },'->',{
            xtype: 'textfield'
            ,id: 'affiliates-search-filter'
            ,emptyText: _('affiliates.search...') 
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
    Webinex.grid.Affiliates.superclass.constructor.call(this,config)
};
Ext.extend(Webinex.grid.Affiliates,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,getMenu: function() {
        return [{
            text: _('webinex.affiliate_update')
            ,handler: this.updateAffiliate
        },'-',{
            text: _('webinex.affiliate_remove')
            ,handler: this.removeAffiliate
        }];
    }
    ,updateAffiliate: function(btn,e) {
        if (!this.updateAffiliateWindow) {
            this.updateAffiliateWindow = MODx.load({
                xtype: 'webinex-window-affiliate-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.updateAffiliateWindow.setValues(this.menu.record);
        this.updateAffiliateWindow.show(e.target);
    }

    ,removeAffiliate: function() {
        MODx.msg.confirm({
            title: _('webinex.affiliate_remove')
            ,text: _('webinex.affiliate_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/affiliate/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
});

Ext.reg('webinex-grid-affiliates',Webinex.grid.Affiliates);


Webinex.window.CreateAffiliate = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('webinex.affiliate_create')
        ,url: Webinex.config.connectorUrl
        ,baseParams: {
            action: 'mgr/affiliate/create'
        }
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('affiliates.name')
            ,name: 'name'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-browser'
            ,browserEl: 'modx-browser'
            ,prependPath: false
            ,prependUrl: false
            ,hideFiles: true
            ,fieldLabel: _('affiliates.logo')
            ,name: 'logo'
            ,id: 'webinex-create-affiliate-logo'
            ,maxLength: 255
            ,anchor: '100%'
            ,listeners: {
                'select':{fn:function(data) {
                    var str = data.fullRelativeUrl;
                    if (MODx.config.base_url != '/') {
                        str = str.replace(MODx.config.base_url,'');
                    }
                    if (str.substring(0,1) == '/') { str = str.substring(1); }
                    Ext.getCmp('webinex-create-affiliate-logo').setValue(str);
                    this.markDirty();
                },scope:this}
            }
        },{
            xtype: 'webinex-combo-state'
            ,fieldLabel: _('affiliates.state')
            ,hiddenName: 'state'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('affiliates.code')
            ,name: 'code'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('affiliates.description')
            ,name: 'description'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('affiliates.notes')
            ,name: 'notes'
            ,anchor: '100%'
        }]
    });
    Webinex.window.CreateAffiliate.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.window.CreateAffiliate,MODx.Window);
Ext.reg('webinex-window-affiliate-create',Webinex.window.CreateAffiliate);


Webinex.window.UpdateAffiliate = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('webinex.affiliate_update')
        ,url: Webinex.config.connectorUrl
        ,baseParams: {
            action: 'mgr/affiliate/update'
        }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('affiliates.name')
            ,name: 'name'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-browser'
            ,browserEl: 'modx-browser'
            ,prependPath: false
            ,prependUrl: false
            ,hideFiles: true
            ,fieldLabel: _('affiliates.logo')
            ,name: 'logo'
            ,id: 'webinex-affiliate-logo'
            ,maxLength: 255
            ,anchor: '100%'
            ,listeners: {
                'select':{fn:function(data) {
                    var str = data.fullRelativeUrl;
                    if (MODx.config.base_url != '/') {
                        str = str.replace(MODx.config.base_url,'');
                    }
                    if (str.substring(0,1) == '/') { str = str.substring(1); }
                    Ext.getCmp('webinex-affiliate-logo').setValue(str);
                    this.markDirty();
                },scope:this}
            }
        },{
            xtype: 'webinex-combo-state'
            ,fieldLabel: _('affiliates.state')
            ,hiddenName: 'state'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('affiliates.code')
            ,name: 'code'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('affiliates.description')
            ,name: 'description'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('affiliates.notes')
            ,name: 'notes'
            ,anchor: '100%'
        }]
    });
    Webinex.window.UpdateAffiliate.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.window.UpdateAffiliate,MODx.Window);
Ext.reg('webinex-window-affiliate-update',Webinex.window.UpdateAffiliate);

Webinex.combo.State = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0
            ,fields: ['value','text']
            ,data: [
            		['NA', 'No State'],
            	    ['AL', 'Alabama'],
					['AK', 'Alaska'],
					['AZ', 'Arizona'],
					['AR', 'Arkansas'],
					['CA', 'California'],
					['CO', 'Colorado'],
					['CT', 'Connecticut'],
					['DE', 'Delaware'],
					['DC', 'District of Columbia'],
					['FL', 'Florida'],
					['GA', 'Georgia'],
					['HI', 'Hawaii'],
					['ID', 'Idaho'],
					['IL', 'Illinois'],
					['IN', 'Indiana'],
					['IA', 'Iowa'],
					['KS', 'Kansas'],
					['KY', 'Kentucky'],
					['LA', 'Louisiana'],
					['ME', 'Maine'],
					['MD', 'Maryland'],
					['MA', 'Massachusetts'],
					['MI', 'Michigan'],
					['MN', 'Minnesota'],
					['MS', 'Mississippi'],
					['MO', 'Missouri'],
					['MT', 'Montana'],
					['NE', 'Nebraska'],
					['NV', 'Nevada'],
					['NH', 'New Hampshire'],
					['NJ', 'New Jersey'],
					['NM', 'New Mexico'],
					['NY', 'New York'],
					['NC', 'North Carolina'],
					['ND', 'North Dakota'],
					['OH', 'Ohio'],
					['OK', 'Oklahoma'],
					['OR', 'Oregon'],
					['PA', 'Pennsylvania'],
					['PR', 'Puerto Rico'],
					['RI', 'Rhode Island'],
					['SC', 'South Carolina'],
					['SD', 'South Dakota'],
					['TN', 'Tennessee'],
					['TX', 'Texas'],
					['UT', 'Utah'],
					['VT', 'Vermont'],
					['VI', 'Virgin Islands'],
					['VA', 'Virginia'],
					['WA', 'Washington'],
					['WV', 'West Virginia'],
					['WI', 'Wisconsin'],
					['WY', 'Wyoming'],
            ]
        })
        ,mode: 'local'
        ,displayField: 'text'
        ,valueField: 'value'
    });
    Webinex.combo.State.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.combo.State,MODx.combo.ComboBox);
Ext.reg('webinex-combo-state',Webinex.combo.State);