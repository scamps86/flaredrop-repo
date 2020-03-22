<section id="page" class="row">
    <div class="centered">

        <div id="left">
            <!-- CONTACT INFO -->
            <div class="row">
                <h1 class="title"><?= Managers::literals()->get('TITLE_01', 'Contact') ?></h1>

                <p class="text"><?= Managers::literals()->get('TEXT_01', 'Contact') ?></p>

                <h2 class="postal fontBold"><?= Managers::literals()->get('POSTAL', 'Contact') ?></h2>

                <h3 class="phone"><?= WebConstants::PHONE ?></h3>
                <a class="mail" href="mailto:<?= WebConstants::SUBMIT_MAIL ?>"><?= WebConstants::SUBMIT_MAIL ?></a>
            </div>

            <!-- CONTACT FORM -->
            <div class="row">
                <?php
                $form = new ComponentForm(UtilsHttp::getWebServiceUrl('ContactFormSend'), 'contactForm');
                $form->addInput('text', 'frmName', 'fill', Managers::literals()->get('FRM_ERROR_NAME', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_NAME', 'Shared') . ' *');
                $form->addInput('text', 'frmEmail', 'email', Managers::literals()->get('FRM_ERROR_EMAIL', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_EMAIL', 'Shared') . ' *');
                $form->addTextArea('frmMessage', 'fill', Managers::literals()->get('FRM_ERROR_MESSAGE', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_MESSAGE', 'Shared') . ' *');
                $form->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('FRM_SEND', 'Shared'));
                $form->echoComponent();
                ?>
            </div>
        </div>

        <!-- GOOGLE MAPS -->
        <div id="gm"></div>
    </div>
</section>