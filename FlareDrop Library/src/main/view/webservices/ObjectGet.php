<?php

// Get the params
$id = UtilsHttp::getParameterValue('objectId');
$objectType = UtilsHttp::getParameterValue('objectType');

// Get the object / user from the database
$object = $objectType == 'user' ? SystemUsers::get($id) : SystemDisk::objectGet($id, $objectType);

// Print the object as a JSON string
$json = json_encode($object);
UtilsHttp::fileGenerateHeaders('application/json', strlen($json), 'objectGet', false);

echo $json;