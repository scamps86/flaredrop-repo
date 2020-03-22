<section class="content row">
    <div class="centered">

        <!-- NEWS LIST -->
        <div id="newsList" class="row">
            <?php
            foreach ($news->list as $n) {
                ?>
                <h2><b><?php echo UtilsDate::toDDMMYYYY($n['creationDate']) . ' - ' . $n['title'] ?>:</b></h2>
                <p><?php echo $n['description'] ?></p>
            <?php
            }
            ?>
        </div>

    </div>
</section>