<?php

use TelegramNotificationBot\App\Services\TelegramService;

$menuCommands = TelegramService::MENU_COMMANDS ?? [];
?>

<b>BOT MENU</b> 🤖

<?php foreach ($menuCommands as $menuCommand) : ?>
<b><?= $menuCommand['command'] ?></b> - <?= $menuCommand['description'] ?>

<?php endforeach; ?>

Select a button:
