<?php

// Define the mail subject
$subject = 'Nova sol·licitud de FLAREDROP.COM';

// Define the mail content
$message = '<b>DADES PERSONALS</b><br><br><b>Nom complet: </b>' . UtilsHttp::getParameterValue('frmName') . '<br>';
$message .= '<b>Correu electrònic: </b>' . UtilsHttp::getParameterValue('frmEmail') . '<br><br><br>';
$message .= '<b>DADES DEL PRODUCTE</b><br><br><b>Tipus de producte: </b>' . UtilsHttp::getParameterValue('frmWebType') . '<br>';
$message .= '<b>Disposa de disseny: </b>' . (UtilsHttp::getParameterValue('frmWebDesign') == '1' ? 'Si' : 'No') . '<br><br>';
$message .= '<b>Disposa de material:</b><br>' . UtilsHttp::getParameterValue('frmWebMaterial') . '<br><br>';
$message .= '<b>Idiomes:</b><br>' . UtilsHttp::getParameterValue('frmWebLanguages') . '<br><br>';
$message .= '<b>Seccions:</b><br>' . UtilsHttp::getParameterValue('frmWebSections') . '<br><br>';
$message .= '<b>Continguts dinàmics: </b><br>' . UtilsHttp::getParameterValue('frmWebSectionsDynamic') . '<br><br>';
$message .= '<b>Altres suggeriments web: </b><br>' . UtilsHttp::getParameterValue('frmWebOthers') . '<br><br><br>';
$message .= "<b>DADES DE DOMINI I ALLOTJAMENT</b><br><br><b>Tipus d'allotjament: </b>" . UtilsHttp::getParameterValue('frmPlan') . '<br>';
$message .= '<b>Domini: </b>' . UtilsHttp::getParameterValue('frmDomain') . '<br><br><br>';
$message .= '<b>Altres suggeriments:</b><br>' . UtilsHttp::getParameterValue('frmOthers');

// Send the mail
if (!Managers::mailing()->send(UtilsHttp::getParameterValue('frmEmail'), WebConfigurationBase::$MAIL_COMMERCIAL, $subject, $message)) {
    echo 'The email could not be sent';
}
