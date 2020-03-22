<?php

// Load the library
include_once '../system/SystemWebLoader.php';

// Get all customers
$filter = new VoSystemFilter();
$filter->setDiskId(WebConfigurationBase::$DISK_MANAGER_ID);
$filter->setAND();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setSortFields('expirationDate', 'ASC');

$customers = SystemDisk::objectsGet($filter, 'customer');


// Get the current date
$date = UtilsDate::create();

// Define the customers information summary
$summaryMessage = "<p><b>LLISTAT DE CLIENTS</b></p>";

// Define the mail subject
$summarySubject = 'RESUM dels serveis contractats pels clients';

// Scan each customer
foreach ($customers->list as $c) {

    // Validate if the customer expiration date expires in the next month
    $color = '#339900';

    // Reformat the expiration date
    $expirationDate = UtilsDate::toDDMMYYYY($c['expirationDate'], '/');

    if (UtilsDate::operate('MONTH', $c['expirationDate'], 1, false) < $date) {
        $color = '#ff0000';

        // Send notification email to the customer only if enabled
        if ($c['enabled']) {
            // Define the notification subject
            $notificationSubject = Managers::literals()->get('SUBJECT', 'Mailing', $c['lanTag']);

            // Define the notification message
            if ($c['hasManager'] == '1') {
                $notificationMessage = Managers::literals()->get('MESSAGE_MANAGER', 'Mailing', $c['lanTag']);
                $notificationMessage = str_replace('{DOMAIN}', $c['domain'], $notificationMessage);
                $notificationMessage = str_replace('{EXPIRATION_DATE}', $expirationDate, $notificationMessage);
                $notificationMessage = str_replace('{COMMERCIAL_EMAIL}', WebConfigurationBase::$MAIL_COMMERCIAL, $notificationMessage);
                $notificationMessage = str_replace('{IMG_URL}', 'http://flaredrop.com/view/resources/images/shared/flareDropTopLogo.png', $notificationMessage);
            } else {
                $notificationMessage = Managers::literals()->get('MESSAGE_NO_MANAGER', 'Mailing', $c['lanTag']);
                $notificationMessage = str_replace('{DOMAIN}', $c['domain'], $notificationMessage);
                $notificationMessage = str_replace('{EXPIRATION_DATE}', $expirationDate, $notificationMessage);
                $notificationMessage = str_replace('{COMMERCIAL_EMAIL}', WebConfigurationBase::$MAIL_COMMERCIAL, $notificationMessage);
                $notificationMessage = str_replace('{IMG_URL}', 'http://flaredrop.com/view/resources/images/shared/flareDropTopLogo.png', $notificationMessage);
            }

            Managers::mailing()->send(WebConfigurationBase::$MAIL_COMMERCIAL, $c['email'], $notificationSubject, $notificationMessage);
        }
    }

    // Generate the summary message
    $summaryMessage .= '<p><b>Domini:</b> ' . $c['domain'] . ' - ';
    $summaryMessage .= '<b>Expiració:</b> <span style="color: ' . $color . ';">' . $expirationDate . '</span> - ';
    $summaryMessage .= '<b>Preu:</b> ' . $c['price'] . '€ - ';
    $summaryMessage .= '<b>Gestor:</b> ' . $c['hasManager'] . ' - ';
    $summaryMessage .= '<b>Idioma:</b> ' . $c['lanTag'] . ' - ';
    $summaryMessage .= '<b>Reb notificacions:</b> ' . $c['enabled'] . '</p>';
}

// Send the summary mail
Managers::mailing()->send(WebConfigurationBase::$MAIL_NOREPLY, WebConfigurationBase::$MAIL_COMMERCIAL, $summarySubject, $summaryMessage);