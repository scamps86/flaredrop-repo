<?php

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


// Generate the related products filter
$filter = new VoSystemFilter();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setRandom();
$filter->setPageNumItems(4);

// Get the products list
$relatedProducts = SystemDisk::objectsGet($filter, 'product');

// Shopping cart product (the detailed one)
$shoppingCartProducts = [[
    'type' => $product->type,
    'creationDate' => $product->creationDate,
    'title' => $product->localizedPropertyGet('title'),
    'objectId' => $product->objectId,
    'price' => $product->propertyGet('price')
]];