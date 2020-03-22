<?php

// Validate the PayPal IPN
if (Managers::payPal()->validateIpn()) {

    // Define the mailing subject
    $subject = 'Validació de pagament per PAYPAL - FALUGA KARTING';

    // Validate the custom data
    if (!isset($_POST['custom']) || $_POST['custom'] == '') {
        die();
    }

    // Get the custom data (objectIds and units)
    $custom = json_decode(base64_decode($_POST['custom']));

    // Get the products and total amount
    $price = 0;
    $products = '';

    if (is_array($custom) && count($custom) > 0) {
        foreach ($custom as $c) {
            if (is_array($c) && count($c) == 2) {
                $p = SystemDisk::objectGet($c[0], 'product');
                $products .= '<p><b>Nom:</b> ';
                $products .= $p->localizedPropertyGet('title', WebConfigurationBase::$LOCALES[0]);
                $products .= '<br><b>Referència:</b> ' . $p->propertyGet('reference');
                $products .= '<br><b>Id:</b> ' . $p->objectId;
                $products .= '<br><b>Preu:</b> ' . $p->propertyGet('price') . '&euro;';
                $products .= '<br><b>Unitats:</b> ' . $c[1];
                $products .= '</p>';

                $price = $price + (floatVal($p->propertyGet('price')) * intVal($c[1]));
            }
        }
    } else {
        die();
    }

    // Get the PayPal POST data and others as an string
    $message = '<b>DADES USUARI</b>';
    $message .= '<p><b>Nom complet: </b>' . $_POST['first_name'] . ' ' . $_POST['last_name'] . '<br>';
    $message .= '<b>Correu electrònic: </b>' . $_POST['payer_email'] . '</span></p><br>';
    $message .= '<b>PRODUCTES COMPRATS</b>' . $products . '<br>';
    $message .= '<b>HA PAGAT:</b> ' . $_POST['mc_gross'] . '&euro;<br><br><br>';
    $message .= '<b>DADES PAYPAL</b><p>';

    foreach ($_POST as $k => $v) {
        $message .= '<b>' . $k . ': </b> ' . $v . '<br>';
    }

    $message .= '</p>';

    // Validate the amount according to the products
    if (Managers::payPal()->validateAmount($price)) {
        Managers::mailing()->send(WebConstants::NOREPLY_MAIL, WebConstants::SUBMIT_MAIL, $subject, $message);
    }
}