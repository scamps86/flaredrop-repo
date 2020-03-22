<?php

class ManagerGame
{

    private static $_LEVEL_INCREASE = 4;
    private static $_POINTS_TOP_SECONDS = 50;
    private static $_ISSUE_CLASS_QUANTITY = 20;
    private static $_ISSUE_GAME_QUANTITY = 10;

    /**
     * Get the games list info
     *
     * @return array
     */
    public static function getListInfo()
    {
        $filter = new VoSystemFilter();
        $filter->setLanTag(WebConstants::getLanTag());
        $filter->setAND();
        $filter->setFolderId(WebConstants::FOLDER_GAMES_ACTIVE);
        $filter->setAND();
        $filter->setRootId(WebConfigurationBase::$ROOT_ID);
        $filter->setAND();
        $filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
        $filter->setSortFields('price', 'ASC');

        $games = SystemDisk::objectsGet($filter, 'game');
        $result = [];

        foreach ($games->list as $g) {
            $ga = [];
            $ga['gameId'] = $g['objectId'];
            $ga['title'] = $g['title'];
            $ga['price'] = $g['price'];
            $ga['color'] = $g['color'];
            $ga['PRIZE'] = $g['PRIZE'];
            $ga['LEADER'] = $g['LEADER'];
            array_push($result, $ga);
        }
        return $result;
    }


    /**
     * Get the selected game info
     *
     * @param int $gameId The game id
     */
    public static function getGameInfo($gameId)
    {
        return SystemDisk::objectGet($gameId, 'game');
    }


    /**
     * Initialize a game if the user can, and substract the necessary tickets
     *
     * @param int $gameId The current game id
     *
     * @return VoResult the result
     */
    public static function startGame($gameId)
    {
        // Initialize session
        self::_initializeSession();

        // Validate if the time is not expired
        if (self::getRemainingSeconds() > 0) {

            // Get the game
            $game = self::getGameInfo($gameId);

            if ($game != null) {
                // Validate if the game is not previously created
                if (self::getCreatedGameId() == -1) {

                    // Get game params
                    $gamePrice = intval($game->propertyGet('price'));

                    // Validate if the user has enough tickets (for all paying games)
                    if ($gamePrice <= 0) {
                        if (self::_createGame($game)) {
                            return UtilsResult::generateSuccessResult('Free game');
                        } else {
                            // Error creating game
                            return UtilsResult::generateErrorResult('ERROR_3', null, false);
                        }
                    } else {
                        $user = SystemUsers::getLogged(WebConfigurationBase::$DISK_WEB_ID);
                        if ($user != null && intval($user->data) >= $gamePrice) {
                            if (self::_createGame($game, $user)) {
                                return UtilsResult::generateSuccessResult('Payment game');
                            } else {
                                // Error creating game
                                return UtilsResult::generateErrorResult('ERROR_3', null, false);
                            }
                        } else {
                            // Not enough tickets
                            return UtilsResult::generateErrorResult('ERROR_2', null, false);
                        }
                    }
                } else {
                    // Game is previously started
                    return UtilsResult::generateErrorResult('ERROR_3', null, false);
                }
            } else {
                // Game not exists
                return UtilsResult::generateErrorResult('ERROR_3', null, false);
            }
        } else {
            // Time out
            return UtilsResult::generateErrorResult('ERROR_1', null, false);
        }
    }


    /**
     * Get the created game id. If the game is not created it will return -1
     *
     * @return int The game id
     */
    public static function getCreatedGameId()
    {
        if (self::validateCurrentGameExpired()) {
            return -1;
        }
        return isset($_SESSION['game_id']) ? $_SESSION['game_id'] : -1;
    }


