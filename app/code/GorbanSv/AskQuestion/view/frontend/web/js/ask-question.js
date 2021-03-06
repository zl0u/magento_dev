define([
    'jquery',
    'gorbanSv_validationAlert',
    'Magento_Ui/js/modal/alert',
    'mage/cookies',
    'mage/translate',
    'jquery/ui'
], function ($, validationAlert, alert) {
    'use strict';

    $.widget('gorbansv.requestSample', {
        options: {
            cookieName: 'gorbansv_ask_question',
            cookieLifetime: 2,
            timeZoneOffset: 1
        },

        /** @inheritdoc */
        _create: function () {
            $(this.element).submit(this.submitForm.bind(this));
        },

        /**
         * Validate request and submit the form if able
         */
        submitForm: function () {
            if (!this.validateForm()) {
                validationAlert();

                return;
            }

            this.ajaxSubmit();
        },

        /**
         * Submit request via AJAX. Add form key to the post data.
         */
        ajaxSubmit: function () {
            var formData = new FormData($(this.element).get(0)),
                lifetime = 120;

            formData.append('form_key', $.mage.cookies.get('form_key'));
            formData.append('isAjax', 1);

            $.ajax({
                url: $(this.element).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                dataType: 'json',
                context: this,

                /** @inheritdoc */
                beforeSend: function () {
                    if ($.mage.cookies.get(this.options.cookieName)) {
                        alert({
                            title: $.mage.__('Error'),
                            content: $.mage.__('It is forbidden to send questions more than once per 2 minutes.')
                        });

                        return false;
                    }
                    $('body').trigger('processStart');
                },

                /** @inheritdoc */
                success: function (response) {
                    $('body').trigger('processStop');
                    alert({
                        title: $.mage.__(response.status),
                        content: $.mage.__(response.message)
                    });

                    if (response.status === 'Success') {
                        $.mage.cookies.set(this.options.cookieName, true, {
                            lifetime: lifetime
                        });
                    }
                },

                /** @inheritdoc */
                error: function () {
                    $('body').trigger('processStop');
                    alert({
                        title: $.mage.__('Error'),
                        content: $.mage.__('Your request can not be submitted.')
                    });
                }
            });
        },

        /**
         * Validate request form
         */
        validateForm: function () {
            return $(this.element).validation().valid();
        }
    });

    return $.gorbansv.requestSample;
});
