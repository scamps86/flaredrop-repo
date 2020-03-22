<section id="header" class="row">
    <div class="centered">
        <!-- TOP LOGO -->
        <a href="<?php echo UtilsHttp::getSectionUrl('home') ?>" id="topLogo"
           title="<?php echo WebConfigurationBase::$WEBSITE_TITLE ?>">
            <img src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/shared/serratsicia-logo.png') ?>"
                 alt="<?php echo WebConfigurationBase::$WEBSITE_TITLE ?>">
        </a>

        <!-- LANGUAGE CHANGER -->
        <?php
        $languageChanger = new ComponentLanguageChanger();
        $languageChanger->setOptions(['català', 'español']);
        $languageChanger->echoComponent();
        ?>

        <!-- MAIN MENU -->
        <?php
        $mainMenu = new ComponentSectionMenu();
        $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_HOME', 'Shared'), ['home']);
        $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_PRODUCTS', 'Shared'), ['catalog', 'product']);
        $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_WE', 'Shared'), ['we']);
        $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_CONTACT', 'Shared'), ['contact']);
        $mainMenu->echoComponent();
        ?>
    </div>
</section>