<?php

// Get parameters
$userData = new VoUser();

$userData->folderIds = WebConstants::WEB_USER_FOLDER_ID;

$userData->name = UtilsHttp::getParameterValue('frmEmail');
$userData->email = UtilsHttp::getParameterValue('frmEmail');
$userData->password = base64_encode(UtilsHttp::getParameterValue('frmPassword'));
$userData->location = UtilsHttp::getParameterValue('frmLocation');
$userData->country = UtilsHttp::getParameterValue('frmCountry');
$userData->region = UtilsHttp::getParameterValue('frmRegion');
$userData->city = UtilsHttp::getParameterValue('frmCity');
$userData->cp = UtilsHttp::getParameterValue('frmCp');
$userData->firstName = UtilsHttp::getParameterValue('frmName');
$userData->phone1 = UtilsHttp::getParameterValue('frmPhone');

$userData->data = json_encode([
    'fiscalName' => UtilsHttp::getParameterValue('frmFiscalName'),
    'shopName' => UtilsHttp::getParameterValue('frmShopName'),
    'NIFCIF' => UtilsHttp::getParameterValue('frmNIFCIF'),
    'mobile' => UtilsHttp::getParameterValue('frmMobile'),
    're' => UtilsHttp::getParameterValue('frmRe')
]);


$result = SystemUsers::set($userData, true, false);

if (!$result->state) {
    echo 'Error 1 ' . $result->description;
} else {
    // Send a validation email
    $validationKey = SystemUsers::generateValidationKey($result->data->userId, false);

    $subject = Managers::literals()->get('JOIN_SUBJECT', 'Mailing');
    $message = str_replace('{VERIFICATION_LINK}', UtilsHttp::getSectionUrl('home', ['key' => $validationKey], '', '', true), Managers::literals()->get('JOIN_MESSAGE', 'Mailing'));

    if (!Managers::mailing()->send(WebConstants::MAIL_NOREPLY, $userData->email, $subject, $message)) {
        echo 'Error 2';
    }
}