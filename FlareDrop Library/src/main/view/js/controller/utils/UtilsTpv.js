function UtilsTpvClass() {
    // Define this service
    var service = this;
}


/**
 * Generate the necessary data to be sent and to generate the signature
 * @param options
 * @return {String|*}
 */
UtilsTpvClass.prototype.generateBase64Data = function (options) {
    var data = {};

    if (options.code !== undefined) {
        data['DS_MERCHANT_MERCHANTCODE'] = options.code;
    }
    if (options.order !== undefined) {
        data['DS_MERCHANT_ORDER'] = options.order;
    }
    if (options.terminal !== undefined) {
        data['DS_MERCHANT_TERMINAL'] = options.terminal;
    }
    if (options.transactionType !== undefined) {
        data['DS_MERCHANT_TRANSACTIONTYPE'] = options.transactionType;
    }
    if (options.currency !== undefined) {
        data['DS_MERCHANT_CURRENCY'] = options.currency;
    }
    if (options.amount !== undefined) {
        data['DS_MERCHANT_AMOUNT'] = UtilsFormatter.setDecimals(options.amount * 100, 0);
    }
    if (options.urlMerchant !== undefined) {
        data['DS_MERCHANT_MERCHANTURL'] = options.urlMerchant;
    }
    if (options.dataMerchant !== undefined) {
        data['DS_MERCHANT_MERCHANTDATA'] = options.dataMerchant;
    }

    return UtilsConversion.base64Encode(UtilsConversion.objectToJson(data));
};


/**
 *
 * @param containerElement
 * @param options
 * @param label
 * @param tpvSignatureService
 */
UtilsTpvClass.prototype.sendTpvRequest = function (containerElement, options, label, tpvSignatureService) {

    // Generate merchant parameters
    var merchantParameters = this.generateBase64Data(options);

    // Call the TPV service to get the signature through the merchant parameters
    $.ajax({
        url: tpvSignatureService,
        method: 'POST',
        data: {
            tpvParameters: merchantParameters
        },
        error: function () {
            // ERROR
        },
        success: function (signature) {
            if (signature && signature !== -1) {
                // Create the button form
                var btn = $('<form class="payPalBuyNowButton" action="' + options.url_tpvv + '" method="POST" target="_blank"></form>');

                // Set the TPV options
                // Signature version
                $(btn).append('<input type="text" name="Ds_SignatureVersion" value="HMAC_SHA256_V1"/>');

                // JSON data
                $(btn).append('<input type="text" name="Ds_MerchantParameters" value="' + merchantParameters + '"/>');

                // Signature
                $(btn).append('<input type="text" name="Ds_Signature" value="' + signature + '"/>');

                // Create the submit button
                $(btn).append($('<input type="submit" value="' + (label === undefined ? "" : label) + '">'));

                // Append it to the container element
                if (containerElement !== undefined) {
                    $(containerElement).append(btn);
                }
                else {
                    // Add the button to the body (hidden) to be submitted
                    $("body").append(btn);
                    $(btn).hide().submit();
                }
            }
            else {
                // ERROR
            }
        }
    });
};