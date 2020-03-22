<?php
// Get the params
$user = UtilsHttp::getParameterValue('xLOG1');
$psw = base64_encode(UtilsHttp::getParameterValue('xLOG2'));
$diskId = UtilsHttp::getParameterValue('diskId') == '' ? 1 : UtilsHttp::getParameterValue('diskId');

// Do the login
$result = SystemUsers::login($user, $psw, $diskId);

if (!$result->state) {
    $msg = 'Login error: ' . $result->description;
    UtilsHttp::fileGenerateHeaders('text/plain', strlen($msg), 'userLogin', false);
    echo $msg;
} else {
    UtilsHttp::fileGenerateHeaders('text/plain', 0, 'userLogin', false);
}