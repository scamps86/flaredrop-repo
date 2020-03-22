<?php

// Get parameters
$userData = new VoUser();

$userData->name = UtilsHttp::getParameterValue('frmNick');
$userData->firstName = UtilsHttp::getParameterValue('frmName');
$userData->email = UtilsHttp::getParameterValue('frmEmail');
$userData->password = base64_encode(UtilsHttp::getParameterValue('frmPassword'));
$userData->folderIds = WebConstants::USER_FOLDER_ID;
$userData->data = WebConstants::USER_DEFAULT_BANS;

$result = SystemUsers::set($userData, false, false);

if (!$result->state) {
    echo 'Error 1 ' . $result->description;
} else {
    // Send a validation email
    //$validationKey = SystemUsers::generateValidationKey($result->data->userId, false);

    //$subject = Managers::literals()->get('SIGN_IN_SUBJECT', 'Mailing');
    //$message = str_replace('{VERIFICATION_LINK}', UtilsHttp::getSectionUrl('home', ['key' => $validationKey], '', '', true), Managers::literals()->get('SIGN_IN_MESSAGE', 'Mailing'));

    //if (!Managers::mailing()->send(WebConstants::MAIL_NOREPLY, $userData->email, $subject, $message)) {
    //echo 'Error 2';
    //}
}