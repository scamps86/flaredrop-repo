<section class="section row">
    <div class="centered">

        <div id="history" class="row">
            <h1><?= Managers::literals()->get('HISTORY_TITLE', 'Staff') ?></h1>
            <p><?= Managers::literals()->get('HISTORY', 'Staff') ?></p>
            <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/staff/history.jpg') ?>"
                 alt="<?= Managers::literals()->get('HISTORY_TITLE', 'Staff') ?>"/>
        </div>

        <div id="staff" class="row">
            <h1><?= Managers::literals()->get('STAFF_TITLE', 'Staff') ?></h1>

            <div class="grid">
                <!--                <div class="staff">
                    <img src="<? /*= UtilsHttp::getRelativeUrl('view/resources/images/staff/staff1.jpg') */ ?>" alt="Laura"/>
                    <h2>Laura</h2>
                    <p><? /*= Managers::literals()->get('STAFF_1', 'Staff') */ ?></p>
                </div>-->

                <div class="staff">
                    <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/staff/staff2.jpg') ?>" alt="Esther"/>
                    <h2>Esther</h2>
                    <p><?= Managers::literals()->get('STAFF_2', 'Staff') ?></p>
                </div>

                <div class="staff">
                    <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/staff/staff3.jpg') ?>" alt="Maria"/>
                    <h2>Maria</h2>
                    <p><?= Managers::literals()->get('STAFF_3', 'Staff') ?></p>
                </div>

                <div class="staff">
                    <img src="<?= UtilsHttp::getRelativeUrl('view/resources/images/staff/staff4.jpg') ?>" alt="Anna"/>
                    <h2>Anna</h2>
                    <p><?= Managers::literals()->get('STAFF_4', 'Staff') ?></p>
                </div>
                <!--                <div class="staff">
                    <img src="<? /*= UtilsHttp::getRelativeUrl('view/resources/images/staff/staff5.jpg') */ ?>"
                         alt="Mercedes"/>
                    <h2>Mercedes</h2>
                    <p><? /*= Managers::literals()->get('STAFF_5', 'Staff') */ ?></p>
                </div>-->
            </div>
        </div>

    </div>
</section>