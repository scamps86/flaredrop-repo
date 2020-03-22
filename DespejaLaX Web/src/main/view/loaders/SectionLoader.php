<?php

// Load the library
include_once '../../controller/system/SystemWebLoader.php';

// Load the loader base
include_once PATH_VIEW . 'loaders/SectionLoaderBase.php';


// Home
if (WebConstants::getSectionName() == 'home') {
    $section = new WebSection('home');
    $section->addCssFiles(['view/css/3rdParty/animate.css', 'view/css/Home.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Home'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Home'));
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptBeforeHead('home/HomeBefore.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('home/HomeAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Help
if (WebConstants::getSectionName() == 'help') {
    $section = new WebSection('products');
    $section->addCssFiles(['view/css/Products.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Products'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Products'));
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('products/HelpAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Contact
if (WebConstants::getSectionName() == 'contact') {
    $section = new WebSection('contact');
    $section->addCssFiles(['view/css/Contact.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Contact'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Contact'));
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptInnerHead('contact/ContactInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('contact/ContactAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Play
if (WebConstants::getSectionName() == 'play') {
    $section = new WebSection('play');
    $section->addCssFiles(['view/css/Play.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Play'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Play'));
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptBeforeHead('play/PlayBefore.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('play/PlayAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Account
if (WebConstants::getSectionName() == 'account') {
    $section = new WebSection('account');
    $section->addCssFiles(['view/css/Account.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Account'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Account'));
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('account/AccountAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Account validate
if (WebConstants::getSectionName() == 'accountValidate') {
    $section = new WebSection('accountValidate');
    $section->addCssFiles(['view/css/AccountValidate.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'AccountValidate'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'AccountValidate'));
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptBeforeHead('accountValidate/AccountValidateBefore.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('accountValidate/AccountValidateAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Account logout
if (WebConstants::getSectionName() == 'accountLogout') {
    $section = new WebSection('accountLogout');
    $section->loadPhpScriptBeforeHead('accountLogout/AccountLogoutBefore.php');
    $section->echoSection();
}

// Buy
if (WebConstants::getSectionName() == 'buy') {
    $section = new WebSection('buy');
    $section->addCssFiles(['view/css/Buy.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Buy'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Buy'));
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptInnerHead('buy/BuyInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('buy/BuyAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// REDIRECT TO THE MAIN SECTION IF THE REQUESTED SECTION NOT EXISTS
UtilsHttp::redirectToSection(WebConfigurationBase::$MAIN_SECTION);

