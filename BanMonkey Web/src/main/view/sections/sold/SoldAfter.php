<section id="page" class="row">

    <!-- TOP TITLE -->
    <div id="presentationContainer" class="row">
        <div class="centered">
            <h1 class="title1"><?= Managers::literals()->get('TITLE_1', 'Sold') ?></h1>

            <p><?= Managers::literals()->get('TOP_TEXT1', 'Sold') ?></p><br>

            <p class="fontBold"><?= Managers::literals()->get('TOP_TEXT2', 'Sold') ?></p><br>

            <p><?= Managers::literals()->get('TOP_TEXT3', 'Sold') ?></p>
        </div>
    </div>

    <!-- SOLD ITEMS LIST -->
    <div class="row">
        <div class="centered">
            <ul class="row productsList">
                <?php
                $i = 0;

                foreach ($products->list as $p) {
                    $picture = UtilsDiskObject::firstFileGet($p['pictures']);
                    ?>

                    <li class="sold<?= $i % 3 == 1 ? ' center' : '' ?>">
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

            <!-- PAGINATION -->
            <?php
            $pagination = new ComponentPagesNavigator($products->totalPages);
            $pagination->echoComponent();
            ?>

        </div>
    </div>

    <!-- CUSTOMERS -->
    <div id="customersContainer" class="row">
        <div class="centered">
            <h2 class="title1"><?= Managers::literals()->get('TITLE_2', 'Sold') ?></h2>

            <p class="description"><?= Managers::literals()->get('TEXT2', 'Sold') ?></p>

            <ul id="customersList">
                <?php
                $i = 0;

                foreach ($customers->list as $c) {
                    $picture = UtilsDiskObject::firstFileGet($c['pictures']);
                    ?>
                    <li class="next<?= $i % 3 == 1 ? ' center' : '' ?>">
                        <?php if ($picture != null) : ?>
                            <img src="<?= UtilsHttp::getPictureUrl($picture->fileId, '305x250') ?>"
                                 alt="<?= $c['title'] ?>"/>
                        <?php endif ?>

                        <h3><?= $c['title'] ?></h3>

                        <p><?= $c['description'] ?></p>
                    </li>

                    <?php
                    $i++;
                }
                ?>
            </ul>

            <!-- PAGINATION -->
            <?php
            $pagination = new ComponentPagesNavigator($customers->totalPages, '', 5, '|', 'pageC');
            $pagination->echoComponent();
            ?>
        </div>
    </div>

    <!-- BOTTOM BANNER -->
    <div class="centered" id="bottomBanner">

        <a href="<?= UtilsHttp::getSectionUrl('help') ?>"
           title="<?= Managers::literals()->get('MAIN_MENU_HELP', 'Shared') ?>">
            <div id="slider" class="owl-carousel">
                <?php
                foreach ($presentations->list as $p) {
                    $pic = UtilsDiskObject::firstFileGet($p['pictures']);

                    if ($pic) {
                        ?>

                        <div class="slide">
                            <img src="<?= UtilsHttp::getPictureUrl($pic->fileId, '992x220') ?>"
                                 title="<?= WebConfigurationBase::$WEBSITE_TITLE ?>"/>
                        </div>

                    <?php
                    }
                }
                ?>
            </div>
        </a>
    </div>
</section>