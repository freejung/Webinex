<?php
 
$menu= $modx->newObject('modMenu');
$menu->fromArray(array(
    'text' => 'Refresh Webinar Templates',
    'parent' => 'site',
    'description' => 'Update the default webinar templates for all webinars.',
    'icon' => 'images/icons/plugin.gif',
    'menuindex' => 0,
    'params' => '',
    'handler' => 'var topic = "/webinex/";
var register = "mgr";
var console = MODx.load({
   xtype: "modx-console"
   ,register: register
   ,topic: topic
   ,show_filename: 0
   ,listeners: {
     "shutdown": {fn:function() {
         /* do code here when you close the console */
     },scope:this}
   }
});
console.show(Ext.getBody());

MODx.Ajax.request({
    url: "/assets/components/webinex/connector.php"
    ,params: {
        action: "mgr/overthruster/fullinit"
        ,register: register
        ,topic: topic
    }
    ,listeners: {
        "success":{fn:function() {
            console.fireEvent("complete");
        },scope:this}
    }
});',
),'',true,true);
 
return $menu;