    /**
     * Create the game and substract the tickets
     *
     * @param VoObject $game The game object
     * @param VoUser $user The user object
     *
     * @return boolean If the game is created or not
     */
    private static function _createGame($game, $user = null)
    {
        // Get the game price
        $price = intval($game->propertyGet('price'));

        // Set the game type
        if ($user != null) {
            // Substract the user tickets
            $user->data = intval($user->data) - $price;
            $result = SystemUsers::set($user);

            if ($result->state) {
                $_SESSION['game_user_name'] = $user->name; //nick
            } else {
                return false;
            }
        } else {
            $_SESSION['game_user_name'] = 'user_' . (UtilsDate::toTimestamp(UtilsDate::create()) * 2);
        }

        // Set if the game is free or not and increase the prize as the half that the user payed
        if ($price > 0) {
            $_SESSION['game_type'] = 'payment';

            $prize = intval($game->propertyGet('PRIZE'));
            $prize += $price / 2;
            $game->propertySet('PRIZE', $prize);

            $result = SystemDisk::objectSet($game, 'game');

            if (!$result->state) {
                return false;
            }
        } else {
            $_SESSION['game_type'] = 'free';
        }

        // Set the game id
        $_SESSION['game_id'] = $game->objectId;

        // Set game started date
        $_SESSION['game_start_date'] = UtilsDate::toTimestamp(UtilsDate::create());

        // Set default params
        $_SESSION['game_issue_count'] = 0;
        $_SESSION['game_issue_level'] = 0;
        $_SESSION['game_points'] = 0;
        $_SESSION['game_issue_solution'] = '';

        // Return ok
        return true;
    }


    /**
     * Clear the game from the session
     */
    public static function stopGame()
    {
        // Remove all game session info
        foreach ($_SESSION as $k => $v) {
            if (substr($k, 0, 4) == 'game') {
                unset($_SESSION[$k]);
            }
        }
    }


    /**
     * Validate if a game is expired or ended by tries. If expired, remove all game session info
     *
     * @return bool
     */
    public static function validateCurrentGameExpired()
    {
        // Check
        if (isset($_SESSION['game_start_date']) && isset($_SESSION['game_issue_count'])) {
            $currentDate = UtilsDate::toTimestamp(UtilsDate::create());

            if ($_SESSION['game_start_date'] >= $currentDate - WebConstants::getVariable('GAME_EXPIRE_TIME', 'INTEGER')) {
                if ($_SESSION['game_issue_count'] <= self::$_ISSUE_GAME_QUANTITY) {
                    return false;
                }
            }
        }

        // Save the score
        self::saveScore();

        // Remove all game session info
        self::stopGame();

        // Do the return
        return true;
    }


    /**
     * Evaluate the previously generated issue solution and print the response as a JSON. If no game initialized, it will return an error 404
     *
     * @param string $solution The issue solution
     */
    public static function evaluateSolution($solution = '')
    {
        // Initialize session
        self::_initializeSession();

        // Validate if the game is expired
        if (self::validateCurrentGameExpired()) {
            UtilsHttp::error404(false);
        }

        // Define main vars
        $points = 0;
        $correct = $_SESSION['game_issue_solution'] == $solution;

        // Do the evaluation
        if ($correct) {
            $current = UtilsDate::toTimestamp(UtilsDate::create());
            $difference = $current - $_SESSION['game_issue_time'];
            $points = $difference > self::$_POINTS_TOP_SECONDS ? 0 : self::$_POINTS_TOP_SECONDS - $difference;
        }

        // Reset the previous solution
        $_SESSION['game_issue_solution'] = '';

        // Add the points
        $_SESSION['game_points'] += $points;

        // Generate the response
        $json = [];
        $json['totalPoints'] = $_SESSION['game_points'];
        $json['points'] = $points;
        $json['correct'] = $correct;

        // Print the json
        $json = json_encode($json);
        UtilsHttp::fileGenerateHeaders('application/json', strlen($json), 'issueEvaluate', false);
        echo $json;

        // If this is the last issue solution, stop the game and save the score
        self::validateCurrentGameExpired();
    }


