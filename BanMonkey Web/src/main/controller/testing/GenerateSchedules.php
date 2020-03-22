<?php

$filter = new VoSystemFilter();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setFolderId(8);

$users = SystemUsers::getList($filter);


foreach ($users->list as $u) {
    if (substr($u['name'], 0, 4) == 'test') {
        SystemBids::setSchedule(rand(15, 20), rand(500, 1000), rand(200, 50000), '', $u['userId']);
        SystemBids::setSchedule(rand(15, 20), rand(500, 1000), rand(200, 50000), '', $u['userId']);
        SystemBids::setSchedule(rand(15, 20), rand(500, 1000), rand(200, 50000), '', $u['userId']);
    }
}