<section class="content row">
    <div class="centered">

        <!-- PRODUCT CATEGORIES -->
        <?php
        include_once PATH_VIEW . '/sections/shared/CategoriesMenu.php';
        ?>

        <!-- PRODUCTS -->
        <div id="productsContainer" class="row">
            <?php
            foreach ($products->list as $p) {
                $picture = UtilsDiskObject::firstFileGet($p['pictures']);

                if ($picture != null) {
                    ?>
                    <a href="<?php echo UtilsHttp::getSectionUrl('producte', ['productId' => $p['objectId']], $p['title']) ?>"
                       class="transitionFast">
                        <div>
                            <h3 class="title fontTypeB"><?php echo $p['title'] ?></h3>
                            <h4 class="subtitle fontColorGrey"><?php echo $p['subtitle'] ?></h4>
                        </div>
                        <figure>
                            <img src="<?php echo UtilsHttp::getPictureUrl($picture->fileId, '150x150')?>" alt="<?php echo $p['title'] ?>" />
                        </figure>
                    </a>
                <?php
                }
            }

            if ($products->totalItems <= 0) {
                echo '<p>' . Managers::literals()->get('NO_PRODUCTS', 'Productes') . '</p>';
            }
            ?>
        </div>

    </div>
</section>