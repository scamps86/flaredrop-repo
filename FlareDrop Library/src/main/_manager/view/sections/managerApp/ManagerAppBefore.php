<?php

// Set non scalable by default
WebConfigurationBase::$PAGE_SCALABLE = false;

// Redirect to the login section only if the session is not correct
$session = SystemUsers::login();

// Redirect to the login view if there isn't an established session
if (!$session->state) {
    UtilsHttp::redirectToSection('_manager');
}