    /**
     * Generate a new game issue and check if the solution is correct or not, and evaluate it. Error 404 if error
     */
    public static function generateIssue()
    {
        // Initialize session
        self::_initializeSession();

        // Get game info
        $gameId = self::getCreatedGameId();
        $game = self::getGameInfo($gameId);

        // Generate the issue or return error 404 / NOT FOUND
        if ($gameId != -1 && $game != null) {

            // Issue counter
            $_SESSION['game_issue_count']++;

            // Set difficulty
            $_SESSION['game_issue_level'] += self::$_LEVEL_INCREASE;

            // Set issue time
            $_SESSION['game_issue_time'] = UtilsDate::toTimestamp(UtilsDate::create());

            // Generate a random issue
            $issueId = rand(1, self::$_ISSUE_CLASS_QUANTITY);
            $issueId = 1;// TODO REMOVE!
            call_user_func('SystemGenerateIssue' . $issueId . '::generate', $_SESSION['game_issue_level']);
        } else {
            UtilsHttp::error404(false);
        }
    }


    /**
     * Get the round remaining seconds
     *
     * @return int
     */
    public static function getRemainingSeconds()
    {
        $expirationÇDate = UtilsDate::toTimestamp(self::getRoundExpirationDate());
        $now = UtilsDate::toTimestamp(UtilsDate::create());

        return $expirationÇDate - $now;
    }


    /**
     * Get the round expiration date
     *
     * @return string
     */
    public static function getRoundExpirationDate()
    {
        return WebConstants::getVariable('GAME_ROUND_EXPIRATION_DATE');
    }


    /**
     * Initialize a session. Not affect if a previous session is initialized
     */
    private static function _initializeSession()
    {
        // Initialize the session (for non users)
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }


    /**
     * Save the game final store to the game info. No problem if game is expired, but the game must be previously created!
     */
    public static function saveScore()
    {
        $gameId = isset($_SESSION['game_id']) ? $_SESSION['game_id'] : -1;

        // Get the game object
        $game = self::getGameInfo($gameId);

        if ($game != null) {
            ;

            // If the user is the leader, set the leader to the game
            if (self::_getUserPosition($gameId, $_SESSION['game_user_name']) == 0) {
                $game->propertySet('LEADER', $_SESSION['game_user_name']);
            }

            // Get the leader board
            $data = $game->propertyGet('LEADERBOARD');
            $data = $data == '' ? [] : json_decode($data);

            array_push($data, ['user' => $_SESSION['game_user_name'], 'points' => $_SESSION['game_points']]);

            // Sort by points
            $data = UtilsArray::arrayOfAssociativeArraysSort($data, 'points', SORT_DESC);

            // Save to the game
            $game->propertySet('LEADERBOARD', json_encode($data));
            SystemDisk::objectSet($data, 'game', false);
        }
    }


    /**
     * Get the game leader board array
     *
     * @param int $gameId The game id
     *
     * @return array associative array [[user => xxx, points => yyy], ...]
     */
    public static function getLeaderBoard($gameId)
    {
        $result = [];

        $game = self::getGameInfo($gameId);

        if ($game != null) {
            $data = $game->propertyGet('LEADERBOARD');
            if ($data != '') {
                $result = json_decode($data);
            }
        }
        return $result;
    }


    /**
     * Get the user leaderboard position. If the user not found it will return a -1
     *
     * @param int $gameId The game id
     * @param string $userName The user name
     * @return int
     */
    private static function _getUserPosition($gameId, $userName)
    {
        $leaderBoard = self::getLeaderBoard($gameId);

        foreach ($leaderBoard as $k => $v) {
            if ($v['user'] == $userName) {
                return $k;
            }
        }
        return -1;
    }


    /**
     * Get the game leader user. If no leader or user found, it will return null
     *
     * @param int $gameId The game id
     *
     * @return VoUser
     */
    public static function getLeaderUser($gameId)
    {
        $game = self::getGameInfo($gameId);

        if ($game != null) {
            return SystemUsers::get('', $game->propertyGet('LEADER'), false);
        }
        return null;
    }

}