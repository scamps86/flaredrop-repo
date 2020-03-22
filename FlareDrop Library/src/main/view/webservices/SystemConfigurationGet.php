<?php

// Define the application data array
$systemConfiguration = [];

// Get the current user
$loginResult = SystemUsers::login();

if ($loginResult->state == 1) {
    $systemConfiguration['user'] = $loginResult->data;
}

// Get the root configuration
$systemConfiguration['configuration'] = SystemManager::configurationGet(WebConfigurationBase::$ROOT_ID);

// Get if the manager can be configured or not
$systemConfiguration['configurable'] = WebConfigurationBase::$MANAGER_CONFIGURABLE;

// Get the server's disks
$systemConfiguration['disks'] = SystemDisk::getDisks();

// Get the configured root id
$systemConfiguration['rootId'] = WebConfigurationBase::$ROOT_ID;

// Get the FlareDrop PayPal constants
$systemConfiguration['payPalBusiness'] = WebConfigurationBase::$PAYPAL_FD_BUSINESS;
$systemConfiguration['sandboxEnabled'] = WebConfigurationBase::$PAYPAL_SANDBOX;

// Get privilege ids
$systemConfiguration['privilegeWriteId'] = WebConfigurationBase::$PRIVILEGE_WRITE_ID;
$systemConfiguration['privilegeReadId'] = WebConfigurationBase::$PRIVILEGE_READ_ID;

// Print the application data as an array
$json = json_encode($systemConfiguration);
UtilsHttp::fileGenerateHeaders('application/json', strlen($json), 'systemConfigurationGet', false);

echo $json;