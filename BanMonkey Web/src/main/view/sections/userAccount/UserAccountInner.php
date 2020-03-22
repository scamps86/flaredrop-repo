<?php

UtilsJavascript::newVar('CANCEL_ACCOUNT_SURE', Managers::literals()->get('CANCEL_ACCOUNT_SURE', 'UserAccount'));
UtilsJavascript::newVar('CANCEL_ACCOUNT_ERROR', Managers::literals()->get('CANCEL_ACCOUNT_ERROR', 'UserAccount'));
UtilsJavascript::newVar('AC_URL', UtilsHttp::getWebServiceUrl('AccountCancel'));
UtilsJavascript::newVar('FRM_USER_DATA_SUCCESS', Managers::literals()->get('FRM_USER_DATA_SUCCESS', 'Shared'));
UtilsJavascript::newVar('FRM_USER_DATA_ERROR', Managers::literals()->get('FRM_USER_DATA_ERROR', 'Shared'));
UtilsJavascript::echoVars();