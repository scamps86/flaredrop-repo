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
        <div id="picturesContainer" class="row">
            <?php
            foreach ($pictureEvents->list as $k => $s) {
                $pictures = UtilsDiskObject::filesArrayGet($s['pictures']);

                ?>
                <h2 class="fontColorRed fontLight"><?= $s['title'] ?></h2>

                <div class="row">
                    <?php

                    foreach ($pictures as $picture) {
                        $thumbUrl = UtilsHttp::getPictureUrl($picture->fileId, '600x400');
                        $fullUrl = UtilsHttp::getPictureUrl($picture->fileId);

                        ?>
                        <a target="_blank" href="<?= $fullUrl ?>"><img src="<?= $thumbUrl ?>"/></a>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
    </section>
</div>
