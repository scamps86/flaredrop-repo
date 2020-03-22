<?php

// Define javascript global vars
UtilsJavascript::newVar('GLOBAL_URL_MANAGER_LOGIN', UtilsHttp::getSectionUrl('_manager'));
UtilsJavascript::newVar('GLOBAL_URL_MANAGER_APP', UtilsHttp::getSectionUrl('_managerApp'));
UtilsJavascript::newVar('GLOBAL_URL_BASE', UtilsHttp::getRelativeUrl(''));
UtilsJavascript::newVar('GLOBAL_URL_BASE_ABSOLUTE', UtilsHttp::getAbsoluteUrl(''));
UtilsJavascript::newVar('GLOBAL_URL_WEB_SERVICE_BASE', UtilsHttp::getWebServiceUrl(''));
UtilsJavascript::newVar('GLOBAL_CURRENT_LAN_TAG', WebConstants::getLanTag());
UtilsJavascript::newVar('GLOBAL_CURRENT_LANGUAGE', WebConstants::getLanguage());
UtilsJavascript::newVar('GLOBAL_MANAGER_LITERALS', json_encode(Managers::literals()->getManagerBundles()));
UtilsJavascript::echoVars();