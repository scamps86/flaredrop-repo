<section class="section row">
    <div class="centered">

        <!-- BREADCRUMB -->
        <?php
        $breadcrumb = new ComponentFolderBreadCrumb();
        $breadcrumb->addFolderTree($FOLDERS, 'catalog');
        $breadcrumb->addOption($product->localizedPropertyGet('title'), 'product', UtilsHttp::getEncodedParamsArray());
        $breadcrumb->echoComponent();
        ?>

        <!-- COLUMNS -->
        <div id="productColumns" class="row">

            <!-- PICTURES -->
            <div id="productPictures">
                <?php
                $pictures = $product->filesArrayGet();
                $firstPicture = UtilsHttp::getRelativeUrl('view/resources/images/shared/productNoImage.png');

                if (count($pictures) > 0) {
                    $firstPicture = UtilsHttp::getPictureUrl($pictures[0]->fileId);
                }

                if (count($pictures) > 0) {
                    foreach ($pictures as $p) {
                        echo '<div class="slide">';
                        echo '<a href="' . UtilsHttp::getPictureUrl($p->fileId) . '" title="' . $product->localizedPropertyGet('title') . '">';
                        echo '<img src="' . UtilsHttp::getPictureUrl($p->fileId, '300x300') . '" alt="' . $product->localizedPropertyGet('title') . '"></a>';
                        echo '</div>';
                    }
                } else {
                    echo '<img class="productImage" src="' . $firstPicture . '" alt="' . $product->localizedPropertyGet('title') . '">';
                }
                ?>
            </div>

            <!-- PRODUCT CONTENTS 1 -->
            <div id="productContents1">
                <?php
                $price = UtilsFormatter::currency(floatval($product->propertyGet('price')));
                ?>

                <!-- TITLE & PRICE -->
                <h1 class="productTitle fontBold"><?= $product->localizedPropertyGet('title') ?></h1>
                <span class="productPrice"><?= $price ?></span>

                <!-- OPTIONS -->
                <div id="productOptions" class="row">
                    <!-- ADD TO CART -->
                    <div id="addToCartOptions">
                        <p class="unselectable">
                            <span><?= Managers::literals()->get('PRODUCTS_QUANTITY', 'Product') ?>&#58;</span>
                            <span class="cartUnitSelector cartUnitSelectorRemove">&#45;</span>
                            <span class="cartUnitSelectorUnits">1</span>
                            <span class="cartUnitSelector cartUnitSelectorAdd">&#43;</span>

                            <button class="addToCartBtn"
                                    pid="<?= $product->objectId ?>"
                                    purl="<?= $firstPicture ?>"
                                    punits="1">
                                <?= Managers::literals()->get('ADD_TO_CART', 'Shared') ?>
                            </button>
                        </p>
                    </div>

                    <!-- SOCIAL NETWORKS -->
                    <!-- Go to www.addthis.com/dashboard to customize your tools -->
                    <div class="addthis_inline_share_toolbox"></div>
                </div>
            </div>

            <!-- BANNERS -->
            <div id="rightBanners">
                <?php
                $pMiniList = new ProductMiniList();
                $pMiniList::echoList($relatedProducts, Managers::literals()->get('FEATURED_PRODUCTS', 'Product'));
                ?>
            </div>
        </div>

        <div id="productDescription" class="row">
            <div class="title">
                <h2><?= Managers::literals()->get('PRODUCT_DESCRIPTION', 'Product') ?></h2>
            </div>

            <p><?= $product->localizedPropertyGet('description') ?></p>
        </div>
    </div>

    <!-- RELATED BRANDS -->
    <?php include '../components/RelatedBrands.php'; ?>
</section>