var GoogleSheets = function (config) {
    config = config || {};
    GoogleSheets.superclass.constructor.call(this, config);
};
Ext.extend(GoogleSheets, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('googlesheets', GoogleSheets);

GoogleSheets = new GoogleSheets();