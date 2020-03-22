<?php

// Define the filter
$filter = new VoSystemFilter();

$filterData = json_decode(UtilsHttp::getParameterValue('filterData'));

// Set the filter data
$filter->setData($filterData->_filterData);

// Get the params
$objectType = UtilsHttp::getParameterValue('objectType');

// Print the columns
$columns = '';

if ($objectType != 'user') {
    $columns = SystemDisk::objectsGetColumns($filter, $objectType);
}

// Print the JSON
$json = json_encode($columns);
UtilsHttp::fileGenerateHeaders('application/json', strlen($json), 'objectsColumnsGet', false);

echo $json;