<section class="row content">
    <div class="centered">

        <?php include PATH_VIEW . 'sections/shared/CategoryMenu.php'; ?>

        <!-- PRODUCTS LIST -->
        <div id="productsList" class="row">

            <!-- SHOW SELECTED CATEGORY TITLE -->
            <div class="row">
                <?php
                if ($folder != null) {
                    echo '<h1>' . Managers::literals()->get('TITLE', 'Catalog') . ':</h1>';
                    echo '<h2>' . strip_tags($folder->nameGet()) . '</h2>';

                    if ($folder->descriptionGet() != '') {
                        echo '<h3 class="paragraph">' . $folder->descriptionGet() . '</h3>';
                    }
                } else {
                    echo '<h1>' . Managers::literals()->get('TITLE', 'Catalog') . ':</h1>';
                    echo '<h2>' . Managers::literals()->get('ALL_FOLDERS', 'Catalog') . '</h2>';
                }
                ?>
            </div>

            <!-- THE LIST -->
            <div class="row">
                <?php
                foreach ($products->list as $p) {
                    $picture = UtilsDiskObject::firstFileGet($p['pictures']);

                    if ($picture != null) {
                        $folderId = UtilsDiskObject::firstFolderIdGet($p['folderIds']);
                        ?>
                        <a class="scItem"
                           href="<?php echo UtilsHttp::getSectionUrl('product', ['objectId' => $p['objectId'], 'folderId' => $folderId]) ?>"
                           title="<?php echo $p['title'] ?>">
                            <img src="<?php echo UtilsHttp::getPictureUrl($picture->fileId, '170x170') ?>"
                                 alt="<?php echo $picture->filename ?>">
                            <span><?php echo $p['title'] ?></span>
                        </a>
                    <?php
                    }
                    ?>
                <?php
                }
                ?>
            </div>

            <!-- PAGES NAVIGATOR -->
            <div class="row">
                <?php
                $pagesNavigator = new ComponentPagesNavigator($products->totalPages);
                $pagesNavigator->echoComponent();
                ?>
            </div>
        </div>

    </div>
</section>