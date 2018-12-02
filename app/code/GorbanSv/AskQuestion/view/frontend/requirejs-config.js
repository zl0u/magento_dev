var config = {
    map: {
        '*': {
            'gorbanSv_askQuestion': 'GorbanSv_AskQuestion/js/ask-question',
            'gorbanSv_validationAlert': 'GorbanSv_AskQuestion/js/validation-alert',
            'gorbanSv_validationPhone': 'GorbanSv_AskQuestion/js/validation-phone-mixin',
            'validation': 'mage/validation/validation'
        }
    },
    config: {
        mixins: {
            'mage/validation': {
                'gorbanSv_validationPhone': true
            }
        }
    }
};
