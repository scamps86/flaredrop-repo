<?php

// Get the game
$gameId = UtilsHttp::getEncodedParam('id');
$game = ManagerGame::getGameInfo($gameId);


// Custom redirect to home if the game not exists or user is not logged and the game is not free
if ($game == null || (!$USER_LOGGED && $game->propertyGet('price') != 0)) {
    UtilsHttp::redirectToSection('home');
}


// Validate if there is a current game started
$GAME_CREATED = $gameId == ManagerGame::getCreatedGameId();

// Validate if the game is expired and finish it if necessary
ManagerGame::validateCurrentGameExpired();

// Get the leader board
$leaderBoard = ManagerGame::getLeaderBoard($gameId);