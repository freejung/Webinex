Webinex.grid.Registrations = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'webinex-grid-registrations' 
        ,url: Webinex.config.connectorUrl
        ,baseParams: { action: 'mgr/registration/getList'
            ,presentation: config.presentation
            ,all: 0
        }
        ,fields: ['id','fullname','Company','Title','email','phone','state','referrer','attended','createdon']
        ,paging: true
        ,pageSize: 1000
        ,grouping: true
        ,groupBy: 'referrer'
        ,remoteSort: false
        ,sortBy: 'createdon'
        ,autosave: true
        ,pluralText: _('registrations')
        ,singleText: _('registration')
        ,anchor: '97%'
        ,autoExpandColumn: 'email'
        ,columns: [{
            header: _('id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 40
        },{
            header: _('prospect.fullname')
            ,dataIndex: 'fullname'
            ,sortable: true
            ,width: 300
        },{
            header: _('prospect.Company')
            ,dataIndex: 'Company'
            ,sortable: true
            ,width: 350
        },{
            header: _('prospect.Title')
            ,dataIndex: 'Title'
            ,sortable: true
            ,width: 350
        },{
            header: _('prospect.email')
            ,dataIndex: 'email'
            ,sortable: true
            ,width: 350
        },{
            header: _('prospect.phone')
            ,dataIndex: 'phone'
            ,sortable: true
            ,width: 350
        },{
            header: _('prospect.state')
            ,dataIndex: 'state'
            ,sortable: true
            ,width: 100
        },{
            header: _('affiliate.referrer')
            ,dataIndex: 'referrer'
            ,sortable: true
            ,width: 250
        },{
            header: _('registration.attended')
            ,dataIndex: 'attended'
            ,sortable: true
            ,width: 180
        },/*{
            header: _('registration.viewedrecording')
            ,dataIndex: 'viewedrecording'
            ,sortable: true
            ,width: 180
        },*/{
            header: _('registration.createdon')
            ,dataIndex: 'createdon'
            ,sortable: true
            ,width: 350
        }],tbar:[{
                xtype: 'button'
                ,text: _('registration.toggle_dups')
                ,handler: this.toggleAll
            }
        
		/*'->',{
            xtype: 'textfield'
            ,id: 'registrations-search-filter'
            ,emptyText: _('registration.search...')
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
        }*/]
    });
    Webinex.grid.Registrations.superclass.constructor.call(this,config)
};
Ext.extend(Webinex.grid.Registrations,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,toggleAll: function(tf,nv,ov) {
        var s = this.getStore();
        if(s.baseParams.all == 0)
        {s.baseParams.all = 1}
        else
        {s.baseParams.all = 0};
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
});

Ext.reg('webinex-grid-registrations',Webinex.grid.Registrations);