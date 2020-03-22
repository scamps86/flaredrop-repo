<section class="content row">
    <div class="centered">

        <!-- DOWNLOADS LIST -->
        <div id="downloadsList" class="row">
            <h1><b class="title"><?php echo Managers::literals()->get('WELCOME', 'Downloads') ?></b></h1><br>

            <p><?php echo Managers::literals()->get('COMPATIBLE', 'Downloads') ?></p>

            <?php
            foreach ($downloads->list as $d) {
                $file = UtilsDiskObject::firstFileGet($d['files']);
                ?>
                <a target="_blank" href="<?php echo UtilsHttp::getFileUrl($file->fileId) ?>"
                   alt="<?php echo $d['title'] ?>">
                    <?php echo '<span><b>' . $d['title'] . '</b><br>' . $d['language'] . '<br>' . $d['size'] . '</span>' ?>
                </a>
                <br>
            <?php
            }
            ?>
        </div>

    </div>
</section>

<!-- GOOGLE ADSENSE AD BANNER -->
<aside id="gAdsenseAd2">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- SCT Cars cursor banner -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:336px;height:280px"
         data-ad-client="ca-pub-6755946233651514"
         data-ad-slot="1259691380"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</aside>