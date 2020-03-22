<section id="content" class="row">
    <div class="centered">

        <!-- CONTENTS -->
        <div id="contentContainer" class="row">

            <h1 class="title fontThin"><?php echo Managers::literals()->get('TITLE', 'Request') ?></h1>

            <!-- LEFT TEXT -->
            <div id="contentLeft">
                <h2><?php echo Managers::literals()->get('DESCRIPTION', 'Request') ?></h2>
            </div>

            <!-- FORM -->
            <div id="contentRight">
                <?php
                // Define web type options
                $webTypes = [];
                array_push($webTypes, ['value' => 'web-simple', 'label' => Managers::literals()->get('WEB_SIMPLE', 'Request')]);
                array_push($webTypes, ['value' => 'web-advanced', 'label' => Managers::literals()->get('WEB_ADVANCED', 'Request')]);
                array_push($webTypes, ['value' => 'web-shop', 'label' => Managers::literals()->get('WEB_SHOP', 'Request')]);
                array_push($webTypes, ['value' => 'domain-hosting', 'label' => Managers::literals()->get('DOMAIN-HOSTING', 'Request')]);

                // Plan type
                $plans = [];
                array_push($plans, ['value' => '2M', 'label' => Managers::literals()->get('PLAN_2M', 'Request')]);
                array_push($plans, ['value' => '5M', 'label' => Managers::literals()->get('PLAN_5M', 'Request')]);
                array_push($plans, ['value' => '1G', 'label' => Managers::literals()->get('PLAN_1G', 'Request')]);
                array_push($plans, ['value' => '2G', 'label' => Managers::literals()->get('PLAN_2G', 'Request')]);
                array_push($plans, ['value' => '5G', 'label' => Managers::literals()->get('PLAN_5G', 'Request')]);

                // Get the selected option from the url encoded parameter
                $selectedTypeIndex = 0;

                switch (UtilsHttp::getEncodedParam('product')) {
                    case 'web-simple':
                        $selectedTypeIndex = 0;
                        break;
                    case 'web-advanced':
                        $selectedTypeIndex = 1;
                        break;
                    case 'web-shop':
                        $selectedTypeIndex = 2;
                        break;
                    case 'domain-hosting':
                        $selectedTypeIndex = 3;
                        break;
                }

                $form = new ComponentForm(UtilsHttp::getWebServiceUrl('RequestFormSend'), 'requestForm');
                $form->addInput('text', 'frmName', 'fill', Managers::literals()->get('FRM_ERROR_NAME', 'Request') . ';' . Managers::literals()->get('ERROR', 'Shared'), '<span style="margin-top: 0">' . Managers::literals()->get('FRM_PERSONAL_DATA', 'Request') . '</span><br>' . Managers::literals()->get('FRM_NAME', 'Request') . ' (*)');
                $form->addInput('text', 'frmEmail', 'email', Managers::literals()->get('FRM_ERROR_EMAIL', 'Request') . ';' . Managers::literals()->get('ERROR', 'Shared'), Managers::literals()->get('FRM_EMAIL', 'Request') . ' (*)');
                $form->addOptionBarComponent('frmWebType', $webTypes, '<span>' . Managers::literals()->get('FRM_GENERIC_DATA', 'Request') . '</span><br>' . Managers::literals()->get('FRM_WEB_TYPE', 'Request') . ' <a class="moreInfo" target="_blank" href="' . UtilsHttp::getSectionUrl('products') . '"><i>' . Managers::literals()->get('MORE_INFO', 'Request') . '</i></a>', $selectedTypeIndex, 'frmWebType');

                $form->addSwitchComponent('frmWebDesign', '', '', Managers::literals()->get('FRM_WEB_DESIGN', 'Request'), '', 'frmWebDesign');
                $form->addTextArea('frmWebMaterial', 'fill', Managers::literals()->get('FRM_ERROR_WEB_MATERIAL', 'Request') . ';' . Managers::literals()->get('ERROR', 'Shared'), Managers::literals()->get('FRM_WEB_MATERIAL', 'Request') . ' (*)', '', 'frmWebMaterial');
                $form->addInput('text', 'frmWebLanguages', 'fill', Managers::literals()->get('FRM_ERROR_WEB_LANGUAGES', 'Request') . ';' . Managers::literals()->get('ERROR', 'Shared'), Managers::literals()->get('FRM_WEB_LANGUAGES', 'Request') . ' (*)', '', 'frmWebLanguages');
                $form->addTextArea('frmWebSections', 'fill', Managers::literals()->get('FRM_ERROR_WEB_SECTIONS', 'Request') . ';' . Managers::literals()->get('ERROR', 'Shared'), Managers::literals()->get('FRM_WEB_SECTIONS', 'Request') . ' (*)', '', 'frmWebSections');
                $form->addTextArea('frmWebSectionsDynamic', 'fill', Managers::literals()->get('FRM_ERROR_WEB_SECTIONS_DYNAMIC', 'Request') . ';' . Managers::literals()->get('ERROR', 'Shared'), Managers::literals()->get('FRM_WEB_SECTIONS_DYNAMIC', 'Request') . ' (*)', '', 'frmWebSectionsDynamic');
                $form->addTextArea('frmWebOthers', '', '', Managers::literals()->get('FRM_WEB_OTHERS', 'Request'), '', 'frmWebOthers');

                $form->addOptionBarComponent('frmPlan', $plans, '<span>' . Managers::literals()->get('FRM_DH_DATA', 'Request') . '</span><br>' . Managers::literals()->get('FRM_PLAN', 'Request') . ' <a class="moreInfo" target="_blank" href="' . UtilsHttp::getSectionUrl('products') . '#pack-domain-hosting"><i>' . Managers::literals()->get('MORE_INFO', 'Request') . '</i></a>');
                $form->addInput('text', 'frmDomain', 'fill', Managers::literals()->get('FRM_ERROR_DOMAIN', 'Request') . ';' . Managers::literals()->get('ERROR', 'Shared'), Managers::literals()->get('FRM_DOMAIN', 'Request') . ' (*)');

                $form->addTextArea('frmOthers', '', '', Managers::literals()->get('FRM_OTHERS', 'Request'), '', 'frmOthers');
                $form->addSwitchComponent('frmConditions', 'numberNatural', Managers::literals()->get('FRM_ERROR_CONDITIONS', 'Request') . ';' . Managers::literals()->get('ERROR', 'Shared'), '<a href="' . UtilsHttp::getRelativeUrl('view/resources/pdf/shared/ppcc_' . WebConstants::getLanTag() . '.pdf') . '" target="_blank">' . Managers::literals()->get('FRM_CONDITIONS', 'Request') . '</a>', '', 'frmConditions');
                $form->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('FRM_SEND', 'Request'));
                $form->echoComponent();
                ?>
            </div>

        </div>
    </div>
</section>