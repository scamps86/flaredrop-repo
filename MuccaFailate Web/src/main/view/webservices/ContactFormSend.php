<?php

$subject = 'Nova consulta de MUCCA FAILATE.COM';

// Define the mail content
$message = '<b>Nom complet: </b>' . UtilsHttp::getParameterValue('frmName') . '<br>';
$message .= '<b>Correu electrònic: </b>' . UtilsHttp::getParameterValue('frmEmail') . '<br><br>';
$message .= '<b>Telèfon: </b>' . UtilsHttp::getParameterValue('frmPhone') . '<br><br>';
$message .= '<b>MISSATGE: </b><br>' . UtilsHttp::getParameterValue('frmMessage') . '</p>';

// Send the mail
if (!Managers::mailing()->send(UtilsHttp::getParameterValue('frmEmail'), WebConstants::MAIL_CONTACT, $subject, $message)) {
    echo 'Error 1';
}
