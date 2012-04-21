var Webinex = function(config) {
    config = config || {};
    Webinex.superclass.constructor.call(this,config);
};
Ext.extend(Webinex,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},view: {}
});
Ext.reg('Webinex',Webinex);
Webinex = new Webinex();