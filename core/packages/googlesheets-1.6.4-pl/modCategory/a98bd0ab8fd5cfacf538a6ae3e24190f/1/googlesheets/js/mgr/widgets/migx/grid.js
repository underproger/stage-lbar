GoogleSheets.grid.Migx = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'googlesheets-grid-migx';
    }
    Ext.applyIf(config, {
        url: GoogleSheets.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/migx/getlist',
            sort: 'rank',
            dir: 'asc',
        },
        stateful: true,
        stateId: config.id,
        ddGroup: 'googlesheets-grid-migxDD',
        ddAction: 'mgr/migx/sort',
        enableDragDrop: true,
        multi_select: true,
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateItem(grid, e, row);
            },
            render:{
                scope: this,
                fn: function(grid) {
                    var grid = this;
                    var el = grid.getEl();
                    new Ext.dd.DropTarget(el, {
                        ddGroup: grid.ddGroup,
                        notifyDrop: function (dd, e, data) {
                            var store = grid.getStore();
                            var target = store.getAt(dd.getDragData(e).rowIndex);
                            var sources = [];
                            if (data.selections.length < 1 || data.selections[0].id == target.id) {
                                return false;
                            }
                            for (var i in data.selections) {
                                if (!data.selections.hasOwnProperty(i)) {
                                    continue;
                                }
                                var row = data.selections[i];
                                sources.push(row.id);
                            }

                            el.mask(_('loading'), 'x-mask-loading');
                            MODx.Ajax.request({
                                url: config.url,
                                params: {
                                    action: config.ddAction,
                                    sources: Ext.util.JSON.encode(sources),
                                    target: target.id,
                                },
                                listeners: {
                                    success: {
                                        fn: function () {
                                            el.unmask();
                                            grid.refresh();
                                            if (typeof(grid.reloadTree) == 'function') {
                                                sources.push(target.id);
                                                grid.reloadTree(sources);
                                            }
                                        }, scope: grid
                                    },
                                    failure: {
                                        fn: function () {
                                            el.unmask();
                                        }, scope: grid
                                    },
                                }
                            });
                        },
                        notifyOver: function(dd, e, data) {
                            var returnCls = this.dropAllowed;
                            return returnCls;
                        },
                    });
                },
            },
        },
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0,
            getRowClass: function (rec) {
                return !rec.data.active
                    ? 'googlesheets-grid-row-disabled'
                    : '';
            }
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
    });
    GoogleSheets.grid.Migx.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(GoogleSheets.grid.Migx, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = GoogleSheets.utils.getMenu(row.data['actions'], this, ids);
    
        this.addContextMenuItem(menu);
    },

    createItem: function (btn, e) {
        var w = MODx.load({
            xtype: 'googlesheets-migx-window-create',
            id: Ext.id(),
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        w.reset();
        w.setValues({active: false});
        w.show(e.target);
    },
    
    copyItem: function (btn, e) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: _('googlesheets_copy'),
            text: ids.length > 1
                ? _('googlesheets_items_copy_confirm')
                : _('googlesheets_item_copy_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/migx/copy',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        return true;
    },

    updateItem: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/migx/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'googlesheets-migx-window-update',
                            id: Ext.id(),
                            record: r,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                }
                            }
                        });
                        w.reset();
                        w.setValues(r.object);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    removeItem: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: _('googlesheets_remove'),
            text:  _('googlesheets_migx_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/migx/remove',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        return true;
    },

    exportItem: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        var myMask = new Ext.LoadMask(Ext.getBody(), {msg:"Please wait..."});
        myMask.show();
        MODx.msg.confirm({
           title: _('googlesheets_export_confirm_title'),
           text: _('googlesheets_export_confirm_content'),
           url: this.config.url,
           params: {
              action: 'mgr/migx/export',
              ids: Ext.util.JSON.encode(ids),
           },
           listeners: {
                'success': {fn:function(r) {
                    myMask.hide();
                    MODx.msg.alert(
                       _('googlesheets_title_success'),
                        r.message,
                    );
                    this.refresh();
                },scope: this},
                'failure' : {fn:function(r) {
                    myMask.hide();
                    MODx.msg.alert('Warning!',r.message || r.data[0]['msg'], function() {});
                    this.refresh();
                },scope: this},
                'cancel': {fn:function(){
                    myMask.hide();
                }}
           }
        });
    },

    importItem: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        var myMask = new Ext.LoadMask(Ext.getBody(), {msg:"Please wait..."});
        myMask.show();
        MODx.msg.confirm({
           title: _('googlesheets_import_confirm_title'),
           text: _('googlesheets_import_confirm_content'),
           url: this.config.url,
           params: {
              action: 'mgr/migx/import',
              ids: Ext.util.JSON.encode(ids),
           },
           listeners: {
                'success': {fn:function(r) {
                    myMask.hide();
                    MODx.msg.alert(
                       _('googlesheets_title_success'),
                        r.message,
                    );
                    this.refresh();
                },scope: this},
                'failure' : {fn:function(r) {
                    myMask.hide();
                    MODx.msg.alert('Warning!',r.message || r.data[0]['msg'], function() {});
                    this.refresh();
                },scope: this},
                'cancel': {fn:function(){
                    myMask.hide();
                }}
           }
        });
    },

    getFields: function () {
        return ['id', 'name', 'range', 'resource', 'migx', 'actions'];
    },

    getColumns: function () {
        return [
        {
            header: _('googlesheets_id'),
            dataIndex: 'id',
            sortable: true,
            width: 50,
        }, {
            header: _('googlesheets_range'),
            dataIndex: 'range',
            sortable: true,
            width: 150,
        }, {
            header: _('googlesheets_resource'),
            dataIndex: 'resource',
            sortable: true,
            width: 150,
        }, {
            header: _('googlesheets_field_migx'),
            dataIndex: 'migx',
            sortable: false,
            width: 150,
        }, {
            header: _('googlesheets_grid_actions'),
            dataIndex: 'actions',
            renderer: GoogleSheets.utils.renderActions,
            sortable: false,
            width: 75,
            id: 'actions'
        }];
    },

    getTopBar: function () {
        return [{
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('googlesheets_create'),
            handler: this.createItem,
            scope: this
        }, '->', {
            xtype: 'googlesheets-field-search',
            width: 250,
            listeners: {
                search: {
                    fn: function (field) {
                        this._doSearch(field);
                    }, scope: this
                },
                clear: {
                    fn: function (field) {
                        field.setValue('');
                        this._clearSearch();
                    }, scope: this
                },
            }
        }];
    },

    onClick: function (e) {
        var elem = e.getTarget();
        if (elem.nodeName == 'BUTTON') {
            var row = this.getSelectionModel().getSelected();
            if (typeof(row) != 'undefined') {
                var action = elem.getAttribute('action');
                if (action == 'showMenu') {
                    var ri = this.getStore().find('id', row.id);
                    return this._showMenu(this, ri, e);
                }
                else if (typeof this[action] === 'function') {
                    this.menu.record = row.data;
                    return this[action](this, e);
                }
            }
        }
        return this.processEvent('click', e);
    },

    _getSelectedIds: function () {
        var ids = [];
        var selected = this.getSelectionModel().getSelections();

        for (var i in selected) {
            if (!selected.hasOwnProperty(i)) {
                continue;
            }
            ids.push(selected[i]['id']);
        }

        return ids;
    },

    _doSearch: function (tf) {
        this.getStore().baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
    },

    _clearSearch: function () {
        this.getStore().baseParams.query = '';
        this.getBottomToolbar().changePage(1);
    },
});
Ext.reg('googlesheets-grid-migx', GoogleSheets.grid.Migx);