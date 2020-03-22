<?php

for ($i = 0; $i < 500; $i++) {

    $userData = new VoUser();
    $userData->city = 'city_' . $i;
    $userData->country = 'city_' . $i;
    $userData->cp = 'city_' . $i;
    $userData->location = 'location_' . $i;
    $userData->region = 'region_' . $i;
    $userData->data = 20000;
    $userData->email = 'scamps@gmail.com';
    $userData->firstName = 'firstName_' . $i;
    $userData->middleName = 'middleName_' . $i;
    $userData->lastName = 'lastName_' . $i;
    $userData->folderIds = 8;
    $userData->name = 'test' . $i;
    $userData->password = base64_encode('Admin1234');
    $userData->phone1 = 'phone1_' . $i;
    $userData->phone2 = 'phone2_' . $i;

    SystemUsers::set($userData, false);

}