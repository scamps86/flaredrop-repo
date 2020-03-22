<div class="ticket-office">
    <?php

    // Check if we are logged and show the login form if not
    if (!USER_LOGGED) {
        ?>
        <div class="to-container">
            <?php
            $loginForm = new ComponentForm(UtilsHttp::getWebServiceUrl('UserLogin'), 'ticketOfficeLoginForm');
            $loginForm->addInput('hidden', 'diskId', '', '', '', '', '', WebConfigurationBase::$DISK_WEB_ID);
            $loginForm->addInput('text', 'xLOG1', 'fill', '', Managers::literals()->get('FRM_TICKET_OFFICE_USER', 'TicketOffice') . ' *');
            $loginForm->addInput('password', 'xLOG2', 'fill;password', '', Managers::literals()->get('FRM_PASSWORD', 'TicketOffice') . ' *');
            $loginForm->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('FRM_LOGIN', 'TicketOffice'));
            $loginForm->echoComponent();
            ?>
        </div>
        <?php
        die();
    } else {
        ?>

        <!-- IF WE ARE LOGGED -->
        <div id="initial-options" class="to-container">
            <h1><?= Managers::literals()->get('CHOOSE_AN_OPTION', 'TicketOffice') ?></h1>
            <button id="generate-tickets-btn"><?= Managers::literals()->get('GENERATE_TICKETS', 'TicketOffice') ?></button>
            <button id="validate-tickets-btn"><?= Managers::literals()->get('VALIDATE_TICKETS', 'TicketOffice') ?></button>
        </div>


        <div id="generate-tickets" class="to-container">
            <h1><?= Managers::literals()->get('GENERATE_TICKETS', 'TicketOffice') ?></h1>
            <?php
            $showsOptions = array_map(function ($show) {
                return [
                    'value' => $show['folderId'],
                    'label' => $show['name']
                ];
            }, $shows);

            if (count($showsOptions) > 0) {
                $form = new ComponentForm(UtilsHttp::getWebServiceUrl('GenerateTicket'), 'generateTicketForm');
                $form->addInput('text', 'frmFullName', 'fill', Managers::literals()->get('FRM_ERROR_FULL_NAME', 'TicketOffice') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_FULL_NAME', 'TicketOffice') . ' *');
                $form->addInput('text', 'frmEmail', 'email', Managers::literals()->get('FRM_ERROR_EMAIL', 'TicketOffice') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_EMAIL', 'TicketOffice') . ' *');
                $form->addInput('text', 'frmDni', 'fill', Managers::literals()->get('FRM_ERROR_DNI', 'TicketOffice') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_DNI', 'TicketOffice') . ' *');
                $form->addSelector('frmShowId', $showsOptions, Managers::literals()->get('FRM_SHOW', 'TicketOffice'));
                $form->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('FRM_GENERATE_TICKET', 'TicketOffice'));
                $form->echoComponent();

                ?>
                <button id="goBack1"
                        class="go-back-btn"><?= Managers::literals()->get('GO_BACK', 'TicketOffice') ?></button>
                <?php
            } else {
                ?>
                <p>No hay conciertos disponibles!</p>
                <?php
            }
            ?>
        </div>


        <div id="validate-tickets" class="to-container">
            <h1><?= Managers::literals()->get('VALIDATE_TICKETS', 'TicketOffice') ?></h1>

            <div id="validate-tickets-form">
                <input id="input-file" type="file" accept="image/*;">
                <button id="scan-ticket-btn"><?= Managers::literals()->get('SCAN_TICKET', 'TicketOffice') ?></button>
            </div>

            <div id="validate-tickets-result">
                hola
            </div>

            <button id="goBack2"
                    class="go-back-btn"><?= Managers::literals()->get('GO_BACK', 'TicketOffice') ?></button>

            <img id="ticket-img">
        </div>

        <?php
    }
    ?>
</div>


<div id="loading-backdrop">

</div>
