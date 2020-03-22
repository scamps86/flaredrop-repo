<?php

// Get the in auction products
$filter = new VoSystemFilter();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setFolderId(WebConstants::ID_CATEGORY_IN_AUCTION);

$inAuctionProducts = SystemDisk::objectsGet($filter, 'product');

$productIds = [];

foreach ($inAuctionProducts->list as $p) {
    array_push($productIds, $p['objectId']);
}

$result = [];
$result['auctionProductIds'] = $productIds;
$result['productsLastBid'] = SystemBids::getProductsLastBid();

echo json_encode($result);