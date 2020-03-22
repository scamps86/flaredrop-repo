<?php

// Generate the shopping cart literals
$shoppingCartLiterals = [
    'units' => Managers::literals()->get('SHOPPING_CART_UNITS', 'Checkout'),
    'price' => Managers::literals()->get('SHOPPING_CART_PRICE', 'Checkout'),
    'remove' => Managers::literals()->get('SHOPPING_CART_REMOVE', 'Checkout'),
    'cancel' => Managers::literals()->get('SHOPPING_CART_CANCEL', 'Checkout'),
    'alert' => Managers::literals()->get('SHOPPING_CART_ALERT', 'Checkout'),
    'emptyCart' => Managers::literals()->get('SHOPPING_CART_EMPTY_CART', 'Checkout'),
    'shippingPrice' => Managers::literals()->get('SHOPPING_CART_SHIPPING_PRICE', 'Checkout'),
    'totalPrice' => Managers::literals()->get('SHOPPING_CART_TOTAL_PRICE', 'Checkout'),
    'sureEmptyCart' => Managers::literals()->get('SHOPPING_CART_SURE_EMPTY_CART', 'Checkout'),
    'sureRemoveItem' => Managers::literals()->get('SHOPPING_CART_SURE_REMOVE_ITEM', 'Checkout'),
    'noItems' => Managers::literals()->get('SHOPPING_CART_NO_ITEMS', 'Checkout')];

UtilsJavascript::newVar('SHOPPING_CART_LITERALS', $shoppingCartLiterals);
UtilsJavascript::newVar('dialogSuccess', Managers::literals()->get('DIALOG_SUCCESS', 'Shared'));
UtilsJavascript::newVar('dialogError', Managers::literals()->get('DIALOG_ERROR', 'Shared'));
UtilsJavascript::newVar('FRM_CHECKOUT_SUCCESS', Managers::literals()->get('FRM_CHECKOUT_SUCCESS', 'Shared'));
UtilsJavascript::newVar('FRM_CHECKOUT_ERROR', Managers::literals()->get('FRM_CHECKOUT_ERROR', 'Shared'));
UtilsJavascript::newVar('PAYPAL_USE_SANDBOX', WebConfigurationBase::$PAYPAL_SANDBOX);
UtilsJavascript::newVar('PAYPAL_BUSINESS', WebConfigurationBase::$PAYPAL_BUSINESS);
UtilsJavascript::newVar('PAYPAL_CPP_HEADER_IMAGE', UtilsHttp::getAbsoluteUrl('view/resources/images/shared/payPalHeader.png'));
UtilsJavascript::newVar('PAYPAL_NOTIFY_URL', UtilsHttp::getWebServiceUrl('ValidateIpn', null, true));
UtilsJavascript::newVar('TPV_URL_TPVV', WebConfigurationBase::$TPV_URL_TPVV);
UtilsJavascript::newVar('TPV_KEY', WebConfigurationBase::$TPV_KEY);
UtilsJavascript::newVar('TPV_CODE', WebConfigurationBase::$TPV_CODE);
UtilsJavascript::newVar('TPV_TERMINAL', WebConfigurationBase::$TPV_TERMINAL);
UtilsJavascript::newVar('TPV_CURRENCY', WebConfigurationBase::$TPV_CURRENCY);
UtilsJavascript::newVar('TPV_TRANSACTION_TYPE', WebConfigurationBase::$TPV_TRANSACTION_TYPE);
UtilsJavascript::newVar('TPV_NOTIFY_URL', UtilsHttp::getWebServiceUrl('ValidateTpv', null, true));
UtilsJavascript::newVar('TPV_SIGNATURE_GET', UtilsHttp::getWebServiceUrl('TpvSignatureGet', null, true));
UtilsJavascript::echoVars();