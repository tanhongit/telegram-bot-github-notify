<?php

use TelegramNotificationBot\App\Http\Actions\SendNotifyAction;
use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

date_default_timezone_set(config('app.timezone'));

$sendNotifyAction = new SendNotifyAction();
$sendNotifyAction();
