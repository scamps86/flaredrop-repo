<?php

// Define the filter
$filter = new VoSystemFilter();

$filterData = json_decode(UtilsHttp::getParameterValue('filterData'));

// Set the filter data
$filter->setData($filterData->_filterData);

// Get the params
$objectType = UtilsHttp::getParameterValue('objectType');

// Print the list as a JSON
$list = '';

if ($objectType == 'user') {
    $list = SystemUsers::getList($filter);
} else {
    $list = SystemDisk::objectsGet($filter, $objectType);
}

$json = json_encode($list);
UtilsHttp::fileGenerateHeaders('application/json', strlen($json), 'objectsGet', false);

echo $json;