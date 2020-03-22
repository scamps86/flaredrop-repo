<?php

// Generate the downloads filter
$filter = new VoSystemFilter();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setPropertyMatch('visible', '1');

// Get the news list
$downloads = SystemDisk::objectsGet($filter, 'product');

$FILE_URL = '';

if ($downloads->totalItems > 1) {
    if (WebConstants::getLanTag() === 'es_ES') {
        if (count($downloads->list[1]['files']) > 0) {
            $FILE_URL = UtilsHttp::getFileUrl(UtilsDiskObject::firstFileGet($downloads->list[1]['files'])->fileId);
        }
    }
    if (WebConstants::getLanTag() === 'ca_ES') {
        if (count($downloads->list[0]['files']) > 0) {
            $FILE_URL = UtilsHttp::getFileUrl(UtilsDiskObject::firstFileGet($downloads->list[0]['files'])->fileId);
        }
    }
}


// LANGUAGE CHANGER
$languageChanger = new ComponentLanguageChanger();
$languageChanger->setOptions(['CA', 'ES']);
$languageChanger->echoComponent();
?>

<!-- DESKTOP HEADER -->
<section id="header" class="row">

    <!-- TOP BAR -->
    <div id="topHeader" class="row">
        <!-- LOGO -->
        <a href="<?= UtilsHttp::getSectionUrl('home') ?>" alt="Twins Original">
            <img class="logo transitionNormal"
                 src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/twinsco-logo.svg') ?>"
                 alt="Twins Original"/>
        </a>
    </div>

    <!-- BOTTOM BAR-->
    <div id="bottomHeader" class="row">
        <div class="centered">
            <!-- MAIN MENU -->
            <nav class="row">
                <?php
                $mainMenu = new ComponentSectionMenu();
                $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_HOME', 'Shared'), ['home']);
                $mainMenu->addLink(Managers::literals()->get('MAIN_MENU_MENU', 'Shared'), $FILE_URL);
                $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_STAFF', 'Shared'), ['staff']);
                $mainMenu->addSection(Managers::literals()->get('MAIN_MENU_CONTACT', 'Shared'), ['contact']);
                $mainMenu->echoComponent();
                ?>
            </nav>
        </div>
    </div>

</section>

<!-- MOBILE HEADER -->
<section id="mblHeader" class="row">

    <!-- Menu Button -->
    <i class="menuBtn"></i>

    <!-- LOGO -->
    <a href="<?= UtilsHttp::getSectionUrl('home') ?>" alt="Twins Original">
        <img class="logo transitionNormal"
             src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/twinsco-logo.svg') ?>"
             alt="Twins Original"/>
    </a>
</section>

<!-- MBL MAIN MENU -->
<nav id="mblMainMenu" class="row transitionNormal">
    <?php
    $mainMenu->echoComponent();
    ?>
</nav>