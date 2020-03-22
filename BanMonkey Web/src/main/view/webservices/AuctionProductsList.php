<?php

// Get the in auction products
$filter = new VoSystemFilter();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setFolderId(WebConstants::ID_CATEGORY_IN_AUCTION);
$filter->setSortFields('creationDate', 'ASC');

$inAuctionProducts = SystemDisk::objectsGet($filter, 'product');

?>

<ul id="auctionProductsList" class="row">
    <?php foreach ($inAuctionProducts->list as $p): ?>
        <?php
        $picture = UtilsDiskObject::firstFileGet($p['pictures']);
        ?>
        <li pid="<?= $p['objectId'] ?>">
            <div class="productPicture">
                <?php if ($picture) : ?>
                    <img src="<?= UtilsHttp::getPictureUrl($picture->fileId, '100x100') ?>" alt="<?= $p['name'] ?>"/>
                <?php endif ?>
            </div>
            <p><?= $p['name'] ?></p>
        </li>

    <?php endforeach ?>
</ul>