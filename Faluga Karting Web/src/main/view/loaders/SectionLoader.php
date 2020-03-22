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
    $section->loadPhpScriptBeforeHead('home/HomeBefore.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('home/HomeAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// We
if (WebConstants::getSectionName() == 'we') {
    $section = new WebSection('we');
    $section->addCssFiles(['view/css/We.css', 'view/js/libraries/owl/css/owl.carousel.css', 'view/js/libraries/owl/css/owl.transitions.css']);
    $section->addJsFiles(['view/js/libraries/owl/owl.carousel.min.js']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'We'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'We'));
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('we/WeAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Test
if (WebConstants::getSectionName() == 'test') {
    $section = new WebSection('test');
    $section->addCssFiles(['view/css/Test.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Test'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Test'));
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('test/TestAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// News
if (WebConstants::getSectionName() == 'news') {
    $section = new WebSection('news');
    $section->addCssFiles(['view/css/News.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'News'));
    $section->loadPhpScriptBeforeHead('news/NewsBefore.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('news/NewsAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Products
if (WebConstants::getSectionName() == 'products') {
    $section = new WebSection('products');
    $section->addCssFiles(['view/css/Products.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Products'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Products'));
    $section->loadPhpScriptBeforeHead('products/ProductsBefore.php');
    $section->loadPhpScriptInnerHead('products/ProductsInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('products/ProductsAfter.php');
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

// Checkout
if (WebConstants::getSectionName() == 'checkout') {
    $section = new WebSection('checkout');
    $section->addCssFiles(['view/css/Checkout.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Checkout'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Checkout'));
    $section->loadPhpScriptInnerHead('checkout/CheckoutInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('checkout/CheckoutAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// REDIRECT TO THE MAIN SECTION IF THE REQUESTED SECTION NOT EXISTS
UtilsHttp::redirectToSection(WebConfigurationBase::$MAIN_SECTION);

