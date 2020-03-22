<h1><?= Managers::literals()->get('TITLE', 'AccountValidate'); ?></h1>

<?php
$message = Managers::literals()->get('MESSAGE', 'AccountValidate');
$message = str_replace('{USER_EMAIL}', $userData->email, $message);

echo '<p>' . $message . '</p>';
?>