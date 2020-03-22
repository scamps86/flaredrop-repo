<section id="footer" class="row">
    <div class="centered">

        <div class="row">
            <!-- WEB MENU -->
            <nav id="footerMenu">
                <?php
                $mainMenu->echoComponent();
                ?>
            </nav>

            <!-- SCHEDULES -->
            <p id="footerSchedules"><?= Managers::literals()->get('FOOTER_SCHEDULES', 'Shared') ?></p>
        </div>

        <!-- SOCIAL NETWORKS -->
        <div class="row">
            <ul id="footerSn">
                <li class="snFb">
                    <a href="http://www.facebook.com" target="_blank"></a>
                </li>
                <li class="snTw">
                    <a href="http://www.twitter.com" target="_blank"></a>
                </li>
                <li class="snG">
                    <a href="http://www.google.com" target="_blank"></a>
                </li>
                <li class="snI">
                    <a href="http://www.instagram.com" target="_blank"></a>
                </li>
                <li class="snYo">
                    <a href="http://www.youtube.com" target="_blank"></a>
                </li>
            </ul>
        </div>

        <!-- DEVELOPED / DESIGNED -->
        <div id="footerInfo" class="row">
            <p>© 2015
                <a href="http://flaredrop.com" tagret="_blank"
                   title="<?= Managers::literals()->get('DEVELOPED_BY', 'Shared') ?>"><?= Managers::literals()->get('FOOTER_DEVELOPED_BY', 'Shared') ?></a>
                &amp;
                <a href="http://adex-media.com" tagret="_blank"
                   title="<?= Managers::literals()->get('DESIGNED_BY', 'Shared') ?>"><?= Managers::literals()->get('FOOTER_DESIGNED_BY', 'Shared') ?></a>
            </p>
        </div>

    </div>
</section>