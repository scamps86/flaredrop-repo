<section id="footer" class="row">
    <div class="centered">

        <!-- BOTTOM MENU -->
        <nav class="row">
            <?php
            $mainMenu->echoComponent();
            ?>
        </nav>

        <!-- CONTACT INFO -->
        <div id="footerContactInfo" class="row">
            <i class="footerIcon" id="footerAr"></i>
            <nav>
                <p id="footerContactInfoTop">
                    <span class="fontColorGold"><?php echo WebConstants::PHONE ?></span>
                    <a class="fontColorGold" href="mailto:<?php echo WebConstants::MAIL_SUBMIT ?>"
                       title="<?php echo WebConstants::MAIL_SUBMIT ?>">
                        <?php echo WebConstants::MAIL_SUBMIT ?>
                    </a>
                </p>

                <p class="fontColorGold">C/ Major, 31 - 33, Castellar del Vallès, Barcelona</p>
                <a id="footerDevelopedBy" class="fontColorGrey" href="http://www.flaredrop.com" target="_blank"
                   title="<?php echo Managers::literals()->get('DEVELOPED_BY', 'Shared') ?>">
                    <?php echo Managers::literals()->get('DEVELOPED_BY', 'Shared') ?>
                </a>
            </nav>
            <i class="footerIcon" id="footerFacebook"></i>
        </div>

    </div>
</section>