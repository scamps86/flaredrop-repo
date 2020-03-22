<section id="page" class="row">

    <!-- TOP SLIDER -->
    <figure id="sliderContainer" class="row">
        <div class="centered">

            <div id="slider" class="owl-carousel">
                <?php
                foreach ($presentations->list as $p) {
                    $pic = UtilsDiskObject::firstFileGet($p['pictures']);

                    if ($pic) {
                        ?>

                        <div class="slide">
                            <img src="<?= UtilsHttp::getPictureUrl($pic->fileId, '992x419') ?>"
                                 title="<?= WebConfigurationBase::$WEBSITE_TITLE ?>"/>
                        </div>

                        <?php
                    }
                }
                ?>
            </div>

        </div>
    </figure>

    <!-- PRESENTATION -->
    <div id="presentationContainer" class="row">
        <div class="centered">
            <h1 class="title1"><?= Managers::literals()->get('TITLE_1', 'Home') ?></h1>

            <p><?= Managers::literals()->get('DESCRIPTION1', 'Home') ?></p>
        </div>
    </div>

    <!-- AUCTION PRODUCTS -->
    <div id="auctionProductsContainer" class="row">
        <div class="centered">

            <!-- No products in auction -->
            <?php
            if ($schedules != null) {
                echo '<div id="sliderSchedules" class="owl-carousel">';

                foreach ($schedules->list as $s) {
                    $pic = UtilsDiskObject::firstFileGet($s['pictures']);

                    if ($pic) {
                        ?>
                        <div class="slide">
                            <img src="<?= UtilsHttp::getPictureUrl($pic->fileId, '992x220') ?>"
                                 title="<?= $s['title'] ?>"/>
                        </div>
                        <?php
                    }
                }
                echo '</div>';
            }
            ?>

            <ul id="inAuctionProductsContainer" class="row productsList">
                <?php
                $i = 0;

                foreach ($inAuctionProducts->list as $p) {
                    $picture = UtilsDiskObject::firstFileGet($p['pictures']);

                    if (!isset($p['auctionExpireDate'])) {
                        $p['auctionExpireDate'] = UtilsDate::operate('SECONDS', UtilsDate::create(), $p['initialTime']);
                    }

                    $auctionExpireTime = UtilsDate::toTimestamp($p['auctionExpireDate']) - UtilsDate::toTimestamp('');
                    $lastBid = isset($p['productLastBid']) ? $p['productLastBid'] : "";
                    ?>

                    <li id="pid-<?= $p['objectId'] ?>"
                        pid="<?= $p['objectId'] ?>"
                        pprice="<?= $p['price'] ?>"
                        pcurrentprice="<?= $p['currentPrice'] ?>"
                        pname="<?= $p['name'] ?>"
                        pauctionexpiretime="<?= $auctionExpireTime ?>"
                        <?= $i % 3 == 1 ? 'class="center"' : '' ?>>

                        <div class="info"></div>
                        <h2 class="productName"><?= $p['name'] ?></h2>

                        <a class="productImage"
                           href="<?= UtilsHttp::getSectionUrl('product', ['id' => $p['objectId']]) ?>"
                           title="<?= $p['name'] ?>">
                            <?php if ($picture != null) : ?>
                                <img src="<?= UtilsHttp::getPictureUrl($picture->fileId, '305x250') ?>"
                                     alt="<?= $p['name'] ?>"/>
                            <?php endif ?>
                        </a>

                        <div class="productPrices">
                            <p class="productCurrentPrice"><?= UtilsFormatter::currency($p['currentPrice']) ?></p>

                            <p class="productPrice"><?= Managers::literals()->get('PRODUCT_VALUE', 'Shared') . ' ' . UtilsFormatter::currency($p['price']) ?></p>
                        </div>

                        <p class="productRemainingTime"></p>

                        <p class="productLastBid">
                            <span></span><?= Managers::literals()->get('PRODUCT_LAST_BID', 'Shared') ?></p>

                        <?php
                        if (USER_LOGGED) {
                            ?>
                            <button
                                class="productPlaceBid"><?= Managers::literals()->get('PLACE_BID', 'Shared') ?></button>
                            <?php
                        }
                        ?>

                        <p class="productBidBans row"><?= Managers::literals()->get('PRODUCT_BID_BANS', 'Shared') . ': <span class="fontBold">' . $p['bidBans'] . '</span>' ?></p>
                    </li>

                    <?php
                    $i++;
                }
                ?>
            </ul>
        </div>
    </div>

    <!-- NEXT PRODUCTS -->
    <?php if ($nextProducts->totalItems > 0) : ?>
        <div id="nextProductsContainer" class="row">
            <div class="centered">
                <h2 class="title1"><?= Managers::literals()->get('TITLE_2', 'Home') ?></h2>

                <p class="description"><?= Managers::literals()->get('DESCRIPTION2', 'Home') ?></p>

                <ul id="nextProductsContainer" class="row productsList">
                    <?php
                    $i = 0;

                    foreach ($nextProducts->list as $p) {
                        $picture = UtilsDiskObject::firstFileGet($p['pictures']);
                        ?>

                        <li class="next<?= $i % 3 == 1 ? ' center' : '' ?>">
                            <div class="info"></div>
                            <h2 class="productName"><?= $p['name'] ?></h2>

                            <a class="productImage"
                               title="<?= $p['name'] ?>">
                                <?php if ($picture != null) : ?>
                                    <img src="<?= UtilsHttp::getPictureUrl($picture->fileId, '305x250') ?>"
                                         alt="<?= $p['name'] ?>"/>
                                <?php endif ?>
                            </a>

                            <div class="productPrices">
                                <p class="productPrice"><?= Managers::literals()->get('PRODUCT_VALUE', 'Shared') . ' ' . UtilsFormatter::currency($p['price']) ?></p>
                            </div>
                        </li>

                        <?php
                        $i++;
                    }
                    ?>
                </ul>
            </div>
        </div>
    <?php endif ?>
</section>