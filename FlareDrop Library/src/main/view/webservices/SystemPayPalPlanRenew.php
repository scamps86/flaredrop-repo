<?php

// Validate the PayPal IPN
if (Managers::payPal()->validateIpn() && Managers::payPal()->validateCustom() && Managers::payPal()->validateBusiness(WebConfigurationBase::$PAYPAL_FD_BUSINESS)) {

    // Get the custom data
    $custom = json_decode(base64_decode($_POST['custom']));
    $rootId = intval($custom[0]);
    $plan = $custom[1];

    // Get the configuration data
    $configuration = SystemManager::configurationGet($rootId);

    // Get the PayPal POST data and others as an string
    $messageData = '';
    $messageData .= '<p style="font-weight: bold;">DADES USUARI</p>';
    $messageData .= '<p><span style="font-weight: bold;">Nom complet: </span><span>' . $_POST['first_name'] . ' ' . $_POST['last_name'] . '</span></p>';
    $messageData .= '<p><span style="font-weight: bold;">Correu electrònic: </span><span>' . $_POST['payer_email'] . '</span></p>';
    $messageData .= '<p><span style="font-weight: bold;">Nom web: </span><span>' . WebConfigurationBase::$WEBSITE_TITLE . '</span></p><br>';
    $messageData .= '<p style="font-weight: bold;">DADES PAYPAL</p>';

    foreach ($_POST as $k => $v) {
        $messageData .= '<p><span style="font-weight: bold;">' . $k . ': </span><span>' . $v . '</span></p>';
    }

    // Validate if the paypal plan is the same of the root
    if ($configuration['global']['planType'] != $plan) {
        Managers::mailing()->send(WebConfigurationBase::$MAIL_NOREPLY, WebConfigurationBase::$MAIL_COMMERCIAL, 'Intent de renovació fallit', $messageData);
        die();
    }

    // Validate the amount according to the plan
    if (Managers::payPal()->validateAmount($configuration['global']['planPrice'])) {
        // Renew the selected plan
        $result = SystemManager::planRenew($rootId);

        if (!$result->state) {
            Managers::mailing()->send(WebConfigurationBase::$MAIL_NOREPLY, WebConfigurationBase::$MAIL_COMMERCIAL, 'Intent de renovació fallit per error del sistema', $messageData);
            die();
        }

        // Generate the notification email message
        $message = '<p style="font-size: 20px; font-weight: bold;">FlareDrop Plan ' . $plan . ' (' . $configuration['global']['planPrice'] . '€)</p><br>';
        $message .= '<p>Un usuari ha realitzat un pagament de <b>' . $_POST['mc_gross'] . '€</b> per realitzar una renovació.</p><br>';
        $message .= $messageData;

        // Send a notification email to the commercial
        Managers::mailing()->send(WebConfigurationBase::$MAIL_NOREPLY, WebConfigurationBase::$MAIL_COMMERCIAL, 'Nova renovació pagada correctament', $message);
    }
}