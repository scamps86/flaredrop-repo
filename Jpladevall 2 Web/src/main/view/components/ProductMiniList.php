<?php

class ProductMiniList
{

    /**
     * @param $products
     * @param $title
     *
     */
    public static function echoList($products, $title = '')
    {
        if ($products) {
            ?>

            <!-- RELATED PRODUCTS -->
            <div class="productsMiniList">
                <div class="miniListTitle">
                    <h2><?= $title ?></h2>
                </div>

                <?php
                foreach ($products->list as $p) {
                    $price = UtilsFormatter::currency(floatval($p['price']));
                    $picture = UtilsDiskObject::firstFileGet($p['pictures']);

                    echo '<a class="productMiniListCard" href="' . UtilsHttp::getSectionUrl('product', ['objectId' => $p['objectId'], 'folderId' => UtilsDiskObject::firstFolderIdGet($p['folderIds'])]) . '">';

                    if ($picture) {
                        echo '<img class="productImage" src="' . UtilsHttp::getPictureUrl($picture->fileId, '300x300') . '" alt="' . $p['title'] . '">';
                    } else {
                        echo '<img class="productImage" src="' . UtilsHttp::getRelativeUrl('view/resources/images/shared/productNoImage.png') . '" alt="' . $p['title'] . '">';
                    }
                    echo '<p class="productTitle">' . $p['title'] . '</p>';
                    echo '<p class="productPrice">' . $price . '</p></a>';
                }
                ?>
            </div>
            <?php
        }
    }

}

?>