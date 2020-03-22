<?php

UtilsJavascript::newVar('URL_SERVICE_GAME_START', UtilsHttp::getWebServiceUrl('gameStart'));
UtilsJavascript::newVar('URL_SERVICE_GENERATE_ISSUE', UtilsHttp::getWebServiceUrl('issueGenerate'));
UtilsJavascript::newVar('URL_SERVICE_EVALUATE_ISSUE', UtilsHttp::getWebServiceUrl('issueEvaluate'));
UtilsJavascript::newVar('GAME_ID', $gameId);
UtilsJavascript::newVar('GAME_ERROR_1', Managers::literals()->get('GAME_ERROR_1', 'Play'));
UtilsJavascript::newVar('GAME_ERROR_2', Managers::literals()->get('GAME_ERROR_2', 'Play'));
UtilsJavascript::newVar('GAME_ERROR_3', Managers::literals()->get('GAME_ERROR_3', 'Play'));
UtilsJavascript::newVar('GAME_ERROR_4', Managers::literals()->get('GAME_ERROR_4', 'Play'));
UtilsJavascript::echoVars();

?>

<section class="row">
    <div class="centered">

        <!-- START BUTTON -->
        <?php
        if (!$GAME_CREATED) {
            ?>
            <p id="startGameBtn">START!!!</p>

            <?php
        } else {
            ?>

            <!-- POINTS -->
            <p id="totalPoints">0</p>
            <p id="issuePoints">0</p>

            <!-- EVALUATE BUTTON -->
            <p id="solutionScreen"></p>

            <!-- KEYBOARD -->
            <ul id="gameKeyboard">
                <li class="in n">7</li>
                <li class="in n">8</li>
                <li class="in n">9</li>
                <li class="in n">4</li>
                <li class="in n">5</li>
                <li class="in n">6</li>
                <li class="in n">1</li>
                <li class="in n">2</li>
                <li class="in n">3</li>
                <li class="in n">0</li>
                <li class="in q">,</li>
                <li class="in e">E</li>
                <li id="resetBtn"><?= Managers::literals()->get('RESET', 'Play') ?></li>
                <li id="commitBtn"><?= Managers::literals()->get('COMMIT', 'Play') ?></li>
            </ul>

            <!-- ISSUE IMAGE -->
            <img id="blackboard" src="<?= UtilsHttp::getWebServiceUrl('issueGenerate') ?>"/>

            <?php
            print_r($_SESSION);
        }
        ?>

        <!-- LEADER BOARD -->
        <ul id="leaderBoard">

            <li class="header"><p>
                    <span class="bPosition"><?= Managers::literals()->get('LEADERBOARD_POSITION', 'Play') ?></span>
                    <span class="bUser"><?= Managers::literals()->get('LEADERBOARD_USER', 'Play') ?></span>
                    <span class="bPoints"><?= Managers::literals()->get('LEADERBOARD_POINTS', 'Play') ?></span>
                </p>
            </li>

            <?php
            foreach ($leaderBoard as $v) {
                ?>

                <li><p>
                        <span class="bPosition"><?= $k + 1 ?></span>
                        <span class="bUser"><?= $v['user'] ?></span>
                        <span class="bPoints"><?= $v['points'] ?></span>
                    </p>
                </li>

                <?php
            }
            ?>
        </ul>
    </div>
</section>