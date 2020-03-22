<?php

/** Tpv utils */
class UtilsTpv
{

    /**
     * Generate a TPV signature
     *
     * @param string $parameters All TPV data parameters as base64 json
     * @param string $order The order id
     *
     * @return string The TPV signature
     */
    public static function generateSignature($parameters, $order)
    {
        $key = self::_encrypt_3DES($order, base64_decode(WebConfigurationBase::$TPV_KEY));
        return base64_encode(hash_hmac('sha256', $parameters, $key, true));
    }


    /**
     * Validate the TPV post data
     *
     * @return bool
     */
    public static function validateTpvPostResponse()
    {
        try {
            $parametersArray = self::getMerchantParametersFromPostData();
            $order = $parametersArray['Ds_Order'];
            $receivedSignature = str_replace('_', '/', $_POST['Ds_Signature']); // Received signature contains underscores instead slashes
            $adminSignature = self::generateSignature($_POST['Ds_MerchantParameters'], $order);

            return $adminSignature === $receivedSignature;
        } catch (Exception $e) {
            return false;
        }
    }


    /**
     * Validate TPV minimum amount
     * @param int $amount The amount to validate
     * @return bool
     */
    public static function validateAmount($amount)
    {
        $parametersArray = self::getMerchantParametersFromPostData();
        return isset($parametersArray['Ds_Amount']) && floatval($parametersArray['Ds_Amount']) >= $amount * 100;
    }


    /**
     * Encode to 3DES
     *
     * @param string $message
     * @param string $key
     * @return string
     */
    private static function _encrypt_3DES($message, $key)
    {
        $iv = implode(array_map('chr', array(0, 0, 0, 0, 0, 0, 0, 0)));
        return mcrypt_encrypt(MCRYPT_3DES, $key, $message, MCRYPT_MODE_CBC, $iv);
    }


    /**
     * Get an associative array of the merchant parameters of the received TPV POST data
     * @return array
     */
    private static function getMerchantParametersFromPostData()
    {
        return json_decode(base64_decode($_POST['Ds_MerchantParameters']), true);
    }
}