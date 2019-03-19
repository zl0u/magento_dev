var config = {
    'config': {
        'mixins': {
            'Magento_Checkout/js/view/shipping': {
                'GorbanSv_CustomCheckout/js/view/shipping-payment-mixin': true
            },
            'Magento_Checkout/js/view/payment': {
                'GorbanSv_CustomCheckout/js/view/shipping-payment-mixin': true
            }
        }
    }
}