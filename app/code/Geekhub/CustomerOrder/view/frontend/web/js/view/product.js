define([
    'jquery',
    'underscore',
    'uiComponent',
    'ko',
    'Magento_Checkout/js/model/step-navigator',
    'mage/translate',
    'mageUtils',
    'Geekhub_CustomerOrder/js/model/product-service'
], function (
    $,
    _,
    Component,
    ko,
    stepNavigator,
    $t,
    utils,
    productService
) {
    'use strict';

    return Component.extend({
        defaults: {
            products: [],
            listens: {
                responseData: 'updateProductsList',
                request: 'searchRequest'
            }
        },
        isVisible: ko.observable(false),

        /** @inheritdoc */
        initialize: function () {
            this._super();
            stepNavigator.registerStep(
                'product',
                null,
                $t('Product'),
                this.isVisible,
                _.bind(this.navigate, this),
                20
            );

            this.initProductList();

            return this;
        },

        initObservable: function () {
            return this._super()
                .observe([
                    'responseData',
                    'responseStatus',
                    'products',
                    'request'
                ]);
        },

        initProductList: function (params) {
            productService.getProductList(
                params,
                {
                    url: this.productsListUrl
                },
                {
                    data: this.responseData,
                    status: this.responseStatus
                }
            );
        },

        updateProductsList: function (data) {
            this.products(data.products);
        },


        chooseProduct: function (product) {
            alert(product.id);
        },

        searchRequest: function (request) {
            this.initProductList({q:request});
        },

        /**
         * Navigate method.
         */
        navigate: function () {
            var self = this;
            self.isVisible(true);
        },

        nextAction: function () {
            stepNavigator.next();
        }
    });
});
