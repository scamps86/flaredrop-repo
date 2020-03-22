<?php

// Validate the user validation
$validationKey = UtilsHttp::getEncodedParam('key');

if ($validationKey != '') {
    $validationResult = SystemUsers::validate($validationKey, false);

    if ($validationResult->state) {
        UtilsJavascript::newVar('USER_VALIDATION_SUCCESS', 1);
        UtilsJavascript::newVar('USER_VALIDATION_SUCCESS_MESSAGE', Managers::literals()->get('USER_VALIDATION_SUCCESS_MESSAGE', 'Home'));
    } else {
        UtilsJavascript::newVar('USER_VALIDATION_SUCCESS', 0);
    }
} else {
    UtilsJavascript::newVar('USER_VALIDATION_SUCCESS', 0);
}

// Other necessary Javascript vars
UtilsJavascript::newVar('RAB_URL', UtilsHttp::getWebServiceUrl('RefreshAllBidding'));
UtilsJavascript::echoVars();