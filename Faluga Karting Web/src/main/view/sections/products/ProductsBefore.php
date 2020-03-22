<?php

// Get the category/subcategory id
$cId = UtilsHttp::getEncodedParam('c');
$sId = UtilsHttp::getEncodedParam('sc');
$ssId = UtilsHttp::getEncodedParam('ssc');

$products = null;
$subcategory = null;
$subcategories = null;
$subsubcategory = null;

if ($ssId != '') {
    // Generate the products filter
    $filter = new VoSystemFilter();
    $filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
    $filter->setAND();
    $filter->setLanTag(WebConstants::getLanTag());
    $filter->setAND();
    $filter->setFolderId($ssId);

    // Get the products list
    $products = SystemDisk::objectsGet($filter, 'product');

    // Get the subcategory
    $subcategory = SystemDisk::folderGet($ssId, 'product');
}