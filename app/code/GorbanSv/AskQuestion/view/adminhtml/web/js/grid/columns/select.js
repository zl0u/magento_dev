define([
    'underscore',
    'Magento_Ui/js/grid/columns/select'
], function (_, Select) {
    'use strict';

    return Select.extend({
        defaults: {
            additionalCustomClass: '',
            customClasses: {
                pending: 'grid-severity-critical',
                processed: 'grid-severity-notice'
            },
            bodyTmpl: 'GorbanSv_AskQuestion/grid/cells/text'
        },

        getCustomClass: function (row) {
            var customClass = this.customClasses[row.status] || '';
            return customClass + ' ' + this.additionalCustomClass;
        }
    });
});
