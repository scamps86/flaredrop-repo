<style>
    body {
        background-color: #fff;
    }
</style>

<section class="section row">

    <div style="position: relative;" class="centered">

        <!-- SUBTEXT -->
        <div id="subtitles">
            <h4 class="fontBold"><?= Managers::literals()->get('SUBTITLE_00', 'Home') ?></h4>
            <h5><?= Managers::literals()->get('SUBTITLE_01', 'Home') ?></h5>
        </div>

        <!-- DOGS -->
        <img id="lrBoxDogs" src="<?= UtilsHttp::getRelativeUrl('view/resources/images/home/dogs.png') ?>"
             title="<?= WebConfigurationBase::$WEBSITE_TITLE ?>">

        <div id="lrBox">
            <!-- REGISTER MODULE -->
            <div id="rBox" class="boxContainer">
                <h2><?= Managers::literals()->get('REGISTER_TITLE', 'Home') ?></h2>
                <p id="registerContent"><?= Managers::literals()->get('REGISTER_CONTENT', 'Home') ?></p>

                <?php
                $form = new ComponentForm(UtilsHttp::getWebServiceUrl('UserJoin'), 'userJoinForm');

                // ACCESS DATA
                $form->addContent('<p class="formSection">' . Managers::literals()->get('ACCESS_DATA', 'Home') . '</p>');
                $form->addInput('text', 'frmEmail', 'fill;email;repeat', Managers::literals()->get('FRM_EMAIL_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_EMAIL', 'Shared') . ' *', 'AND', '', '', '', 'e1');
                $form->addInput('text', '', 'repeat', Managers::literals()->get('FRM_EMAIL_REPEAT_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_EMAIL_REPEAT', 'Shared') . ' *', 'AND', '', '', '', 'e1');
                $form->addInput('password', 'frmPassword', 'fill;password;repeat', Managers::literals()->get('FRM_PASSWORD_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PASSWORD', 'Shared') . ' *', 'AND', '', '', '', 'p1');
                $form->addInput('password', '', 'repeat', Managers::literals()->get('FRM_PASSWORD_REPEAT_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PASSWORD_REPEAT', 'Shared') . ' *', 'AND', '', '', '', 'p1');

                // PERSONAL DATA
                $form->addContent('<p class="formSection">' . Managers::literals()->get('PERSONAL_DATA', 'Home') . '</p>');
                $form->addInput('text', 'frmFiscalName', 'fill', Managers::literals()->get('FRM_FISCAL_NAME_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_FISCAL_NAME', 'Shared') . ' *', 'AND');
                $form->addInput('text', 'frmShopName', 'fill', Managers::literals()->get('FRM_SHOP_NAME_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_SHOP_NAME', 'Shared') . ' *', 'AND');
                $form->addInput('text', 'frmNIFCIF', 'fill', Managers::literals()->get('FRM_NIFCIF_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_NIFCIF', 'Shared') . ' *', 'AND');
                $form->addInput('text', 'frmName', 'fill', Managers::literals()->get('FRM_NAME_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_NAME', 'Shared') . ' *', 'AND');
                $form->addInput('text', 'frmLocation', 'fill', Managers::literals()->get('FRM_LOCATION_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_LOCATION', 'Shared') . ' *', 'AND');
                $form->addInput('text', 'frmCountry', 'fill', Managers::literals()->get('FRM_COUNTRY_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_COUNTRY', 'Shared') . ' *', 'AND');
                $form->addInput('text', 'frmRegion', 'fill', Managers::literals()->get('FRM_REGION_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_REGION', 'Shared') . ' *', 'AND');
                $form->addInput('text', 'frmCity', 'fill', Managers::literals()->get('FRM_CITY_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_CITY', 'Shared') . ' *', 'AND');
                $form->addInput('text', 'frmCp', 'fill', Managers::literals()->get('FRM_PC_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PC', 'Shared') . ' *', 'AND');
                $form->addInput('text', 'frmPhone', 'fill;phone', Managers::literals()->get('FRM_PHONE_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PHONE', 'Shared') . ' *', 'AND');
                $form->addInput('text', 'frmMobile', 'phone', Managers::literals()->get('FRM_MOBILE_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_MOBILE', 'Shared'), 'AND');
                $form->addSwitchComponent('frmRe', '', '', Managers::literals()->get('FRM_RE', 'Shared'));

                // SUBMIT
                $form->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('FRM_JOIN', 'Shared'));
                $form->echoComponent();
                ?>
                <button id="userJoinFormSubmit"><?= Managers::literals()->get('FRM_JOIN', 'Shared') ?></button>
            </div>


            <!-- LOGIN MODULE-->

            <div id="lModule" class="boxContainer">
                <h2><?= Managers::literals()->get('LOGIN_TITLE', 'Home') ?></h2>

                <p><?= Managers::literals()->get('LOGIN_ENTER_CREDENTIALS', 'Home') ?></p>

                <?php
                $form = new ComponentForm(UtilsHttp::getWebServiceUrl('UserLogin'), 'userLoginForm');
                $form->addInput('hidden', 'diskId', '', '', '', '', '', 2);
                $form->addInput('text', 'xLOG1', 'fill;email',
                    Managers::literals()->get('FRM_EMAIL_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'),
                    Managers::literals()->get('FRM_EMAIL', 'Shared') . ' *');
                $form->addInput('password', 'xLOG2', 'fill;password',
                    Managers::literals()->get('FRM_PASSWORD_ERROR', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'),
                    Managers::literals()->get('FRM_PASSWORD', 'Shared') . ' *');
                $form->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('FRM_LOGIN', 'Shared'));
                $form->echoComponent();
                ?>
            </div>
        </div>
    </div>

    <!-- 3 BLOCKS -->
    <div id="blocks" class="row">
        <div class="centered">

            <div class="block">
                <img
                    src="<?= UtilsHttp::getRelativeUrl('view/resources/images/home/blcon1.png') ?>"
                    alt="<?= Managers::literals()->get('BLOCK_TITLE1', 'Home') ?>">
                <p>
                    <span class="title"><?= Managers::literals()->get('BLOCK_TITLE1', 'Home') ?></span>
                    <span class="content"><?= Managers::literals()->get('BLOCK_CONTENT1', 'Home') ?></span>
                </p>
            </div>

            <div class="block">
                <img
                    src="<?= UtilsHttp::getRelativeUrl('view/resources/images/home/blcon2.png') ?>"
                    alt="<?= Managers::literals()->get('BLOCK_TITLE2', 'Home') ?>">
                <p>
                    <span class="title"><?= Managers::literals()->get('BLOCK_TITLE2', 'Home') ?></span>
                    <span class="content"><?= Managers::literals()->get('BLOCK_CONTENT2', 'Home') ?></span>
                </p>
            </div>

            <div class="block">
                <img
                    src="<?= UtilsHttp::getRelativeUrl('view/resources/images/home/blcon3.png') ?>"
                    alt="<?= Managers::literals()->get('BLOCK_TITLE3', 'Home') ?>">
                <p>
                    <span class="title"><?= Managers::literals()->get('BLOCK_TITLE3', 'Home') ?></span>
                    <span class="content"><?= Managers::literals()->get('BLOCK_CONTENT3', 'Home') ?></span>
                </p>
            </div>

        </div>
    </div>

    <!-- DISTRIBUIDOR OFICIAL -->
    <div id="brands" class="row">
        <div class="centered">
            <h3><?= Managers::literals()->get('BRANDS_TITLE1', 'Home') ?></h3>
            <?php
            for ($i = 0; $i < 16; $i++) {
                ?>
                <a href="#">
                    <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/home/hl' . $i . '.jpg') ?>" alt="">
                </a>
                <?php
            }
            ?>
        </div>
        <div class="centered">
            <h3><?= Managers::literals()->get('BRANDS_TITLE2', 'Home') ?></h3>
            <?php
            for ($i = 0; $i < 10; $i++) {
                ?>
                <a href="#">
                    <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/home/hl' . $i . '.jpg') ?>" alt="">
                </a>
                <?php
            }
            ?>
        </div>
    </div>

    <p id="homeBottom"><?= Managers::literals()->get('BOTTOM_TEXT', 'Home') ?></p>

</section>