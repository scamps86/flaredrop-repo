<?php

// Validate the PayPal IPN
if (Managers::payPal()->validateIpn() && Managers::payPal()->validateCustom() && Managers::payPal()->validateBusiness(WebConfigurationBase::$PAYPAL_FD_BUSINESS)) {

    // Get the custom data
    $custom = json_decode(base64_decode($_POST['custom']));

    // Validate if custom data is correct
    if (is_array($custom) && count($custom) == 2) {
        $userId = $custom[0];
        $price = intval($custom[1]);

        // Validate if the price is correct
        if (Managers::payPal()->validateAmount($price) && $price >= 1) {

            // Validate if the user exists
            $userData = SystemUsers::get($userId, '', false);

            if ($userData != null) {

                // Increase user tickets
                $userData->data += $price;
                $result = SystemUsers::set($userData, false, false);

                if ($result->state) {

                    // Send a notification email to the user
                    $subject = str_replace('{TICKETS}', $price, Managers::literals()->get('BUY_TICKETS_CONFIRMATION_SUBJECT', 'Mailing'));
                    $message = str_replace('{TICKETS}', $price, Managers::literals()->get('BUY_TICKETS_CONFIRMATION_MESSAGE', 'Mailing'));
                    $message = str_replace('{USER_NAME}', $userData->firstName . ' (' . $userData->name . ')', $message);

                    Managers::mailing()->send(WebConstants::MAIL_NOREPLY, $userData->email, $subject, $message);

                    // Send a notification email to the admin
                    $subject = 'Nova compra de tickets de: ' . $userData->firstName . ' (' . $userData->name . ') (' . $userData->email . ')';
                    $message = '<p style="font-weight: bold;">DADES PAYPAL</p>';

                    foreach ($_POST as $k => $v) {
                        $message .= '<p><span style="font-weight: bold;">' . $k . ': </span><span>' . $v . '</span></p>';
                    }

                    Managers::mailing()->send(WebConstants::MAIL_NOREPLY, WebConstants::MAIL_COMMERCIAL, $subject, $message);
                }
            }
        }
    }
}