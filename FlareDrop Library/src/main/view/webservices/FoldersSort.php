<?php

// Get the folder data as an associative array from JSON
$sortData = json_decode(UtilsHttp::getParameterValue('sortData'), true);

// Update the folder sorting priorities
$result = SystemDisk::foldersSort($sortData);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'foldersSort', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}