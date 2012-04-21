Webinex.grid.Documents = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'webinex-grid-documents'
        ,url: Webinex.config.connectorUrl
        ,baseParams: { action: 'mgr/document/getList' }
        ,save_action: 'mgr/document/updateFromGrid'
        ,fields: ['id','title','url','doctype','description']
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
            header: _('documents.title')
            ,dataIndex: 'title'
            ,sortable: true
            ,width: 350
            ,editor: { xtype: 'textfield' }
        },{
            header: _('documents.url')
            ,dataIndex: 'url'
            ,sortable: true
            ,width: 350
            ,editor: { xtype: 'textfield' }
        },{
            header: _('documents.doctype')
            ,dataIndex: 'doctype'
            ,sortable: false
            ,width: 200
            ,editor: { xtype: 'webinex-combo-doctype' ,renderer: true}
        },{
            header: _('documents.description')
            ,dataIndex: 'description'
            ,sortable: true
            ,width: 350
            ,editor: { xtype: 'textfield' }
        }],tbar:[{
            text: _('webinex.document_create')
            ,handler: { xtype: 'webinex-window-document-create' ,blankValues: true ,baseParams: {action: 'mgr/document/create'}}
        },'->',{
            xtype: 'textfield'
            ,id: 'documents-search-filter'
            ,emptyText: _('documents.search...')
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
    Webinex.grid.Documents.superclass.constructor.call(this,config)
};
Ext.extend(Webinex.grid.Documents,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,getMenu: function() {
        return [{
            text: _('webinex.document_update')
            ,handler: this.updateDocument
        },'-',{
            text: _('webinex.document_remove')
            ,handler: this.removeDocument
        }];
    }
    ,updateDocument: function(btn,e) {
        if (!this.updateDocumentWindow) {
            this.updateDocumentWindow = MODx.load({
                xtype: 'webinex-window-document-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.updateDocumentWindow.setValues(this.menu.record);
        this.updateDocumentWindow.show(e.target);
    }

    ,removeDocument: function() {
        MODx.msg.confirm({
            title: _('webinex.document_remove')
            ,text: _('webinex.document_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/document/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
});

Ext.reg('webinex-grid-documents',Webinex.grid.Documents);

Webinex.window.UpdateDocument = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('webinex.document_update')
        ,url: Webinex.config.connectorUrl
        ,baseParams: {
            action: 'mgr/document/update'
        }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
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
            ,id: 'webinex-document-url'
            ,maxLength: 255
            ,anchor: '100%'
            ,listeners: {
                'select':{fn:function(data) {
                    var str = data.fullRelativeUrl;
                    if (MODx.config.base_url != '/') {
                        str = str.replace(MODx.config.base_url,'');
                    }
                    if (str.substring(0,1) == '/') { str = str.substring(1); }
                    Ext.getCmp('webinex-document-url').setValue(str);
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
    Webinex.window.UpdateDocument.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.window.UpdateDocument,MODx.Window);
Ext.reg('webinex-window-document-update',Webinex.window.UpdateDocument);