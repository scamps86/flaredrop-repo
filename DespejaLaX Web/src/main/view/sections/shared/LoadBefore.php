<?php

// Validate if the user is logged
$loginResult = SystemUsers::login('', '', WebConfigurationBase::$DISK_WEB_ID);

$USER_LOGGED = $loginResult->state;
$userData = $loginResult->data;

// Redirect to the home section if the user is not logged in a session section
if (!$USER_LOGGED && in_array(WebConstants::getSectionName(), explode(',', WebConstants::SESSION_SECTIONS))) {
    UtilsHttp::redirectToSection('home');
}

// Get the remaining time
$GAMES_REMAINING = ManagerGame::getRemainingSeconds();
$GAME_ROUND_TIME_DIVISION = intval(WebConstants::getVariable('GAME_ROUND_TIME', 'INTEGER') / 5);

// Paint the background color depending of the remaining time
$BG_COLOR = '#fff';

if ($GAMES_REMAINING < $GAME_ROUND_TIME_DIVISION) {
    $BG_COLOR = '#f65e5e';
} else if ($GAMES_REMAINING >= $GAME_ROUND_TIME_DIVISION && $GAMES_REMAINING < ($GAME_ROUND_TIME_DIVISION * 2)) {
    $BG_COLOR = '#f5ab5b';
} else if ($GAMES_REMAINING >= ($GAME_ROUND_TIME_DIVISION * 2) && $GAMES_REMAINING < ($GAME_ROUND_TIME_DIVISION * 3)) {
    $BG_COLOR = '#eeea7d';
} else if ($GAMES_REMAINING >= ($GAME_ROUND_TIME_DIVISION * 3) && $GAMES_REMAINING < ($GAME_ROUND_TIME_DIVISION * 4)) {
    $BG_COLOR = '#a1ec6f';
}