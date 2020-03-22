<?php

$loginResult = SystemUsers::login('', '', WebConfigurationBase::$DISK_WEB_ID);
define('USER_LOGGED', $loginResult->state);

// Get all ticket shows
$shows = SystemDisk::foldersGet(
    WebConfigurationBase::$ROOT_ID,
    'ticket',
    WebConfigurationBase::$DISK_MANAGER_ID,
    true,
    WebConstants::getLanTag()
);