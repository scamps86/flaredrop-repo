<!-- LOAD THE BACKGROUND VIDEO -->
<?php require_once PATH_VIEW . 'sections/shared/Background.php' ?>

<div id="webapp" class="centered">
    <!-- LOAD THE LEFT HEADER -->
    <?php require_once PATH_VIEW . 'sections/shared/Header.php' ?>

    <!-- SECTION -->
    <section id="page" class="row">

        <!-- LOAD THE LANGUAGE CHANGER-->
        <?php require_once PATH_VIEW . 'sections/shared/LanguageChanger.php' ?>

        <div class="row">
            <!-- CONTACT CONTENTS -->
            <div id="contactContent">
                <ul class="row">
                    <li>
                        <h1 class="row contactTitle fontColorRed fontThin">
                            <?= Managers::literals()->get('BAND_DATA', 'Contact') ?>
                        </h1>
                    <li>
                        <span class="fontBold">
                            <?= Managers::literals()->get('CONTENT_NAME', 'Contact') ?>:
                        </span>
                        <?= Managers::literals()->get('CONTENT_NAME_', 'Contact') ?>
                    </li>
                    <li>
                        <span class="fontBold">
                            <?= Managers::literals()->get('CONTENT_YEAR', 'Contact') ?>:
                        </span>
                        <?= Managers::literals()->get('CONTENT_YEAR_', 'Contact') ?>
                    </li>
                    <li>
                        <span class="fontBold">
                            <?= Managers::literals()->get('CONTENT_LOCATION', 'Contact') ?>:
                        </span>
                        <?= Managers::literals()->get('CONTENT_LOCATION_', 'Contact') ?>
                    </li>
                    <li>
                        <span class="fontBold">
                            <?= Managers::literals()->get('CONTENT_KIND', 'Contact') ?>:
                        </span>
                        <?= Managers::literals()->get('CONTENT_KIND_', 'Contact') ?>
                    </li>
                    <li>
                        <span class="fontBold">
                            <?= Managers::literals()->get('CONTENT_MEMBERS', 'Contact') ?>:
                        </span>
                        <?= Managers::literals()->get('CONTENT_MEMBERS_', 'Contact') ?>
                    </li>
                    <li>
                        <span class="fontBold">
                            <?= Managers::literals()->get('CONTENT_PHONE', 'Contact') ?>:
                        </span>
                        <?= Managers::literals()->get('CONTENT_PHONE_', 'Contact') ?>
                    </li>
                    <li>
                        <span class="fontBold">
                            <?= Managers::literals()->get('CONTENT_EMAIL', 'Contact') ?>:
                        </span>
                        <?= Managers::literals()->get('CONTENT_EMAIL_', 'Contact') ?>
                    </li>
                    <li>
                        <span class="fontBold">
                            <?= Managers::literals()->get('CONTENT_WEB', 'Contact') ?>:
                        </span>
                        <?= Managers::literals()->get('CONTENT_WEB_', 'Contact') ?>
                    </li>

                    <li><br>
                        <h1 class="row contactTitle fontColorRed fontThin">
                            <?= Managers::literals()->get('BAND_TECHNICAL', 'Contact') ?>
                        </h1>
                    <li>
                        <span class="fontBold">
                            <?= Managers::literals()->get('CONTENT_SOUND', 'Contact') ?>:
                        </span>
                        <?= Managers::literals()->get('CONTENT_SOUND_', 'Contact') ?>
                    </li>
                    <li>
                        <span class="fontBold">
                            <?= Managers::literals()->get('CONTENT_PHOTOGRAPHY', 'Contact') ?>:
                        </span>
                        <?= Managers::literals()->get('CONTENT_PHOTOGRAPHY_', 'Contact') ?>
                    </li>
                </ul>

                <div class="row">
                    <!--                    <a class="contactMail fontColorRed fontBold" href="mailto:<? /*= WebConstants::MAIL_CONTACT */ ?>"
                       target="_blank"><? /*= WebConstants::MAIL_CONTACT */ ?></a>-->

                    <p class="contactPhone"><span>Tel.</span> <?= WebConstants::PHONE_CONTACT ?></p>
                    <a class="contactFacebook" href="https://www.facebook.com/muccafailate/?fref=ts"
                       target="_blank">
                        <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/contact/fb.png') ?>"
                             alt="Facebook"/>
                        <span><?= Managers::literals()->get('VISIT_FACEBOOK', 'Contact') ?></span>
                    </a>
                </div>
            </div>

            <!-- CONTACT FORM -->
            <?php
            $form = new ComponentForm(UtilsHttp::getWebServiceUrl('ContactFormSend'), 'contactForm');
            $form->addInput('text', 'frmName', 'fill', Managers::literals()->get('FRM_ERROR_NAME', 'Contact') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_NAME', 'Contact') . ' *');
            $form->addInput('text', 'frmEmail', 'email', Managers::literals()->get('FRM_ERROR_EMAIL', 'Contact') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_EMAIL', 'Contact') . ' *');
            $form->addInput('text', 'frmPhone', 'empty;phone', Managers::literals()->get('FRM_ERROR_PHONE', 'Contact') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PHONE', 'Contact'), 'OR');
            $form->addTextArea('frmMessage', 'fill', Managers::literals()->get('FRM_ERROR_MESSAGE', 'Contact') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_MESSAGE', 'Contact') . ' *');
            $form->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('FRM_SEND', 'Contact'));
            $form->echoComponent();
            ?>
        </div>

    </section>
</div>