<?php
UtilsJavascript::newVar('GAME_LIST_REFRESH_TIME', WebConstants::getVariable('GAME_LIST_REFRESH_TIME', 'INTEGER'));
UtilsJavascript::echoVars();
?>

<section class="row">

    <!-- COUNTDOWN -->
    <div id="timeLeftContainer" class="boxShadow row<?= $GAMES_REMAINING > 0 ? '' : ' hidden' ?>"
         total="<?= WebConstants::getVariable('GAME_ROUND_TIME', 'INTEGER') ?>" remaining="<?= $GAMES_REMAINING ?>">
        <img class="timeLeftTimer" src="<?= UtilsHttp::getRelativeUrl('view/resources/images/home/Timer.svg') ?>"
             alt="timer"/>

        <p></p>
        <img class="timeLeftTimer" src="<?= UtilsHttp::getRelativeUrl('view/resources/images/home/Timer.svg') ?>"
             alt="timer"/>

        <div class="row">
            <div id="timeLeftBar" class="transitionSlow" style="background-color:<?= $BG_COLOR ?>"></div>
        </div>
    </div>

    <!-- CONTENTS -->
    <div class="centered">
        <div id="timeLeftFinishedContainer" class="row<?= $GAMES_REMAINING > 0 ? ' hidden' : '' ?>">
            <p><?= Managers::literals()->get('TIME_LEFT_FINISHED', 'Shared') ?></p>
        </div>


        <!-- BANNERS (NOT LOGGED) -->
        <? if (!$USER_LOGGED) : ?>
            <div id="banners" class="row">
            </div>
        <?php endif ?>

        <!-- GAMES LIST -->
        <ul id="gamesList" class="row">
            <?php foreach ($games as $g) : ?>

                <?php
                $isGameFree = $g['price'] <= 0;
                ?>

                <li class="animated flipInX" style="background-color:<?= $g['color'] ?>">
                    <a <?= $isGameFree || (!$isGameFree && $USER_LOGGED) ? 'href="' . UtilsHttp::getSectionUrl('play', ['id' => $g['gameId']]) . '" class="enabled"' : '' ?>
                        title="<?= $g['title'] ?>">
                        <div class="gameSelectBg transitionFast"></div>
                        <h3 class="gameTitle"><?= $g['title'] ?></h3>
                        <h4 class="gameAward"><?= Managers::literals()->get('GAME_PRIZE', 'Shared') ?>
                            <span><?= $g['PRIZE'] ?></span></h4>
                        <h5 class="gameCurrentWinner"><?= Managers::literals()->get('GAME_LEADER', 'Shared') ?>
                            <span><?= $g['LEADER'] ?></span></h5>
                    </a>
                </li>

            <? endforeach ?>
        </ul>
    </div>
</section>