define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/additional-validators',
        'Flyxrg_ValidateZipcode/js/model/zipcode-validator'
    ],
    function (Component, additionalValidators, zipcodeValidation) {
        'use strict';
        additionalValidators.registerValidator(zipcodeValidation);
        return Component.extend({});
    }
);