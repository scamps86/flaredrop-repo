<nav id="categoriesMenu" class="row">
    <?php
    $foldersMenu = new ComponentFolderMenu();
    $foldersMenu->addOption(Managers::literals()->get('ALL_CATEGORIES', 'Shared'), 'productes');
    $foldersMenu->addFolderTree($folders, 'productes');
    $foldersMenu->echoComponent();
    ?>
</nav>