<?php

// Validate if the user is logged
$loginResult = SystemUsers::login('', '', WebConfigurationBase::$DISK_WEB_ID);
define('USER_LOGGED', $loginResult->state);

/**
 * @var $USER VoUser
 */
$USER = null;

$FOLDERS = null;


if (USER_LOGGED) {
    $USER = $loginResult->data;
    $USER->data = json_decode($USER->data, true);

    // GET CATEGORIES AND PRODUCTS
    // Get the folders tree
    $FOLDERS = SystemDisk::foldersGet(WebConfigurationBase::$ROOT_ID, 'product', WebConfigurationBase::$DISK_WEB_ID, true, WebConstants::getLanTag());

    // Generate the products filter
    $filter = new VoSystemFilter();
    $filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
    $filter->setAND();
    $filter->setLanTag(WebConstants::getLanTag());

    // Get the folder only if it's selected
    $FOLDER = SystemDisk::folderGet(UtilsHttp::getEncodedParam('folderId'), 'product');
    $FOLDER = $FOLDER != null && $FOLDER->visible ? $FOLDER : null;

    if ($FOLDER != null) {
        $filter->setAND();
        $filter->setFolderId($FOLDER->folderId);
    }

    // Get the current pagination page
    $filter->setPageCurrent(UtilsHttp::getEncodedParam('page'));
    $filter->setPageNumItems(12);

    // Set the sort by
    $filter->setSortFields('reference', 'ASC');

    // Get the products list
    $PRODUCTS = SystemDisk::objectsGet($filter, 'product');


    // DO NECESSARY REDIRECTIONS
    if (WebConstants::getSectionName() === 'home') {
        // Redirect to private section if the user is logged and is in the home section
        UtilsHttp::redirectToSection('privateHome');
    }
} else if (WebConstants::getSectionName() !== 'home') {
    // Redirect to the home section when the user is not logged in an user section
    UtilsHttp::redirectToSection('home');
}