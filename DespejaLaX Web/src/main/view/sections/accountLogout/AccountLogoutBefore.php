<?php

// Do the logout
SystemUsers::logout(WebConfigurationBase::$DISK_WEB_ID);

// Redirect to homt
UtilsHttp::redirectToSection('home');