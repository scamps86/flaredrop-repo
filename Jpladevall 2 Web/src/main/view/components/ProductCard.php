<?php

class ProductCard
{

    /**
     * @param $product
     *
     */
    public static function echoCard($product)
    {
        if ($product) {
            $url = UtilsHttp::getSectionUrl('product', ['objectId' => $product['objectId'], 'folderId' => UtilsDiskObject::firstFolderIdGet($product['folderIds'])]);
            $price = UtilsFormatter::currency(floatval($product['price']));
            $picture = UtilsDiskObject::firstFileGet($product['pictures']);
            $pictureUrl = '';

            $html = '<div class="productCard">';

            $html .= '<a class="productLinkable" href="' . $url . '">';
            if ($picture) {
                $pictureUrl = UtilsHttp::getPictureUrl($picture->fileId, '300x300');
                $html .= '<img class="productImage" src="' . $pictureUrl . '" alt="' . $product['title'] . '">';
            } else {
                $pictureUrl = UtilsHttp::getRelativeUrl('view/resources/images/shared/productNoImage.png');
                $html .= '<img class="productImage" src="' . $pictureUrl . '" alt="' . $product['title'] . '">';
            }
            $html .= '<p class="productTitle">' . $product['title'] . '</p>';
            $html .= '<p class="productPrice">' . $price . '</p></a>';

            // Hover
            $html .= '<div class="productHover transitionFast"><div class="productHoverInner transitionNormal">';
            $html .= '<a class="viewProductBtn" href="' . $url . '">' . Managers::literals()->get('VIEW_PRODUCT_DETAIL', 'Shared') . '</a>';
            $html .= '<button punits="1" pid="' . $product['objectId'] . '" purl="' . $pictureUrl . '" class="addToCartBtn">' . Managers::literals()->get('ADD_TO_CART', 'Shared') . '</button>';

            $html .= '</div></div></div>';

            echo $html;
        }
    }

}

?>