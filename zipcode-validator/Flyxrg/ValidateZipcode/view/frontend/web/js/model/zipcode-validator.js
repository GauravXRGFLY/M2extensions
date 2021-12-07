define(
    [
        'jquery',
		'Magento_Ui/js/model/messageList',
		'mage/translate',
		'mage/storage',
		'Magento_Checkout/js/model/full-screen-loader'
    ],
    function ($,messageList,$t,storage,fullScreenLoader) {
        'use strict';

        return {

            /**
             * Validate zipcode
             *
             * @returns {Boolean}
             */
            validate: function () {
                var zipcodeValidationResult = false;
                var postcode = $('input[name=postcode]').val();
				var payload;
				
				payload = {
						postcode: postcode
					};
				fullScreenLoader.startLoader();
					
				return storage.post(
					'zipcode/ajax/result',
					JSON.stringify(payload),
					false
				).done(
					function (response) {
						if (response && response.country_id == null)
						{
							messageList.addErrorMessage({ message: $t('Sorry, service not available at this pincode, please try another pincode')});
							fullScreenLoader.stopLoader();
						}else{
							zipcodeValidationResult = true;
						}
					}
				).fail(
					function (response) 
					{
						alert("Please try again");
					}
				).always(fullScreenLoader.stopLoader);  
                return zipcodeValidationResult;
            }
        };
    }
);