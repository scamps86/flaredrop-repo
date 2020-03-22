<section id="content" class="row">
    <div class="centered">
        <div id="contentContainer" class="row">

            <!-- CONTENTS -->
            <div class="row">
                <h1 class="title fontThin"><?php echo Managers::literals()->get('TITLE', 'Works') ?></h1>
                <h2 class="description"><?php echo Managers::literals()->get('DESCRIPTION', 'Works') ?></h2>
            </div>

            <?php
            foreach ($works->list as $w) {
                $picture = UtilsDiskObject::firstFileGet($w['pictures']);

                if ($picture != null) {
                    ?>
                    <article class="itemContainer">
                        <img src="<?php echo UtilsHttp::getPictureUrl($picture->fileId, '300x200') ?>"
                             alt="<?php echo $w['title'] ?>" class="transitionFast"/>

                        <h3 class="fontBold"><?php echo $w['title'] ?></h3>

                        <p>
                            <?php
                            $folderId = explode(';', $w['folderIds']);

                            switch ($folderId[0]) {
                                case WebConstants::FOLDER_WORK_WEB_SIMPLE:
                                    echo Managers::literals()->get('WEB_SIMPLE', 'Works');
                                    break;
                                case WebConstants::FOLDER_WORK_WEB_ADVANCED:
                                    echo Managers::literals()->get('WEB_ADVANCED', 'Works');
                                    break;
                                case WebConstants::FOLDER_WORK_WEB_SHOP:
                                    echo Managers::literals()->get('WEB_SHOP', 'Works');
                                    break;
                            }
                            ?>
                        </p>

                        <h4><?php echo $w['description'] ?></h4>

                        <a href="<?php echo htmlspecialchars($w['url']) ?>"
                           target="_blank"><?php echo Managers::literals()->get('VISIT_WEB', 'Works') ?></a>
                    </article>
                <?php
                }
            }
            ?>
        </div>
    </div>
</section>