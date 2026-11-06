GoogleSheets.combo.Search = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        xtype: 'twintrigger',
        ctCls: 'x-field-search',
        allowBlank: true,
        msgTarget: 'under',
        emptyText: _('search'),
        name: 'query',
        triggerAction: 'all',
        clearBtnCls: 'x-field-search-clear',
        searchBtnCls: 'x-field-search-go',
        onTrigger1Click: this._triggerSearch,
        onTrigger2Click: this._triggerClear,
    });
    GoogleSheets.combo.Search.superclass.constructor.call(this, config);
    this.on('render', function () {
        this.getEl().addKeyListener(Ext.EventObject.ENTER, function () {
            this._triggerSearch();
        }, this);
    });
    this.addEvents('clear', 'search');
};
Ext.extend(GoogleSheets.combo.Search, Ext.form.TwinTriggerField, {

    initComponent: function () {
        Ext.form.TwinTriggerField.superclass.initComponent.call(this);
        this.triggerConfig = {
            tag: 'span',
            cls: 'x-field-search-btns',
            cn: [
                {tag: 'div', cls: 'x-form-trigger ' + this.searchBtnCls},
                {tag: 'div', cls: 'x-form-trigger ' + this.clearBtnCls}
            ]
        };
    },

    _triggerSearch: function () {
        this.fireEvent('search', this);
    },

    _triggerClear: function () {
        this.fireEvent('clear', this);
    },

});
Ext.reg('googlesheets-combo-search', GoogleSheets.combo.Search);
Ext.reg('googlesheets-field-search', GoogleSheets.combo.Search);

GoogleSheets.combo.Migx = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        name: config.name || 'migx',
        fieldLabel: _('googlesheets_migx'),
        hiddenName: config.name || 'migx',
        displayField: 'name',
        valueField: 'name',
        anchor: '99%',
        fields: ['name'],
        pageSize: 20,
        url: GoogleSheets.config['connector_url'],
        typeAhead: true,
        editable: true,
        allowBlank: true,
        emptyText: '',
        minChars: 1,
        baseParams: {
            action: 'mgr/migx/getlisttv',
            id: config.value,
        }
    });
    GoogleSheets.combo.Migx.superclass.constructor.call(this, config);
    this.on('expand', function () {
        if (!!this.pageTb) {
            this.pageTb.show();
        }
    });
};
Ext.extend(GoogleSheets.combo.Migx, MODx.combo.ComboBox);
Ext.reg('googlesheets-combo-migx', GoogleSheets.combo.Migx);