<?php

// Load the library
include_once '../../controller/system/SystemWebLoader.php';

// Load the loader base
include_once PATH_VIEW . 'loaders/SectionLoaderBase.php';


// Home
if (WebConstants::getSectionName() == 'home') {
    $section = new WebSection('home');
    $section->addCssFiles(['view/css/Home.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE);
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Home'));
    $section->loadPhpScriptBeforeHead('home/HomeBefore.php');
    $section->loadPhpScriptAfterHead('home/HomeAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// The band
if (WebConstants::getSectionName() == 'theband') {
    $section = new WebSection('theband');
    $section->addCssFiles(['view/css/TheBand.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' - ' . Managers::literals()->get('META_TITLE', 'TheBand'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Products'));
    $section->loadPhpScriptAfterHead('theband/TheBandAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Shows
if (WebConstants::getSectionName() == 'shows') {
    $section = new WebSection('shows');
    $section->addCssFiles(['view/css/Shows.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' - ' . Managers::literals()->get('META_TITLE', 'Shows'));
    $section->loadPhpScriptBeforeHead('shows/ShowsBefore.php');
    $section->loadPhpScriptAfterHead('shows/ShowsAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Discography
if (WebConstants::getSectionName() == 'discography') {
    $section = new WebSection('discography');
    $section->addCssFiles(['view/css/Discography.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' - ' . Managers::literals()->get('META_TITLE', 'Discography'));
    $section->loadPhpScriptBeforeHead('discography/DiscographyBefore.php');
    $section->loadPhpScriptAfterHead('discography/DiscographyAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Pictures
if (WebConstants::getSectionName() == 'pictures') {
    $section = new WebSection('pictures');
    $section->addCssFiles(['view/css/Pictures.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' - ' . Managers::literals()->get('META_TITLE', 'Pictures'));
    $section->loadPhpScriptBeforeHead('pictures/PicturesBefore.php');
    $section->loadPhpScriptAfterHead('pictures/PicturesAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Contact
if (WebConstants::getSectionName() == 'contact') {
    $section = new WebSection('contact');
    $section->addCssFiles(['view/css/Contact.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' - ' . Managers::literals()->get('META_TITLE', 'Contact'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Contact'));
    $section->loadPhpScriptInnerHead('contact/ContactInner.php');
    $section->loadPhpScriptAfterHead('contact/ContactAfter.php');
    $section->loadPhpScriptAfterHead('shared/Footer.php');
    $section->echoSection();
}

// Ticket office
if (WebConstants::getSectionName() == '_ticket-office') {
    $section = new WebSection('ticket-office');
    $section->addCssFiles(['view/css/TicketOffice.css']);
    $section->addJsFiles(['view/js/libraries/qcode-decoder/qcode-decoder.min.js']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' - ' . Managers::literals()->get('META_TITLE', 'TicketOffice'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'Contact'));
    $section->loadPhpScriptBeforeHead('ticketOffice/TicketOfficeBefore.php');
    $section->loadphpScriptInnerHead('ticketOffice/TicketOfficeInner.php');
    $section->loadPhpScriptAfterHead('ticketOffice/TicketOfficeAfter.php');
    $section->echoSection();
}

// REDIRECT TO THE MAIN SECTION IF THE REQUESTED SECTION NOT EXISTS
UtilsHttp::redirectToSection(WebConfigurationBase::$MAIN_SECTION);

