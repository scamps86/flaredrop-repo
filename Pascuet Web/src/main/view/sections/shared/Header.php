<section id="header" class="row">
    <div id="headerTop" class="row">
        <div class="centered">

            <!-- TOP LOGO -->
            <a id="topLogo" href="<?php echo UtilsHttp::getSectionUrl('aparador') ?>"
               title="<?php echo WebConfigurationBase::$WEBSITE_TITLE ?>">
                <img src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/shared/pascuet1.png') ?>"
                     alt="<?php echo WebConfigurationBase::$WEBSITE_TITLE ?>"/>
            </a>

            <!-- LANGUAGE CHANGER -->
            <nav id="languageChanger">
                <?php
                $languageChanger = new ComponentLanguageChanger();
                $languageChanger->setOptions(['català', 'español']);
                $languageChanger->echoComponent();
                ?>
            </nav>

            <!-- CONTACT INFO -->
            <div id="topContactInfo">
                <p class="fontColorGold"><?php echo WebConstants::PHONE ?></p>
                <a class="fontColorGold" title="<?php echo WebConstants::MAIL_SUBMIT ?>"
                   href="mailto:<?php echo WebConstants::MAIL_SUBMIT ?>"><?php echo WebConstants::MAIL_SUBMIT ?></a>
                <a id="facebook" href="https://www.facebook.com/profile.php?id=100005576114864&amp;fref=ts"
                   target="_blank"
                   title="<?php echo Managers::literals()->get('MAIN_MENU_FACEBOOK_VISIT', 'Shared') ?>">
                    <i></i>
                    <?php echo Managers::literals()->get('MAIN_MENU_FACEBOOK_VISIT', 'Shared') ?>
                </a>
            </div>
        </div>
    </div>

    <!-- MAIN MENU -->
    <div id="headerBottom" class="row">
        <div class="centered">
            <nav id="topMenu" class="row">
                <?php
                $mainMenu = new ComponentSectionMenu();
                $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_APARADOR', 'Shared'), ['aparador']);
                $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_QUISOM', 'Shared'), ['quisom']);
                $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_PRODUCTES', 'Shared'), ['productes', 'producte']);
                $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_CONTACTE', 'Shared'), ['contacte']);
                $mainMenu->echoComponent();
                ?>
            </nav>
        </div>
    </div>
</section>