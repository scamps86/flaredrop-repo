<?php

// Define the filter
$filter = new VoSystemFilter();

$filterData = json_decode(UtilsHttp::getEncodedParam('filterData'));

// Set the filter data
$filter->setData($filterData->_filterData);

// Get the params
$objectType = UtilsHttp::getEncodedParam('objectType');
$csvColumns = json_decode(UtilsHttp::getEncodedParam('csvColumns'));
$csvDelimiter = UtilsHttp::getEncodedParam('csvDelimiter');
$csvEnclosure = UtilsHttp::getEncodedParam('csvEnclosure');

// Set defaults
$csvColumns = count($csvColumns) <= 0 ? null : $csvColumns;
$csvDelimiter = $csvDelimiter == '' ? ';' : $csvDelimiter;
$csvEnclosure = $csvEnclosure == '' ? '"' : $csvEnclosure;

// Print the CSV
if ($objectType != 'user') {
    $csv = SystemDisk::objectsGetCsv($filter, $objectType, $csvColumns, $csvDelimiter, $csvEnclosure);
    UtilsHttp::fileGenerateHeaders('text/csv', Managers::ftpFileSystem()->fileSize('', $csv), $objectType . '_export.csv', false);
    echo $csv;
}