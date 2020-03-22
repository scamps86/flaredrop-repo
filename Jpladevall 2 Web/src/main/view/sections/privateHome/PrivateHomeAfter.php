<section class="section row">

    <!-- TOP SLIDER -->
    <figure class="row">
        <div id="privateHomeSlider" class="owl-carousel">
            <?php
            for ($i = 1; $i < 4; $i++) {
                ?>
                <div class="slide">
                    <img
                        src="<?= UtilsHttp::getRelativeUrl('view/resources/images/privateHome/banner' . $i . '.jpg') ?>"/>

                    <div class="sliderContent transitionNormal show">
                        <div class="centered">
                            <h2><?= Managers::literals()->get('BANNER_TITLE_' . $i, 'PrivateHome') ?></h2>
                            <p><?= Managers::literals()->get('BANNER_CONTENT_' . $i, 'PrivateHome') ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </figure>

    <!-- NEW PRODUCTS -->
    <figure class="row">
        <div id="newProducts" class="centered">
            <div id="newProductsLeft" class="productsBlueBox">
                <hr>
                <h2 class="fontBold"><?= Managers::literals()->get('NEW_PRODUCTS', 'PrivateHome') ?></h2>
                <p><?= Managers::literals()->get('NEW_PRODUCTS_CONTENT', 'PrivateHome') ?></p>
                <hr>
            </div>

            <div id="newProductsSlider" class="productsSlider owl-carousel">
                <?php
                foreach ($newProducts->list as $p) {
                    echo '<div class="slide">';
                    ProductCard::echoCard($p);
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </figure>

    <!-- 3 BLOCKS -->
    <figure class="row">
        <div id="privateHome3Blocks" class="centered">
            <nav>
                <a href="#">
                    <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/privateHome/b1.jpg') ?>" alt=""/>
                </a>
                <a href="#">
                    <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/privateHome/b2.jpg') ?>" alt=""/>
                </a>
                <a href="#">
                    <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/privateHome/b3.jpg') ?>" alt=""/>
                </a>
            </nav>
        </div>
    </figure>

    <!-- SHUFFLE PRODUCTS -->
    <figure class="row">
        <div id="shuffleProducts" class="centered">
            <div id="shuffleProductsSlider" class="productsSlider owl-carousel">
                <?php
                foreach ($shuffleProducts->list as $p) {
                    echo '<div class="slide">';
                    ProductCard::echoCard($p);
                    echo '</div>';
                }
                ?>
            </div>

            <div id="shuffleProductsRight" class="productsBlueBox">
                <hr>
                <h2 class="fontBold"><?= Managers::literals()->get('SHUFFLE_PRODUCTS', 'PrivateHome') ?></h2>
                <p><?= Managers::literals()->get('SHUFFLE_PRODUCTS_CONTENT', 'PrivateHome') ?></p>
                <hr>
            </div>
        </div>
    </figure>

</section>