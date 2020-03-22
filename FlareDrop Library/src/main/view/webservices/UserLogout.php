<?php

$diskId = UtilsHttp::getParameterValue('diskId');


UtilsHttp::fileGenerateHeaders('text/plain', 0, 'userLogout', false);

// Destroy a user session if it exists
SystemUsers::logout($diskId);