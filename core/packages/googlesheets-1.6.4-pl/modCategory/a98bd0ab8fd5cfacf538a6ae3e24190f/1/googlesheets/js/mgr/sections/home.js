GoogleSheets.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'googlesheets-panel-home',
            renderTo: 'googlesheets-panel-home-div'
        }],
        buttons: this.getButtons(),
    });
    GoogleSheets.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(GoogleSheets.page.Home, MODx.Component,{
    getButtons: function() {
        var auth = MODx.config.googlesheets_auth_code == '' && MODx.config.googlesheets_token == '' ? false : true;
        return [{
            text: _('googlesheets_btn_get_token'),
            handler: this.getToken,
            cls: 'googlesheets-btn-primary',
            id: 'googlesheets-btn-auth',
            scope: this,
            hidden: auth,
        }, {
            text: _('googlesheets_btn_reset_token'),
            handler: this.clearToken,
            cls: 'googlesheets-btn-danger',
            id: 'googlesheets-btn-auth-clear',
            scope: this,
            hidden: !auth,
        }];
    },
    getToken: function(){
        MODx.Ajax.request({
            url: GoogleSheets.config.connectorUrl,
            params: {
                action: 'mgr/auth/token'
            },
            listeners: {
                success: {fn: function(r) {
                    
                    if(r.object.status) {
                        MODx.msg.alert(
                            _('googlesheets_auth'),
                            r.message,
                            function() {},MODx);
                        Ext.getCmp('googlesheets-btn-auth-clear').setVisible(true);
                        Ext.getCmp('googlesheets-btn-auth').setVisible(false);    
                    } else {
                        if(r.object.type == 'text') {
                            MODx.msg.alert(
                            'Warning!',
                            r.message,
                            function() {},MODx);
                        }
                        
                        if(r.object.type == 'uri' && r.message != '') {
                            window.open(r.message);
                            
                        }
                    }
                    
                    MODx.clearCache();
                    
                }, scope: this},
                failure: {fn: function(r) {
                    console.log(r);
                }, scope: this},
                scope: this
            }
        });
    },
    
    clearToken: function(){
        MODx.msg.confirm({
            title: _('googlesheets_auth_reset_title'),
            text:  _('googlesheets_auth_reset_confirm'),
            url: GoogleSheets.config.connectorUrl,
            params: {
                action: 'mgr/auth/reset',
            },
            listeners: {
                success: {
                    fn: function (r) {
                        MODx.msg.alert(
                        _('googlesheets_auth_reset_title'),
                        r.message,
                        function() {},MODx);
                        MODx.clearCache();
                        Ext.getCmp('googlesheets-btn-auth-clear').setVisible(false);
                        Ext.getCmp('googlesheets-btn-auth').setVisible(true);
                    }, scope: this
                }
            }
        });
    }
});
Ext.reg('googlesheets-page-home', GoogleSheets.page.Home);