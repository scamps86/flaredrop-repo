<section id="page" class="row">
    <div class="centered">

        <div class="left">
            <h1 class="title"><?= Managers::literals()->get('TITLE_01', 'We') ?></h1>

            <p class="description"><?= Managers::literals()->get('TEXT_01', 'We') ?></p>
        </div>

        <!-- SLIDER -->
        <figure class="right">
            <div id="slider" class="owl-carousel">
                <?php
                for ($i = 1; $i < 7; $i++) {
                    ?>
                    <div class="slide">
                        <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/we/falugaWe' . $i . '.jpg') ?>"
                             alt="<?= Managers::literals()->get('TITLE_01', 'We') ?>"/>
                    </div>
                <?php
                }
                ?>
            </div>
        </figure>

    </div>
</section>