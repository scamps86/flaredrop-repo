<section class="section row">
    <div id="catalog" class="centered">


        <!-- PRODUCTS LIST -->
        <div id="rightContainer">

            <!-- BREADCRUMB -->
            <div class="row">
                <?php
                $breadcrumb = new ComponentFolderBreadCrumb();
                $breadcrumb->addFolderTree($FOLDERS, 'catalog');
                $breadcrumb->echoComponent();
                ?>
            </div>

            <!-- CATEGORY PICTURE -->
            <?php
            if ($FOLDER != null) {
                $pic = UtilsDiskObject::firstFileGet($FOLDER->pictures);

                if ($pic !== null) {
                    ?>
                    <img id="categoryPicture" src="<?= UtilsHttp::getPictureUrl($pic->fileId, '900x200') ?>">
                    <?php
                }
            }

            ?>

            <!-- PRODUCT LIST-->
            <div id="productsList">
                <?php
                foreach ($products->list as $p) {
                    ProductCard::echoCard($p);
                }
                ?>
            </div>

            <!-- PAGES NAVIGATOR -->
            <div class="row">
                <?php
                $pagesNavigator = new ComponentPagesNavigator($products->totalPages, '', 5, '');
                $pagesNavigator->echoComponent();
                ?>
            </div>
        </div>

        <!-- LEFT CONTAINER -->
        <div id="leftContainer">
            <!-- CATEGORY TREE -->
            <div class="leftTitle"><h2><?= Managers::literals()->get('CATEGORIES', 'Catalog') ?></h2></div>

            <?php
            $categoryTree = new ComponentFolderMenu();
            $categoryTree->addFolderTree($FOLDERS, 'catalog');
            $categoryTree->echoComponent();
            ?>

            <!-- RELATED PRODUCTS -->
            <?php
            $pMiniList = new ProductMiniList();
            $pMiniList::echoList($relatedProducts, Managers::literals()->get('RELATED_PRODUCTS', 'Catalog'));
            ?>
        </div>
    </div>
</section>