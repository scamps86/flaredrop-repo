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
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptBeforeHead('home/HomeBefore.php');
    $section->loadPhpScriptInnerHead('home/HomeInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('home/HomeAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Product
if (WebConstants::getSectionName() == 'product') {
    $section = new WebSection('product');
    $section->addCssFiles(['view/css/Product.css', 'view/js/libraries/owl/css/owl.carousel.css', 'view/js/libraries/owl/css/owl.transitions.css', 'view/js/libraries/share/jquery.share.css']);
    $section->addJsFiles(['view/js/libraries/owl/owl.carousel.min.js', 'view/js/libraries/share/jquery.share.js']);
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptBeforeHead('product/ProductBefore.php');
    $section->loadPhpScriptInnerHead('product/ProductInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('product/ProductAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Sold
if (WebConstants::getSectionName() == 'sold') {
    $section = new WebSection('sold');
    $section->addCssFiles(['view/css/Sold.css', 'view/js/libraries/owl/css/owl.carousel.css', 'view/js/libraries/owl/css/owl.transitions.css']);
    $section->addJsFiles(['view/js/libraries/owl/owl.carousel.min.js']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Sold'));
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptBeforeHead('sold/SoldBefore.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('sold/SoldAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Help
if (WebConstants::getSectionName() == 'help') {
    $section = new WebSection('help');
    $section->addCssFiles(['view/css/Help.css', 'view/js/libraries/owl/css/owl.carousel.css', 'view/js/libraries/owl/css/owl.transitions.css']);
    $section->addJsFiles(['view/js/libraries/owl/owl.carousel.min.js']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Help'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Help'));
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptBeforeHead('help/HelpBefore.php');
    $section->loadPhpScriptInnerHead('help/HelpInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('help/HelpAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// User buy bans
if (WebConstants::getSectionName() == 'userBuyBans') {
    $section = new WebSection('userBuyBans');
    $section->addCssFiles(['view/css/UserBuyBans.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'UserBuyBans'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'UserBuyBans'));
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptBeforeHead('userBuyBans/UserBuyBansBefore.php');
    $section->loadPhpScriptInnerHead('userBuyBans/UserBuyBansInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('userBuyBans/UserBuyBansAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// User schedule bills
if (WebConstants::getSectionName() == 'userSchedule') {
    $section = new WebSection('userSchedule');
    $section->addCssFiles(['view/css/UserSchedule.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'UserSchedule'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'UserSchedule'));
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptInnerHead('userSchedule/UserScheduleInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('userSchedule/UserScheduleAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// User account
if (WebConstants::getSectionName() == 'userAccount') {
    $section = new WebSection('userAccount');
    $section->addCssFiles(['view/css/UserAccount.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'UserAccount'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'UserAccount'));
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptInnerHead('userAccount/UserAccountInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('userAccount/UserAccountAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// REDIRECT TO THE MAIN SECTION IF THE REQUESTED SECTION NOT EXISTS
UtilsHttp::redirectToSection(WebConfigurationBase::$MAIN_SECTION);

