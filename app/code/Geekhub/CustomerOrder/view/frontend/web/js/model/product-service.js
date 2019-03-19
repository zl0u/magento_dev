define([
    'underscore',
    'mageUtils'
], function (_, utils) {
    'use strict';

    return {
        getProductList: function (params, options, response) {
            params = params || {};
            utils.ajaxSubmit({
                url: options.url,
                data: params
            }, {
                ajaxSaveType: 'default',
                response: response
            });
        }
    }
});