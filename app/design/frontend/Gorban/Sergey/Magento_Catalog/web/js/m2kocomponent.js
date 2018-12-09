define(['jquery', 'uiComponent', 'ko', 'Magento_Catalog/js/model/rgb-model'], function ($, Component, ko, rgbModel) {
        'use strict';

        var self;

        return Component.extend({
            myTimer: ko.observable(0),
            randomColour: ko.computed(function() {
                //we are using the aliased rgbModel here giving us access to the RGB values
                return 'rgb(' + rgbModel.red() + ', ' + rgbModel.blue() + ', ' + rgbModel.green() + ')';
            }, this),
            initialize: function () {
                self = this;
                this._super();
                //call the incrementTime function to run on intialize
                this.incrementTime();
                this.subscribeToTime();
            },
            //increment myTimer every second
            incrementTime: function() {
                var t = 0;
                setInterval(function() {
                    t++;
                    self.myTimer(t);
                }, 1000);
            },
            subscribeToTime: function() {
                this.myTimer.subscribe(function() {
                    rgbModel.updateColour();
                });
            }
        });
    }
);
