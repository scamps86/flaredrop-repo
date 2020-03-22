<section class="content row">
    <div class="centered">
        <div id="logoColor" class="row">
            <img src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/quisom/pascuetLogoColor.png') ?>"
                 title="<?php echo WebConfigurationBase::$WEBSITE_TITLE ?>"
                 alt="<?php echo WebConfigurationBase::$WEBSITE_TITLE ?>"/>
        </div>
        <div id="container">
            <div id="mask"></div>
            <h1 class="fontTypeB"><?php echo Managers::literals()->get('TITLE', 'Quisom') ?></h1>

            <p><?php echo Managers::literals()->get('TEXT', 'Quisom') ?></p>
        </div>
    </div>
</section>