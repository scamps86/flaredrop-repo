<?php

// Generate the new products filter
$filter = new VoSystemFilter();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setSortFields('creationDate', 'ASC');
$filter->setPageNumItems(10);

// Get the products list
$newProducts = SystemDisk::objectsGet($filter, 'product');

// Generate the shuffle products filter
$filter = new VoSystemFilter();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setRandom();
$filter->setPageNumItems(10);

// Get the products list
$shuffleProducts = SystemDisk::objectsGet($filter, 'product');


// Mix for shopping cart products
$shoppingCartProducts = array_merge($newProducts->list, $shuffleProducts->list);

?>