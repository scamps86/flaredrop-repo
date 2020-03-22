<div class="centered">
    <!-- IMAGE -->
    <img
        src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/underConstruction/underConstructionLogo.png') ?>"
        alt="">

    <!-- TEXT -->
    <p id="text"><?php echo Managers::literals()->get('TEXT', 'UnderConstruction') ?></p>

    <!-- LANGUAGE CHANGER -->
    <?php
    $languageChanger = new ComponentLanguageChanger();
    $languageChanger->setOptions(['català', 'español']);
    $languageChanger->echoComponent();
    ?>
</div>