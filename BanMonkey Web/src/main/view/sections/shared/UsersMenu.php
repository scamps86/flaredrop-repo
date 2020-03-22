<div id="usersMenuContainer" class="row">
    <div class="centered">
        <?php
        $usersMenu = new ComponentSectionMenu();
        $usersMenu->addSection(Managers::literals()->get('USER_MENU_BUY_BANS', 'Shared'), ['userBuyBans']);
        $usersMenu->addSection(Managers::literals()->get('USER_MENU_SCHEDULED_BILLS', 'Shared'), ['userSchedule']);
        $usersMenu->addSection(Managers::literals()->get('USER_MENU_ACCOUNT', 'Shared'), ['userAccount']);
        $usersMenu->echoComponent();
        ?>
    </div>
</div>

<div id="usersMenuInfo" class="row">
    <div class="centered">
        <p><?= Managers::literals()->get('USER_WELCOME', 'Shared') . ' ' . $loginResult->data->firstName . ', ' . Managers::literals()->get('USER_REMAINING_BANS1', 'Shared') . ' ' . $loginResult->data->data . ' ' . Managers::literals()->get('USER_REMAINING_BANS2', 'Shared') ?></p>
    </div>
</div>