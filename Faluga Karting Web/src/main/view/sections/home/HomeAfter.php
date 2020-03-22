<section id="page" class="row">
    <div class="centered">

        <!-- TOP SLIDER -->
        <figure class="row">
            <div id="slider" class="owl-carousel">
                <?php
                foreach ($presentations->list as $p) {
                    $picture = UtilsDiskObject::firstFileGet($p['pictures']);
                    $pictureUrl = $picture == null ? '' : UtilsHttp::getPictureUrl($picture->fileId, '600x420');
                    ?>
                    <div class="slide"
                         style="<?php echo $pictureUrl == '' ? '' : 'background-image: url(' . $pictureUrl . ')' ?>">
                        <div>
                            <h2><?= $p['title'] ?></h2>

                            <h3><?= $p['subtitle'] ?></h3>
                            <h4><?= $p['description'] ?></h4>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </figure>

        <!-- CONTENTS CONTAINER -->
        <div id="contentsContainer" class="row">
            <!-- TITLE & DESCRIPTION -->
            <div id="titleDescriptionContainer" class="row">
                <h1 class="title"><?= Managers::literals()->get('TITLE', 'Home') ?></h1>

                <p><?= Managers::literals()->get('DESCRIPTION', 'Home') ?></p>
            </div>

            <!-- PRODUCTS -->
            <div id="productsContainer" class="row">
                <h2 class="title"><?= Managers::literals()->get('PRODUCTS', 'Home') ?></h2>

                <ul class="row">
                    <?php
                    foreach ($products->list as $p) {
                        $picture = UtilsDiskObject::firstFileGet($p['pictures']);
                        if ($picture != null) {
                            ?>
                            <li class="productItem transitionFast"
                                full-img="<?= UtilsHttp::getPictureUrl($picture->fileId, '600x420') ?>">
                                <img src="<?= UtilsHttp::getPictureUrl($picture->fileId, '140x120') ?>"
                                     alt="<?= $p['title'] ?>"/>

                                <div>
                                    <h5 class="titleProduct"><?= $p['title'] ?></h5>

                                    <p class="productReference"><?= '<span>' . Managers::literals()->get('PRODUCT_REFERENCE', 'Shared') . ':</span> ' . $p['reference'] ?></p>

                                    <p class="productPrice"><?= '<span>' . Managers::literals()->get('PRODUCT_PRICE', 'Shared') . ':</span> ' . UtilsFormatter::currency(floatval($p['price']) * ((WebConstants::IVA / 100) + 1)) . ' ' . Managers::literals()->get('IVA', 'Shared') ?></p>
                                </div>
                            </li>
                        <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>