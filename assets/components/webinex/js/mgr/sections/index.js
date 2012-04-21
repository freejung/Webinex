Ext.onReady(function() {
    MODx.load({ xtype: 'webinex-page-home'});
});
 
Webinex.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'webinex-panel-home'
            ,renderTo: 'webinex-panel-home-div'
        }]
    });
    Webinex.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(Webinex.page.Home,MODx.Component);
Ext.reg('webinex-page-home',Webinex.page.Home);