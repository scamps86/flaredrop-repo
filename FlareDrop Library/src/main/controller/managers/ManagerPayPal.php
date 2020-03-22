<?php

/*
 * PayPal Manager
 */

class ManagerPayPal
{
    // Define the base constants
    const SERVER_PRODUCTION = 'https://www.paypal.com';
    const SERVER_SANDBOX = 'https://www.sandbox.paypal.com';
    const SERVER_COMMON_PATH = '/cgi-bin/webscr';


    /**
     * Create and echo a buy now button
     *
     * @param boolean $useSandBox Boolean that indicates if it's using the sandbox test server or not
     * @param array $options An associative array containing the properties below: <br>
     * <b>business</b> merchant id or merchant email<br>
     * <b>item_name</b><br>
     * <b>currency_code</b> EUR, USD<br>
     * <b>amount</b> product price<br>
     * <b>cpp_header_image</b> URL to the PayPal header image (750x90)<br>
     * <b>notify_url</b> The IPN service URL<br>
     * <b>custom</b> The custom data sent to the IPN service
     * @param string $label The button label
     */
    public function echoBuyNowButton($useSandBox, array $options, $label = '')
    {
        // Create the form
        echo '<form class="payPalBuyNowButton" name="_xclick" action="' . ($useSandBox ? self::SERVER_SANDBOX : self::SERVER_PRODUCTION) . self::SERVER_COMMON_PATH . '" method="post" target="_blank">';

        // Create the necessary inputs
        echo '<input type="hidden" name="cmd" value="_xclick">';
        echo '<input type="hidden" name="charset" value="utf-8">';

        // Set the PayPal options
        if (isset($options['business'])) {
            echo '<input type="hidden" name="business" value="' . $options['business'] . '">';
        }
        if (isset($options['item_name'])) {
            echo '<input type="hidden" name="item_name" value="' . $options['item_name'] . '">';
        }
        if (isset($options['currency_code'])) {
            echo '<input type="hidden" name="currency_code" value="' . $options['currency_code'] . '">';
        }
        if (isset($options['amount'])) {
            echo '<input type="hidden" name="amount" value="' . $options['amount'] . '">';
        }
        if (isset($options['cpp_header_image'])) {
            echo '<input type="hidden" name="cpp_header_image" value="' . $options['cpp_header_image'] . '">';
        }
        if (isset($options['notify_url'])) {
            echo '<input type="hidden" name="notify_url" value="' . $options['notify_url'] . '">';
        }
        if (isset($options['custom'])) {
            echo '<input type="hidden" name="custom" value="' . $options['custom'] . '">';
        }

        // Create the submit button
        echo '<input type="submit" value="' . $label . '">';

        // Close the form
        echo '</form>';
    }


    /**
     * Execute the paypal IPN validation so we can confirm that a received payment is correct. The process will connect with paypal and send
     * the received IPN headers so we can get a valid or invalid response for the transaction from the paypal servers.
     * Note that it uses headers and nothing can be printed before calling this method.
     *
     * @return boolean The validation is correct or not
     */
    public function validateIpn()
    {
        // Validate the IPN POST
        if (count($_POST) <= 0) {
            echo 'IPN validation error 1';
            return false;
        }

        // Reading POSTed data directly from $_POST causes serialization issues with array data in the POST
        // Instead, read raw POST data from the input stream.
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = [];
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        // Read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
        $req = 'cmd=_notify-validate';
        $get_magic_quotes_exists = false;

        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        // Initialize and define the CURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, (WebConfigurationBase::$PAYPAL_SANDBOX ? self::SERVER_SANDBOX : self::SERVER_PRODUCTION) . self::SERVER_COMMON_PATH);
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
        curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $req);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Connection: close',
            'Expect: ',
        ]);

        // Get the PayPal validation response
        $res = curl_exec($curl);

        // Close the CURL
        curl_close($curl);

        // Read the PayPal response and return it as a boolean
        return strcmp($res, 'VERIFIED') == 0;
    }


    /**
     * Validates if the IPN amount is the same or bigger than the specified
     *
     * @param float $amount The amount to validate
     *
     * @return boolean
     */
    public function validateAmount($amount)
    {
        return isset($_POST['mc_gross']) && floatval($_POST['mc_gross']) >= $amount;
    }


    /**
     * Validate the PayPal business
     *
     * @param string $business The business
     *
     * @return bool
     */
    public function validateBusiness($business)
    {
        return isset($_POST['business']) && $_POST['business'] == $business;
    }


    /**
     * Validate if custom data is filled
     *
     * @return bool
     */
    public function validateCustom()
    {
        return isset($_POST['custom']) && $_POST['custom'] != '';
    }
}