<?php

include PATH_CONTROLLER . 'libraries/phpqrcode/qrlib.php';


SystemUsers::login('', '', WebConfigurationBase::$DISK_WEB_ID);
$user = SystemUsers::getLogged(WebConfigurationBase::$DISK_WEB_ID);

if ($user == null) {
    echo 'ERROR NO USER SESSION';
    die();
}

// Get form data
$fullName = UtilsHttp::getParameterValue('frmFullName');
$email = UtilsHttp::getParameterValue('frmEmail');
$dni = UtilsHttp::getParameterValue('frmDni');
$showId = UtilsHttp::getParameterValue('frmShowId');

$fullName = UtilsString::cut($fullName, 30);

// Generate ticket
$ticket = new VoObject();
$ticket->propertySet('fullName', $fullName);
$ticket->propertySet('email', $email);
$ticket->propertySet('dni', $dni);
$ticket->propertySet('createdBy', $user->name);
$ticket->propertySet('isValidated', 0);
$ticket->folderIds = $showId;

$result = SystemDisk::objectSet(
    $ticket,
    'ticket',
    true,
    WebConfigurationBase::$DISK_WEB_ID
);


if (!$result->state) {
    echo 'ERROR CREATING THE TICKET';
    die();
}

// Get the ticket with the id and generate the code to be used in the QR
$ticketId = $result->data->objectId;

$code = md5($ticketId . ';' . $showId . ';' . UtilsDate::toTimestamp(UtilsDate::create()));

$ticket->propertySet('code', $code);

$result = SystemDisk::objectSet(
    $ticket,
    'ticket',
    true,
    WebConfigurationBase::$DISK_WEB_ID
);

if (!$result->state) {
    echo 'ERROR SETTING THE CODE TO THE TICKET';
    die();
}

// Get the folder ticket picture
$folder = SystemDisk::folderGet(
    $showId,
    'ticket'
);

if (!$folder) {
    echo 'ERROR SHOW FOLDER NOT FOUND';
    die();
}

// Get the folder image blob
$showFile = UtilsDiskObject::firstFileGet($folder->pictures);

if (!$showFile) {
    echo 'ERROR SHOW FILE NOT FOUND';
    die();
}

$showImg = SystemDisk::filePrint($showFile->fileId, '', '800x400', true);

// Generate the QR (175 x 175)
$qrImg = UtilsQr::generateQr($code);

// Combine both pictures
$dimensions = UtilsPicture::getDimensions($qrImg);
$ticketImg = UtilsPicture::combine($showImg, $qrImg, 785 - $dimensions[0], 15);

// Add the name to the ticket
$ticketImg = UtilsPicture::addRectangle($ticketImg, 0, 340, 800, 400, 'black', 0.7);
$ticketImg = UtilsPicture::addText(
    $ticketImg,
    20,
    378,
    0,
    $fullName,
    20,
    'white',
    'Helvetica-Bold'
);

// Fit in an to A4 PDF
$ticketImg = UtilsPicture::fitInA4Pdf($ticketImg, 120);

// Generate the file headers

// Save the ticket file to the ticket a private
$file = UtilsFile::blobToFile($ticketImg, 'ticket', 'application/pdf', 'pdf');
$result = SystemDisk::filesSet(-1, $ticketId, 'file', [$file], $pictureDimensions = '', $pictureQuality = 0, false);

if (!$result->state) {
    echo 'ERROR SAVING THE FILE';
    die();
}

$fileId = $result->data[0];

// Send email
Managers::mailing()->attachFile('Entrada.pdf', '', $ticketImg);
$subject = '¡Ya tienes disponible tu entrada de Mucca Failate!';
$message = 'Hola ' . $fullName . '!<br><br>';
$message .= 'Muchas gracias por comprar la entrada. Te la adjuntamos en este correo. <br>';
$message .= 'Recuerda que la deberás llevar imprimida o dess del móvil en la taquilla de la sala.<br><br>';
$message .= '¡Nos vemos pronto!';

if (!Managers::mailing()->send(WebConstants::MAIL_NOREPLY, $email, $subject, $message)) {
    echo 'ERROR MAIL COULD NOT BE SENT';
} else {
    echo UtilsHttp::getFileUrl($fileId, '', true);
}