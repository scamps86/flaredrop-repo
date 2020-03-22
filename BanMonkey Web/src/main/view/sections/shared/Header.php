<?php

// Define the bars
UtilsJavascript::newVar('DIALOG_SUCCESS', Managers::literals()->get('DIALOG_SUCCESS', 'Shared'));
UtilsJavascript::newVar('DIALOG_ERROR', Managers::literals()->get('DIALOG_ERROR', 'Shared'));
UtilsJavascript::newVar('DIALOG_ALERT', Managers::literals()->get('DIALOG_ALERT', 'Shared'));
UtilsJavascript::newVar('DIALOG_ACCEPT', Managers::literals()->get('DIALOG_ACCEPT', 'Shared'));
UtilsJavascript::newVar('DIALOG_CANCEL', Managers::literals()->get('DIALOG_CANCEL', 'Shared'));
UtilsJavascript::newVar('FRM_NICK', Managers::literals()->get('FRM_NICK', 'Shared'));
UtilsJavascript::newVar('FRM_PASSWORD', Managers::literals()->get('FRM_PASSWORD', 'Shared'));
UtilsJavascript::newVar('FRM_LOG_IN', Managers::literals()->get('FRM_LOG_IN', 'Shared'));
UtilsJavascript::newVar('FRM_LOGIN_ERROR', Managers::literals()->get('FRM_LOGIN_ERROR', 'Shared'));
UtilsJavascript::newVar('FRM_USER_LOGIN_NO_REMEMBER', Managers::literals()->get('FRM_USER_LOGIN_NO_REMEMBER', 'Shared'));
UtilsJavascript::newVar('FRM_USER_RESET', Managers::literals()->get('FRM_USER_RESET', 'Shared'));
UtilsJavascript::newVar('FRM_USER_RESET_NAME', Managers::literals()->get('FRM_USER_RESET_NAME', 'Shared'));
UtilsJavascript::newVar('FRM_USER_RESET_RESET', Managers::literals()->get('FRM_USER_RESET_RESET', 'Shared'));
UtilsJavascript::newVar('FRM_PASSWORD_REMEMBER_SUCCESS', Managers::literals()->get('FRM_PASSWORD_REMEMBER_SUCCESS', 'Shared'));
UtilsJavascript::newVar('FRM_PASSWORD_REMEMBER_ERROR', Managers::literals()->get('FRM_PASSWORD_REMEMBER_ERROR', 'Shared'));
UtilsJavascript::newVar('USER_LOGGED', USER_LOGGED);
UtilsJavascript::newVar('ULO_URL', UtilsHttp::getWebServiceUrl('UserLogout'));
UtilsJavascript::newVar('ULI_URL', UtilsHttp::getWebServiceUrl('UserLogin'));
UtilsJavascript::newVar('PB_URL', UtilsHttp::getWebServiceUrl('DoBid'));
UtilsJavascript::newVar('ULR_URL', UtilsHttp::getWebServiceUrl('UserPasswordReset'));
UtilsJavascript::newVar('SECTION_USER_BUY_BANS_URL', UtilsHttp::getSectionUrl('userBuyBans'));
UtilsJavascript::newVar('PAYPAL_SANDBOX', WebConfigurationBase::$PAYPAL_SANDBOX, true);
UtilsJavascript::newVar('PAYPAL_BUSINESS', WebConfigurationBase::$PAYPAL_BUSINESS);
UtilsJavascript::newVar('PAYPAL_HEADER_IMAGE_URL', UtilsHttp::getAbsoluteUrl('view/resources/images/shared/payPalHeader.jpg'));
UtilsJavascript::newVar('PAYPAL_BUY_NOW_NOTIFY_URL', UtilsHttp::getWebServiceUrl('PayPalIPNValidateBuyNow', null, true));
UtilsJavascript::newVar('BID_ERROR', Managers::literals()->get('BID_ERROR', 'Shared'));
UtilsJavascript::newVar('BID_SUCCESS', Managers::literals()->get('BID_SUCCESS', 'Shared'));
UtilsJavascript::newVar('BID_NOBANS_ERROR', Managers::literals()->get('BID_NOBANS_ERROR', 'Shared'));
UtilsJavascript::newVar('BID_CURRENT_ERROR', Managers::literals()->get('BID_CURRENT_ERROR', 'Shared'));
UtilsJavascript::newVar('MAIL_NOREPLY', WebConstants::MAIL_NOREPLY);
UtilsJavascript::newVar('USER_CONDITIONS_TITLE', Managers::literals()->get('USER_CONDITIONS_TITLE', 'Shared'));
UtilsJavascript::newVar('PRODUCT_NOBODY', Managers::literals()->get('PRODUCT_NOBODY', 'Shared'));
UtilsJavascript::newVar('DISK_WEB_ID', WebConfigurationBase::$DISK_WEB_ID);

