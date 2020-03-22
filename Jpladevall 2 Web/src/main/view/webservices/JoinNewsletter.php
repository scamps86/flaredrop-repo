<?php

$subject = 'Nueva inscripción a la newsletter';
$message = UtilsHttp::getParameterValue('frmEmail');

if (!Managers::mailing()->send(WebConstants::MAIL_NOREPLY, WebConstants::MAIL_ADMIN, $subject, $message)) {
    echo 'Error 2';
}