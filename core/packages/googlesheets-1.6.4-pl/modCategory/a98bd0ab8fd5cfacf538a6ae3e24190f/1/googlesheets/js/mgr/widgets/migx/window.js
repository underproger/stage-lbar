GoogleSheets.window.CreateMigx = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'googlesheets-migx-window-create';
    }
    Ext.applyIf(config, {
        title: _('googlesheets_migx_create'),
        width: 550,
        autoHeight: true,
        url: GoogleSheets.config.connector_url,
        action: 'mgr/migx/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit();
            }, scope: this
        }]
    });
    GoogleSheets.window.CreateMigx.superclass.constructor.call(this, config);
};
Ext.extend(GoogleSheets.window.CreateMigx, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('googlesheets_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            fieldLabel: _('googlesheets_range'),
            name: 'range',
            id: config.id + '-range',
            anchor: '99%',
            allowBlank: false,
        }, {
            layout: 'column',
            items: [{
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'textfield',
                    fieldLabel: _('googlesheets_resource'),
                    description: _('googlesheets_resource_desc'),
                    name: 'resource',
                    id: config.id + '-resource',
                    anchor: '99%',
                    allowBlank: false
                }]
            }, {
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'googlesheets-combo-migx',
                    fieldLabel: _('googlesheets_migx'),
                    name: 'migx',
                    id: config.id + '-migx',
                    anchor: '99%',
                    allowBlank: false
                }]
            }]
        }];
    },
    

    loadDropZones: function () {
    }

});
Ext.reg('googlesheets-migx-window-create', GoogleSheets.window.CreateMigx);

GoogleSheets.window.UpdateMigx = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'googlesheets-migx-window-update';
    }
    Ext.applyIf(config, {
        title: _('googlesheets_update'),
        width: 550,
        autoHeight: true,
        url: GoogleSheets.config.connector_url,
        action: 'mgr/migx/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    GoogleSheets.window.UpdateMigx.superclass.constructor.call(this, config);
};
Ext.extend(GoogleSheets.window.UpdateMigx, MODx.Window, {

    getFields: function (config) {
        return GoogleSheets.window.CreateMigx.prototype.getFields.call(this, config);
    },
    
    loadDropZones: function () {
    }

});
Ext.reg('googlesheets-migx-window-update', GoogleSheets.window.UpdateMigx);