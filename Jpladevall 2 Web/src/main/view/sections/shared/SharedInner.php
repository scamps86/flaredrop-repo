<?php

// Global literals
UtilsJavascript::newVar('DIALOG_ERROR', Managers::literals()->get('DIALOG_ERROR', 'Shared'));
UtilsJavascript::newVar('DIALOG_SUCCESS', Managers::literals()->get('DIALOG_SUCCESS', 'Shared'));
UtilsJavascript::newVar('DIALOG_ACCEPT', Managers::literals()->get('DIALOG_ACCEPT', 'Shared'));
UtilsJavascript::newVar('DIALOG_CANCEL', Managers::literals()->get('DIALOG_CANCEL', 'Shared'));
UtilsJavascript::newVar('DIALOG_ALERT', Managers::literals()->get('DIALOG_ALERT', 'Shared'));

// Global constants
UtilsJavascript::newVar('DISK_WEB_ID', WebConfigurationBase::$DISK_WEB_ID);

// Global webservices
UtilsJavascript::newVar('WEBSERVICE_LOGOUT', UtilsHttp::getWebServiceUrl('UserLogout'));
UtilsJavascript::newVar('WEBSERVICE_NEWSLETTER_JOIN', UtilsHttp::getWebServiceUrl('JoinNewsletter'));
UtilsJavascript::newVar('WEBSERVICE_USER_UNREGISTER', UtilsHttp::getWebServiceUrl('UserUnregister'));
UtilsJavascript::newVar('WEBSERVICE_PAYPAL_IPN', UtilsHttp::getWebServiceUrl('PayPalIPNValidate', null, true));

// Section relative urls
UtilsJavascript::newVar('SECTION_CATALOG', UtilsHttp::getSectionUrl('catalog'));
UtilsJavascript::newVar('SECTION_PRIVATE_HOME', UtilsHttp::getSectionUrl('privateHome'));
UtilsJavascript::newVar('SECTION_MY_CART', UtilsHttp::getSectionUrl('myCart'));

// Other necessary vars
UtilsJavascript::newVar('USER_VALIDATION_SUCCESS', '');
UtilsJavascript::newVar('USER_VALIDATION_SUCCESS_MESSAGE', '');
UtilsJavascript::newVar('FRM_NEWSLETTER_JOIN_SUCCESS', Managers::literals()->get('FRM_NEWSLETTER_JOIN_SUCCESS', 'Shared'));

// Shopping cart literals
UtilsJavascript::newVar('BUTTON_CART_GO_TO_MYCART', Managers::literals()->get('BUTTON_CART_GO_TO_MYCART', 'Shared'));
UtilsJavascript::newVar('MESSAGE_CART_SETITEM_SUCCESS', Managers::literals()->get('MESSAGE_CART_SETITEM_SUCCESS', 'Shared'));
UtilsJavascript::newVar('MESSAGE_CART_SETITEM_ERROR', Managers::literals()->get('MESSAGE_CART_SETITEM_ERROR', 'Shared'));
UtilsJavascript::newVar('CART_HEADER_UNIT_PRICE', Managers::literals()->get('CART_HEADER_UNIT_PRICE', 'Shared'));
UtilsJavascript::newVar('CART_HEADER_QUANTITY', Managers::literals()->get('CART_HEADER_QUANTITY', 'Shared'));
UtilsJavascript::newVar('CART_HEADER_SUBTOTAL', Managers::literals()->get('CART_HEADER_SUBTOTAL', 'Shared'));
UtilsJavascript::newVar('CART_REMOVE', Managers::literals()->get('CART_REMOVE', 'Shared'));
UtilsJavascript::newVar('CART_CANCEL', Managers::literals()->get('CART_CANCEL', 'Shared'));
UtilsJavascript::newVar('CART_ALERT', Managers::literals()->get('CART_ALERT', 'Shared'));
UtilsJavascript::newVar('CART_EMPTY_CART', Managers::literals()->get('CART_EMPTY_CART', 'Shared'));
UtilsJavascript::newVar('CART_TOTAL_PRICE', Managers::literals()->get('CART_TOTAL_PRICE', 'Shared'));
UtilsJavascript::newVar('CART_SURE_EMPTY_CART', Managers::literals()->get('CART_SURE_EMPTY_CART', 'Shared'));
UtilsJavascript::newVar('CART_SURE_REMOVE_ITEM', Managers::literals()->get('CART_SURE_REMOVE_ITEM', 'Shared'));
UtilsJavascript::newVar('CART_EMPTY', Managers::literals()->get('CART_EMPTY', 'Shared'));

// My account literals
UtilsJavascript::newVar('FRM_USER_MODIFY_SUCCESS', Managers::literals()->get('FRM_USER_MODIFY_SUCCESS', 'Shared'));
UtilsJavascript::newVar('FRM_USER_MODIFY_ERROR', Managers::literals()->get('FRM_USER_MODIFY_ERROR', 'Shared'));
UtilsJavascript::newVar('USER_UNREGISTER_SURE', Managers::literals()->get('USER_UNREGISTER_SURE', 'Shared'));
UtilsJavascript::newVar('USER_UNREGISTER_SUCCESS', Managers::literals()->get('USER_UNREGISTER_SUCCESS', 'Shared'));
UtilsJavascript::newVar('USER_UNREGISTER_ERROR', Managers::literals()->get('USER_UNREGISTER_ERROR', 'Shared'));

// PayPal
UtilsJavascript::newVar('PAYPAL_SANDBOX', WebConfigurationBase::$PAYPAL_SANDBOX, true);
UtilsJavascript::newVar('PAYPAL_BUSINESS', WebConfigurationBase::$PAYPAL_BUSINESS);
UtilsJavascript::newVar('PAYPAL_BUY_NOW_NOTIFY_URL', UtilsHttp::getWebServiceUrl('PayPalIPNValidateBuyNow', null, true));


// Shopping cart products
if (isset($shoppingCartProducts)) {
    UtilsJavascript::newVar('SHOPPING_CART_PRODUCTS', $shoppingCartProducts);
    UtilsJavascript::echoVars();
}

// Echo the vars
UtilsJavascript::echoVars();

?>