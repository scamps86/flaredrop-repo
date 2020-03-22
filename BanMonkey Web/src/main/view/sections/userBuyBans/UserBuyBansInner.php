<?php

UtilsJavascript::newVar('PAYPAL_BUY_BANS_NOTIFY_URL', UtilsHttp::getWebServiceUrl('PayPalIPNValidateBansPack', null, true));
UtilsJavascript::echoVars();