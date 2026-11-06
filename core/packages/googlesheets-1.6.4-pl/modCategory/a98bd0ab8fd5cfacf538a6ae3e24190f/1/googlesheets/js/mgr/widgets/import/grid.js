GoogleSheets.grid.Imports = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'googlesheets-grid-imports';
    }
    Ext.applyIf(config, {
        url: GoogleSheets.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/import/getlist',
            sort: 'rank',
            dir: 'asc',
        },
        stateful: true,
        stateId: config.id,
        ddGroup: 'googlesheets-grid-importsDD',
        ddAction: 'mgr/import/sort',
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
    GoogleSheets.grid.Imports.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(GoogleSheets.grid.Imports, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = GoogleSheets.utils.getMenu(row.data['actions'], this, ids);
    
        this.addContextMenuItem(menu);
    },

    createItem: function (btn, e) {
        var w = MODx.load({
            xtype: 'googlesheets-import-window-create',
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
                action: 'mgr/import/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'googlesheets-import-window-update',
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
                action: 'mgr/import/copy',
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

    removeItem: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: _('googlesheets_remove'),
            text:  _('googlesheets_import_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/import/remove',
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

    removeData: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        
        MODx.msg.confirm({
           title: _('googlesheets_remove_confirm_title'),
           text: _('googlesheets_remove_confirm_content'),
           url: this.config.url,
           params: {
              action: 'mgr/import/remove_data',
              ids: Ext.util.JSON.encode(ids),
           },
           listeners: {
                'success': {fn:function(r) {
                    MODx.msg.alert(
                       _('googlesheets_title_success'),
                        r.message,
                    );
                    this.refresh();
                },scope: this},
                'failure' : {fn:function(r) {
                    MODx.msg.alert('Warning!',r.message || r.data[0]['msg'], function() {});
                    this.refresh();
                },scope: this},
           }
        });
    },
    
    getValues: function () {
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
                action: 'mgr/import/getvalues',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                'success': {fn:function(r) {
                    myMask.hide();
                    r.object.msg = {};
                    r.object.msg.total = r.object.total;
                    r.object.msg.offset = 0;
                    r.object.msg.error = 0;
                    r.object.msg.success = 0;
                    r.object.msg.update = 0;
                    r.object.msg.create = 0;
                    r.object.msg.empty = 0;
                    this._message(r.object);
                    this.importItem.call(this, r.object);
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

    importItem: function (obj) {
        MODx.Ajax.request({
            url: GoogleSheets.config.connector_url,
            params: {
                action: 'mgr/import/import',
                object: JSON.stringify(obj),
                value: JSON.stringify(obj.values[obj.msg.offset]),
            },
            listeners: {
                success: {fn:function(r){
                    ++obj.msg.success;
                    ++obj.msg.offset;
                    if(r.message == 'create') {
                        ++obj.msg.create;  
                    }
                    if(r.message == 'update') {
                        ++obj.msg.update;  
                    }
                    if(r.message == 'empty') {
                        ++obj.msg.empty;  
                    }
                    this._message(obj);
                    if(obj.total > obj.msg.offset) {
                        this.importItem(obj);
                        
                    }
                },scope: this},
                    
                failure: {fn:function(r){
                    ++obj.msg.error;
                    ++obj.msg.offset;
                    this._message(obj);
                    if(obj.total > obj.msg.offset) {
                        this.importItem(obj);
                    }
                },scope: this},
            }
        });
    },
    
    getFields: function () {
        return ['id', 'name', 'range', 'type', 'import_fields', 'unique', 'imethod', 'actions'];
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
            width: 100,
        }, {
            header: _('googlesheets_import_type'),
            dataIndex: 'type',
            sortable: true,
            width: 150,
        }, {
            header: _('googlesheets_import_fields'),
            dataIndex: 'import_fields',
            sortable: false,
            width: 300,
        }, {
            header: _('googlesheets_field_unique'),
            dataIndex: 'unique',
            sortable: false,
            width: 100,
        }, {
            header: _('googlesheets_import_imethod'),
            dataIndex: 'imethod',
            sortable: false,
            width: 100,
        }, {
            header: _('googlesheets_grid_actions'),
            dataIndex: 'actions',
            renderer: GoogleSheets.utils.renderActions,
            sortable: false,
            width: 100,
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
    
    _message: function(obj) {
        obj.title = _('googlesheets_msg_loading');
        obj.message = _('googlesheets_msg_processed') + ' ' + obj.msg.offset + ' из ' + obj.total;
        
        if(obj.total == obj.msg.offset) {
            var content = '<br>';
            for (let [key, value] of Object.entries(obj.msg)) {
                if(key == 'offset') key = 'processed';
                if(value > 0) {
                    content += _('googlesheets_msg_' + key) + ': ' + value + '<br>';    
                }
            }
            MODx.msg.alert(
              _('googlesheets_title_success'), content
            );
        } else {
            if(obj.progress) {
                // obj.progress.updateText(obj.msg.message, obj.msg.title);
                var procent = Math.round(obj.msg.offset / obj.total * 100); 
                obj.progress.updateProgress(undefined, procent + '%', obj.message)
            } else {
                obj.progress = Ext.Msg.wait(obj.message, obj.title);
            }
            // MODx.msg.status({
            //     'title': _('googlesheets_msg_loading'),
            //     'message' : message, 
            //     'dontHide' : (obj.total == obj.offset + 1) ? false : true
            // });
            
        } 
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
Ext.reg('googlesheets-grid-imports', GoogleSheets.grid.Imports);