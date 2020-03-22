<section id="header" class="row">
    <div class="centered">
        <!-- TOP LOGO -->
        <a id="topLogo" href="<?= UtilsHttp::getSectionUrl('home') ?>">
            <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/logo.png') ?>">
        </a>

        <!-- MAIN MENU -->
        <nav id="topMenu">
            <?php
            $mainMenu = new ComponentSectionMenu();
            $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_HOME', 'Shared'), ['home']);
            $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_PRODUCTS', 'Shared'), ['home'], '#homeList');
            $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_CONTACT', 'Shared'), ['home'], '#form');
            $mainMenu->echoComponent();
            ?>
        </nav>
    </div>
</section>