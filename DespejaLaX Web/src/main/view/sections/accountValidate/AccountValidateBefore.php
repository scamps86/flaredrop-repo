<?php

// Validate the requested user validation key
$VALIDATION_OK = false;

$validationKey = UtilsHttp::getEncodedParam(WebConstants::VALIDATION_KEY_PARAM);

if ($validationKey != '') {
    $validationResult = SystemUsers::validate($validationKey, false);
    $VALIDATION_OK = $validationResult->state;

    if ($VALIDATION_OK) {
        $userData = $validationResult->data;
    }
}

// Redirect to home if validation error. Send a validated email if OK
if (!$VALIDATION_OK) {
    UtilsHttp::redirectToSection('home');
}