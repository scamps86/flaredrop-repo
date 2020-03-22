<section id="content" class="row">
    <div class="centered">

        <!-- CONTENTS -->
        <div id="contentContainer" class="row">

            <!-- INFO -->
            <h1 class="title fontThin"><?php echo Managers::literals()->get('TITLE', 'Contact') ?></h1>

            <h2><?php echo Managers::literals()->get('DESCRIPTION', 'Contact') ?></h2>
            <a id="commercialEmail"
               href="mailto:<?php echo WebConfigurationBase::$MAIL_COMMERCIAL ?>"
               target="_blank"><?php echo WebConfigurationBase::$MAIL_COMMERCIAL ?></a>

            <!-- FORM -->
            <?php
            $form = new ComponentForm(UtilsHttp::getWebServiceUrl('ContactFormSend'), 'contactForm');
            $form->addInput('text', 'frmName', 'fill', Managers::literals()->get('FRM_ERROR_NAME', 'Contact') . ';' . Managers::literals()->get('ERROR', 'Shared'), Managers::literals()->get('FRM_NAME', 'Contact') . ' *');
            $form->addInput('text', 'frmEmail', 'email', Managers::literals()->get('FRM_ERROR_EMAIL', 'Contact') . ';' . Managers::literals()->get('ERROR', 'Shared'), Managers::literals()->get('FRM_EMAIL', 'Contact') . ' *');
            $form->addTextArea('frmMessage', 'fill', Managers::literals()->get('FRM_ERROR_MESSAGE', 'Contact') . ';' . Managers::literals()->get('ERROR', 'Shared'), Managers::literals()->get('FRM_MESSAGE', 'Contact') . ' *');
            $form->addSwitchComponent('frmConditions', 'numberNatural', Managers::literals()->get('FRM_ERROR_CONDITIONS', 'Contact') . ';' . Managers::literals()->get('ERROR', 'Shared'), '<a href="' . UtilsHttp::getRelativeUrl('view/resources/pdf/shared/ppcc_' . WebConstants::getLanTag() . '.pdf') . '" target="_blank">' . Managers::literals()->get('FRM_CONDITIONS', 'Contact') . '</a>', '', 'frmConditions');
            $form->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('FRM_SEND', 'Contact'));
            $form->echoComponent();
            ?>

            <!-- FACEBOOK -->
            <div id="visitFacebook" class="row">
                <a href="http://www.facebook.com/flaredrop" target="_blank"
                   title="<?= Managers::literals()->get('VISIT_FACEBOOK', 'Contact') ?>">
                    <?= Managers::literals()->get('VISIT_FACEBOOK', 'Contact') ?>
                </a>
            </div>

        </div>
    </div>
</section>