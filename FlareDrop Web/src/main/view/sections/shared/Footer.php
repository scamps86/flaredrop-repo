<section id="footer" class="row">
    <div class="centered">

        <!-- BOTTOM MENU -->
        <nav class="row">
            <?php
            $mainMenu->echoComponent();
            ?>
            <a id="footerPrivacy"
               href="<?php echo UtilsHttp::getRelativeUrl('view/resources/pdf/shared/ppcc_' . WebConstants::getLanTag() . '.pdf') ?>"
               target="_blank">
                <?php echo Managers::literals()->get('MAIN_MENU_TERMS_USE', 'Shared') ?>
            </a>
        </nav>

        <!-- SHARED NETWORKS -->
        <nav id="bottomSharedNetworks" class="row">
            <a href="https://www.facebook.com/sharer/sharer.php?u=http://www.<?php echo WebConstants::getDomain() ?>"
               target="_blank" class="fb"
               title="<?php echo Managers::literals()->get('SHARE_TO', 'Shared') . ' Facebook' ?>"></a>
            <a href="https://plus.google.com/share?url=http://www.<?php echo WebConstants::getDomain() ?>"
               target="_blank"
               class="g" title="<?php echo Managers::literals()->get('SHARE_TO', 'Shared') . ' Google+' ?>"></a>
            <a href="https://twitter.com/home?status=http://www.<?php echo WebConstants::getDomain() ?>"
               target="_blank"
               class="tw" title="<?php echo Managers::literals()->get('SHARE_TO', 'Shared') . ' Twitter' ?>"></a>
            <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=http://www.<?php echo WebConstants::getDomain() ?>"
               target="_blank" class="ln"
               title="<?php echo Managers::literals()->get('SHARE_TO', 'Shared') . ' LinkedIn' ?>"></a>
        </nav>

        <!-- ALL RIGHTS RESERVED -->
        <div class="row">
            <p id="footerAllRights">© 2014 FlareDrop. All Rights Reserved</p>
        </div>

    </div>
</section>