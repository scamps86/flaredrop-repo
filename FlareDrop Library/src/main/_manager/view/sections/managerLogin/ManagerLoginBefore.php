<?php

// Set non scalable by default
WebConfigurationBase::$PAGE_SCALABLE = false;

// Destroy a user session if it exists
SystemUsers::logout(WebConfigurationBase::$DISK_MANAGER_ID);