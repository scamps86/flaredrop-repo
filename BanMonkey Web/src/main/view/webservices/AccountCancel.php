<?php

// Get parameters
SystemUsers::login('', '', WebConfigurationBase::$DISK_WEB_ID);
$userData = SystemUsers::getLogged(WebConfigurationBase::$DISK_WEB_ID);

if ($userData) {
    $result = SystemUsers::remove([$userData->userId], true, WebConfigurationBase::$DISK_WEB_ID);

    if (!$result->state) {
        echo 'Error 1. ' . $result->description;
    }
} else {
    echo 'Error 2';
}