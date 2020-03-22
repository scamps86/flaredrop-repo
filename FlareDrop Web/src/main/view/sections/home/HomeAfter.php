<!-- PAGE CONTENT -->
<section id="content" class="row transitionFast">

    <div class="centered">

        <!-- CONTENTS -->
        <div id="contentContainer" class="row">

            <!-- TOP SLIDER -->
            <section class="row">
                <div id="slider" class="owl-carousel">
                    <?php
                    foreach ($slider as $s) {
                        echo $s;
                    }
                    ?>
                </div>
            </section>

            <!-- WELCOME TEXT -->
            <div id="welcomeTextContainer" class="row">
                <p><?php echo Managers::literals()->get('WELCOME_TEXT', 'Home') ?></p>
            </div>

            <!-- PACKS -->
            <div id="desktopPacks" class="row">
                <article class="box">
                    <div class="row">
                        <img
                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/shared/pack-web-simple.png') ?>"
                            alt="<?php echo Managers::literals()->get('BOX_0_TITLE', 'Home') ?>"/>

                        <h2><?php echo Managers::literals()->get('BOX_0_TITLE', 'Home') ?></h2>
                    </div>
                    <div class="row">
                        <h3><?php echo Managers::literals()->get('BOX_0_DESCRIPTION', 'Home') ?></h3>
                    </div>
                    <div class="row">
                        <a class="btnBlue"
                           href="<?php echo UtilsHttp::getSectionUrl('products') ?>#pack-web-simple"><?php echo Managers::literals()->get('READ_MORE', 'Shared') ?></a>
                    </div>
                </article>
                <article class="box">
                    <div class="row">
                        <img
                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/shared/pack-web-advanced.png') ?>"
                            alt="<?php echo Managers::literals()->get('BOX_0_TITLE', 'Home') ?>"/>

                        <h2><?php echo Managers::literals()->get('BOX_1_TITLE', 'Home') ?></h2>
                    </div>
                    <div class="row">
                        <h3><?php echo Managers::literals()->get('BOX_1_DESCRIPTION', 'Home') ?></h3>
                    </div>
                    <div class="row">
                        <a class="btnRed"
                           href="<?php echo UtilsHttp::getSectionUrl('products') ?>#pack-web-advanced"><?php echo Managers::literals()->get('READ_MORE', 'Shared') ?></a>
                    </div>
                </article>
                <article class="box">
                    <div class="row">
                        <img
                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/shared/pack-web-shop.png') ?>"
                            alt="<?php echo Managers::literals()->get('BOX_0_TITLE', 'Home') ?>"/>

                        <h2><?php echo Managers::literals()->get('BOX_2_TITLE', 'Home') ?></h2>
                    </div>
                    <div class="row">
                        <h3><?php echo Managers::literals()->get('BOX_2_DESCRIPTION', 'Home') ?></h3>
                    </div>
                    <div class="row">
                        <a class="btnGreen"
                           href="<?php echo UtilsHttp::getSectionUrl('products') ?>#pack-web-shop"><?php echo Managers::literals()->get('READ_MORE', 'Shared') ?></a>
                    </div>
                </article>
                <article class="box">
                    <div class="row">
                        <img
                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/shared/pack-domain-hosting.png') ?>"
                            alt="<?php echo Managers::literals()->get('BOX_0_TITLE', 'Home') ?>"/>

                        <h2><?php echo Managers::literals()->get('BOX_3_TITLE', 'Home') ?></h2>
                    </div>
                    <div class="row">
                        <h3><?php echo Managers::literals()->get('BOX_3_DESCRIPTION', 'Home') ?></h3>
                    </div>
                    <div class="row">
                        <a class="btnYellow"
                           href="<?php echo UtilsHttp::getSectionUrl('products') ?>#pack-domain-hosting"><?php echo Managers::literals()->get('READ_MORE', 'Shared') ?></a>
                    </div>
                </article>
            </div>

            <!-- SOME WORKS -->
            <?php
            if ($works->totalItems > 0) {
                ?>
                <article id="someWorksContainer" class="row">
                    <div class="row">
                        <h2 class="title fontThin"><?php echo Managers::literals()->get('WORKS_TITLE', 'Home') ?></h2>

                        <?php
                        foreach ($works->list as $w) {
                            $picture = UtilsDiskObject::firstFileGet($w['pictures']);

                            if ($picture != null) {
                                ?>

                                <div class="workItemContainer" fdHref="<?php echo htmlspecialchars($w['url']) ?>">
                                    <img class="transitionFast"
                                         src="<?php echo UtilsHttp::getPictureUrl($picture->fileId, '300x200') ?>"
                                         alt="<?php $w['title'] ?>"/>

                                    <p><?php echo $w['title'] ?>
                                        <a class="transitionFast smHide"
                                           href="<?php echo htmlspecialchars($w['url']) ?>"
                                           target="_blank"><?php echo Managers::literals()->get('VISIT', 'Shared') ?></a>
                                    </p>
                                </div>

                            <?php
                            }
                        }
                        ?>
                    </div>
                </article>
            <?php
            }
            ?>

        </div>
    </div>
</section>