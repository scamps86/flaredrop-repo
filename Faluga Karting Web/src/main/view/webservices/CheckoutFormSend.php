<?php

$subject = 'Nova sol·licitud de compra de FALUGA KARTING';

// Get the product through the paypal custom data. Validate the total price
$cart = json_decode(base64_decode(UtilsHttp::getParameterValue('frmCart')), true);

if (!$cart || count($cart) < 1) {
    echo 'Error code 1';
    die();
}

$products = '';
$price = 0;

foreach ($cart as $item) {
    $p = SystemDisk::objectGet($item['itemId'], 'product');
    $products .= '<p>&nbsp;<b>Nom:</b> ';
    $products .= $p->localizedPropertyGet('title', WebConfigurationBase::$LOCALES[0]);
    $products .= '<br>&nbsp;<b>Referència:</b> ' . $p->propertyGet('reference');
    $products .= '<br>&nbsp;<b>Id:</b> ' . $p->objectId;
    $products .= '<br>&nbsp;<b>Preu:</b> ' . $p->propertyGet('price') . '&euro;';
    $products .= '<br>&nbsp;<b>Unitats:</b> ' . $item['units'];
    $products .= '</p>';

    $price = $price + (floatval($p->propertyGet('price')) * intVal($item['units']));
}

if (floatval(UtilsHttp::getParameterValue('frmTotalPrice')) < $price) {
    echo 'Error code 2';
    die();
}

// Define the mail content
$message = '<b>DADES PERSONALS: </b><br><br>';
$message .= '<b>Nom complet: </b>' . UtilsHttp::getParameterValue('frmName') . '<br>';
$message .= '<b>Telèfon: </b>' . UtilsHttp::getParameterValue('frmPhone') . '<br>';
$message .= '<b>Correu electrònic: </b>' . UtilsHttp::getParameterValue('frmEmail') . '<br>';
$message .= '<b>Adreça: </b>' . UtilsHttp::getParameterValue('frmLocation') . '<br>';
$message .= '<b>Ciutat: </b>' . UtilsHttp::getParameterValue('frmCity') . '<br>';
$message .= '<b>Codi postal: </b>' . UtilsHttp::getParameterValue('frmCp') . '<br><br><br>';
$message .= '<b>PRODUCTES COMPRATS: </b>' . $products . '<br>';
$message .= '<b>PREU TOTAL: </b>' . UtilsHttp::getParameterValue('frmTotalPrice') . '&euro;<br>';
$message .= '<b>MÈTODE DE PAGAMENT: </b>' . UtilsHttp::getParameterValue('frmPayMode');

// Send the mail
if (!Managers::mailing()->send(UtilsHttp::getParameterValue('frmEmail'), WebConstants::SUBMIT_MAIL, $subject, $message)) {
    echo 'Error code 3';
}

// Return payment data if necessary
// Return TPV order
if (UtilsHttp::getParameterValue('frmPayMode') === 'tpv') {
    echo UtilsDate::toTimestamp(UtilsDate::create());
}