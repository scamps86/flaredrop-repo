<?php
// Auto select the first category
if ($cId == '') {
    $cId = $categories[0]['folderId'];
}

if ($products) {
    UtilsJavascript::newVar('PRODUCTS', $products->list);
    UtilsJavascript::echoVars();
}
?>


<section id="page" class="row">
    <div class="centered">

        <!-- CATEGORIES -->
        <nav id="topCategories" class="row">
            <?php
            if ($categories) {
                foreach ($categories as $c) {
                    if ($cId != '' && $cId == $c['folderId']) {
                        $subcategories = $c['child'];

                        if ($sId != '') {
                            foreach ($subcategories as $s) {
                                if ($sId == $s['folderId']) {
                                    $subcategories = $s['child'];
                                    break;
                                }
                            }
                        }
                    }

                    ?>
                    <a class="<?= $cId == $c['folderId'] ? 'selected' : '' ?>"
                       href="<?= UtilsHttp::getSectionUrl('products', ['c' => $c['folderId']], $c['name']) ?>"
                       title="<?= $c['name'] ?>"><?= $c['name'] ?></a>
                    <?php
                }
            }
            ?>
        </nav>

        <!-- SUBCATEGORIES OR PRODUCTS LISTS-->
        <?php
        if ($products == null) {
            // SUBCATEGORIES LIST
            echo '<div id="subcategoriesList" class="row">';

            if ($sId != '') {
                echo '<div id="back" class="row"><a href="' . UtilsHttp::getSectionUrl('products', ['c' => $cId]) . '" title="' . Managers::literals()->get('GO_BACK', 'Products') . '">&#60; ' . Managers::literals()->get('GO_BACK', 'Products') . '</a></div>';
            }

            if ($subcategories) {
                foreach ($subcategories as $s) {
                    if ($sId != '') {
                        $urlParams = ['c' => $cId, 'sc' => $sId, 'ssc' => $s['folderId']];
                    } else {
                        $urlParams = ['c' => $cId, 'sc' => $s['folderId']];
                    }

                    $picture = UtilsDiskObject::firstFileGet($s['pictures']);

                    if ($picture) {
                        ?>
                        <a href="<?= UtilsHttp::getSectionUrl('products', $urlParams, $s['name']) ?>"
                           class="transitionFast" title="<?= $s['name'] ?>">
                            <img src="<?= UtilsHttp::getPictureUrl($picture->fileId, '140x120') ?>"
                                 alt="<?= $s['name'] ?>"/>

                            <h3><?= $s['name'] ?></h3>
                        </a>
                        <?php
                    }
                }
            }
        } else {
            // PRODUCTS LIST
            echo '<div id="productsList" class="row"><div id="productsLeft">';
            echo '<h1 class="title">' . $subcategory->nameGet(WebConstants::getLanTag()) . '</h1>';

            foreach ($products->list as $p) {
                $price = floatval($p['price']) * ((WebConstants::IVA / 100) + 1);
                ?>
                <div class="productItem row">
                    <p class="productTitle titleProduct"><?= $p['index'] . ' - ' . $p['title'] ?></p>

                    <p class="productDescription"><?= $p['description'] ?></p>

                    <p class="productReference"><?= '<span>' . Managers::literals()->get('PRODUCT_REFERENCE', 'Shared') . ':</span> ' . $p['reference'] ?></p>

                    <p class="productPrice"><?= '<span>' . Managers::literals()->get('PRODUCT_PRICE', 'Shared') . ':</span> ' . UtilsFormatter::currency($price) . ' ' . Managers::literals()->get('IVA', 'Shared') ?></p>

                    <p class="productAddToCart"
                       pid="<?= $p['objectId'] ?>"
                       pprice="<?= $price ?>"
                       purl="<?= UtilsHttp::getSectionUrl('products', ['c' => $cId, 'sc' => $sId]) ?>"
                    ">
                    <input type="text" value="1"/>
                    <span><?= Managers::literals()->get('ADD_TO_CART', 'Products') ?></span></p>

                    <!-- Linked file -->
                    <?php
                    $file = UtilsDiskObject::firstFileGet($p['files']);

                    if ($file) {
                        ?>
                        <a class="productPdf" href="<?= UtilsHttp::getFileUrl($file->fileId) ?>" target="_blank">
                            <?= Managers::literals()->get('DOWNLOAD_PDF', 'Products') ?>
                        </a>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            echo '</div>';

            $picture = UtilsDiskObject::firstFileGet($subcategory->pictures);

            if ($picture) {
                ?>
                <div id="productsRight"><img dsrc="<?= UtilsHttp::getPictureUrl($picture->fileId) ?>"
                                             src="<?= UtilsHttp::getPictureUrl($picture->fileId) ?>"
                                             alt="<?= $subcategory->nameGet(WebConstants::getLanTag()) ?>"/></div>
                <?php
            }
        }
        echo '</div>';
        ?>
    </div>
</section>