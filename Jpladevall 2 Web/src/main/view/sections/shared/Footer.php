<footer id="footer" class="row">
    <div class="centered">

        <div class="row footerContainer">

            <div id="footerResponsiveTest" class="footerBox">
                <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/responsiveIcon.png') ?>"
                     alt="<?= Managers::literals()->get('FOOTER_C9', 'Shared') ?>"/>
                <h3><?= Managers::literals()->get('FOOTER_C9', 'Shared') ?></h3>
                <p><?= Managers::literals()->get('FOOTER_C9_00', 'Shared') ?></p>
            </div>

            <div id="footerSubscribe" class="footerBox">
                <h3><?= Managers::literals()->get('FOOTER_C5', 'Shared') ?></h3>

                <nav id="footerSocial">
                    <a href="http://google.com" title="Facebook">
                        <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/face.png') ?>">
                    </a>
                    <a href="http://google.com" title="Twitter">
                        <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/twitter.png') ?>">
                    </a>
                    <a href="http://google.com" title="Google +">
                        <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/google.png') ?>">
                    </a>
                    <a href="http://google.com" title="Pinterest">
                        <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/p.png') ?>">
                    </a>
                    <a href="http://google.com" title="Two point">
                        <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/two_point.png') ?>">
                    </a>
                </nav>

                <h3><?= Managers::literals()->get('FOOTER_C6', 'Shared') ?></h3>
                <input type="text">
                <button id="joinNewsletterBtn"><?= Managers::literals()->get('FOOTER_C6_00', 'Shared') ?></button>
            </div>

            <div class="footerBox">
                <h3><?= Managers::literals()->get('FOOTER_C7', 'Shared') ?></h3>
                <p><?= Managers::literals()->get('FOOTER_C7_00', 'Shared') ?></p>
                <p>
                    <span class="footerIcon footerIconAddress"><?= WebConstants::ADDRESS_CONTACT ?></span>
                    <span class="footerIcon footerIconPhone"><?= WebConstants::PHONE_CONTACT ?></span>
                    <span class="footerIcon footerIconMail"><?= WebConstants::MAIL_CONTACT ?></span>
                </p>
            </div>

            <div class="footerBox" style="display: flex; flex-flow: column nowrap;">
                <h3><?= Managers::literals()->get('FOOTER_C8', 'Shared') ?></h3>
                <div id="footerMap"></div>
            </div>

        </div>
        sha
        <div class="row footerContainer">

            <div class="footerBox">
                <h3><?= Managers::literals()->get('FOOTER_C1', 'Shared') ?></h3>
                <?php
                $userMenu = new ComponentSectionMenu();
                $userMenu->addSection(Managers::literals()->get('FOOTER_C1_00', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C1_01', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C1_02', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C1_03', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C1_04', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C1_05', 'Shared'), ['catalog']);
                $userMenu->echoComponent();
                ?>
            </div>

            <div class="footerBox">
                <h3><?= Managers::literals()->get('FOOTER_C2', 'Shared') ?></h3>
                <?php
                $userMenu = new ComponentSectionMenu();
                $userMenu->addSection(Managers::literals()->get('FOOTER_C2_00', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C2_01', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C2_02', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C2_03', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C2_04', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C2_05', 'Shared'), ['catalog']);
                $userMenu->echoComponent();
                ?>
            </div>

            <div class="footerBox">
                <h3><?= Managers::literals()->get('FOOTER_C3', 'Shared') ?></h3>
                <?php
                $userMenu = new ComponentSectionMenu();
                $userMenu->addSection(Managers::literals()->get('FOOTER_C3_00', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C3_01', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C3_02', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C3_03', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C3_04', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C3_05', 'Shared'), ['catalog']);
                $userMenu->echoComponent();
                ?>
            </div>

            <div class="footerBox">
                <h3><?= Managers::literals()->get('FOOTER_C4', 'Shared') ?></h3>
                <?php
                $userMenu = new ComponentSectionMenu();
                $userMenu->addSection(Managers::literals()->get('FOOTER_C4_00', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C4_01', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C4_02', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C4_03', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C4_04', 'Shared'), ['catalog']);
                $userMenu->addSection(Managers::literals()->get('FOOTER_C4_05', 'Shared'), ['catalog']);
                $userMenu->echoComponent();
                ?>
            </div>

        </div>
    </div>

    <div id="footerBottom">
        <div class="centered">
            <p><?= Managers::literals()->get('FOOTER_BOTTOM', 'Shared') ?></p>
            <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/paypal.png') ?>" alt="PayPal">
            <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/visa.png') ?>" alt="Visa">
            <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/master_card.png') ?>"
                 alt="Master Card">
            <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/discover.png') ?>" alt="Discover">
        </div>
    </div>
</footer>