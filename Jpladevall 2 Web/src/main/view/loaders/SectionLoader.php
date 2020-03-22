<?php

// Load the library
include_once '../../controller/system/SystemWebLoader.php';

// Load the loader base
include_once PATH_VIEW . 'loaders/SectionLoaderBase.php';


// Home
if (WebConstants::getSectionName() == 'home') {
    $section = new WebSection('home');
    $section->addCssFiles(['view/css/Home.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Home'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Home'));
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptInnerHead('shared/SharedInner.php');
    $section->loadPhpScriptInnerHead('home/HomeInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('home/HomeAfter.php');
    $section->echoSection();
}
if (WebConstants::getSectionName() == 'catalog') {
    $section = new WebSection('home');
    $section->addCssFiles(['view/css/Catalog.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Catalog'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Catalog'));
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptBeforeHead('catalog/CatalogBefore.php');
    $section->loadPhpScriptInnerHead('shared/SharedInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('catalog/CatalogAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}
if (WebConstants::getSectionName() == 'product') {
    $section = new WebSection('product');
    $section->addCssFiles(['view/css/Product.css', 'view/js/libraries/owl/css/owl.carousel.css', 'view/js/libraries/owl/css/owl.transitions.css']);
    $section->addJsFiles(['view/js/libraries/owl/owl.carousel.min.js']);
    $section->addExternalJsScripts(['//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-57e248f1d15d379c']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'Product'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Product'));
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptBeforeHead('product/ProductBefore.php');
    $section->loadPhpScriptInnerHead('shared/SharedInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('product/ProductAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}
if (WebConstants::getSectionName() == 'myCart') {
    $section = new WebSection('myCart');
    $section->addCssFiles(['view/css/MyCart.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'MyCart'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'MyCart'));
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptBeforeHead('myCart/MyCartBefore.php');
    $section->loadPhpScriptInnerHead('shared/SharedInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('myCart/MyCartAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}
if (WebConstants::getSectionName() == 'myAccount') {
    $section = new WebSection('myAccount');
    $section->addCssFiles(['view/css/MyAccount.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'MyCart'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'MyAccount'));
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptBeforeHead('myAccount/MyAccountBefore.php');
    $section->loadPhpScriptInnerHead('shared/SharedInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('myAccount/MyAccountAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}
if (WebConstants::getSectionName() == 'privateHome') {
    $section = new WebSection('privateHome');
    $section->addCssFiles(['view/css/PrivateHome.css', 'view/js/libraries/owl/css/owl.carousel.css', 'view/js/libraries/owl/css/owl.transitions.css']);
    $section->addJsFiles(['view/js/libraries/owl/owl.carousel.min.js']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'PrivateHome'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'PrivateHome'));
    $section->loadPhpScriptBeforeHead('shared/LoadBefore.php');
    $section->loadPhpScriptBeforeHead('privateHome/PrivateHomeBefore.php');
    $section->loadPhpScriptInnerHead('shared/SharedInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('privateHome/PrivateHomeAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// REDIRECT TO THE MAIN SECTION IF THE REQUESTED SECTION NOT EXISTS
UtilsHttp::redirectToSection(WebConfigurationBase::$MAIN_SECTION);

