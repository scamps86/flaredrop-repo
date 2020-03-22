<!-- LOAD THE BACKGROUND VIDEO -->
<?php require_once PATH_VIEW . 'sections/shared/Background.php' ?>

<div id="webapp" class="centered">
    <!-- LOAD THE LEFT HEADER -->
    <?php require_once PATH_VIEW . 'sections/shared/Header.php' ?>

    <!-- SECTION -->
    <section id="page" class="row">

        <!-- LOAD THE LANGUAGE CHANGER-->
        <?php require_once PATH_VIEW . 'sections/shared/LanguageChanger.php' ?>

        <!-- SONGS LIST -->
        <?php if (isset($songs)) : ?>
            <div id="songsContent">
                <ul id="songsList">
                    <li class="mainTitle">
                        <h1 class="fontColorRed fontLight"><?= $album->nameGet() ?></h1>
                    </li>
                    <?php
                    foreach ($songs->list as $s) {
                        $mp3 = UtilsDiskObject::firstFileGet($s['files']);
                        ?>

                        <li class="song">
                            <p>

                            <h2 class="songTitle fontColorDark"><?= $s['title'] ?></h2>
                            <span class="songDuration">(<?= $s['duration'] ?>)</span>
                            <?php if ($mp3 != null) : ?>
                                <a class="songListen fontColorRed"
                                   href="<?= UtilsHttp::getFileUrl($mp3->fileId) ?>"
                                   target="_blank"><?= Managers::literals()->get('LISTEN', 'Discography') ?></a>
                            <?php endif ?>
                            </p>
                        </li>

                        <?php
                    }
                    ?>
                </ul>

                <?php if (isset($album)) : ?>

                    <?php
                    $albumPic = UtilsDiskObject::firstFileGet($album->pictures);
                    ?>
                    <div id="selectedAlbum">
                        <img src="<?= UtilsHttp::getPictureUrl($albumPic->fileId) ?>"
                             alt="<?= $a['name'] ?>"/>

                        <!-- Download full album zip -->
                        <?php
                        if (isset($albumZip)) {
                            $fileUrl = UtilsHttp::getFileUrl($albumZip->fileId);
                            ?>
                            <a class="downloadFullAlbum fontBold" href="<?= $fileUrl ?>"
                               title="<?= Managers::literals()->get('DOWNLOAD_ALBUM', 'Discography') ?>"
                               target="_blank">
                                <?= Managers::literals()->get('DOWNLOAD_ALBUM', 'Discography') ?>
                            </a>
                            <?php
                        }
                        ?>
                    </div>

                <?php endif ?>
            </div>

        <?php endif ?>

        <!-- ALBUMS LIST -->
        <ul id="albumsList">
            <?php
            foreach ($albums as $a) {
                $picture = UtilsDiskObject::firstFileGet($a['pictures']);

                if ($picture != null) {
                    ?>

                    <li class="transitionFast">
                        <a href="<?= UtilsHttp::getSectionUrl('discography', ['a' => $a['folderId']], $a['name']) ?>"
                           title="<?= $a['name'] ?>">
                            <img src="<?= UtilsHttp::getPictureUrl($picture->fileId, '200x200') ?>"
                                 alt="<?= $a['name'] ?>"/>
                        </a>
                    </li>

                    <?php
                }
            } ?>
        </ul>

    </section>
</div>
