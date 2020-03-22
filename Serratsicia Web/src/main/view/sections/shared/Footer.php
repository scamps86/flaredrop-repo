<section id="footer">
    <div class="centered">

        <!-- PICTURE -->
        <img id="footerGifts" class="mdHide"
             src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/shared/footer-gifts.png') ?>"
             alt="Serrats i cia">

        <!-- BOTTOM MENU -->
        <div id="footerMenu" class="row">
            <?php
            $mainMenu->echoComponent();
            ?>
        </div>

        <!-- SOCIAL NETWORKS -->
        <div id="footerSn" class="row">
            <a href="https://www.facebook.com/pages/Serrats-i-cia/1513717898880163" target="_blank" class="facebook"
               title="<?php echo Managers::literals()->get('SN_FACEBOOK', 'Shared') ?>"></a>
            <a href="https://www.facebook.com/pages/Serrats-i-cia/1513717898880163" class="twitter" target="_blank"
               title="<?php echo Managers::literals()->get('SN_TWITTER', 'Shared') ?>"></a>
            <a href="https://www.facebook.com/pages/Serrats-i-cia/1513717898880163" class="google" target="_blank"
               title="<?php echo Managers::literals()->get('SN_GOOGLE', 'Shared') ?>"></a>
        </div>

        <!-- DEBELOPED BY -->
        <div id="footerDeveloped" class="row">
            <a href="http://www.flaredrop.com"
               target="_blank"><?php echo Managers::literals()->get('DEVELOPED_BY', 'Shared') ?></a>
        </div>

    </div>
</section>