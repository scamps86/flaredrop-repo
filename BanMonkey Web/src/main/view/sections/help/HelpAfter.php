<section id="page" class="row">
    <div class="centered">

        <!-- TOP CONTENTS -->
        <div id="topContents" class="row">
            <h1 class="title"><?= Managers::literals()->get('TOP_TITLE', 'Help') ?></h1>

            <h2><?= Managers::literals()->get('TOP_MESSAGE', 'Help') ?></h2>
        </div>

        <!-- SLIDER -->
        <figure class="row">

            <div id="slider" class="owl-carousel">
                <?php
                foreach ($presentations->list as $p) {
                    $pic = UtilsDiskObject::firstFileGet($p['pictures']);

                    if ($pic) {
                        ?>

                        <div class="slide">
                            <img src="<?= UtilsHttp::getPictureUrl($pic->fileId, '992x220') ?>"
                                 title="<?= WebConfigurationBase::$WEBSITE_TITLE ?>"/>
                        </div>

                    <?php
                    }
                }
                ?>
            </div>

        </figure>

        <div class="row">
            <!-- CONTENTS LEFT -->
            <article id="leftContents">
                <h1 class="title1 row"><?= Managers::literals()->get('TITLE1', 'Help') ?></h1>

                <p class="description row"><?= Managers::literals()->get('CONTENTS1', 'Help') ?></p>

                <p class="description row"><?= Managers::literals()->get('CONTENTS2', 'Help') ?></p>

                <p class="description row"><?= Managers::literals()->get('CONTENTS3', 'Help') ?></p>

                <p class="description row"><?= Managers::literals()->get('CONTENTS4', 'Help') ?></p>

                <p class="description row"><?= Managers::literals()->get('CONTENTS5', 'Help') ?></p>

                <p class="textCenter row fontBold"><?= Managers::literals()->get('CONTENTS6', 'Help') ?></p>

                <!-- LOGO -->
                <a class="row" id="banMonkeyLogo" href="<?= UtilsHttp::getSectionUrl('home') ?>"
                   title="<?= WebConfigurationBase::$WEBSITE_TITLE ?>">
                    <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/shared/banmonkey-logo.png') ?>"
                         alt="<?= WebConfigurationBase::$WEBSITE_TITLE ?>"/>
                </a>
            </article>

            <!--CONTENTS RIGHT  -->
            <div id="rightContents">
                <!-- CONTACT FORM -->
                <div id="signInFormContainer">
                    <h2><?= Managers::literals()->get('TITLE_SIGN_IN', 'Help') ?></h2>
                    <?php
                    $form = new ComponentForm(UtilsHttp::getWebServiceUrl('SignInFormSend'), 'signInForm');
                    $form->addInput('text', 'frmName', 'fill', Managers::literals()->get('FRM_ERROR_NAME', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_NAME', 'Shared') . ' *');
                    $form->addInput('text', 'frmNick', 'fill;default', Managers::literals()->get('FRM_ERROR_NICK', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_NICK', 'Shared') . ' *');
                    $form->addInput('text', 'frmEmail', 'fill;email;repeat', Managers::literals()->get('FRM_ERROR_EMAIL', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_EMAIL', 'Shared') . ' *', 'AND', '', '', '', 'e1');
                    $form->addInput('text', '', 'repeat', Managers::literals()->get('FRM_ERROR_EMAIL_REPEAT', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_EMAIL_REPEAT', 'Shared') . ' *', 'AND', '', '', '', 'e1');
                    $form->addInput('password', 'frmPassword', 'fill;password;repeat', Managers::literals()->get('FRM_ERROR_PASSWORD', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PASSWORD', 'Shared') . ' *', 'AND', '', '', '', 'p1');
                    $form->addInput('password', '', 'repeat', Managers::literals()->get('FRM_ERROR_PASSWORD_REPEAT', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PASSWORD_REPEAT', 'Shared') . ' *', 'AND', '', '', '', 'p1');
                    $form->addSwitchComponent('frmConditions', 'numberNatural', Managers::literals()->get('FRM_ERROR_CONDITIONS', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), '<p id="frmShowUserConditions">' . Managers::literals()->get('FRM_CONDITIONS', 'Shared') . '</p>', '', 'frmConditions');
                    $form->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('FRM_SIGN_IN', 'Shared'));
                    $form->echoComponent();
                    ?>
                </div>

                <!-- CONTACT US -->
                <div id="contactUsContainer">
                    <h2><?= Managers::literals()->get('CONTACT_US', 'Help') ?></h2>

                    <ul class="row">
                        <li class="iconPhone row">
                            <p class="highlight"><?= WebConstants::CONTACT_PHONE ?></p>

                            <p><?= Managers::literals()->get('OUR_SCHEDULE', 'Help') ?></p>
                        </li>
                        <li class="iconEmail row">
                            <a class="highlight" href="<?= UtilsHttp::getSectionUrl('contact') ?>"
                               title="<?= Managers::literals()->get('CONTACT_EMAIL', 'Help') ?>">
                                <?= Managers::literals()->get('CONTACT_EMAIL', 'Help') ?>
                            </a>
                        </li>
                        <li class="iconFacebook row">
                            <p class="highlight"><?= Managers::literals()->get('CONTACT_FACEBOOK', 'Help') ?></p>

                            <div class="fb-like" data-href="<?= WebConstants::getDomain() ?>" data-layout="button_count"
                                 data-action="like" data-show-faces="true" data-share="false"></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>