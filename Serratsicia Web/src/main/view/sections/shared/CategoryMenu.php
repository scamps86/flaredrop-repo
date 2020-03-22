<!-- CATEGORIES MENU -->
<div id="categoryMenu" class="row">
    <?php
    $categoryMenu = new ComponentFolderMenu();
    $categoryMenu->addOption(Managers::literals()->get('ALL_FOLDERS', 'Catalog'), 'catalog');
    $categoryMenu->addFolderTree($folders, 'catalog');
    $categoryMenu->echoComponent();
    ?>
</div>