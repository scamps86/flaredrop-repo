<figure class="relatedBrands row">
    <div class="relatedBrandsSlider centered">
        <?php
        foreach (explode(';', WebConstants::BRANDS) as $b) {
            ?>
            <div class="slide">
                <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/brands/' . $b) ?>" alt="">
            </div>
            <?php
        }
        ?>
    </div>
</figure>