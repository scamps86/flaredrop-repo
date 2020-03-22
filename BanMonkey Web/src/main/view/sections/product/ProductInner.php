<?php

UtilsJavascript::newVar('RPB_URL', UtilsHttp::getWebServiceUrl('RefreshProductBidding'));
UtilsJavascript::newVar('SECTION_SOLD_URL', UtilsHttp::getSectionUrl('sold'));
UtilsJavascript::echoVars();