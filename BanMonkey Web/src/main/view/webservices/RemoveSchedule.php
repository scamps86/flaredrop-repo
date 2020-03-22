<?php

// Do the user login
SystemUsers::login('', '', WebConfigurationBase::$DISK_WEB_ID);

// Get the params
$bidScheduleId = UtilsHttp::getParameterValue('bidScheduleId');

// Set the schedule
if (!SystemBids::removeSchedules([$bidScheduleId])) {
    echo 'error 1';
}