<?php

$tpvParameters = UtilsHttp::getParameterValue('tpvParameters'); // All TPV parameters as base64 json

try {

    // Get the order
    $tpvParametersArray = json_decode(base64_decode($tpvParameters), true);
    $tpvOrder = $tpvParametersArray['DS_MERCHANT_ORDER'];


    // Generate and print the signature
    $signature = UtilsTpv::generateSignature($tpvParameters, $tpvOrder);
    UtilsHttp::fileGenerateHeaders('text/plain', strlen($signature), 'tpvSignatureGet', false);

    echo $signature;
} catch (Exception $e) {
    UtilsHttp::fileGenerateHeaders('text/plain', 2, 'tpvSignatureGet', false);
    echo -1;
}