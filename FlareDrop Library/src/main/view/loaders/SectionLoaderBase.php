<?php

// Add the manager predefined sections
if (WebConfigurationBase::$ANT_MANAGER_GENERATION_ENABLED) {
// Manager login section
    if (WebConstants::getSectionName() == '_manager') {
        $section = new WebSection('_manager');
        $section->removeCssFiles();
        $section->removeJsFiles();
        $section->addCssFiles(['view/css/Initialize.css', 'view/css/ManagerShared.css', 'view/css/ManagerLogin.css']);
        $section->addJsFiles(['view/js/_manager.js']);
        $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' Manager');
        $section->addHtmlClass('container');
        $section->addBodyClass('container');
        $section->loadPhpScriptBeforeHead('managerLogin/ManagerLoginBefore.php');
        $section->loadPhpScriptInnerHead('managerShared/ManagerJavascriptVarsDefine.php');
        $section->loadPhpScriptAfterHead('managerLogin/ManagerLoginAfter.php');
        $section->echoSection();
    }

// Manager app section
    if (WebConstants::getSectionName() == '_managerApp') {
        $section = new WebSection('_manager');
        $section->removeCssFiles();
        $section->removeJsFiles();
        $section->addCssFiles(['view/css/Initialize.css', 'view/css/ManagerShared.css', 'view/css/ManagerApplication.css']);
        $section->addJsFiles(['view/js/_manager.js']);
        $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' Manager');
        $section->addHtmlClass('container');
        $section->addBodyClass('container');
        $section->loadPhpScriptBeforeHead('managerApp/ManagerAppBefore.php');
        $section->loadPhpScriptInnerHead('managerApp/ManagerAppInner.php');
        $section->loadPhpScriptInnerHead('managerShared/ManagerJavascriptVarsDefine.php');
        $section->loadPhpScriptAfterHead('managerApp/ManagerAppAfter.php');
        $section->echoSection();
    }
}

// Add the under construction section
if (WebConfigurationBase::$WEB_UNDER_CONSTRUCTION_ENABLED) {
    if (WebConstants::getSectionName() != 'underConstruction') {
        UtilsHttp::redirectToSection('underConstruction');
    }
    $section = new WebSection('underConstruction');
    $section->removeCssFiles();
    $section->removeJsFiles();
    $section->addCssFiles(['view/css/Initialize.css', 'view/css/UnderConstruction.css']);
    $section->addMetaTitle(WebConfigurationBase::$WEBSITE_TITLE . ' ' . Managers::literals()->get('META_TITLE', 'UnderConstruction'));
    $section->addMetaDescription(Managers::literals()->get('META_DESCRIPTION', 'UnderConstruction'));
    $section->loadPhpScriptAfterHead('underConstruction/UnderConstruction.php');
    $section->echoSection();
}


// Validate if the web configuration is correct in production
if (WebConstants::isInProduction()) {
    $subject = 'Bad configuration in production for: ' . WebConstants::getDomain();
    $message = '';

    // Do the validations
    if (!WebConfigurationBase::$ANT_MINIFY_ENABLED) {
        $message .= '- The website is not minified!<br>';
    }
    if (WebConfigurationBase::$MANAGER_CONFIGURABLE) {
        $message .= '- The manager is configurable!<br>';
    }
    if (WebConfigurationBase::$PAYPAL_SANDBOX) {
        $message .= '- The PayPal Sandbox is enabled!<br>';
    }

    if ($message != '') {
        Managers::mailing()->send(WebConfigurationBase::$ERROR_NOREPLY_MAIL, WebConfigurationBase::$ERROR_NOTIFY_MAIL, $subject, $message);
    }
}
