<section id="page" class="row">

    <?php
    require PATH_VIEW . 'sections/shared/UsersMenu.php';
    ?>

    <div class="centered">
        <!-- BAN PACKS LIST -->
        <ul id="banPacksList" class="row">
            <?php
            foreach ($bansPacks->list as $p) {
                $picture = UtilsDiskObject::firstFileGet($p['pictures']);

                if ($picture) {
                    ?>
                    <li class="row" pid="<?= $p['objectId'] ?>" pprice="<?= $p['price'] ?>" ptitle="<?= $p['title'] ?>">
                        <img src="<?= UtilsHttp::getPictureUrl($picture->fileId, '992x176') ?>" title="Bans"/>
                        <button><?= Managers::literals()->get('BUY_BANS', 'UserBuyBans') ?></button>
                    </li>
                <?php
                }
            }
            ?>
        </ul>
    </div>
</section>