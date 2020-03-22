<?php

$result = SystemTesting::run();

$toPrint = $result->state ? nl2br("TESTING OK:\n" . $result->description) : nl2br("TESTING KO:\n\n" . $result->description . ":\n" . print_r($result->data, true));

// Print the result
UtilsHttp::fileGenerateHeaders('text/plain', strlen($toPrint), 'systemTestingRun', false);
echo $toPrint;