<!-- LOAD THE BACKGROUND VIDEO -->
<?php require_once PATH_VIEW . 'sections/shared/Background.php' ?>

<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.8&appId=1455588004675069";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<div id="webapp" class="centered">
    <!-- LOAD THE LEFT HEADER -->
    <?php require_once PATH_VIEW . 'sections/shared/Header.php' ?>

    <!-- SECTION -->
    <section class="row">
        <div id="page">

            <!-- LOAD THE LANGUAGE CHANGER-->
            <?php require_once PATH_VIEW . 'sections/shared/LanguageChanger.php' ?>

            <!-- SECTION CONTENTS -->
            <!-- Mobile band pic -->
            <div id="bandMbl">
                <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/home/mucca.png') ?>"/>
            </div>

            <!-- LEFT SHOWS -->
            <ul id="leftShowsContainer">
                <?php foreach ($shows->list as $s) : ?>
                    <?php
                    $showTimestamp = UtilsDate::toTimestamp($s['time']);

                    if (time() < $showTimestamp) {
                        $day = intval(UtilsDate::getDay($s['time']));
                        $month = UtilsDate::getMonthName($s['time']);
                        $hour = UtilsFormatter::pad(UtilsDate::getHour($s['time']), 2, 0);
                        $minute = UtilsFormatter::pad(UtilsDate::getMinute($s['time']), 2, 0);
                        ?>

                        <li class="row">
                            <a href="<?= UtilsHttp::getSectionUrl('shows') ?>" title="<?= $s['place'] ?>">
                                <div class="row">
                                    <p class="showDay fontColorRed fontLight"><?= $day ?></p>

                                    <p class="showMonth fontColorRed fontLight"><?= Managers::literals()->get('MONTH_' . $month, 'Shared') ?></p>

                                    <p class="showTime fontColorRed fontLight"><?= $hour . ':' . $minute ?></p>
                                </div>

                                <p class="row showPlace fontColorRed"><?= $s['place'] ?></p>

                                <p class="row showCity fontColorDark"><?= $s['city'] ?></p>

                                <p class="row showDescription"><?= UtilsString::cut($s['sDescription']) ?></p>

                                <?php
                                if ($s['price'] !== '0') {
                                    ?>
                                    <p class="row showPrice fontBold fontColorDark <?= $s['aPrice'] ? 'crossed' : '' ?>">
                                        <?= Managers::literals()->get('SHOW_PRICE', 'Home') . ': <span class="price fontBold">' . UtilsFormatter::currency($s['price']) . '</span>' ?>
                                        <?php

                                        if ($s['aPrice'] !== '') {
                                            ?>
                                            <span class="aPrice">
                                        <span class="fontBold"><?= UtilsFormatter::currency($s['aPrice']) ?></span>
                                                <?= $s['aPriceText'] ?>
                                    </span>
                                            <?php
                                        }
                                        ?>
                                    </p>
                                    <?php
                                }
                                ?>
                            </a>
                        </li>

                        <?php
                    }
                endforeach
                ?>

                <li id="goToShowsBtn" class="row">
                    <a class="transitionFast" href="<?= UtilsHttp::getSectionUrl('shows') ?>"
                       title="<?= Managers::literals()->get('VIEW_MORE_SHOWS', 'Home') ?>">
                        <?= Managers::literals()->get('VIEW_MORE_SHOWS', 'Home') ?>
                    </a>
                </li>
            </ul>

            <!-- RIGHT NEWS (Desktop) -->
            <div id="rightNewsContainer">

                <!-- DESKTOP -->
                <ul id="slider">
                    <?php foreach ($news->list as $n) : ?>

                        <li>
                            <h2 class="newsTitle fontBold"><?= $n['title'] ?></h2>

                            <p class="newsDescription"><?= $n['description'] ?></p>
                        </li>

                    <?php endforeach ?>
                </ul>

                <!-- MOBILE -->
                <ul id="mobileNews">
                    <?php foreach ($news->list as $n) : ?>

                        <li>
                            <h2 class="newsTitle fontBold"><?= $n['title'] ?></h2>

                            <p class="newsDescription"><?= $n['description'] ?></p>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>

        <!-- SOCIALS -->
        <div id="socials" class="row">
            <div class="centered">
                <!-- FACEBOOK -->
                <div class="fb-page" data-href="https://www.facebook.com/muccafailate/" data-tabs="timeline"
                     data-width="500" data-height="1000" data-small-header="false" data-adapt-container-width="true"
                     data-hide-cover="false" data-show-facepile="true">
                    <blockquote cite="https://www.facebook.com/muccafailate/" class="fb-xfbml-parse-ignore"><a
                                href="https://www.facebook.com/muccafailate/"></a></blockquote>
                </div>
            </div>
        </div>
    </section>
</div>