<!-- LOAD FACEBOOK SDK -->
<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/ca_ES/sdk.js#xfbml=1&version=v2.8&appId=1455588004675069";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<section class="section row">

    <!-- TOP SLIDER -->
    <figure class="row">
        <div id="slider" class="owl-carousel">

            <?php
            for ($i = 1; $i < 6; $i++) {
                ?>
                <div class="slide s<?= $i ?>">
                    <div class="centered">
                        <div class="slideTitle row">
                            <h2><?= Managers::literals()->get('BANNER_' . $i . '_TITLE', 'Home') ?></h2>
                        </div>
                        <div class="slideDescription row">
                            <h3><?= Managers::literals()->get('BANNER_' . $i . '_DESCRIPTION', 'Home') ?></h3>
                        </div>

                        <div class="slideButton row">
                            <a href="<?= UtilsHttp::getSectionUrl('home') . '#op' . $i ?>" target="_blank">
                                <?= Managers::literals()->get('MORE_INFO', 'Home') ?>
                            </a>
                        </div>
                    </div>
                </div>

                <?php
            }
            ?>
        </div>
    </figure>

    <div class="centered">

        <!-- DESCRIPTION -->
        <div class="row">
            <p class="mainDescription"><?php echo Managers::literals()->get('DESCRIPTION', 'Home') ?></p>
            <h3 class="welcome"><?php echo Managers::literals()->get('WELCOME', 'Home') ?></h3>
        </div>
    </div>


    <!-- BANNER OPTIONS -->
    <div class="row" id="homeOptions">
        <?php for ($i = 1; $i < 6; $i++) { ?>
            <div id="op<?= $i ?>" class="bannerOption">
                <div class="centered">
                    <h4><?= Managers::literals()->get('BANNER_' . $i . '_TITLE', 'Home') ?></h4>
                    <p><?= Managers::literals()->get('BANNER_' . $i . '_PARAGRAPH', 'Home') ?></p>
                </div>
            </div>
            <?php
        }
        ?>
    </div>


    <!-- SOCIALS -->
    <div class="centered">
        <div id="socials" class="row">
            <!-- FACEBOOK -->
            <div class="fb-page" data-href="https://www.facebook.com/twins.original/" data-tabs="timeline"
                 data-width="500" data-height="1000" data-small-header="false" data-adapt-container-width="true"
                 data-hide-cover="false" data-show-facepile="true">
                <blockquote cite="https://www.facebook.com/twins.original/" class="fb-xfbml-parse-ignore"><a
                            href="https://www.facebook.com/twins.original/">Twins Original</a></blockquote>
            </div>
        </div>
    </div>
</section>