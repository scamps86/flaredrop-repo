<section id="footer" class="row">
    <div class="centered">

        <!-- SOCIAL NETWORKS -->
        <nav id="footerSocialNetworks" class="row">
            <p><?php echo Managers::literals()->get('SHARE_NETWORKS', 'Shared') ?></p><br>

            <div class="row">
                <a rel="nofollow" target="_blank" href="http://www.facebook.com/share.php?u=http://www.sctcars.net">
                    <img src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/shared/facebook.png') ?>"
                         alt="Facebook" title="Facebook"/>
                </a>
                <a rel="nofollow" target="_blank" href="http://twitter.com/home?status=http://www.sctcars.net">
                    <img src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/shared/twitter.png') ?>"
                         alt="Twitter" title="Twitter"/>
                </a>
            </div>
        </nav>

        <!-- POWERED -->
        <div class="row">
            <a href="http://www.flaredrop.com" title="FlareDrop Development" target="_blank">
                <?php echo Managers::literals()->get('POWERED', 'Shared') ?>
            </a>
        </div>

        <!-- ADS -->
        <div class="row">
            <div style="width: 728px; height: 90px; margin-top: 20px; margin-left: 20px;">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- SCT Cars Leaderboard -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:728px;height:90px"
                     data-ad-client="ca-pub-6755946233651514"
                     data-ad-slot="7326070580"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>

    </div>
</section>