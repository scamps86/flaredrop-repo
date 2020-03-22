<?php

// Get the product
$product = SystemDisk::objectGet(UtilsHttp::getEncodedParam('productId'), 'product');

// If the product not exists or not visible, redirect to the productes section
if (!$product || $product->propertyGet('visible') != '1') {
    UtilsHttp::redirectToSection('productes');
}

// Get the folders list
$folders = SystemDisk::foldersGet(WebConfigurationBase::$ROOT_ID, 'product', WebConfigurationBase::$DISK_WEB_ID, true, WebConstants::getLanTag());

// Get the product pictures
$pictures = $product->filesArrayGet();

// Set section meta tags
self::addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' - ' . $product->localizedPropertyGet('title'));
self::addMetaDescription($product->localizedPropertyGet('description'));