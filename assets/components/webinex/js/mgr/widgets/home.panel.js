Webinex.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2>'+_('webinex')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,items: [{
                title: _('presenters')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('presenters.management_desc')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'webinex-grid-presenters'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            }, {
                title: _('companies')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('companies.management_desc')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'webinex-grid-companies'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            }, {
                title: _('affiliates')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('affiliates.management_desc')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'webinex-grid-affiliates'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            }, {
                title: _('documents')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('documents.management_desc')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'webinex-grid-documents'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            }, {
                title: _('videos')   
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('videos.management_desc')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'webinex-grid-videos'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            }]
        }]
    });
    Webinex.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.panel.Home,MODx.Panel);
Ext.reg('webinex-panel-home',Webinex.panel.Home);