<section class="row content">
    <div class="centered">

        <!-- CONTACT DATA -->
        <div class="row">
            <h1><?php echo Managers::literals()->get('TITLE', 'Contact') ?></h1>

            <h2><?php echo Managers::literals()->get('SUBTITLE', 'Contact') ?></h2>
        </div>

        <!-- LEFT CONTENTS -->
        <div id="contactLeft" class="row">
            <!-- CONTACT DATA -->
            <p>
                <span class="fontBold"><?php echo Managers::literals()->get('PHONE', 'Contact') ?>:</span>
                <span><?php echo WebConstants::PHONE1 . ', ' . WebConstants::PHONE2 ?></span>
            </p>
            <a href="mailto:<?php echo WebConstants::SUBMIT_MAIL ?>">
                <span class="fontBold"><?php echo Managers::literals()->get('EMAIL', 'Contact') ?>:</span>
                <span><?php echo WebConstants::SUBMIT_MAIL ?></span>
            </a>

            <!-- SOCIAL NETWORKS -->
            <div id="contactSn" class="row">
                <p class="fontBold"><?php echo Managers::literals()->get('THROUGH_SN', 'Contact') ?></p>
                <a href="https://www.facebook.com/pages/Serrats-i-cia/1513717898880163" target="_blank" class="facebook"
                   title="<?php echo Managers::literals()->get('SN_FACEBOOK', 'Shared') ?>"></a>
                <a href="https://www.facebook.com/pages/Serrats-i-cia/1513717898880163" class="twitter" target="_blank"
                   title="<?php echo Managers::literals()->get('SN_TWITTER', 'Shared') ?>"></a>
                <a href="https://www.facebook.com/pages/Serrats-i-cia/1513717898880163" class="google" target="_blank"
                   title="<?php echo Managers::literals()->get('SN_GOOGLE', 'Shared') ?>"></a>
            </div>
        </div>

        <!-- RIGHT CONTENTS -->
        <div id="contactRight" class="row">
            <!-- CONTACT FORM -->
            <div class="row">
                <?php
                $form = new ComponentForm(UtilsHttp::getWebServiceUrl('ContactFormSend'), 'contactForm');
                $form->addInput('text', 'frmName', 'fill', Managers::literals()->get('FRM_ERROR_NAME', 'Contact') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_NAME', 'Contact') . ' *');
                $form->addInput('text', 'frmEmail', 'email', Managers::literals()->get('FRM_ERROR_EMAIL', 'Contact') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_EMAIL', 'Contact') . ' *');
                $form->addTextArea('frmMessage', 'fill', Managers::literals()->get('FRM_ERROR_MESSAGE', 'Contact') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_MESSAGE', 'Contact') . ' *');
                $form->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('FRM_SEND', 'Contact'));
                $form->echoComponent();
                ?>
            </div>
        </div>

    </div>
</section>