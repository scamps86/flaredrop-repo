<?php

// Load the library
include_once '../../controller/system/SystemWebLoader.php';

// Load the loader base
include_once PATH_VIEW . 'loaders/SectionLoaderBase.php';


// Aparador
if (WebConstants::getSectionName() == 'aparador') {
    $section = new WebSection('aparador');
    $section->addCssFiles(['view/css/Aparador.css', 'view/js/libraries/owl/css/owl.carousel.css', 'view/js/libraries/owl/css/owl.transitions.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' - ' . Managers::literals()->get('META_TITLE', 'Aparador'));
    $section->addJsFiles(['view/js/libraries/owl/owl.carousel.min.js']);
    $section->loadPhpScriptBeforeHead('aparador/AparadorBefore.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('aparador/AparadorAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Qui som?
if (WebConstants::getSectionName() == 'quisom') {
    $section = new WebSection('quisom');
    $section->addCssFiles(['view/css/Quisom.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' - ' . Managers::literals()->get('META_TITLE', 'Quisom'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Quisom'));
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('quisom/QuiSomAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Productes
if (WebConstants::getSectionName() == 'productes') {
    $section = new WebSection('productes');
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' - ' . Managers::literals()->get('META_TITLE', 'Productes'));
    $section->loadPhpScriptBeforeHead('productes/ProductesBefore.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('productes/ProductesAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Producte
if (WebConstants::getSectionName() == 'producte') {
    $section = new WebSection('producte');
    $section->addCssFiles(['view/css/Producte.css', 'view/js/libraries/owl/css/owl.carousel.css', 'view/js/libraries/owl/css/owl.transitions.css']);
    $section->addJsFiles(['view/js/libraries/owl/owl.carousel.min.js']);
    $section->loadPhpScriptBeforeHead('producte/ProducteBefore.php');
    $section->loadPhpScriptInnerHead('producte/ProducteInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('producte/ProducteAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Contacte
if (WebConstants::getSectionName() == 'contacte') {
    $section = new WebSection('contacte');
    $section->addCssFiles(['view/css/Contacte.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' - ' . Managers::literals()->get('META_TITLE', 'Contacte'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Contacte'));
    $section->loadPhpScriptInnerHead('contacte/ContacteInner.php');
    $section->loadPhpScriptAfterHead('shared/Header.php');
    $section->loadPhpScriptAfterHead('contacte/ContacteAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// REDIRECT TO THE MAIN SECTION IF THE REQUESTED SECTION NOT EXISTS
UtilsHttp::redirectToSection(WebConfigurationBase::$MAIN_SECTION);

