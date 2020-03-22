<?php

UtilsJavascript::newVar('USER_ID', $userData->userId);
UtilsJavascript::newVar('PAYPAL_SANDBOX', WebConfigurationBase::$PAYPAL_SANDBOX, true);
UtilsJavascript::newVar('PAYPAL_BUSINESS', WebConfigurationBase::$PAYPAL_FD_BUSINESS);
UtilsJavascript::newVar('PAYPAL_HEADER_IMAGE_URL', UtilsHttp::getAbsoluteUrl('view/resources/images/shared/payPalHeader.jpg'));
UtilsJavascript::newVar('PAYPAL_NOTIFY_URL', UtilsHttp::getWebServiceUrl('PayPalIPNValidateTickets', null, true));
UtilsJavascript::newVar('TICKETS', Managers::literals()->get('TICKETS', 'Buy'));
UtilsJavascript::echoVars();