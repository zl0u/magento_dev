define([
    'jquery',
    'Magento_Ui/js/modal/modal'
], function ($, modal) {
    'use strict';

    return function (config) {
        var options = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            title: config.title,
            buttons: [{
                text: $.mage.__('Close'),
                class: '',
                click: function () {
                    this.closeModal();
                }
            }]
        },
            popEl = $('#dealer-registration-pop'),
            popup = modal(options, popEl);

        $('#dealer-registration').on('click', function () {
            popup.openModal();
            popEl.trigger('contentUpdated');

            return false;
        });
    };
});
