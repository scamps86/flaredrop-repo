<section class="section row">
    <div class="centered">

        <h1><?= Managers::literals()->get('MAIN_TITLE', 'MyAccount') ?></h1>

        <div id="myAccountContainer">
            <!-- USER DATA -->
            <div id="userData">
                <?php

                $form = new ComponentForm(UtilsHttp::getWebServiceUrl('UserModify'), 'userModifyForm');
                // ACCESS DATA
                $form->addContent('<p class="formSection">' . Managers::literals()->get('ACCESS_DATA', 'MyAccount') . '</p>');
                $form->addInput('text', 'frmEmail', 'fill;email;repeat', Managers::literals()->get('FRM_EMAIL_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_EMAIL', 'Shared') . ' *', 'AND', '', $USER->email);
                $form->addInput('password', 'frmPassword', 'fill;password;repeat', Managers::literals()->get('FRM_ERROR_PASSWORD', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PASSWORD', 'Shared') . ' *', 'AND', '', '', '', 'p1');
                $form->addInput('password', '', 'repeat', Managers::literals()->get('FRM_ERROR_PASSWORD_REPEAT', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PASSWORD_REPEAT', 'Shared') . ' *', 'AND', '', '', '', 'p1');

                // PERSONAL DATA
                $form->addContent('<p class="formSection">' . Managers::literals()->get('PERSONAL_DATA', 'MyAccount') . '</p>');
                $form->addInput('text', 'frmFiscalName', 'fill', Managers::literals()->get('FRM_FISCAL_NAME_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_FISCAL_NAME', 'Shared') . ' *', 'AND', '', $USER->data['fiscalName']);
                $form->addInput('text', 'frmShopName', 'fill', Managers::literals()->get('FRM_SHOP_NAME_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_SHOP_NAME', 'Shared') . ' *', 'AND', '', $USER->data['shopName']);
                $form->addInput('text', 'frmNIFCIF', 'fill', Managers::literals()->get('FRM_NIFCIF_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_NIFCIF', 'Shared') . ' *', 'AND', '', $USER->data['NIFCIF']);
                $form->addInput('text', 'frmName', 'fill', Managers::literals()->get('FRM_NAME_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_NAME', 'Shared') . ' *', 'AND', '', $USER->firstName);
                $form->addInput('text', 'frmLocation', 'fill', Managers::literals()->get('FRM_LOCATION_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_LOCATION', 'Shared') . ' *', 'AND', '', $USER->location);
                $form->addInput('text', 'frmCountry', 'fill', Managers::literals()->get('FRM_COUNTRY_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_COUNTRY', 'Shared') . ' *', 'AND', '', $USER->country);
                $form->addInput('text', 'frmRegion', 'fill', Managers::literals()->get('FRM_REGION_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_REGION', 'Shared') . ' *', 'AND', '', $USER->region);
                $form->addInput('text', 'frmCity', 'fill', Managers::literals()->get('FRM_CITY_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_CITY', 'Shared') . ' *', 'AND', '', $USER->city);
                $form->addInput('text', 'frmCp', 'fill', Managers::literals()->get('FRM_PC_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PC', 'Shared') . ' *', 'AND', '', $USER->cp);
                $form->addInput('text', 'frmPhone', 'fill;phone', Managers::literals()->get('FRM_PHONE_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PHONE', 'Shared') . ' *', 'AND', '', $USER->phone1);
                $form->addInput('text', 'frmMobile', 'phone', Managers::literals()->get('FRM_MOBILE_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_MOBILE', 'Shared'), 'AND', '', $USER->data['mobile']);

                $form->addInput('hidden', 'frmRe', '', '', '', '', '', $USER->data['re']);

                // SUBMIT
                $form->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('MODIFY', 'MyAccount'));
                $form->echoComponent();
                ?>
            </div>

            <!-- RIGHT OPTIONS -->
            <div id="rightOptions">
                <!-- UNREGISTER -->
                <div id="userUnregister">
                    <p><?= Managers::literals()->get('USER_UNREGISTER_TEXT', 'MyAccount') ?></p>
                    <button
                        id="userUnregisterBtn"><?= Managers::literals()->get('UNREGISTER_USER', 'MyAccount') ?></button>
                </div>
            </div>
        </div>

    </div>
</section>