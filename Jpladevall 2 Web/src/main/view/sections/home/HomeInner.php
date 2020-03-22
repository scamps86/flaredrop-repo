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

// Home vars
UtilsJavascript::newVar('FRM_LOGIN_ERROR', Managers::literals()->get('FRM_LOGIN_ERROR', 'Shared'));
UtilsJavascript::newVar('FRM_JOIN_ERROR', Managers::literals()->get('FRM_JOIN_ERROR', 'Shared'));
UtilsJavascript::newVar('FRM_JOIN_SUCCESS', Managers::literals()->get('FRM_JOIN_SUCCESS', 'Shared'));

UtilsJavascript::echoVars();