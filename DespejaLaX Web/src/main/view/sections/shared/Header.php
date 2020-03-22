<?php

// Declare Javascript vars
UtilsJavascript::newVar('URL_SERVICE_GAME_LIST_INFO', UtilsHttp::getWebServiceUrl('gameGetListInfo'));
UtilsJavascript::echoVars();

// Define the main menu
$mainMenu = new ComponentSectionMenu();
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_HOME', 'Shared'), ['home']);
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_HELP', 'Shared'), ['help']);
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_CONTACT', 'Shared'), ['contact']);
?>


<style>
    body {
        background-color: <?= $BG_COLOR ?>;
    }
</style>

<!-- HEADER CONTAINER -->
<section id="header" class="row">

    <!-- LOGO -->
    <div id="topLogo">
        <a href="<?= UtilsHttp::getSectionUrl('home') ?>" title="<?= WebConfigurationBase::$WEBSITE_TITLE ?>">
            <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/logo.png') ?>"
                 alt="<?= WebConfigurationBase::$WEBSITE_TITLE ?>"/>
        </a>
    </div>

    <!-- LANGUAGE CHANGER -->
    <nav>
        <?php
        $languageChanger = new ComponentLanguageChanger();
        $languageChanger->setOptions(['CA', 'ES']);
        $languageChanger->echoComponent();
        ?>
    </nav>

    <nav id="userTop">
        <?php if (!$USER_LOGGED) { ?>
            <a class="userLoginBtn" href="#"
               title="<?= Managers::literals()->get('USER_LOGIN', 'Shared') ?>"><?= Managers::literals()->get('USER_LOGIN', 'Shared') ?></a>
            <a class="userJoinBtn" href="#"
               title="<?= Managers::literals()->get('USER_JOIN', 'Shared') ?>"><?= Managers::literals()->get('USER_JOIN', 'Shared') ?></a>
            <?php
        } else {
            ?>
            <a id="userTopTickets"
               href="<?= UtilsHttp::getSectionUrl('buy') ?>"><?= Managers::literals()->get('USER_YOU_HAVE', 'Shared') . ' ' . $userData->data . ' ' . Managers::literals()->get('USER_TICKETS', 'Shared') ?></a>
            <a href="<?= UtilsHttp::getSectionUrl('account') ?>"
               title="<?= Managers::literals()->get('MAIN_MENU_ACCOUNT', 'Shared') ?>"><?= Managers::literals()->get('MAIN_MENU_ACCOUNT', 'Shared') ?></a>
            <a class="userLoggutBtn" href="<?= UtilsHttp::getSectionUrl('accountLogout') ?>"
               title="<?= Managers::literals()->get('USER_LOGOUT', 'Shared') ?>"><?= Managers::literals()->get('USER_LOGOUT', 'Shared') ?></a>

            <?php
        }
        ?>
    </nav>
</section>


<!-- ASIDE CONTENTS -->
<aside class="hidden">

    <!-- USER JOIN FORM -->
    <div id="joinFormContainer">
        <div class="left">
            <?php
            $joinForm = new ComponentForm(UtilsHttp::getWebServiceUrl('userJoin'), 'userJoinForm');
            $joinForm->addInput('text', 'frmName', 'fill', Managers::literals()->get('FRM_ERROR_NAME', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_NAME', 'Shared') . ' *');
            $joinForm->addInput('text', 'frmEmail', 'email', Managers::literals()->get('FRM_ERROR_EMAIL', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_EMAIL', 'Shared') . ' *');
            $joinForm->addInput('text', 'frmNick', 'fill', Managers::literals()->get('FRM_ERROR_NICK', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_NICK', 'Shared') . ' *');
            $joinForm->addInput('password', 'frmPassword', 'fill;password;repeat', Managers::literals()->get('FRM_ERROR_PASSWORD', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PASSWORD', 'Shared') . ' *', 'AND', '', '', '', 'p1');
            $joinForm->addInput('password', '', 'repeat', Managers::literals()->get('FRM_ERROR_PASSWORD_REPEAT', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PASSWORD_REPEAT', 'Shared') . ' *', 'AND', '', '', '', 'p1');
            $joinForm->addSwitchComponent('', 'numberNatural', Managers::literals()->get('FRM_ERROR_CONDITIONS', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), '<a href="' . UtilsHttp::getSectionUrl('conditions') . '">' . Managers::literals()->get('FRM_CONDITIONS', 'Shared') . '</a>', '', 'frmConditions');
            $joinForm->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('FRM_JOIN', 'Shared'));
            $joinForm->echoComponent();
            ?>
        </div>
        <div class="right">
            <img src="" title="<?= Managers::literals()->get('USER_JOIN_US', 'Shared') ?>"/>
        </div>
    </div>

    <!-- USER LOGIN FORM -->
    <div id="loginFormContainer">
        <?php
        $loginForm = new ComponentForm(UtilsHttp::getWebServiceUrl('userLogin'), 'userLoginForm');
        $loginForm->addInput('hidden', 'diskId', '', '', '', '', '', 2);
        $loginForm->addInput('text', 'xLOG1', 'fill', '', Managers::literals()->get('FRM_NICK', 'Shared') . ' *');
        $loginForm->addInput('password', 'xLOG2', 'fill;password', '', Managers::literals()->get('FRM_PASSWORD', 'Shared') . ' *');
        $loginForm->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('FRM_LOGIN', 'Shared'));
        $loginForm->echoComponent();
        ?>
    </div>
</aside>
