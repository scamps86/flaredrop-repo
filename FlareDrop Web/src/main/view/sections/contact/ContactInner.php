<?php

UtilsJavascript::newVar('formSuccessMessage', Managers::literals()->get('FRM_SUCCESS', 'Contact'));
UtilsJavascript::newVar('formErrorMessage', Managers::literals()->get('FRM_ERROR', 'Contact'));
UtilsJavascript::newVar('successTitle', Managers::literals()->get('SUCCESS', 'Shared'));
UtilsJavascript::newVar('errorTitle', Managers::literals()->get('ERROR', 'Shared'));
UtilsJavascript::echoVars();