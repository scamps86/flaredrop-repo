<section class="content row">
    <div class="centered">

        <div id="contactLeft">

            <!--CONTACT INFO -->
            <div class="row">
                <p class="fontBold"
                   id="contactInfo"><?php echo Managers::literals()->get('CONTACT_INFO', 'Contacte') ?></p>

                <p class="fontColorGrey"><?php echo WebConstants::PHONE ?></p>
                <a class="fontColorGrey"
                   href="mailto:<?php echo WebConstants::MAIL_SUBMIT ?>"><?php echo WebConstants::MAIL_SUBMIT ?></a>
            </div>

            <!-- CONTACT FORM -->
            <div class="row">
                <?php
                $form = new ComponentForm(UtilsHttp::getWebServiceUrl('ContactFormSend'), 'contactForm');
                $form->addInput('text', 'frmName', 'fill', Managers::literals()->get('FRM_ERROR_NAME', 'Contacte') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_NAME', 'Contacte') . ' *');
                $form->addInput('text', 'frmEmail', 'email', Managers::literals()->get('FRM_ERROR_EMAIL', 'Contacte') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_EMAIL', 'Contacte') . ' *');
                $form->addTextArea('frmMessage', 'fill', Managers::literals()->get('FRM_ERROR_MESSAGE', 'Contacte') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_MESSAGE', 'Contacte') . ' *');
                $form->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('FRM_SEND', 'Contacte'));
                $form->echoComponent();
                ?>
            </div>
        </div>

        <!-- GOOGLE MAPS -->
        <div id="gm"></div>
    </div>
</section>