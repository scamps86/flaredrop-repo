<?php

// Validate the PayPal IPN
if (Managers::payPal()->validateIpn() && Managers::payPal()->validateCustom() && Managers::payPal()->validateBusiness(WebConfigurationBase::$PAYPAL_BUSINESS)) {

    // Get the custom data
    $productId = base64_decode($_POST['custom']);
    $product = SystemDisk::objectGet($productId, 'product');

    // Validate the amount
    if (Managers::payPal()->validateAmount(floatval($product->propertyGet('price')))) {
        // Generate subject
        $subject = 'Nuevo producto comprado: ' . $product->localizedPropertyGet('name', WebConstants::getLanTag());

        // Get the PayPal POST data and others as an string
        $message = '';
        $message .= '<p style="font-weight: bold;">DATOS PAYPAL</p>';

        foreach ($_POST as $k => $v) {
            $message .= '<p><span style="font-weight: bold;">' . $k . ': </span><span>' . $v . '</span></p>';
        }

        Managers::mailing()->send(WebConstants::MAIL_NOREPLY, WebConstants::MAIL_COMMERCIAL, $subject, $message);
    }
}