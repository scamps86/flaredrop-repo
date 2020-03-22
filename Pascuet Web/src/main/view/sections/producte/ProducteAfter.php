<section class="content row">
    <div class="centered">

        <!-- PRODUCT CATEGORIES -->
        <?php
        include_once PATH_VIEW . '/sections/shared/CategoriesMenu.php';
        ?>

        <!-- PRODUCT -->
        <div id="containerLeft">
            <div class="row">
                <h1 class="fontTypeB"><?php echo $product->localizedPropertyGet('title') ?></h1>
                <h2 class="fontColorGold"><?php echo $product->localizedPropertyGet('subtitle') ?></h2>
            </div>

            <p id="productDescription"><?php echo $product->localizedPropertyGet('description') ?></p>

            <?php
            if ($product->propertyGet('price') != '') {
                ?>
                <p id="productPrice"><span
                        class="fontBold"><?php echo Managers::literals()->get('PRICE', 'Producte') ?>
                        :</span> <?php echo $product->propertyGet('price') ?>
                </p>
            <?php
            }
            ?>

            <a class="buyBtn button" href="<?php echo UtilsHttp::getSectionUrl('contacte') ?>"
               title="<?php echo Managers::literals()->get('BUY_NOW', 'Shared') ?>">
                <?php echo Managers::literals()->get('BUY_NOW', 'Producte') ?>
            </a>
        </div>

        <!-- SLIDER -->
        <figure id="containerRight">
            <div id="slider">
                <?php
                foreach ($pictures as $p) {
                    ?>
                    <a class="slide" href="<?php echo UtilsHttp::getPictureUrl($p->fileId) ?>">
                        <img class="slide" src="<?php echo UtilsHttp::getPictureUrl($p->fileId, '400x400') ?>"
                             alt="<?php $product->localizedPropertyGet('title') ?>"/>
                    </a>
                <?php
                }
                ?>
            </div>

            <a class="buyBtn button" href="<?php echo UtilsHttp::getSectionUrl('contacte') ?>"
               title="<?php echo Managers::literals()->get('BUY_NOW', 'Shared') ?>">
                <?php echo Managers::literals()->get('BUY_NOW', 'Producte') ?>
            </a>
        </figure>

    </div>
</section>