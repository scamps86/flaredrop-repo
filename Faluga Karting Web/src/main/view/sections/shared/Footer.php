<section id="footer" class="row">
    <div class="centered">

        <!-- BOTTOM MENU -->
        <nav class="row">
            <?php
            $mainMenu->echoComponent();
            ?>
        </nav>

        <!-- LOGO & CONTACT -->
        <div id="footerLogoContactContainer">
            <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/falugaLogoWhite.png') ?>"
                 alt="<?= WebConfigurationBase::$WEBSITE_TITLE ?>"/>

            <div>
                <a href="mailto:<?= WebConstants::SUBMIT_MAIL ?>"
                   title="<?= WebConstants::SUBMIT_MAIL ?>"><?= WebConstants::SUBMIT_MAIL ?></a>

                <p><?= WebConstants::PHONE ?></p>
                <a id="userConditions" href="<?= UtilsHttp::getRelativeUrl('view/resources/pdf/condiciones_uso.pdf') ?>"
                   target="_blank"><?= Managers::literals()->get('USER_CONDITIONS', 'Shared') ?></a>
            </div>
        </div>

        <!-- DEVELOPED BY -->
        <div class="row">
            <a id="developedBy" href="http://www.flaredrop.com"
               target="_blank"><?= Managers::literals()->get('DEVELOPED_BY', 'Shared') ?></a>
        </div>
    </div>
</section>