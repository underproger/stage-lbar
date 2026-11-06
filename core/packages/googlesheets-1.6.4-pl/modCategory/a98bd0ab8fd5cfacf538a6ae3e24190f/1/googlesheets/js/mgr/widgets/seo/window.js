GoogleSheets.window.CreateSEO = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'googlesheets-seo-window-create';
    }
    Ext.applyIf(config, {
        title: _('googlesheets_create'),
        width: 550,
        autoHeight: true,
        url: GoogleSheets.config.connector_url,
        action: 'mgr/seo/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit();
            }, scope: this
        }]
    });
    GoogleSheets.window.CreateSEO.superclass.constructor.call(this, config);
};
Ext.extend(GoogleSheets.window.CreateSEO, MODx.Window, {

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
                    xtype: 'modx-combo',
                    store: ['modResource','msCategory','msProduct'],
                    fieldLabel: _('googlesheets_export_type'),
                    name: 'type',
                    id: config.id + '-type',
                    anchor: '99%',
                    allowBlank: false,
                }]
            }, {
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items: [{
                    xtype: 'modx-combo',
                    store: ['Append', 'Update'],
                    fieldLabel: _('googlesheets_export_imethod'),
                    name: 'imethod',
                    id: config.id + '-imethod',
                    anchor: '99%',
                    allowBlank: false,
                }]
            }]
        }, {
            xtype: 'textarea',
            fieldLabel: _('googlesheets_seo_fields'),
            name: 'fields',
            id: config.id + '-fields',
            anchor: '99%',
            height:150,
            allowBlank: false,
        }];
    },
    


    loadDropZones: function () {
    }

});
Ext.reg('googlesheets-seo-window-create', GoogleSheets.window.CreateSEO);

GoogleSheets.window.UpdateSEO = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'googlesheets-seo-window-update';
    }
    Ext.applyIf(config, {
        title: _('googlesheets_update'),
        width: 550,
        autoHeight: true,
        url: GoogleSheets.config.connector_url,
        action: 'mgr/seo/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    GoogleSheets.window.UpdateSEO.superclass.constructor.call(this, config);
};
Ext.extend(GoogleSheets.window.UpdateSEO, MODx.Window, {

    getFields: function (config) {
        return GoogleSheets.window.CreateSEO.prototype.getFields.call(this, config);
    },
    
    loadDropZones: function () {
    }

});
Ext.reg('googlesheets-seo-window-update', GoogleSheets.window.UpdateSEO);