<section id="footer" class="row">
    <div class="centered">

        <nav id="footerList" class="row">
            <a class="transitionFast" href="mailto:<?= WebConstants::SUBMIT_EMAIL ?>">
                <?= WebConstants::SUBMIT_EMAIL ?><br>
                <?= WebConstants::NAME ?><br>
                <!--                <? /*= WebConstants::PHONE1 */ ?> |
                --><? /*= WebConstants::PHONE2 */ ?>
            </a>

            <p class="transitionFast"><?= WebConstants::LOCATION ?></p>

            <a class="transitionFast" href="<?= UtilsHttp::getSectionUrl('home') ?>" title="Intersand">
                <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/logo4.png') ?>" alt="Intersand">
            </a

            <a class="transitionFast" href="<?= UtilsHttp::getSectionUrl('home') ?>" title="Fiory">
                <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/logo3.png') ?>" alt="Fiory">
            </a>
            <a class="transitionFast" href="<?= UtilsHttp::getSectionUrl('home') ?>" title="Pladevall">
                <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/logo2.png') ?>" alt="Pladevall">
            </a>
        </nav>

    </div>
</section>