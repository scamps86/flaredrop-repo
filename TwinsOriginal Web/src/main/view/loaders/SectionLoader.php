<?php

// Load the library
include_once '../../controller/system/SystemWebLoader.php';

// Load the loader base
include_once PATH_VIEW . 'loaders/SectionLoaderBase.php';


// Home
if (WebConstants::getSectionName() == 'home') {
    $section = new WebSection('home');
    $section->addCssFiles(['view/css/Home.css', 'view/js/libraries/owl/css/owl.carousel.css', 'view/js/libraries/owl/css/owl.transitions.css']);
    $section->addJsFiles(['view/js/libraries/owl/owl.carousel.min.js']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Home'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Home'));
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('home/HomeAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Staff
if (WebConstants::getSectionName() == 'staff') {
    $section = new WebSection('staff');
    $section->addCssFiles(['view/css/Staff.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Staff'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Staff'));
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('staff/StaffAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Contact
if (WebConstants::getSectionName() == 'contact') {
    $section = new WebSection('contact');
    $section->addCssFiles(['view/css/Contact.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Contact'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Contact'));
    $section->loadPhpScriptInnerHead('contact/ContactInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('contact/ContactAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// REDIRECT TO THE MAIN SECTION IF THE REQUESTED SECTION NOT EXISTS
UtilsHttp::redirectToSection(WebConfigurationBase::$MAIN_SECTION);

