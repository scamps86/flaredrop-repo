<?php

UtilsJavascript::newVar('MESSAGE_CART_SETITEM_SUCCESS', Managers::literals()->get('CART_SETITEM_SUCCESS', 'Products'));
UtilsJavascript::newVar('MESSAGE_CART_SETITEM_ERROR', Managers::literals()->get('CART_SETITEM_ERROR', 'Products'));
UtilsJavascript::newVar('MESSAGE_SUCCESS', Managers::literals()->get('FRM_SUCCESS', 'Shared'));
UtilsJavascript::newVar('MESSAGE_ERROR', Managers::literals()->get('FRM_ERROR', 'Shared'));
UtilsJavascript::newVar('BUTTON_CART_GO_TO_MYCART', Managers::literals()->get('CART_GO_TO_MYCART', 'Products'));
UtilsJavascript::newVar('BUTTON_CONTINUE', Managers::literals()->get('CART_CONTINUE', 'Products'));
UtilsJavascript::newVar('SECTION_CHECKOUT_URL', UtilsHttp::getSectionUrl('checkout'));
UtilsJavascript::echoVars();
