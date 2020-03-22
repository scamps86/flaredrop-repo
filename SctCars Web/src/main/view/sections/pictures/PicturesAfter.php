<section id="pictureContents" class="content row">
    <div class="centered">

        <div class="row">
            <figure id="slider">

            <?php
                for ($i = 0; $i < 9; $i++) {
                    ?>
                    <div class="slider">
                        <img
                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/pictures/media_0' . $i . '.jpg') ?>"
                            title="<?php echo WebConfigurationBase::$WEBSITE_TITLE ?>"/>
                    </div>
                <?php
                }
                ?>

            </figure>
        </div>

    </div>
</section>