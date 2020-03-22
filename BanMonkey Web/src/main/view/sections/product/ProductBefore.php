<?php

$product = SystemDisk::objectGet(UtilsHttp::getEncodedParam('id'), 'product');

// If the product does not exist, redirect to home
if ($product == null) {
    UtilsHttp::redirectToSection('home');
}

// If the product is not an auction, redirect to the home
if (WebConstants::ID_CATEGORY_IN_AUCTION != $product->firstFolderIdGet()) {
    UtilsHttp::redirectToSection('home');
}

$auctionExpireTime = UtilsDate::toTimestamp($product->propertyGet('auctionExpireDate')) - UtilsDate::toTimestamp('');


// Set meta tags
self::addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' - ' . $product->localizedPropertyGet('name'));
self::addMetaDescription($product->localizedPropertyGet('description'));