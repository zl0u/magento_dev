define([
    'jquery'
], function ($) {
    'use strict';

    return function () {
        $.validator.addMethod(
            'validation-phone-ua',
            function (phonePattern) {
                //if (phonePattern.match(/^((\3)+([0-9]){12})$/gm)) {
                if (phonePattern.match(/^((\+3|3|8|)+([0-9]){10})$/gm)) {
                    return true;
                }

            },
            $.mage.__('This field is not valide. Please type a ukrainian mobile phone number.')
        );
    };
});
