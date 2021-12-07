define([
        "uiComponent",
        'jquery',
		'mage/storage',
		'Magento_Checkout/js/model/full-screen-loader'
    ],
    function(
        Component,
        $,
		storage,
		fullScreenLoader
    ) {
        'use strict';

        return Component.extend({
            initialize: function () {
                this._super();
                var self = this;                
				$(document).on('change', "[name='postcode']", function () {
                    var postcode = this.value;
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
							if (response && response.country_id != null)
							{
								$("[name='country_id']").val(response.country_id);
								$("[name='region_id']").val(response.region_id);
								$("[name='city']").val(response.city);
							}else{
								alert("Sorry, service not available at this pincode, please try another pincode");
							}
						}
					).fail(
						function (response) 
						{
							alert("Please try again");
						}
					).always(fullScreenLoader.stopLoader);                    
                });
            },
        });
    }
);