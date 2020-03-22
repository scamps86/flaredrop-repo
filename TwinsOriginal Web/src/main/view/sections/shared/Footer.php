<section id="footer" class="row">
    <div class="centered">

        <!-- BOTTOM CONTACT -->
        <nav class="row" id="contactLinks">
            <a class="mail" href="mailto:<?= WebConstants::MAIL_CONTACT ?>"><?= WebConstants::MAIL_CONTACT ?></a>
            <span class="phone"><?= WebConstants::PHONE_CONTACT ?></span>
            <span class="sn">
            <a class="facebook" target="_blank" href="https://www.facebook.com/twins.original/?fref=ts">
                <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/facebook.png') ?>"
                     alt="Facebook"/>
            </a>
            <a class="instagram" target="_blank" href="https://www.instagram.com/twins.original/">
                <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/instagram.png') ?>"
                     alt="Instagram"/>
            </a>
                </span>
        </nav>

        <div id="footerDirection" class="row">
            <a href="https://www.google.es/maps/place/Twins%26Co/@41.578409,2.0104883,17z/data=!3m1!4b1!4m5!3m4!1s0x12a492c954cd0a61:0xc2cb2467f767c9bb!8m2!3d41.578405!4d2.012677?hl=ca"
               target="_blank">
                <?= Managers::literals()->get('FOOTER_DIRECTION', 'Shared') ?>
            </a>
        </div>

        <a id="webMaster" href="http://www.flaredrop.com" target="_blank">
            Website developed by FlareDrop Development ©‎ 2017
        </a>
    </div>
</section>