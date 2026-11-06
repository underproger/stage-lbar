(function ($, msFavoritesConfig) {
    "use strict";

    var indexOf = [].indexOf || function (item) {
            for (var i = 0, l = this.length; i < l; i++) {
                if (i in this && this[i] === item) return i;
            }
            return -1;
        };
    var hasProp = {}.hasOwnProperty;
    var slice = [].slice;

    var bind = function (fn, me) {
        return function () {
            return fn.apply(me, arguments);
        };
    };

    var camelize = function (str) {
        return str.replace(/(-|\.)(\w)/g, function (match, symbol) {
            return symbol.toUpperCase();
        });
    };
    var uncamelize = function (str) {
        return str.replace(/[A-Z]/g, function (symbol, index) {
            return (index == 0 ? '' : '-') + symbol.toLowerCase();
        });
    };

    var setOptions = function ($node, ns, options) {
        var prefix, msfavorites;

        if (typeof ns == 'undefined') {
            ns = $.fn.msfavorites.defaults.ns;
        }

        prefix = camelize(ns);
        msfavorites = $node.data('msFavorites');

        $.each(options, function (index, value) {
            $node.data(prefix + '-' + index, value);
        });

        if (msfavorites) {
            switch (prefix) {
                case 'data':
                    msfavorites.data = $.extend(true, msfavorites.data, options);
                    break;
                case 'options':
                    msfavorites.options = $.extend(true, msfavorites.options, options);
                    break;
            }
        }

        return options;
    };

    var getOptions = function ($node, ns) {
        var prefix, options;

        if (typeof ns == 'undefined') {
            ns = $.fn.msfavorites.defaults.ns;
        }

        prefix = camelize(ns);
        options = $node.data(prefix) || {};

        $.each($node.data(), function (index, value) {
            if (index.indexOf(prefix) === 0) {
                var key = uncamelize(index.replace(prefix, ''));
                if (key.length > 0) {
                    options[key] = value;
                }
            }
        });

        return options;
    };

    var newGuid = function () {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    };

    var inArray = function (needle, haystack) {
        for (var key in haystack) {
            if (haystack[key] == needle) return true;
        }

        return false;
    };


    var runAction = function (action, bind) {
        if (typeof action == 'function') {
            return action.apply(bind, Array.prototype.slice.call(arguments, 2));
        }
        else if (typeof action == 'object') {
            for (var i in action) {
                if (action.hasOwnProperty(i)) {
                    var response = action[i].apply(bind, Array.prototype.slice.call(arguments, 2));
                    if (response === false) {
                        return false;
                    }
                }
            }
        }
        return true;
    };


    var Module, moduleKeywords, msFavorites;
    moduleKeywords = ['extended', 'included'];

    Module = (function () {
        function Module() {
        }

        Module.extend = function (obj) {
            var key, ref, value;
            for (key in obj) {
                value = obj[key];
                if (indexOf.call(moduleKeywords, key) < 0) {
                    this[key] = value;
                }
            }
            if ((ref = obj.extended) != null) {
                ref.apply(this);
            }
            return this;
        };

        Module.include = function (obj) {
            var key, ref, value;
            for (key in obj) {
                value = obj[key];
                if (indexOf.call(moduleKeywords, key) < 0) {
                    this.prototype[key] = value;
                }
            }
            if ((ref = obj.included) != null) {
                ref.apply(this);
            }
            return this;
        };

        return Module;

    })();


    msFavorites = function (element, options) {

        this.defaults = $.fn.msfavorites.defaults;
        this.selectors = $.fn.msfavorites.selectors;

        this.$body = $('body');
        this.$element = $(element);
        this.$parent = this.$element.closest(this.selectors.parent);
        if (this.$parent.length < 1) {
            this.$parent = $('body');
        }


        this.options = $.extend(true, {},
            getOptions(this.$parent),
            options
        );

        this.data = $.extend(true, {id: 0, ctx: msFavoritesConfig.ctx},
            getOptions(this.$parent, 'data'),
            getOptions(this.$element, 'data')
        );

        this.list = this.$body.data('msFavoritesList');
        if (!this.list) {
            this.setFavoritesList({});
            this.getFavoritesList();
        }

        this.updateFavorites();
    };

    msFavorites.prototype = {
        constructor: msFavorites,

        init: function () {
            this.processSuccess = bind(this.processSuccess, this);
            this.processFailure = bind(this.processFailure, this);
            this.processAction = bind(this.processAction, this);
            this.getFavoritesList = bind(this.getFavoritesList, this);
            this.setFavoritesList = bind(this.setFavoritesList, this);
            this.addMethodAction = bind(this.addMethodAction, this);
            this.removeMethodAction = bind(this.removeMethodAction, this);
        },

        getFavoritesList: function () {
            var data;

            data = $.extend(true, this.data,{
                action: 'favorites/multiple',
                limit: 0,
                options: this.options
            });

            $.ajax({
                url: msFavoritesConfig.actionUrl,
                type: 'get',
                dataType: 'json',
                cache: false,
                data: data,
            }).done((function (_this) {
                return function (r) {
                    _this.processSuccess(r);
                    _this.setFavoritesList(r.data);
                    _this.updateFavorites(r.data);
                };
            })(this)).fail((function (_this) {
                return function (r) {
                    _this.processFailure(r);
                };
            })(this));

        },

        setFavoritesList: function (data) {
            this.$body.data('msFavoritesList', data || {});
        },

        updateFavorites: function (data, method, request) {
            var $favorites, $total, $totalAll, $totalUser, $wrapper;

            if (!data) {
                data = this.$body.data('msFavoritesList');
            }

            $wrapper = this.$parent.parent();
            $favorites = $($.fn.msfavorites.selectors.main);
            $total = $($.fn.msfavorites.selectors.total);
            $totalAll = $($.fn.msfavorites.selectors.totalAll);

            $totalUser = $($.fn.msfavorites.selectors.totalUser);
            if (method && request) {
                $totalUser = $totalUser.filter('[data-data-id="'+request['id'] +'"]');
            }

            // set count vote
            /*if (typeof data.total == 'object') {
             $.each(data.total, (function (_this) {
             return function (list, count) {
             $favorites.filter('[data-data-list="' + list + '"]').each(function (item) {
             $(this).find(_this.selectors.count).text(count);
             });
             };
             })(this));
             }*/

            // set voted
            if (typeof data.list == 'object') {
                $.each($favorites.not(this.defaults.cls.load), (function (_this) {
                    return function () {
                        var $this, list, rid;
                        $this = $(this);
                        list = $this.data('data-list');
                        rid = $this.data('data-id');
                        if (data.list[list] && $.inArray(rid, data.list[list]) > -1) {
                            $this.addClass(_this.defaults.cls.load).addClass(_this.defaults.cls.voted);
                        }
                        else if ($.inArray(rid, data.list[list]) < 0) {
                            $this.addClass(_this.defaults.cls.load).removeClass(_this.defaults.cls.voted);
                        }
                    };
                })(this));
            }

            // set total
            if (typeof data.total == 'object') {
                $.each($total, (function (_this) {
                    return function () {
                        var $this, list, count;
                        $this = $(this);
                        list = $this.data('data-list');
                        count = parseInt(data.total[list] || 0);

                        /* fix wow.min.js:2 Uncaught TypeError: a.getElementsByClassName is not a function */
                        setTimeout(function(){
                            $this.text(count);
                            $this.attr('data-value', count);
                        }, 200);
                    };
                })(this));
            }

            // set totalAll
            if (typeof data.total == 'object') {
                $.each($totalAll, (function (_this) {
                    return function () {
                        var $this, list, count;
                        $this = $(this);
                        list = $this.data('data-list');
                        count = parseInt(data.total[list] || 0);

                        if (!$this.hasClass(_this.defaults.cls.visible)) {
                            if (!count) {
                                $this.hide();
                            }
                            else {
                                $this.show();
                            }
                        }
                    };
                })(this));
            }

            // set totalUser
            if (typeof data.user == 'object') {
                $.each($totalUser, (function (_this) {
                    return function () {
                        var $this, list, id, count, tmp;
                        $this = $(this);
                        list = $this.data('data-list');
                        id = $this.data('data-id');

                        tmp = data.user[list] || {};
                        count = parseInt(tmp[id] || 0);
                        setTimeout(function(){
                            $this.text(count);
                            $this.attr('data-value', count);
                        }, 200);
                    };
                })(this));
            }

            switch (true) {
                // remove favorite
                case this.options.mode == 'list' && method == 'remove':
                    this.$parent.remove();
                    // reload page
                    if ($wrapper.find(this.selectors.parent).length < 1) {
                        location.reload();
                    }
                    break;
                // clear favorite
                case method == 'clear':
                    var $this, list;
                    $this = this.$element;
                    list = $this.data('data-list');
                    // reload page
                    if (list && data.list && !data.list[list]) {
                        this.$parent.remove();
                        location.reload();
                    }
                    break;
            }

            $favorites.not(this.defaults.cls.load).addClass(this.defaults.cls.load);
        },

        processAction: function () {
            var e, method, data;

            if (this.$element.hasClass(this.defaults.cls.action)) {
                method = this.data.method;
            }
            else if (this.$element.hasClass(this.defaults.cls.voted)) {
                method = 'remove';
            }
            else {
                method = 'add';
            }

            data = $.extend(true, this.data, {
                action: 'favorites/multiple',
                method: method
            });

            e = $.Event($.fn.msfavorites.PROCESS_ACTION);
            this.$element.trigger(e, data);
            if (e.isDefaultPrevented()) {
                return;
            }

            this.$element.removeClass(this.defaults.cls.load).removeClass(this.defaults.cls.voted);

            $.ajax({
                url: msFavoritesConfig.actionUrl,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: data,
            }).done((function (_this) {
                return function (r) {
                    _this.processSuccess(r);
                    _this.setFavoritesList(r.data);
                    _this.updateFavorites(r.data, method, data);
                };
            })(this)).fail((function (_this) {
                return function (r) {
                    _this.processFailure(r);
                };
            })(this));
        },

        processSuccess: function (r) {
            var e, message;

            e = $.Event($.fn.msfavorites.PROCESS_SUCCESS);
            this.$element.trigger(e, r);
            if (e.isDefaultPrevented()) {
                return;
            }

            if (!r.success) {
                message = r.message;
                if (!message) {
                    message = 'error unknown';
                }

                console.log(message);
            }

            runAction($.fn.msfavorites.methodActions['success'], this, r);

            return true;
        },

        processFailure: function (r) {
            var e, message;

            e = $.Event($.fn.msfavorites.PROCESS_FAILURE);
            this.$element.trigger(e, r);
            if (e.isDefaultPrevented()) {
                return;
            }

            message = r.responseJSON;
            if (!message) {
                message = 'error unknown';
            }

            console.log(message);

            runAction($.fn.msfavorites.methodActions['failure'], this, r.responseJSON);

            return false;
        },

        addMethodAction: function (path, name, func) {
            if (typeof func != 'function') {
                return false;
            }
            if (!$.fn.msfavorites.methodActions[path]) {
                $.fn.msfavorites.methodActions[path] = {};
            }
            $.fn.msfavorites.methodActions[path][name] = func;

            return true;
        },

        removeMethodAction: function (path, name) {
            if (!$.fn.msfavorites.methodActions[path]) {
                $.fn.msfavorites.methodActions[path] = {};
            }

            delete $.fn.msfavorites.methodActions[path][name];

            return true;
        },

    };


    $.fn.msfavorites = function () {
        var args, option;
        option = arguments[0], args = 2 <= arguments.length ? slice.call(arguments, 1) : [];
        return this.each(function () {
            var $this, $parent, msfavorites, options;

            $this = $(this);
            msfavorites = $this.data('msFavorites');
            if (!msfavorites) {

                $parent = $this.closest($.fn.msfavorites.selectors.parent);
                if ($parent.length < 1) {
                    $parent = $('body');
                }

                options = $.extend(true, {},
                    getOptions($parent),
                    getOptions($this)
                );


                switch (options['mode']) {
                    default:
                        msfavorites = new msFavorites(this, options);
                        break;
                }

                if (msfavorites) {
                    $this.data('msFavorites', msfavorites);
                    msfavorites.init();
                }

            }

            if (typeof option === 'string') {
                return msfavorites[option].apply(msfavorites, args);
            }
        })
    };


    /* event constants */
    $.fn.msfavorites.CONTENT_CHANGE = 'msfavorites:content-change.msfavorites';
    $.fn.msfavorites.PROCESS_SUCCESS = 'msfavorites:process-success.msfavorites';
    $.fn.msfavorites.PROCESS_FAILURE = 'msfavorites:process-failure.msfavorites';
    $.fn.msfavorites.PROCESS_ACTION = 'msfavorites:process-action.msfavorites';


    $.fn.msfavorites.defaults = {
        ns: 'msfavorites',
        cls: {
            load: 'load',
            voted: 'voted',
            visible: 'visible',
            action: 'msfavorites-action'
        },
        timeout: 300,
    };


    $.fn.msfavorites.selectors = {
        main: '.' + $.fn.msfavorites.defaults.ns,
        /*count: '.' + $.fn.msfavorites.defaults.ns + '-count',*/
        total: '.' + $.fn.msfavorites.defaults.ns + '-total',
        totalAll: '.' + $.fn.msfavorites.defaults.ns + '-total-all',
        totalUser: '.' + $.fn.msfavorites.defaults.ns + '-total-user',
        parent: '.' + $.fn.msfavorites.defaults.ns + '-parent',
        actionClick: '[data-click]',
        actionFormSubmit: '[data-formsubmit]',
        actionFormChange: '[data-formchange]',
    };


    $.fn.msfavorites.methodActions = {
        success: {},
        failure: {
            'set.cls.load': function (r) {
                if (this.$element && this.defaults.cls) {
                    this.$element.addClass(this.defaults.cls.load);
                }
            },
            'miniShop2.Message.initialize': function (r) {
                if (typeof miniShop2 == 'object') {
                    miniShop2.Message.initialize();
                    if (r && !!r.message) {
                        miniShop2.Message.error(r.message);
                    }
                }
            },
        },
    };


    (function ($) {
        jQuery.fn.originalHtml = jQuery.fn.html;
        jQuery.fn.html = function () {
            var currentHtml = this.originalHtml();
            if (arguments.length && jQuery.fn.originalHtml) {
                jQuery.fn.originalHtml.apply(this, arguments);
                this.trigger($.fn.msfavorites.CONTENT_CHANGE, jQuery.merge([currentHtml], arguments));
                return this;
            } else {
                return currentHtml;
            }
        }
    })(jQuery);


    /** click */
    $(document).on('click', $.fn.msfavorites.selectors.main + $.fn.msfavorites.selectors.actionClick, function (e) {
        var $this = $(this);
        if ($this.is('a')) {
            e.preventDefault();
        }
        if ($this.is('form')) {
            var options = {};
            $.map($this.serializeArray() || [], function (n, i) {
                options[n['name']] = n['value'];
            });
            setOptions($this, 'data', options);
        }
        $this.msfavorites('processAction');
    });

    /* form submit */
    $(document).on('submit', $.fn.msfavorites.selectors.main + $.fn.msfavorites.selectors.actionFormSubmit, function (e) {
        var $this = $(this), options = {};
        e.preventDefault();

        $.map($this.serializeArray() || [], function (n, i) {
            options[n['name']] = n['value'];
        });
        setOptions($this, 'data', options);
        $this.msfavorites('processAction');
    });

    /* form change */
    $(document).on('change', $.fn.msfavorites.selectors.main + $.fn.msfavorites.selectors.actionFormChange, function (e) {
        var $this = $(this), options = {};
        e.preventDefault();

        $.map($this.serializeArray() || [], function (n, i) {
            options[n['name']] = n['value'];
        });
        setOptions($this, 'data', options);
        $this.msfavorites('processAction');
    });

    $(document).on($.fn.msfavorites.CONTENT_CHANGE, function () {
        $($.fn.msfavorites.selectors.main).msfavorites();
    });


    $(window).on('load', function () {
        $($.fn.msfavorites.selectors.main).msfavorites();
    });


    window.msFavorites = new msFavorites(null, msFavoritesConfig.options);

}(window.jQuery, msFavoritesConfig));

/* event example */
/*$(document).ready(function () {
 if (typeof msFavorites != 'undefined' && typeof miniShop2 != 'undefined') {
 msFavorites.addMethodAction('success', 'name_action', function(r){
 miniShop2.Message.initialize();

 var self = this;
 if (self.data && self.data.method == 'add') {
 miniShop2.Message.success('add');
 }
 if (self.data && self.data.method == 'remove') {
 miniShop2.Message.info('remove');
 }
 });
 }
 });*/

/* event example */
/*
 $(document).on('msfavorites:process-action.msfavorites', function (e, data) {
 console.log(data);

 });*/
