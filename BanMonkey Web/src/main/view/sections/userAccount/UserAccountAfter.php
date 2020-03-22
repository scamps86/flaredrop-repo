<section id="page" class="row">

    <?php
    require PATH_VIEW . 'sections/shared/UsersMenu.php';
    ?>

    <div class="centered">

        <!-- UPDATE ACCOUNT FORM -->
        <div id="leftContainer">
            <?php
            $form = new ComponentForm(UtilsHttp::getWebServiceUrl('UserDataFormSend'), 'userDataForm');
            $form->addInput('text', 'frmName', 'fill', Managers::literals()->get('FRM_ERROR_NAME', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_NAME', 'Shared') . ' *', 'AND', '', $loginResult->data->firstName);
            $form->addInput('text', 'frmNick', 'fill;default', Managers::literals()->get('FRM_ERROR_NICK', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_NICK', 'Shared') . ' *', 'AND', '', $loginResult->data->name);
            $form->addInput('text', 'frmLocation', '', '', Managers::literals()->get('FRM_LOCATION', 'Shared'), 'AND', '', $loginResult->data->location);
            $form->addInput('text', 'frmCity', '', '', Managers::literals()->get('FRM_CITY', 'Shared'), 'AND', '', $loginResult->data->city);
            $form->addInput('text', 'frmCp', '', '', Managers::literals()->get('FRM_CP', 'Shared'), 'AND', '', $loginResult->data->cp);
            $form->addInput('text', 'frmCountry', '', '', Managers::literals()->get('FRM_COUNTRY', 'Shared'), 'AND', '', $loginResult->data->country);
            $form->addInput('text', 'frmPhone1', 'empty;phone', Managers::literals()->get('FRM_ERROR_PHONE', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PHONE1', 'Shared'), 'OR', '', $loginResult->data->phone1);
            $form->addInput('text', 'frmPhone2', 'empty;phone', Managers::literals()->get('FRM_ERROR_PHONE', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PHONE2', 'Shared'), 'OR', '', $loginResult->data->phone2);
            $form->addInput('text', 'frmEmail', 'fill;email;repeat', Managers::literals()->get('FRM_ERROR_EMAIL', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_EMAIL', 'Shared') . ' *', 'AND', '', $loginResult->data->email, '', 'e1');
            $form->addInput('text', '', 'repeat', Managers::literals()->get('FRM_ERROR_EMAIL_REPEAT', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_EMAIL_REPEAT', 'Shared') . ' *', 'AND', '', '', '', 'e1');
            $form->addInput('password', 'frmPassword', 'fill;password;repeat', Managers::literals()->get('FRM_ERROR_PASSWORD', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PASSWORD', 'Shared') . ' *', 'AND', '', '', '', 'p1');
            $form->addInput('password', '', 'repeat', Managers::literals()->get('FRM_ERROR_PASSWORD_REPEAT', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PASSWORD_REPEAT', 'Shared') . ' *', 'AND', '', '', '', 'p1');
            $form->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('FRM_UPDATE', 'Shared'));
            $form->echoComponent();
            ?>
        </div>

        <!-- CANCEL ACCOUNT OPTION -->
        <div id="rightContainer">
            <p><?= Managers::literals()->get('CANCEL_ACCOUNT_CONTENT', 'UserAccount') ?></p>
            <button id="cancelAccountBtn"
            "><?= Managers::literals()->get('CANCEL_ACCOUNT', 'UserAccount') ?></button>
        </div>
    </div>
</section>