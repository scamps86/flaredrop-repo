<section id="header" class="row">

    <div class="centered">

        <div id="headerTop">
            <!-- LOGO -->
            <a id="topLogo" href="<?= UtilsHttp::getSectionUrl('home') ?>"
               title="<?= WebConfigurationBase::$WEBSITE_TITLE ?>">
                <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/logo.png') ?>"
                     alt="<?= WebConfigurationBase::$WEBSITE_TITLE ?>">
            </a>

            <?php
            if (USER_LOGGED) {
                ?>

                <!-- USER MENU -->
                <nav id="topUserMenu">
                    <!-- WELCOME MESSAGE -->
                    <span><?= str_replace('{userName}', $USER->firstName, Managers::literals()->get('USER_WELCOME', 'Shared')) ?></span>

                    <?php
                    $userMenu = new ComponentSectionMenu();
                    $userMenu->addSection(Managers::literals()->get('USER_MENU_CATALOG', 'Shared'), ['catalog']);
                    $userMenu->addSection(Managers::literals()->get('USER_MENU_MY_ACCOUNT', 'Shared'), ['myAccount']);
                    $userMenu->addSection(Managers::literals()->get('USER_MENU_MY_CART', 'Shared'), ['myCart']);
                    $userMenu->echoComponent();
                    ?>
                    <!-- USER LOGOUT -->
                    <span id="headerUserLogout"><?= Managers::literals()->get('HEADER_USER_LOGOUT', 'Shared') ?></span>
                </nav>
                <?php
            }
            ?>
            <nav id="headerOptions">
                <?php
                // Language changer
                $languageChanger = new ComponentLanguageChanger();
                $languageChanger->setOptions(['CA', 'ES']);
                $languageChanger->echoComponent();

                if (USER_LOGGED) {
                    ?>
                    <div id="topCart"></div>
                    <?php
                }
                ?>
            </nav>
        </div>

        <div id="headerBottom" class="row">
            <?php
            if (USER_LOGGED) {
                $categoryMenu = new ComponentFolderMenu();
                $categoryMenu->addOption(Managers::literals()->get('CATALOG_PRIVATE_HOME', 'Shared'), 'privateHome');
                $categoryMenu->addFolderTree($FOLDERS, 'catalog');
                $categoryMenu->echoComponent();
            }
            ?>
        </div>
    </div>
</section>

<div id="topCartDrop" class="transitionFast">
    <p><?= Managers::literals()->get('CART_TOP_YOU_HAVE', 'Shared') ?></p>
    <p class="fontBold"><?= Managers::literals()->get('CART_TOP_TOTAL', 'Shared') ?>
        <span class="cartTopTotalPrice"></span>
    </p>
    <a href="<?= UtilsHttp::getSectionUrl('myCart') ?>"><?= Managers::literals()->get('VIEW_CART', 'Shared') ?></a>
</div>