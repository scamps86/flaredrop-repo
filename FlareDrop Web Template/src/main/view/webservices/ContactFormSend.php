<?php

$subject = 'Nova consulta de FLAREDROP.COM';

// Define the mail content
$message = '<b>Nom complet: </b>' . UtilsHttp::getParameterValue('frmName') . '<br>';
$message .= '<b>Correu electrònic: </b>' . UtilsHttp::getParameterValue('frmEmail') . '<br><br>';
$message .= '<b>MISSATGE: </b><br>' . UtilsHttp::getParameterValue('frmMessage') . '</p>';

// Send the mail
if (!Managers::mailing()->send(UtilsHttp::getParameterValue('frmEmail'), WebConfigurationBase::$MAIL_COMMERCIAL, $subject, $message)) {
    echo 'The email could not be sent';
}
