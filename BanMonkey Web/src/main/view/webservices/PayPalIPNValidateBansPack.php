<?php

// Validate the PayPal IPN
if (Managers::payPal()->validateIpn() && Managers::payPal()->validateCustom() && Managers::payPal()->validateBusiness(WebConfigurationBase::$PAYPAL_BUSINESS)) {

    // Get the custom data
    $custom = json_decode(base64_decode($_POST['custom']));
    $user = SystemUsers::get($custom[0]);
    $bansPack = SystemDisk::objectGet($custom[1], 'bansPack');

    // Validate the amount
    if (Managers::payPal()->validateAmount(floatval($bansPack->propertyGet('price')))) {
        // Update the user bans
        $user->data = intval($user->data) + intval($bansPack->propertyGet('bansQuantity'));
        $result = SystemUsers::set($user, false);

        if ($result->state) {
            // Generate subject
            $subject = 'Nuevo pack de bans comprado: ' . $bansPack->localizedPropertyGet('title', WebConstants::getLanTag());

            // Get the PayPal POST data and others as an string
            $message = '';
            $message .= '<p style="font-weight: bold;">DATOS DE USUARIO</p>';
            $message .= '<p><span style="font-weight: bold;">Nombre: </span><span>' . $user->firstName . '</span></p>';
            $message .= '<p><span style="font-weight: bold;">Nick: </span><span>' . $user->name . '</span></p>';
            $message .= '<p><span style="font-weight: bold;">Correo electrónico: </span><span>' . $user->email . '</span></p>';
            $message .= '<p><span style="font-weight: bold;">Teléfono: </span><span>' . $user->phone1 . '</span></p>';
            $message .= '<p><span style="font-weight: bold;">Teléfono alternativo: </span><span>' . $user->phone2 . '</span></p>';
            $message .= '<p><span style="font-weight: bold;">Dirección: </span><span>' . $user->location . '</span></p>';
            $message .= '<p><span style="font-weight: bold;">Ciudad: </span><span>' . $user->city . '</span></p>';
            $message .= '<p><span style="font-weight: bold;">Código postal: </span><span>' . $user->cp . '</span></p>';
            $message .= '<p><span style="font-weight: bold;">País: </span><span>' . $user->country . '</span></p><br>';
            $message .= '<p><span style="font-weight: bold;">HA PAGADO: </span><span>' . UtilsFormatter::currency($_POST['mc_gross']) . '</span></p><br><br>';
            $message .= '<p style="font-weight: bold;">DATOS PAYPAL</p>';

            foreach ($_POST as $k => $v) {
                $message .= '<p><span style="font-weight: bold;">' . $k . ': </span><span>' . $v . '</span></p>';
            }

            Managers::mailing()->send(WebConstants::MAIL_NOREPLY, WebConstants::MAIL_COMMERCIAL, $subject, $message);
        }
    }
}