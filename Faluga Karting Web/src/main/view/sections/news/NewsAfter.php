<section id="page" class="row">
    <div class="centered">

        <!-- MAIN TITLE -->
        <h1 class="title"><?= Managers::literals()->get('TITLE', 'News') ?></h1>

        <!-- NEWS LIST -->
        <div class="row">
            <?php
            foreach ($news->list as $n) {
                $picture = UtilsDiskObject::firstFileGet($n['pictures']);
                ?>

                <div class="row newContainer">
                    <h2 class="newTitle"><?= $n['title']; ?></h2>

                    <?php
                    if ($picture) {
                        ?>
                        <img class="newImage" src="<?= UtilsHttp::getPictureUrl($picture->fileId, '600x420') ?>"
                             alt="<?= $n['title'] ?>"/>
                    <?php
                    }
                    ?>

                    <h3 class="newDescription"><?= $n['description'] ?></h3>
                </div>

            <?php
            }
            ?>

            <?php
            $pagssNavigator = new ComponentPagesNavigator($news->totalPages);
            $pagssNavigator->echoComponent();
            ?>
        </div>

    </div>
</section>