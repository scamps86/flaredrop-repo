<?php

UtilsJavascript::newVar('RUS_URL', UtilsHttp::getWebServiceUrl('RefreshUserSchedules'));
UtilsJavascript::newVar('APL_URL', UtilsHttp::getWebServiceUrl('AuctionProductsList'));
UtilsJavascript::newVar('RS_URL', UtilsHttp::getWebServiceUrl('RemoveSchedule'));
UtilsJavascript::newVar('AS_URL', UtilsHttp::getWebServiceUrl('AddSchedule'));
UtilsJavascript::newVar('SELECT_PRODUCT', Managers::literals()->get('SELECT_PRODUCT', 'UserSchedule'));
UtilsJavascript::newVar('DEFINE_SCHEDULE', Managers::literals()->get('DEFINE_SCHEDULE', 'UserSchedule'));
UtilsJavascript::newVar('MAX_BANS', Managers::literals()->get('MAX_BANS', 'UserSchedule'));
UtilsJavascript::newVar('MAX_PRICE', Managers::literals()->get('MAX_PRICE', 'UserSchedule'));
UtilsJavascript::newVar('MAX_BANS_ERROR', Managers::literals()->get('MAX_BANS_ERROR', 'UserSchedule'));
UtilsJavascript::newVar('MAX_PRICE_ERROR', Managers::literals()->get('MAX_PRICE_ERROR', 'UserSchedule'));
UtilsJavascript::newVar('ADD_SCHEDULE_ERROR', Managers::literals()->get('ADD_SCHEDULE_ERROR', 'UserSchedule'));
UtilsJavascript::newVar('REMOVE_ERROR', Managers::literals()->get('REMOVE_ERROR', 'UserSchedule'));
UtilsJavascript::newVar('REMOVE', Managers::literals()->get('REMOVE', 'UserSchedule'));
UtilsJavascript::echoVars();