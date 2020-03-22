<?php

// Get the folders tree
$folders = SystemDisk::foldersGet(WebConfigurationBase::$ROOT_ID, 'product', WebConfigurationBase::$DISK_WEB_ID, true, WebConstants::getLanTag());

// Get the selected product
$product = SystemDisk::objectGet(UtilsHttp::getEncodedParam('objectId'), 'product');

if ($product == null) {
    UtilsHttp::redirectToSection('catalog');
}
if ($product->propertyGet('visible') == 0) {
    UtilsHttp::redirectToSection('catalog');
}

// Define the section meta tags
self::addMetaTitle(Managers::literals()->get('META_TITLE', 'Product') . ' - ' . $product->localizedPropertyGet('title'));
self::addMetaDescription($product->localizedPropertyGet('description'));