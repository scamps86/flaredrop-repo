<section id="page" class="row">
    <div class="centered">

        <!-- CONTAINER LEFT -->
        <div id="containerLeft">
            <!-- SLIDER -->
            <div id="slider">
                <?php foreach ($product->filesArrayGet() as $picture) : ?>
                    <div class="slide">
                        <img src="<?= UtilsHttp::getPictureUrl($picture->fileId, '545x545') ?>"
                             alt="<?= $product->localizedPropertyGet('name') ?>"/>
                    </div>
                <?php endforeach ?>
            </div>

            <!-- SOCIAL NETWORKS -->
            <div id="socialNetworks"></div>
        </div>

        <!-- CONTAINER RIGHT -->
        <div id="containerRight">

            <!-- PRODUCT DETAILS -->
            <div id="productContainer" class="row"
                 pid="<?= $product->objectId ?>"
                 pprice="<?= $product->propertyGet('price') ?>"
                 pcurrentprice="<?= $product->propertyGet('currentPrice') ?>"
                 pname="<?= $product->localizedPropertyGet('name', WebConstants::getLanTag()) ?>"
                 pauctionexpiretime="<?= $auctionExpireTime ?>">
                <h2 class="title1 row"><?= $product->localizedPropertyGet('name') ?></h2>

                <div class="productPrices row">
                    <p class="productCurrentPrice"><?= UtilsFormatter::currency($product->propertyGet('currentPrice')) ?></p>

                    <p><?= Managers::literals()->get('PRODUCT_VALUE', 'Shared') ?> <span
                            class="productPrice"><?= UtilsFormatter::currency($product->propertyGet('price')) ?></span>

                        <span class="productBuyNow"><?= Managers::literals()->get('PRODUCT_BUY_NOW', 'Shared') ?></span>
                    </p>
                </div>

                <p class="productRemainingTime" row></p>

                <p class="productLastBid row">
                    <span></span><?= Managers::literals()->get('PRODUCT_LAST_BID', 'Shared') ?>
                </p>

                <?php
                if (USER_LOGGED) {
                    ?>
                    <button
                        class="productPlaceBid row"><?= Managers::literals()->get('PLACE_BID', 'Shared') ?></button>
                <?php
                }
                ?>

                <p class="productBidBans row"><?= Managers::literals()->get('PRODUCT_BID_BANS', 'Shared') . ': <span class="fontBold">' . $product->propertyGet('bidBans') . '</span>' ?></p>
            </div>

            <!-- PRODUCT LAST BIDS -->
            <div id="productLastBidsContainer" class="row">
                <?php

                $tabNavigator = new ComponentTabNavigator('tn1');
                $tabNavigator->addTab(Managers::literals()->get('BID_HISTORY', 'Product'), '<p id="bidHeader" class="row"><span class="bidUserNickTitle fontBold">' . Managers::literals()->get('BID_USER_NICK', 'Product') . '</span><span class="bidUserNickQuantity fontBold">' . Managers::literals()->get('BID_QUANTITY', 'Product') . '</span></p><ul id="productLastBidsList" class="row"></ul>');
                $tabNavigator->echoComponent();

                ?>
            </div>
        </div>

        <div id="productInfo" class="row">
            <p class="productInfo"><?= Managers::literals()->get('PRODUCT_INFO', 'Product') ?></p>

            <h3 class="productTitle"><?= $product->localizedPropertyGet('name') ?></h3>

            <p class="productDescription"><?= $product->localizedPropertyGet('description') ?></p>
        </div>

    </div>
</section>