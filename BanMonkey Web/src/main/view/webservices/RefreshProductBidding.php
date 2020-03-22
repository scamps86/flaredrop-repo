<?php

// Get the params
$productId = UtilsHttp::getEncodedParam('productId');

// Get the product
$product = SystemDisk::objectGet($productId, 'product');

// Generate the json
$result = [];
$result['inAuction'] = $product->folderIds == WebConstants::ID_CATEGORY_IN_AUCTION;
$result['bids'] = SystemBids::getProductBids($productId);

echo json_encode($result);