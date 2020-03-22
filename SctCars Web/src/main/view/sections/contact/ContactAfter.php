<section class="content row">
    <div class="centered">

        <div class="row">
            <!-- CONTACT FORM -->
            <?php
            $form = new ComponentForm(UtilsHttp::getWebServiceUrl('ContactFormSend'), 'contactForm');
            $form->addInput('text', 'frmName', 'fill', Managers::literals()->get('FRM_ERROR_NAME', 'Contact') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_NAME', 'Contact') . ' *');
            $form->addInput('text', 'frmEmail', 'email', Managers::literals()->get('FRM_ERROR_EMAIL', 'Contact') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_EMAIL', 'Contact') . ' *');
            $form->addTextArea('frmMessage', 'fill', Managers::literals()->get('FRM_ERROR_MESSAGE', 'Contact') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_MESSAGE', 'Contact') . ' *');
            $form->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('FRM_SEND', 'Contact'));
            $form->echoComponent();
            ?>

            <!-- BANNER -->
            <img id="contactBanner"
                 src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/contact/banner.jpg') ?>"
                 title="SCT Cars"/>
        </div>

    </div>
</section>