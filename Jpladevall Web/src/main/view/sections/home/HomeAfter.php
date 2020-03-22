<section class="row">

    <!-- CAT -->
    <div id="catContainer" class="row">
        <div class="centered">
            <h1><?= Managers::literals()->get('CAT_TITLE', 'Home'); ?></h1>

            <h2 class="fontLight"><?= Managers::literals()->get('CAT_SUBTITLE', 'Home'); ?></h2>
            <a class="fontLight" href="<?= UtilsHttp::getSectionUrl('Home') . '#form' ?>">
                <?= Managers::literals()->get('CAT_SEND_EMAIL', 'Home'); ?>
            </a>
        </div>
    </div>

    <!-- LIST -->
    <div class="row">
        <ul id="homeList" class="centered">
            <?php
            $i = 1;
            for ($i; $i <= 3; $i++) {
                ?>
                <li>
                    <img class="boxShadow"
                         src="<?= UtilsHttp::getRelativeUrl('view/resources/images/home/list' . $i . '.jpg') ?>"
                         alt="<?= Managers::literals()->get('LIST_TITLE' . $i, 'Home') ?>">

                    <h3><?= Managers::literals()->get('LIST_TITLE' . $i, 'Home') ?></h3>
                    <h4 class="fontLight"><?= Managers::literals()->get('LIST_DESCRIPTION' . $i, 'Home') ?></h4>

                </li>
                <?php
            }

            for ($i = 4; $i <= 6; $i++) {
                ?>
                <li>
                    <img class="boxShadow"
                         src="<?= UtilsHttp::getRelativeUrl('view/resources/images/home/list' . $i . '.jpg') ?>"
                         alt="<?= Managers::literals()->get('LIST_TITLE' . $i, 'Home') ?>">

                    <?php
                    if ($i === 4) {
                        ?>
                        <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/home/nutrican.jpg') ?>"
                             alt="Nutrican" title="Nutrican">
                        <?php
                    } else {
                        ?>
                        <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/home/canvit.jpg') ?>"
                             alt="Canvit" title="Canvit">
                        <?php
                    }
                    ?>


                </li>
                <?php
            }
            ?>
        </ul>
    </div>


    <!-- TITLE CUIDADO DE LOS ANIMALES -->
    <div class="row">
        <div class="centered">
            <div class="title">
                <span></span>

                <h2><?= Managers::literals()->get('TITLE_2', 'Home') ?>
            </div>
        </div>
    </div>

    <div class="row" id="cat2Content">
        <div class="centered" style="overflow: visible">
            <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/home/cat2.jpg') ?>"
                 alt="<?= Managers::literals()->get('TITLE_2', 'Home') ?>">

            <p class="fontThin"><?= Managers::literals()->get('CONTENT_2', 'Home') ?></p>
        </div>
    </div>

    <!-- CONTACTA-->
    <div class="row">
        <div class="centered">
            <div class="title">
                <span></span>

                <h2><?= Managers::literals()->get('CONTACT_US', 'Home') ?></h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="centered">

            <div id="gm"></div>

            <div id="form">
                <?php
                $form = new ComponentForm(UtilsHttp::getWebServiceUrl('ContactFormSend'), 'contactForm');
                $form->addInput('text', 'frmName', 'fill', Managers::literals()->get('FRM_ERROR_NAME', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_NAME', 'Shared') . ' *');
                $form->addInput('text', 'frmEmail', 'email', Managers::literals()->get('FRM_ERROR_EMAIL', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_EMAIL', 'Shared') . ' *');
                $form->addInput('text', 'frmPhone', 'phone', Managers::literals()->get('FRM_ERROR_PHONE', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PHONE', 'Shared') . ' *');
                $form->addTextArea('frmMessage', 'fill', Managers::literals()->get('FRM_ERROR_MESSAGE', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_MESSAGE', 'Shared') . ' *');
                $form->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('FRM_SEND', 'Shared'));
                $form->echoComponent();
                ?>
            </div>
        </div>
    </div>

</section>