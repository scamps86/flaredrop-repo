/**
 * PayPal utils
 */
function UtilsPayPalClass() {
    // Define this service
    var service = this;

    // Define the base constants
    service.SERVER_PRODUCTION = "https://www.paypal.com/cgi-bin/webscr";
    service.SERVER_SANDBOX = "https://www.sandbox.paypal.com/cgi-bin/webscr";
}


/**
 * Create a buy now button
 *
 * @param containerElement The element to append the button. If not defined, this function will return the button element
 * @param useSandBox Boolean that indicates if it's using the sandbox test server or not
 * @param options An object containing the properties below: <br>
 * <b>business</b> merchant id or merchant email<br>
 * <b>item_name</b><br>
 * <b>currency_code</b> EUR, USD<br>
 * <b>amount</b> product price<br>
 * <b>cpp_header_image</b> URL to the PayPal header image (750x90)<br>
 * <b>notify_url</b> The IPN service URL<br>
 * <b>custom</b> The custom data sent to the IPN service
 * @param label The button label
 *
 * @returns The button element only if the parent element is undefined
 */
UtilsPayPalClass.prototype.createBuyNowButton = function (containerElement, useSandBox, options, label) {
    // Define this service
    var service = this;

    // Create the button form
    var btn = $('<form class="payPalBuyNowButton" name="_xclick" action="' + (useSandBox ? service.SERVER_SANDBOX : service.SERVER_PRODUCTION) + '" method="post" target="_blank"></form>');

    // Create the necessary inputs
    $(btn).append($('<input type="hidden" name="cmd" value="_xclick">'), $('<input type="hidden" name="charset" value="utf-8">'));

    // Set the PayPal options
    if (options.business !== undefined) {
        $(btn).append($('<input type="hidden" name="business" value="' + options.business + '">'));
    }
    if (options.item_name !== undefined) {
        $(btn).append($('<input type="hidden" name="item_name" value="' + options.item_name + '">'));
    }
    if (options.currency_code !== undefined) {
        $(btn).append($('<input type="hidden" name="currency_code" value="' + options.currency_code + '">'));
    }
    if (options.amount !== undefined) {
        $(btn).append($('<input type="hidden" name="amount" value="' + options.amount + '">'));
    }
    if (options.cpp_header_image !== undefined) {
        $(btn).append($('<input type="hidden" name="cpp_header_image" value="' + options.cpp_header_image + '">'));
    }
    if (options.notify_url !== undefined) {
        $(btn).append($('<input type="hidden" name="notify_url" value="' + options.notify_url + '">'));
    }
    if (options.custom !== undefined) {
        $(btn).append($('<input type="hidden" name="custom" value="' + options.custom + '">'));
    }

    // Create the submit button
    $(btn).append($('<input type="submit" value="' + (label === undefined ? "" : label) + '">'));

    // Append it to the container element
    if (containerElement !== undefined) {
        $(containerElement).append(btn);
    }
    else {
        return btn;
    }
};