<?php

$result = '';

switch ($_GET['p']) {
    case 'masterserver-url':
        $result = 'flaredrop.com';
        break;
    case 'masterserver-port':
        $result = 23456;
        break;
    case 'facil-url':
        $result = 'flaredrop.com';
        break;
    case 'facil-port':
        $result = 50000;
        break;
    case 'tester-url':
        $result = 'flaredrop.com';
        break;
    case 'tester-port':
        $result = 1234;
        break;
}

echo $result;