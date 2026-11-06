GoogleSheets.window.CreateImport = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'googlesheets-import-window-create';
    }
    Ext.applyIf(config, {
        title: _('googlesheets_create'),
        width: 550,
        autoHeight: true,
        url: GoogleSheets.config.connector_url,
        action: 'mgr/import/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit();
            }, scope: this
        }]
    });
    GoogleSheets.window.CreateImport.superclass.constructor.call(this, config);
};
Ext.extend(GoogleSheets.window.CreateImport, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        },{
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
            items:[{
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items:[{
                    xtype: 'modx-combo',
                    store: ['modResource','msCategory','msProduct','msVendor','msOptionsPrice2','msProductRemains'],
                    fieldLabel: _('googlesheets_import_type'),
                    name: 'type',
                    id: config.id + '-type',
                    anchor: '99%',
                    allowBlank: false,
                }],
            },{
                columnWidth: .5,
                layout: 'form',
                defaults: {msgTarget: 'under'},
                items:[{
                    xtype: 'modx-combo',
                    store: ['Default', 'Create', 'Update'],
                    fieldLabel: _('googlesheets_import_imethod'),
                    name: 'imethod',
                    id: config.id + '-imethod',
                    anchor: '99%',
                    allowBlank: false,
                }],
            }]
        }, {
            xtype: 'textarea',
            fieldLabel: _('googlesheets_import_fields'),
            name: 'import_fields',
            id: config.id + '-import_fields',
            anchor: '99%',
            height:'100',
            allowBlank: false,
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('googlesheets_skip_first'),
            name: 'skip_first',
            id: config.id + '-skip_first',
            anchor: '99%',
            checked: config.record ? config.record.object['skip_first'] : false,
        }, {
            xtype: 'textfield',
            fieldLabel: _('googlesheets_field_unique'),
            name: 'unique',
            id: config.id + '-unique',
            anchor: '99%',
            allowBlank: false,
        }
        // , {
        //     xtype: 'checkboxgroup',
        //     hideLabel: false,
        //     fieldLabel: _('googlesheets_sync'),
        //     name: 'checkboxgroup',
        //     columns: 3,
        //     items:[{
        //         xtype: 'xcheckbox',
        //         boxLabel: _('googlesheets_sync_create'),
        //         name: 'create',
        //         id: config.id + '-create',
        //         anchor: '99%',
        //         checked: config.record ? config.record.object['create'] : false,
        //     }, {
        //         xtype: 'xcheckbox',
        //          boxLabel: _('googlesheets_sync_update'),
        //         name: 'update',
        //         id: config.id + '-update',
        //         anchor: '99%',
        //         checked: config.record ? config.record.object['update'] : false,
        //     }, {
        //         xtype: 'xcheckbox',
        //          boxLabel: _('googlesheets_sync_remove'),
        //         name: 'remove',
        //         id: config.id + '-remove',
        //         anchor: '99%',
        //         checked: config.record ? config.record.object['remove'] : false,
        //     }]
        // }
        ];
    },

    loadDropZones: function () {
    }

});
Ext.reg('googlesheets-import-window-create', GoogleSheets.window.CreateImport);

GoogleSheets.window.UpdateImport = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'googlesheets-import-window-update';
    }
    Ext.applyIf(config, {
        title: _('googlesheets_update'),
        width: 550,
        autoHeight: true,
        url: GoogleSheets.config.connector_url,
        action: 'mgr/import/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    GoogleSheets.window.UpdateImport.superclass.constructor.call(this, config);
};
Ext.extend(GoogleSheets.window.UpdateImport, MODx.Window, {

    getFields: function (config) {
        return GoogleSheets.window.CreateImport.prototype.getFields.call(this, config);
    },

    loadDropZones: function () {
    }

});
Ext.reg('googlesheets-import-window-update', GoogleSheets.window.UpdateImport);