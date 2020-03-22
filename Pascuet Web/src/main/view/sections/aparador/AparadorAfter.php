<section class="content row">
    <div class="centered">

        <!-- TOP SLIDER -->
        <figure class="row">
            <div id="slider" class="owl-carousel">
                <?php
                foreach ($presentations->list as $p) {
                    $picture = UtilsDiskObject::firstFileGet($p['pictures']);

                    if ($picture != null) {
                        ?>
                        <article class="slide">
                            <div class="sliderLeft">
                                <h2 class="fontTypeA"><?php echo $p['title'] ?></h2>

                                <h3 class="fontThin"><?php echo $p['subtitle'] ?></h3>
                                <a href="<?php echo UtilsHttp::getSectionUrl('productes') ?>"
                                   class="button"><?php echo Managers::literals()->get('GO_TO_CATALOG', 'Aparador') ?></a>
                            </div>

                            <img class="sliderRight"
                                 src="<?php echo UtilsHttp::getPictureUrl($picture->fileId, '600x470') ?>"
                                     alt="<?php echo $p['title'] ?>">
                        </article>
                    <?php
                    }
                }
                ?>
            </div>
        </figure>

        <!-- PRODUCTS -->
        <div id="productsContainer" class="row">
            <?php
            $i = 0;

            foreach ($products->list as $p) {
                $picture = UtilsDiskObject::firstFileGet($p['pictures']);

                if ($picture != null) {
                    ?>
                    <a href="<?php echo UtilsHttp::getSectionUrl('producte', ['productId' => $p['objectId']], $p['title']) ?>"
                       class="<?php echo $i % 2 != 0 ? 'pair' : '' ?> transitionFast">
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
                $i++;
            }
            ?>
        </div>
    </div>
</section>