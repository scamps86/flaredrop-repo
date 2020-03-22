<section class="row content">
    <div class="centered">

        <?php include PATH_VIEW . 'sections/shared/CategoryMenu.php'; ?>

        <!-- PRODUCT DETAILS -->
        <div id="productDetails" class="row">

            <!-- SHOW SELECTED CATEGORY AND PRODUCT TITLE -->
            <div class="row">
                <h1><?php echo strip_tags($product->localizedPropertyGet('title')) ?></h1>
                <a id="goBack"
                   href="<?= UtilsHttp::getSectionUrl('catalog', ['folderId' => UtilsHttp::getEncodedParam('folderId')]) ?>"
                   title="<?= Managers::literals()->get('BACK', 'Product') ?>">
                    &#60; <?= Managers::literals()->get('BACK', 'Product') ?></a>
            </div>

            <!-- PRODUCT DESCRIPTION & OTHERS AND SLIDER -->
            <div class="row">

                <!-- DESCRIPTION -->
                <div id="productDescription">
                    <h3 class="paragraph"><?php echo strip_tags($product->localizedPropertyGet('description')) ?></h3>

                    <p>
                        <span class="fontBold"><?php echo Managers::literals()->get('PRODUCT_REFERENCE', 'Product') ?>
                            :</span>
                        <span><?php echo $product->propertyGet('reference') ?></span>
                    </p>

                    <p>
                        <span class="fontBold"><?php echo Managers::literals()->get('PRODUCT_DIMENSIONS', 'Product') ?>
                            :</span>
                        <span><?php echo $product->propertyGet('dimensions') ?></span>
                    </p>

                    <p>
                        <span class="fontBold"><?php echo Managers::literals()->get('PRODUCT_PRICE', 'Product') ?>
                            :</span>
                        <span><?php echo $product->propertyGet('price') ?></span>
                    </p>
                </div>

                <!-- SLIDER -->
                <div id="slider" class="owl-carousel">
                    <?php
                    $pictures = $product->filesArrayGet();

                    foreach ($pictures as $p) {
                        echo '<div class="slide">';
                        echo '<a href="' . UtilsHttp::getPictureUrl($p->fileId) . '" title="' . $product->localizedPropertyGet('title') . '">';
                        echo '<img src="' . UtilsHttp::getPictureUrl($p->fileId, '380x280') . '" alt="' . $product->localizedPropertyGet('title') . '"></a>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>