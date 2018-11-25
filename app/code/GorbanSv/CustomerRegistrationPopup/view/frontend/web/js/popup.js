define([
    'jquery',
    'Magento_Ui/js/modal/modal',
], function ($, modal) {
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
        };

        var pop_el = $('#dealer-registration-pop'),
            popup = modal(options, pop_el);

        $("#dealer-registration").on('click', function () {
            popup.openModal();
            pop_el.trigger('contentUpdated');

            return false;
        });
    };
});
