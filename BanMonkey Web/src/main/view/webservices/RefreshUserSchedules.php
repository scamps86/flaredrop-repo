<?php

// Get the user data
SystemUsers::login('', '', WebConfigurationBase::$DISK_WEB_ID);
$userData = SystemUsers::getLogged(WebConfigurationBase::$DISK_WEB_ID);

// Get the schedules
$schedules = SystemBids::getSchedules($userData->userId);

// Assign the products
$result = [];
foreach ($schedules as $s) {
    $product = SystemDisk::objectGet($s['objectId'], 'product');
    $picture = $product->firstFileGet();
    $s['productName'] = $product->localizedPropertyGet('name', WebConstants::getLanTag());

    if ($picture) {
        $s['productPicture'] = UtilsHttp::getPictureUrl($picture->fileId, '100x100');
    }

    array_push($result, $s);
}

// Print it as a json
echo json_encode($result);