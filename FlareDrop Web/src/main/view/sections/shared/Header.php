<!-- Get the current section for the javascript -->
<?php

// Define the main menu
$mainMenu = new ComponentSectionMenu();
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_HOME', 'Shared'), ['home']);
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_WE', 'Shared'), ['we']);
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_SERVICES', 'Shared'), ['products']);
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_REQUEST', 'Shared'), ['request']);
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_WORKS', 'Shared'), ['works']);
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_CONTACT', 'Shared'), ['contact']);

?>

<!-- INITIALIZE THE HEADER -->
<section id="header" class="row">

    <!-- LANGUAGE CHANGER & FLAREDROP TOP LOGO -->
    <div id="topLogoContainer" class="row smHide">
        <div class="centered">
            <?php
            $languageChanger = new ComponentLanguageChanger();
            $languageChanger->setOptions(['català', 'español'], true);
            $languageChanger->echoComponent();
            ?>

            <a class="topLogo" href="<?php echo UtilsHttp::getSectionUrl('home') ?>"
               title="<?php echo WebConfigurationBase::$WEBSITE_TITLE ?>">
                <img
                    src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/shared/flareDropTopLogoWhite.png') ?>"
                     alt="<?php echo WebConfigurationBase::$WEBSITE_TITLE ?>"/>
            </a>

            <nav id="topSharedNetworks">
                <a href="https://www.facebook.com/sharer/sharer.php?u=http://www.<?php echo WebConstants::getDomain() ?>"
                   target="_blank" class="fb"
                   title="<?php echo Managers::literals()->get('SHARE_TO', 'Shared') . ' Facebook' ?>"></a>
                <a href="https://plus.google.com/share?url=http://www.<?php echo WebConstants::getDomain() ?>"
                   target="_blank" class="g"
                   title="<?php echo Managers::literals()->get('SHARE_TO', 'Shared') . ' Google+' ?>"></a>
                <a href="https://twitter.com/home?status=http://www.<?php echo WebConstants::getDomain() ?>"
                   target="_blank"
                   class="tw" title="<?php echo Managers::literals()->get('SHARE_TO', 'Shared') . ' Twitter' ?>"></a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=http://www.<?php echo WebConstants::getDomain() ?>"
                   target="_blank" class="ln"
                   title="<?php echo Managers::literals()->get('SHARE_TO', 'Shared') . ' LinkedIn' ?>"></a>
            </nav>
        </div>
    </div>

    <!-- MAIN MENU -->
    <div id="topMenuContainer" class="row">
        <div class="centered">
            <!-- BIG DEVICES -->
            <nav id="desktopMenuContainer" class="row smHide">
                <?php
                $mainMenu->echoComponent();
                ?>
            </nav>

            <!-- SMALL DEVICES -->
            <div id="mobileTopMenuBtnContainer" class="row smShow">
                <img id="mobileTopMenuBtn"
                     src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/shared/mobileMenuBtn.svg') ?>"
                     alt="<?php echo WebConfigurationBase::$WEBSITE_TITLE ?>"/>

                <a class="topLogoMobile" href="<?php echo UtilsHttp::getSectionUrl('home') ?>"
                   title="<?php echo WebConfigurationBase::$WEBSITE_TITLE ?>">
                    <img class="transitionFast"
                         src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/shared/flareDropTopLogo.png') ?>"
                         alt="<?php echo WebConfigurationBase::$WEBSITE_TITLE ?>"/>
                </a>
            </div>
            <nav id="mobileTopMenuContainer" class="row smShow transitionNormal">
                <?php
                $languageChanger->echoComponent();
                $mainMenu->echoComponent();
                ?>
            </nav>
        </div>
    </div>
</section>