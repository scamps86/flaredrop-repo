<?php

// Get parameters
$userData = new VoUser();

$userData->firstName = UtilsHttp::getParameterValue('frmName');
$userData->name = UtilsHttp::getParameterValue('frmNick');
$userData->email = UtilsHttp::getParameterValue('frmEmail');
$userData->password = base64_encode(UtilsHttp::getParameterValue('frmPassword'));
$userData->folderIds = WebConstants::FOLDER_USERS;
$userData->data = WebConstants::getVariable('DEFAULT_ATTEMPTS', 'INTEGER');

$result = SystemUsers::set($userData, true, false);

if (!$result->state) {
    echo 'Error 1: ' . $result->description;
} else {
    // Send a validation email
    $validationKey = SystemUsers::generateValidationKey($result->data->userId, false);

    $subject = Managers::literals()->get('JOIN_VALIDATION_SUBJECT', 'Mailing');
    $message = str_replace('{VERIFICATION_LINK}', UtilsHttp::getSectionUrl('accountValidate', [WebConstants::VALIDATION_KEY_PARAM => $validationKey], '', '', true), Managers::literals()->get('JOIN_VALIDATION_MESSAGE', 'Mailing'));
    $message = str_replace('{USER_NAME}', $userData->firstName . ' (' . $userData->name . ')', $message);

    if (!Managers::mailing()->send(WebConstants::MAIL_NOREPLY, $userData->email, $subject, $message)) {
        echo 'Error 2';
    }
}