<section id="header" class="row">
    <div class="centered">

        <!-- LANGUAGE CHANGER -->
        <nav class="row">
            <?php
            $languageChanger = new ComponentLanguageChanger();
            $languageChanger->setOptions(['CA', 'EN']);
            $languageChanger->echoComponent();
            ?>
        </nav>

        <!-- MAIN MENU -->
        <nav class="row">
            <?php
            $mainMenu = new ComponentSectionMenu();
            $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_HOME', 'Shared'), ['home']);
            $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_PICTURES', 'Shared'), ['pictures']);
            $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_NEWS', 'Shared'), ['news']);
            $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_HELP', 'Shared'), ['help']);
            $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_DOWNLOADS', 'Shared'), ['downloads']);
            $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_CONTACT', 'Shared'), ['contact']);
            $mainMenu->echoComponent();
            ?>
        </nav>
    </div>
</section>