<?php

// Validate TPV
if (UtilsTpv::validateTpvPostResponse()) {

    // Define the mailing subject
    $subject = 'Validació de pagament per TPV - FALUGA KARTING';

    // Get TPV the parameters array
    $parametersArray = json_decode(base64_decode($_POST['Ds_MerchantParameters']), true);

    // Get the TPV custom data (objectIds and units)
    $custom = json_decode(base64_decode($parametersArray['Ds_MerchantData']));

    // Get the products and total amount
    $price = 0;
    $products = '';

    if (is_array($custom) && count($custom) > 0) {
        foreach ($custom as $c) {
            // c = [productId, units]

            if (is_array($c) && count($c) == 2) {
                // Get the product through its own id
                $p = SystemDisk::objectGet($c[0], 'product');

                // Calculate prices
                $productPrice = (floatVal($p->propertyGet('price')) * intVal($c[1]));
                $ivaAmount = (WebConstants::IVA / 100) * $productPrice;
                $productPrice += $ivaAmount;
                $price += $productPrice;

                // Add products info
                $products .= '<p><b>Nom:</b> ';
                $products .= $p->localizedPropertyGet('title', WebConfigurationBase::$LOCALES[0]);
                $products .= '<br><b>Referència:</b> ' . $p->propertyGet('reference');
                $products .= '<br><b>Id:</b> ' . $p->objectId;
                $products .= '<br><b>Preu:</b> ' . $p->propertyGet('price') . '&euro;';
                $products .= '<br><b>Iva (' . WebConstants::IVA . '%):</b> ' . $ivaAmount . '&euro;';
                $products .= '<br><b>Unitats:</b> ' . $c[1];
                $products .= '</p>';
            }
        }
    } else {
        die();
    }

    // Get the TPV POST data and others as an string
    $message = '<b>PRODUCTES COMPRATS</b>' . $products . '<br>';
    $message .= '<b>HA PAGAT:</b> ' . ($parametersArray['Ds_Amount'] / 100) . '&euro;<br><br><br>';
    $message .= '<b>DADES TPV</b><p>';

    // Add global post data
    foreach ($_POST as $k => $v) {
        $message .= '<b>' . $k . ': </b> ' . $v . '<br>';
    }

    // Add merchant data
    foreach ($parametersArray as $k => $v) {
        $message .= '<b>' . $k . ': </b> ' . $v . '<br>';
    }

    $message .= '</p>';

    // Validate the amount according to the products
    if (UtilsTpv::validateAmount($price)) {
        Managers::mailing()->send(WebConstants::NOREPLY_MAIL, WebConstants::SUBMIT_MAIL, $subject, $message);
    }
}