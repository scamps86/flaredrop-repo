<?php

// Get the product categories
$categories = SystemDisk::foldersGet(WebConfigurationBase::$ROOT_ID, 'product', WebConfigurationBase::$DISK_WEB_ID, true, WebConstants::getLanTag());

// Create the main menu
$mainMenu = new ComponentSectionMenu();
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_HOME', 'Shared'), ['home']);
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_WE', 'Shared'), ['we']);
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_TESTING', 'Shared'), ['test']);
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_NEWS', 'Shared'), ['news']);
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_PRODUCTS', 'Shared'), ['products']);
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_CONTACT', 'Shared'), ['contact']);

?>


<section id="header" class="row">

    <!-- TOP -->
    <div id="headerTop" class="row">
        <div class="centered">
            <!-- LOGO -->
            <a id="headerTopLogo" href="<?= UtilsHttp::getSectionUrl('home') ?>"
               title="<?= WebConfigurationBase::$WEBSITE_TITLE ?>">
                <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/falugaLogo.png') ?>"
                     alt="<?= WebConfigurationBase::$WEBSITE_TITLE ?>"/>
            </a>

            <div id="headerTopRight">
                <!-- LANGUAGE CHANGER -->
                <nav class="row">
                    <?php
                    $languageChanger = new ComponentLanguageChanger();
                    $languageChanger->setOptions(['ES', 'CA', 'EN']);
                    $languageChanger->echoComponent();
                    ?>
                </nav>

                <!-- CONTACT INFO-->
                <ul id="headerContactInfo" class="row xsHide">
                    <li><p class="fontHighlight"><?= WebConstants::PHONE ?></p></li>
                    <li><a class="fontHighlight" href="mailto:><?= WebConstants::SUBMIT_MAIL ?>"
                           title="><?= WebConstants::SUBMIT_MAIL ?>"><?= WebConstants::SUBMIT_MAIL ?></a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- BOTTOM (DESKTOP) -->
    <div id="headerBottom" class="row smHide">
        <div class="centered">
            <!-- CATALOG CATEGORIES -->
            <div id="headerCatalogBtn" class="mdHide">
                <p><?= Managers::literals()->get('MAIN_CATALOG_BTN', 'Shared') ?></p>
            </div>

            <!-- MAIN MENU -->
            <nav id="headerMainMenu">
                <?php
                $mainMenu->echoComponent();
                ?>
                <a class="shcrtUnits" href="<?= UtilsHttp::getSectionUrl('checkout') ?>"
                   title="<?= Managers::literals()->get('SHOPPING_CART_UNITS', 'Shared') ?>">0</a>
            </nav>
        </div>
    </div>

    <!-- BOTTOM MOBILE -->
    <div id="headerBottomMobileBtn" class="row smShow">
        <a class="shcrtUnits" href="<?= UtilsHttp::getSectionUrl('checkout') ?>"
           title="<?= Managers::literals()->get('SHOPPING_CART_UNITS', 'Shared') ?>">0</a></div>
</section>

<!-- ASIDE MAIN MENU MOBILE CONTAINER -->
<aside id="headerMainMenuMobileContainer" class="row">
    <nav>
        <?php
        $mainMenu->echoComponent();
        ?>
    </nav>
</aside>

<!-- ASIDE CATALOG CONTAINER -->
<aside id="headerCatalogContainer" class="row">
    <div class="centered">
        <div class="row">

            <?php
            foreach ($categories as $c) {
                ?>
                <ul>
                    <h6><a href="<?= UtilsHttp::getSectionUrl('products', ['c' => $c['folderId']]) ?>"
                           title="<?= $c['name'] ?>"><?= $c['name'] ?></a></h6>

                    <?php
                    foreach ($c['child'] as $s) {
                        ?>
                        <li>
                            <a href="<?= UtilsHttp::getSectionUrl('products', ['c' => $c['folderId'], 'sc' => $s['folderId']], $s['name']) ?>"
                               title="<?= $s['name'] ?>"><?= $s['name'] ?></a></li>
                    <?php
                    }
                    ?>
                </ul>
            <?php
            }
            ?>

        </div>
    </div>
</aside>