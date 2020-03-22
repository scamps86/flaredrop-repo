<?php

UtilsJavascript::newVar('product', UtilsHttp::getEncodedParam('product'));
UtilsJavascript::newVar('formSuccessMessage', Managers::literals()->get('FRM_SUCCESS', 'Request'));
UtilsJavascript::newVar('formErrorMessage', Managers::literals()->get('FRM_ERROR', 'Request'));
UtilsJavascript::newVar('successTitle', Managers::literals()->get('SUCCESS', 'Shared'));
UtilsJavascript::newVar('errorTitle', Managers::literals()->get('ERROR', 'Shared'));
UtilsJavascript::echoVars();