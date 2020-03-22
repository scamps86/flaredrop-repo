<?php

UtilsJavascript::newVar('VALIDATE_TICKET_URL', UtilsHttp::getWebServiceUrl('ValidateTicket', null, true));
UtilsJavascript::echoVars();