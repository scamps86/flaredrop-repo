<?php

$subject = 'Nova consulta de JPLADEVALL.COM';

// Define the mail content
$message = '<b>Nom complet: </b>' . UtilsHttp::getParameterValue('frmName') . '<br>';
$message .= '<b>Correu electrònic: </b>' . UtilsHttp::getParameterValue('frmEmail') . '<br>';
$message .= '<b>Telèfon: </b>' . UtilsHttp::getParameterValue('frmPhone') . '<br><br>';
$message .= '<b>MISSATGE: </b><br>' . UtilsHttp::getParameterValue('frmMessage') . '</p>';

// Send the mail
if (!Managers::mailing()->send(UtilsHttp::getParameterValue('frmEmail'), WebConstants::SUBMIT_EMAIL, $subject, $message)) {
    echo 'The email could not be sent';
}
if (!Managers::mailing()->send(UtilsHttp::getParameterValue('frmEmail'), WebConstants::SUBMIT_EMAIL2, $subject, $message)) {
    echo 'The email could not be sent';
}
