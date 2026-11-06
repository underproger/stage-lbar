GoogleSheets.window.CreateExport = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'googlesheets-export-window-create';
    }
    Ext.applyIf(config, {
        title: _('googlesheets_export_create'),
        width: 550,
        autoHeight: true,
        url: GoogleSheets.config.connector_url,
        action: 'mgr/export/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit();
            }, scope: this
        }]
    });
    GoogleSheets.window.CreateExport.superclass.constructor.call(this, config);
};
Ext.extend(GoogleSheets.window.CreateExport, MODx.Window, {

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
                    store: ['modResource','msCategory','msProduct','msOrder','msVendor','modUser','msClient','msOptionsPrice2','msProductRemains'],
                    fieldLabel: _('googlesheets_export_type'),
                    name: 'type',
                    id: config.id + '-type',
                    anchor: '99%',
                    allowBlank: false,
                    listeners: {
                        select: {fn: GoogleSheets.window.CreateExport.prototype.onSelectResource, scope: this},
                    }
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
            fieldLabel: _('googlesheets_export_fields'),
            name: 'export_fields',
            id: config.id + '-export_fields',
            anchor: '99%',
            height:100,
            allowBlank: false,
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('googlesheets_header_table'),
            name: 'header_table',
            id: config.id + '-header_table',
            anchor: '99%',
            checked: config.record ? config.record.object['header_table'] : false,
        }, {
            xtype: 'checkboxgroup',
            hideLabel: false,
            fieldLabel: _('googlesheets_sync'),
            name: 'checkboxgroup',
            id: config.id + '-sync',
            columns: 3,
            items:[{
                xtype: 'xcheckbox',
                boxLabel: _('googlesheets_sync_create'),
                name: 'create',
                id: config.id + '-create',
                anchor: '99%',
                checked: config.record ? config.record.object['create'] : false,
            }, {
                xtype: 'xcheckbox',
                boxLabel: _('googlesheets_sync_update'),
                name: 'update',
                id: config.id + '-update',
                anchor: '99%',
                checked: config.record ? config.record.object['update'] : false,
            }, {
                xtype: 'xcheckbox',
                boxLabel: _('googlesheets_sync_remove'),
                name: 'remove',
                id: config.id + '-remove',
                anchor: '99%',
                checked: config.record ? config.record.object['remove'] : false,
            }]
        }, {
            xtype: 'textfield',
            fieldLabel: _('googlesheets_unique_sync'),
            name: 'unique',
            id: config.id + '-unique',
            anchor: '99%',
        }];
    },
    
    onSelectResource: function(combo, row) {
        // Получаем значение
        var val = row == undefined ? Ext.getCmp(this.config.id + '-type').getValue() : row.data.field1;
        var exportFieldHelp = Ext.getCmp(this.config.id + '-export-fields-help');
        exportFieldHelp.hide();
        
        var sync = Ext.getCmp(this.config.id + '-sync');
        if(sync) {
            sync.show();
        }
        
        switch(val){
            case 'modResource':
            case 'msProduct':
                exportFieldHelp.show();
                break;
            case 'msClient':
            case 'msOptionsPrice2':
            case 'msProductRemains':
                if(sync) {
                    sync.hide();
                }
                break;
        }
    },

    loadDropZones: function () {
    }

});
Ext.reg('googlesheets-export-window-create', GoogleSheets.window.CreateExport);

GoogleSheets.window.UpdateExport = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'googlesheets-export-window-update';
    }
    Ext.applyIf(config, {
        title: _('googlesheets_update'),
        width: 550,
        autoHeight: true,
        url: GoogleSheets.config.connector_url,
        action: 'mgr/export/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    GoogleSheets.window.UpdateExport.superclass.constructor.call(this, config);
};
Ext.extend(GoogleSheets.window.UpdateExport, MODx.Window, {

    getFields: function (config) {
        return GoogleSheets.window.CreateExport.prototype.getFields.call(this, config);
    },
    
    loadDropZones: function () {
    }

});
Ext.reg('googlesheets-export-window-update', GoogleSheets.window.UpdateExport);