<?php

// Get the params
$name = UtilsHttp::getParameterValue('name');
$userEmail = UtilsHttp::getParameterValue('userEmail');
$senderEmail = UtilsHttp::getParameterValue('senderEmail');
$emailContentsBundle = UtilsHttp::getParameterValue('emailContentsBundle');
$emailSubjectKey = UtilsHttp::getParameterValue('emailSubjectKey');
$emailMessageKey = UtilsHttp::getParameterValue('emailMessageKey');

$result = '';

if ($emailContentsBundle != '' && $emailSubjectKey != '' && $emailMessageKey != '') {
    $emailSubject = Managers::literals()->get($emailSubjectKey, $emailContentsBundle);
    $emailMessage = Managers::literals()->get($emailMessageKey, $emailContentsBundle);

    if (!SystemUsers::passwordReset($name, $userEmail, $senderEmail, $emailSubject, $emailMessage)) {
        $result = 'User password reset error 2';
    }
} else {
    $result = 'User password reset error 1';
}

// Print the result
UtilsHttp::fileGenerateHeaders('text/plain', strlen($result), 'userPasswordReset', false);
echo $result;