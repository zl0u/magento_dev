define([
    'jquery',
    'Magento_Ui/js/modal/modal',
], function ($, modal) {
    return function (config) {
        let options = {
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

        modal(options, $('#dealer-registration-pop'));

        $("#dealer-registration").on('click', function () {
            $('#dealer-registration-pop-inner').html($('.form-create-account').html());
            $("#dealer-registration-pop").modal("openModal");
        });
    };
});
