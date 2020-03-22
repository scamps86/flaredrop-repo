<div class="centered">

    <!-- CONTENTS -->
    <div id="background" class="row">
        <!-- TEXT -->
        <h1 id="title"><?php echo Managers::literals()->get('TITLE', 'UnderConstruction') ?></h1>

        <p id="text"><?php echo Managers::literals()->get('TEXT', 'UnderConstruction') ?></p>
    </div>

    <!-- FACEBOOK & LANGUAGE CHANGER -->
    <div id="dateChanger" class="row">
        <a href="https://www.facebook.com/pages/Serrats-i-cia/1513717898880163" target="_blank">
            <span class="sn"></span><br>
            <span class="snt"><?php echo Managers::literals()->get('FACEBOOK', 'UnderConstruction') ?></span>
        </a>
        <?php
        $languageChanger = new ComponentLanguageChanger();
        $languageChanger->setOptions(['català', 'español']);
        $languageChanger->echoComponent();
        ?>
    </div>

</div>