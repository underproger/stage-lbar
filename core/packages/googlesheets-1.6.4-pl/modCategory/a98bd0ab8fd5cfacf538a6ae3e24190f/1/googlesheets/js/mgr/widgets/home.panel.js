GoogleSheets.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'googlesheets-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('googlesheets') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('googlesheets_import_tab'),
                layout: 'anchor',
                items: [{
                    html: _('googlesheets_import_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'googlesheets-grid-imports',
                    cls: 'main-wrapper',
                }]
            },{
                title: _('googlesheets_export_tab'),
                layout: 'anchor',
                items: [{
                    html: _('googlesheets_export_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'googlesheets-grid-exports',
                    cls: 'main-wrapper',
                }]
            },{
                title: _('googlesheets_migx'),
                layout: 'anchor',
                items: [{
                    html: _('googlesheets_migx_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'googlesheets-grid-migx',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    GoogleSheets.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(GoogleSheets.panel.Home, MODx.Panel);
Ext.reg('googlesheets-panel-home', GoogleSheets.panel.Home);
