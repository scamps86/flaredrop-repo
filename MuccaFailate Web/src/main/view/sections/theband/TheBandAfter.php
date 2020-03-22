<!-- LOAD THE BACKGROUND VIDEO -->
<?php require_once PATH_VIEW . 'sections/shared/Background.php' ?>

<div id="webapp" class="centered">
    <!-- LOAD THE LEFT HEADER -->
    <?php require_once PATH_VIEW . 'sections/shared/Header.php' ?>

    <!-- SECTION -->
    <section id="page" class="row">

        <!-- LOAD THE LANGUAGE CHANGER-->
        <?php require_once PATH_VIEW . 'sections/shared/LanguageChanger.php' ?>

        <!-- SECTION CONTENTS -->
        <!-- GENERAL -->
        <div id="thebandTop">

            <div id="contentsLeft">
                <h1 class="fontColorRed fontThin"><?= Managers::literals()->get('TITLE', 'TheBand') ?></h1>

                <p><?= Managers::literals()->get('DESCRIPTION', 'TheBand') ?></p>
            </div>

            <div id="contentsRight">
                <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/theband/muccaBand2.jpg') ?>"
                     title="Mucca Failate"/>
            </div>
        </div>

        <!-- MEMBERS -->
        <ul id="membersSlider" class="row">
            <?php for ($i = 0; $i < 5; $i++) { ?>
                <li>
                    <div class="memberImage">
                        <img
                                src="<?= UtilsHttp::getRelativeUrl('view/resources/images/theband/member' . $i . '.jpg') ?>"
                                title="<?= Managers::literals()->get('MEMBER_NAME_' . $i, 'TheBand') ?>"/>
                    </div>

                    <div class="memberDescription">
                        <h2 class="fontLight"><?= Managers::literals()->get('MEMBER_NAME_' . $i, 'TheBand') ?></h2>
                        <p class="fontLight"><?= Managers::literals()->get('MEMBER_' . $i, 'TheBand') ?></p>
                    </div>
                </li>
                <?php
            }
            ?>
        </ul>

    </section>
</div>