// Define the user id if the user is logged
if (USER_LOGGED) {
    UtilsJavascript::newVar('USER_ID', $loginResult->data->userId);
}

UtilsJavascript::echoVars();

?>

<section id="header" class="row">
    <div class="centered">
        <div class="row" style="overflow: visible">

            <!-- LOGO -->
            <div id="topLogoContainer">
                <a href="<?= UtilsHttp::getSectionUrl('home') ?>"
                   title="<?= WebConfigurationBase::$WEBSITE_TITLE ?>">
                    <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/banmonkey-logo.png') ?>"
                         alt="<?= WebConfigurationBase::$WEBSITE_TITLE ?>"/>
                </a>
            </div>

            <!-- TOP MENU -->
            <nav id="topMenu">
                <!-- USERS -->
                <div id="topUsersContainer" class="row">
                    <?php
                    if (USER_LOGGED) {
                        ?>
                        <div id="userLoggedMenuContainer" class="row">
                            <a id="userOptionMyAccount" href="<?= UtilsHttp::getSectionUrl('userBuyBans') ?>"
                               title="<?= Managers::literals()->get('USER_MENU_ACCOUNT', 'Shared') ?>"><?= Managers::literals()->get('USER_MENU_ACCOUNT', 'Shared') ?></a>

                            <p id="userOptionLogout"><?= Managers::literals()->get('USER_MENU_LOGOUT', 'Shared') ?></p>
                        </div>
                    <?php
                    } else {
                        ?>
                        <a id="userMenuOptionJoin" href="<?= UtilsHttp::getSectionUrl('help') ?>"
                           title="<?= Managers::literals()->get('USER_MENU_JOIN', 'Shared') ?>"><?= Managers::literals()->get('USER_MENU_JOIN', 'Shared') ?></a>
                        <p id="userMenuOptionLogin"><?= Managers::literals()->get('USER_MENU_LOGIN', 'Shared') ?></p>

                        <!-- USER LOGIN FORM-->
                        <div id="userLoginFormContainer">
                            <?php
                            $loginForm = new ComponentForm(UtilsHttp::getWebServiceUrl('UserLogin'), 'userLoginForm');
                            $loginForm->addInput('hidden', 'diskId', '', '', '', '', '', 2);
                            $loginForm->addInput('text', 'xLOG1', 'fill', '', Managers::literals()->get('FRM_NICK', 'Shared') . ' *');
                            $loginForm->addInput('password', 'xLOG2', 'fill;password', '', Managers::literals()->get('FRM_PASSWORD', 'Shared') . ' *');
                            $loginForm->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('USER_MENU_LOGIN', 'Shared'));
                            $loginForm->echoComponent();
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <!-- MAIN MENU -->
                <div id="topMenuContainer" class="row">
                    <?php
                    $mainMenu = new ComponentSectionMenu();
                    $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_HOME', 'Shared'), ['home']);
                    $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_SOLD', 'Shared'), ['sold']);
                    $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_HELP', 'Shared'), ['help']);
                    $mainMenu->echoComponent();
                    ?>
                </div>
            </nav>
        </div>
    </div>
</section>

<div id="userConditions">
    <p><?= Managers::literals()->get('USER_CONDITIONS_CONTENTS', 'Shared') ?></p>
</div>