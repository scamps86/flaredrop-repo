<?php

// Generate the products filter
$filter = new VoSystemFilter();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setLanTag(WebConstants::getLanTag());

// Get the folder only if it's selected
$folder = SystemDisk::folderGet(UtilsHttp::getEncodedParam('folderId'), 'product');
$folder = $folder != null && $folder->visible ? $folder : null;

if ($folder != null) {
    $filter->setAND();
    $filter->setFolderId($folder->folderId);
}

// Get the current pagination page
$filter->setPageCurrent(UtilsHttp::getEncodedParam('page'));
$filter->setPageNumItems(12);


// Get the products list
$products = SystemDisk::objectsGet($filter, 'product');

// Define the section meta tags
if ($folder != null) {
    self::addMetaTitle(Managers::literals()->get('META_TITLE', 'Catalog') . ' - ' . $folder->nameGet());
    self::addMetaDescription($folder->descriptionGet());
}

// Get related products
$filter = new VoSystemFilter();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setPageNumItems(4);
$filter->setRandom();

$relatedProducts = SystemDisk::objectsGet($filter, 'product');

// Mix for shopping cart products
$shoppingCartProducts = array_merge($products->list, $relatedProducts->list);

