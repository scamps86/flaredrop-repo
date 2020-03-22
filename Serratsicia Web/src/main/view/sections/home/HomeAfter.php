<?php

$filter = new VoSystemFilter();
$filter->setPageCurrent(0);
$filter->setPageNumItems(12);
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setPropertyMatch('showHome', '1');
$filter->setAND();
$filter->setPropertyMatch('visible', '1');
$filter->setRandom();

$products = SystemDisk::objectsGet($filter, 'product');
?>

<section class="content row">
    <div class="centered">

        <!-- LEFT CONTENTS -->
        <div id="leftContents">
            <div class="row">
                <h1><?php echo Managers::literals()->get('WELCOME', 'Home') ?></h1>

                <h2><?php echo Managers::literals()->get('SUBTITLE', 'Home') ?></h2>

                <p class="paragraph"><?php echo Managers::literals()->get('DESCRIPTION', 'Home') ?></p>
            </div>
        </div>

        <!-- RIGHT CONTENTS -->
        <div id="rightContents">

            <!-- SLIDER -->
            <div class="row mdHide">
                <div id="slider" class="owl-carousel">
                    <?php
                    $i = 0;
                    foreach ($products->list as $p) {
                        $picture = UtilsDiskObject::firstFileGet($p['pictures']);

                        if ($i % 4 == 0) {
                            if ($i > 0) {
                                echo '</div>';
                            }
                            echo '<div class="slide">';
                        }

                        if ($picture != null) {
                            $folderId = UtilsDiskObject::firstFolderIdGet($p['folderIds']);

                            echo '<a href="' . UtilsHttp::getSectionUrl('product', ['objectId' => $p['objectId'], 'folderId' => $folderId], $p['title']) . '" title="' . $p['title'] . '">';
                            echo '<img src="' . UtilsHttp::getPictureUrl($picture->fileId, '170x170') . '" alt="' . $p['title'] . '"></a>';
                            $i++;
                        }
                    }
                    echo '</div>';
                    ?>
                </div>
            </div>

            <!-- SLIDER (MOBILE) -->
            <div id="sliderStatic" class="row mdShow">
                <?php
                $i = 0;
                foreach ($products->list as $p) {
                    $picture = UtilsDiskObject::firstFileGet($p['pictures']);

                    if ($picture != null && $i < 4) {
                        echo '<a href="' . UtilsHttp::getSectionUrl('product', ['objectId' => $p['objectId']], $p['title']) . '" title="' . $p['title'] . '">';
                        echo '<img src="' . UtilsHttp::getPictureUrl($picture->fileId, '170x170') . '" alt="' . $p['title'] . '"></a>';
                        $i++;
                    }
                }
                ?>
            </div>

            <!-- OPTIONS -->
            <div id="homeOptions" class="row">
                <a class="row" href="<?php echo UtilsHttp::getSectionUrl('catalog') ?>"
                   title="<?php echo Managers::literals()->get('SHOW_CATALOG', 'Home') ?>">
                    <span class="fontBold"><?php echo Managers::literals()->get('SHOW_CATALOG', 'Home') ?></span>
                    <span class="option catalog"></span>
                </a>
                <a class="row" href="<?php echo UtilsHttp::getSectionUrl('contact') ?>"
                   title="<?php echo Managers::literals()->get('CONTACT_US', 'Home') ?>">
                    <span class="fontBold"><?php echo Managers::literals()->get('CONTACT_US', 'Home') ?></span>
                    <span class="option contact"></span>
                </a>
            </div>
        </div>
    </div>
</section>