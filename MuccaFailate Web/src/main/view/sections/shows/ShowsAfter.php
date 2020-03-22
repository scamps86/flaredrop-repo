<!-- LOAD THE BACKGROUND VIDEO -->
<?php require_once PATH_VIEW . 'sections/shared/Background.php' ?>

<div id="webapp" class="centered">
    <!-- LOAD THE LEFT HEADER -->
    <?php require_once PATH_VIEW . 'sections/shared/Header.php' ?>

    <!-- SECTION -->
    <section id="page" class="row">

        <!-- LOAD THE LANGUAGE CHANGER-->
        <?php require_once PATH_VIEW . 'sections/shared/LanguageChanger.php' ?>

        <!-- SHOWS LIST -->
        <ul id="showsContainer" class="row">
            <?php
            $pastPrinted = false;

            foreach ($shows->list as $k => $s) {
                $picture = UtilsDiskObject::firstFileGet($s['pictures']);
                $thumbUrl = $picture == null ? '' : UtilsHttp::getPictureUrl($picture->fileId);
                $fullUrl = $picture == null ? '' : UtilsHttp::getPictureUrl($picture->fileId);
                $year = intval(UtilsDate::getYear($s['time']));
                $day = intval(UtilsDate::getDay($s['time']));
                $month = UtilsDate::getMonthName($s['time']);
                $hour = UtilsFormatter::pad(UtilsDate::getHour($s['time']), 2, 0);
                $minute = UtilsFormatter::pad(UtilsDate::getMinute($s['time']), 2, 0);

                // COMING SOON
                if ($k == 0 && $s['time'] >= UtilsDate::create()) {
                    echo '<li class="title row"><p class="fontBold fontColorRed">' . Managers::literals()->get('COMING_SOON_SHOWS', 'Shows') . '</p></li>';
                }

                // PAST
                if (!$pastPrinted && $s['time'] < UtilsDate::create()) {
                    $pastPrinted = true;
                    echo '<li class="title row"><p class="fontBold">' . Managers::literals()->get('PAST_SHOWS', 'Shows') . '</p></li>';
                }
                ?>

                <li class="row">
                    <div class="showLeft">
                        <h2 class="showTitle fontColorRed fontLight"><?= $s['title'] ?></h2>

                        <p class="showTime">
                            <span class="showDay fontColorRed"><?= $day ?></span>

                            <span
                                    class="showMonth fontColorRed"><?= Managers::literals()->get('MONTH_' . $month, 'Shared') ?></span>
                            <span class="showYear fontColorRed"><?= $year ?></span>
                            <span class="fontColorRed fontLight"><?= Managers::literals()->get('AT', 'Shows') ?></span>
                            <span class="showTime fontColorRed"><?= $hour . ':' . $minute ?></span>
                        </p>

                        <h3 class="showPlace">
                            <span class="fontColorDark"><?= $s['place'] ?></span>,
                            <span class="fontColorDark"><?= $s['city'] ?></span>
                        </h3>

                        <p class="showDescription"><?= $s['description'] ?></p>

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
                    </div>

                    <div class="showRight">
                        <?php if ($thumbUrl != '') : ?>
                            <img class="showPicture transitionFast" src="<?= $thumbUrl ?>" full-url="<?= $fullUrl ?>"
                                 alt="<?= $s['title'] ?>"
                                 title="<?= $s['title'] ?>"/>
                        <?php endif ?>
                    </div>
                </li>
                <?php
            }
            ?>
        </ul>

        <!-- PAGINATOR -->
        <div class="row">
            <?php
            $paginator = new ComponentPagesNavigator($shows->totalPages);
            $paginator->echoComponent();
            ?>
        </div>

    </section>
</div>
