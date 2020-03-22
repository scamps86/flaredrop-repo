<section id="content" class="row">
    <div class="centered">

        <!-- CONTENTS -->
        <div id="contentContainer" class="row">
            <h1 class="title fontThin"><?php echo Managers::literals()->get('TITLE', 'We') ?></h1>

            <p class="description"><?php echo Managers::literals()->get('DESCRIPCIO_1', 'We') ?></p>
            <img src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/we/we-schema.png') ?>"
                 alt="<?php echo Managers::literals()->get('TITLE', 'We') ?>"/>

            <p class="description"><?php echo Managers::literals()->get('DESCRIPCIO_2', 'We') ?></p>

            <h2 class="fontBold"><?php echo Managers::literals()->get('FRASE', 'We') ?></h2>
        </div>
    </div>
</section>