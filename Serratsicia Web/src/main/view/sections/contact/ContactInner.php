<?php

UtilsJavascript::newVar('formSuccessMessage', Managers::literals()->get('FRM_SUCCESS', 'Contact'));
UtilsJavascript::newVar('formErrorMessage', Managers::literals()->get('FRM_ERROR', 'Contact'));
UtilsJavascript::newVar('dialogSuccess', Managers::literals()->get('DIALOG_SUCCESS', 'Shared'));
UtilsJavascript::newVar('dialogError', Managers::literals()->get('DIALOG_ERROR', 'Shared'));
UtilsJavascript::echoVars();
 