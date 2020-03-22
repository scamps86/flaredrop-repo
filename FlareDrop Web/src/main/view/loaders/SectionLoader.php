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
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE);
    $section->loadPhpScriptBeforeHead('home/HomeBefore.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('home/HomeAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// We
if (WebConstants::getSectionName() == 'we') {
    $section = new WebSection('we');
    $section->addCssFiles(['view/css/We.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'We'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'We'));
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('we/WeAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Products
if (WebConstants::getSectionName() == 'products') {
    $section = new WebSection('products');
    $section->addCssFiles(['view/css/Products.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Products'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Products'));
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('products/ProductsAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Works
if (WebConstants::getSectionName() == 'works') {
    $section = new WebSection('works');
    $section->addCssFiles(['view/css/Works.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Works'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Works'));
    $section->loadPhpScriptBeforeHead('works/WorksBefore.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('works/WorksAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Request
if (WebConstants::getSectionName() == 'request') {
    $section = new WebSection('request');
    $section->addCssFiles(['view/css/Request.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Request'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Request'));
    $section->loadPhpScriptInnerHead('request/RequestInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('request/RequestAfter.php');
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

