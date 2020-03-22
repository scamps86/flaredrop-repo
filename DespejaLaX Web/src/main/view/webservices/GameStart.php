<?php

// Get the parameters
$gameId = UtilsHttp::getParameterValue('gameId');

// Start the game
$result = ManagerGame::startGame($gameId);

if (!$result->state) {
    UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'gameStart', false);
    echo $result->description;
}