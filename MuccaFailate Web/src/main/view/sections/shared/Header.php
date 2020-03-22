<?php
$mainMenu = new ComponentSectionMenu();
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_HOME', 'Shared'), ['home']);
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_THEBAND', 'Shared'), ['theband']);
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_SHOWS', 'Shared'), ['shows']);
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_DISCOGRAPHY', 'Shared'), ['discography']);
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_PICTURES', 'Shared'), ['pictures']);
$mainMenu->addSection(Managers::literals()->get('MAIN_MENU_CONTACT', 'Shared'), ['contact']);
$mainMenu->addLink(Managers::literals()->get('MAIN_MENU_FANSCLUB', 'Shared'), 'https://www.facebook.com/groups/400897690268600');
?>

<section id="header">

    <!-- TOP LOGO -->
    <a id="topLogo" class="row" href="<?= UtilsHttp::getSectionUrl('home') ?>"
       title="<?= WebConfigurationBase::$WEBSITE_TITLE ?>">
        <span class="fontBold">Mucca Failate</span>
        <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/muccafailate.svg') ?>"
             alt="<?= WebConfigurationBase::$WEBSITE_TITLE ?>"/>
    </a>

    <!-- MAIN MENU -->
    <nav class="row">
        <?php
        $mainMenu->echoComponent();
        ?>
    </nav>
</section>

<section id="headerMobile">
    <i class="menuBtn"></i>

    <div id="menuMobile" class="transitionSlow">
        <?php
        $mainMenu->echoComponent();
        ?>
    </div>
</section>