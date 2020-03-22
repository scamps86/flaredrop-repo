<?php

// Get the application configuration for the CSS skin
$systemConfiguration = SystemManager::configurationGet(WebConfigurationBase::$ROOT_ID);

?>


<!-- Import the skin CSS file -->
<link
    href="<?php echo UtilsHttp::getRelativeUrl('view/css/ManagerSkin' . ucfirst($systemConfiguration['global']['selectedSkin']) . '.css') ?>"
    rel="stylesheet">