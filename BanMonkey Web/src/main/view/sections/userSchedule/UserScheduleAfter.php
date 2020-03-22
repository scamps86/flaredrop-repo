<section id="page" class="row">

    <?php
    require PATH_VIEW . 'sections/shared/UsersMenu.php';
    ?>

    <div class="centered">

        <button id="addSchedule"><?= Managers::literals()->get('ADD_SCHEDULE', 'UserSchedule') ?></button>

        <ul id="userSchedulesList">

        </ul>

    </div>
</section>