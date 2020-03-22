<?php

// Set the skin
$result = SystemManager::skinSet(WebConfigurationBase::$ROOT_ID, $_POST['skin']);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'systemSkinSet', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}