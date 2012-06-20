Webinex.grid.Videos = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'webinex-grid-videos' 
        ,url: Webinex.config.connectorUrl
        ,baseParams: { action: 'mgr/video/getList' }
        ,save_action: 'mgr/video/updateFromGrid'
        ,fields: ['id','title','url','imageurl','host','hostid','runtime','description','recordedon']
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
            header: _('videos.title')
            ,dataIndex: 'title'
            ,sortable: true
            ,width: 350
            ,editor: { xtype: 'textfield' }
        },{
            header: _('videos.url')
            ,dataIndex: 'url'
            ,sortable: true
            ,width: 350
            ,editor: { xtype: 'textfield' }
        },{
            header: _('videos.imageurl')
            ,dataIndex: 'imageurl'
            ,sortable: true
            ,width: 350
            ,editor: { xtype: 'textfield' }
        },{
            header: _('videos.host')
            ,dataIndex: 'host'
            ,sortable: false
            ,width: 200
            ,editor: { xtype: 'webinex-combo-host' ,renderer: true}
        },{
            header: _('videos.hostid')
            ,dataIndex: 'hostid'
            ,sortable: true
            ,width: 350
            ,editor: { xtype: 'textfield' }
        },{
            header: _('videos.runtime')
            ,dataIndex: 'runtime'
            ,sortable: true
            ,width: 350
            ,editor: { xtype: 'textfield' }
        },{
            header: _('videos.description')
            ,dataIndex: 'description'
            ,sortable: true
            ,width: 350
            ,editor: { xtype: 'textfield' }
        }],tbar:[{
            text: _('webinex.video_create')
            ,handler: { xtype: 'webinex-window-video-create' ,blankValues: true ,baseParams: {action: 'mgr/video/create'} }
        },'->',{
            xtype: 'textfield'
            ,id: 'videos-search-filter'
            ,emptyText: _('videos.search...')
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
    Webinex.grid.Videos.superclass.constructor.call(this,config)
};
Ext.extend(Webinex.grid.Videos,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,getMenu: function() {
        return [{
            text: _('webinex.video_update')
            ,handler: this.updateVideo
        },'-',{
            text: _('webinex.video_remove')
            ,handler: this.removeVideo
        }];
    }
    ,updateVideo: function(btn,e) {
        if (!this.updateVideoWindow) {
            this.updateVideoWindow = MODx.load({
                xtype: 'webinex-window-video-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.updateVideoWindow.setValues(this.menu.record);
        this.updateVideoWindow.show(e.target);
    }

    ,removeVideo: function() {
        MODx.msg.confirm({
            title: _('webinex.video_remove')
            ,text: _('webinex.video_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/video/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
});

Ext.reg('webinex-grid-videos',Webinex.grid.Videos);

Webinex.window.UpdateVideo = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('webinex.video_update')
        ,url: Webinex.config.connectorUrl
        ,baseParams: {
            action: 'mgr/video/update'
        }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
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
            ,id: 'webinex-video-imageurl'
            ,maxLength: 255
            ,anchor: '100%'
            ,listeners: {
                'select':{fn:function(data) {
                    var str = data.fullRelativeUrl;
                    if (MODx.config.base_url != '/') {
                        str = str.replace(MODx.config.base_url,'');
                    }
                    if (str.substring(0,1) == '/') { str = str.substring(1); }
                    Ext.getCmp('webinex-video-imageurl').setValue(str);
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
        }]
    });
    Webinex.window.UpdateVideo.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.window.UpdateVideo,MODx.Window);
Ext.reg('webinex-window-video-update',Webinex.window.UpdateVideo);