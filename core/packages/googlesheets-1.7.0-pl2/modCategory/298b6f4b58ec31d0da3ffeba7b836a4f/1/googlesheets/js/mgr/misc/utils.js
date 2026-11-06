GoogleSheets.utils.renderBoolean = function (value) {
    return value
        ? String.format('<span class="green">{0}</span>', _('yes'))
        : String.format('<span class="red">{0}</span>', _('no'));
};

GoogleSheets.utils.getMenu = function (actions, grid, selected) {
    var menu = [];
    var cls, icon, title, action;

    var has_delete = false;
    for (var i in actions) {
        if (!actions.hasOwnProperty(i)) {
            continue;
        }

        var a = actions[i];
        if (!a['menu']) {
            if (a == '-') {
                menu.push('-');
            }
            continue;
        }
        else if (menu.length > 0 && !has_delete && (/^remove/i.test(a['action']) || /^delete/i.test(a['action']))) {
            menu.push('-');
            has_delete = true;
        }

        if (selected.length > 1) {
            if (!a['multiple']) {
                continue;
            }
            else if (typeof(a['multiple']) == 'string') {
                a['title'] = a['multiple'];
            }
        }

        icon = a['icon'] ? a['icon'] : '';
        if (typeof(a['cls']) == 'object') {
            if (typeof(a['cls']['menu']) != 'undefined') {
                icon += ' ' + a['cls']['menu'];
            }
        }
        else {
            cls = a['cls'] ? a['cls'] : '';
        }
        title = a['title'] ? a['title'] : a['title'];
        action = a['action'] ? grid[a['action']] : '';

        menu.push({
            handler: action,
            text: String.format(
                '<span class="{0}"><i class="x-menu-item-icon {1}"></i>{2}</span>',
                cls, icon, title
            ),
            scope: grid
        });
    }

    return menu;
};

GoogleSheets.utils.renderActions = function (value, props, row) {
    var res = [];
    var cls, icon, title, action, item;
    for (var i in row.data.actions) {
        if (!row.data.actions.hasOwnProperty(i)) {
            continue;
        }
        var a = row.data.actions[i];
        if (!a['button']) {
            continue;
        }

        icon = a['icon'] ? a['icon'] : '';
        if (typeof(a['cls']) == 'object') {
            if (typeof(a['cls']['button']) != 'undefined') {
                icon += ' ' + a['cls']['button'];
            }
        }
        else {
            cls = a['cls'] ? a['cls'] : '';
        }
        action = a['action'] ? a['action'] : '';
        title = a['title'] ? a['title'] : '';

        item = String.format(
            '<li class="{0}"><button class="googlesheets-btn googlesheets-btn-default {1}" action="{2}" title="{3}"></button></li>',
            cls, icon, action, title
        );

        res.push(item);
    }

    return String.format(
        '<ul class="googlesheets-row-actions">{0}</ul>',
        res.join('')
    );
};

GoogleSheets.utils.Hash = {
    get: function () {
        var vars = {}, hash, splitter, hashes;
        if (!this.oldbrowser()) {
            var pos = window.location.href.indexOf('?');
            hashes = (pos != -1) ? decodeURIComponent(window.location.href.substr(pos + 1)).replace('+', ' ') : '';
            splitter = '&';
        }
        else {
            hashes = decodeURIComponent(window.location.hash.substr(1)).replace('+', ' ');
            splitter = '/';
        }

        if (hashes.length == 0) {
            return vars;
        }
        else {
            hashes = hashes.split(splitter);
        }

        var matches, key;
        for (var i in hashes) {
            if (hashes.hasOwnProperty(i)) {
                hash = hashes[i].split('=');
                if (typeof hash[1] == 'undefined') {
                    vars['anchor'] = hash[0];
                }
                else {
                    matches = hash[0].match(/\[(.*?|)\]$/);
                    if (matches) {
                        key = hash[0].replace(matches[0], '');
                        if (!vars.hasOwnProperty(key)) {
                            // Array
                            if (matches[1] == '') {
                                vars[key] = [];
                            }
                            // Object
                            else {
                                vars[key] = {};
                            }
                        }
                        if (vars[key] instanceof Array) {
                            vars[key].push(hash[1]);
                        }
                        else {
                            vars[key][matches[1]] = hash[1];
                        }
                    }
                    // String or numeric
                    else {
                        vars[hash[0]] = hash[1];
                    }
                }
            }
        }
        return vars;
    },

    set: function (vars) {
        var hash = '';
        for (var i in vars) {
            if (vars.hasOwnProperty(i)) {
                if (typeof vars[i] == 'object') {
                    for (var j in vars[i]) {
                        if (vars[i].hasOwnProperty(j)) {
                            // Array
                            if (vars[i] instanceof Array) {
                                hash += '&' + i + '[]=' + vars[i][j];
                            }
                            // Object
                            else {
                                hash += '&' + i + '[' + j + ']=' + vars[i][j];
                            }
                        }
                    }
                }
                // String or numeric
                else {
                    hash += '&' + i + '=' + vars[i];
                }
            }
        }

        if (!this.oldbrowser()) {
            if (hash.length != 0) {
                hash = '?' + hash.substr(1);
            }
            window.history.pushState({pdoPage: document.location.pathname + hash}, '', document.location.pathname + hash);
        }
        else {
            window.location.hash = hash.substr(1);
        }
    },

    add: function (key, val) {
        var hash = this.get();
        hash[key] = val;
        this.set(hash);
    },

    remove: function (key) {
        var hash = this.get();
        delete hash[key];
        this.set(hash);
    },

    clear: function () {
        this.set({});
    },

    oldbrowser: function () {
        return !(window.history && history.pushState);
    }
};