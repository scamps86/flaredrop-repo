<?php

$result = [];
$result['roundRemainingSeconds'] = ManagerGame::getRemainingSeconds();
$result['list'] = ManagerGame::getListInfo();

// Echo the result as json
$json = json_encode($result);
UtilsHttp::fileGenerateHeaders('application/json', strlen($json), 'gameGetListInfo', false);
echo $json;