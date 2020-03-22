<?php

// Get the news
$filter = new VoSystemFilter();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setPropertyMatch('visible', '1');
$filter->setRandom();

$videos = SystemDisk::objectsGet($filter, 'video');

?>

<section id="footer" class="row">
    <div class="centered">

        <!-- FOOTER TOP -->
        <div id="footerTop" class="row">

            <!-- VIDEOS SLIDERA-->
            <ul id="footerVideos">
                <?php foreach ($videos->list as $v) : ?>
                    <li>
                        <?= $v['url'] ?>
                    </li>
                <?php endforeach ?>
            </ul>

            <!-- OTHERS -->
            <div id="footerOthers">
                <a id="listenUs" class="fontBold" href="<?= UtilsHttp::getSectionUrl('discography') ?>">
                    <?= Managers::literals()->get('FOOTER_LISTEN_US', 'Shared') ?>
                </a>
                <p><?= WebConstants::PHONE_CONTACT ?></p>
                <a id="footerFb" class="fontBold" href="https://www.facebook.com/muccafailate"
                   target="_blank">Facebook</a>
            </div>
        </div>

        <!-- FOOTER BOTTOM -->
        <div id="footerBottom" class="row">
            <a target="_blank" href="http://www.flaredrop.com" title="FlareDrop Development">
                <span><?= Managers::literals()->get('FOOTER_POWERED_1', 'Shared') ?></span>
                <i></i>
                <span><?= Managers::literals()->get('FOOTER_POWERED_2', 'Shared') ?></span>
            </a>
        </div>

    </div>
</section>