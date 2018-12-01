define([
    'jquery',
    'jquery/ui',
    'Magento_Ui/js/modal/alert',
    'mage/translate'
], function ($) {
    'use strict';

    $.widget('gorbansv.validationAlert', $.mage.alert, {
        options: {
            modalClass: 'error',
            title: $.mage.__('Request error'),
            content: $.mage.__('Please check the form data.')
        },

        /**
         * Override the openModal method to be able to have the default content and do not pass it every time
         */
        openModal: function () {
            var element = this._super();

            $('<div></div>').html(this.options.content).appendTo(element);
        }
    });

    return $.gorbansv.validationAlert;
});
