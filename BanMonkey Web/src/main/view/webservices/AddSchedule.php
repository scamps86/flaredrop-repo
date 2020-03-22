<?php

// Do the user login
SystemUsers::login('', '', WebConfigurationBase::$DISK_WEB_ID);

// Get the params
$productId = UtilsHttp::getParameterValue('frmProductId');
$maxBans = UtilsHttp::getParameterValue('frmMaxBans');
$maxPrice = UtilsHttp::getParameterValue('frmMaxPrice');

// Set the schedule
if (!SystemBids::setSchedule($productId, $maxBans, $maxPrice)) {
    echo 'error 1';
}