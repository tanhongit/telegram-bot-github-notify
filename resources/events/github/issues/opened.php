<?php
/**
 * @var $payload mixed
 */

$message = "⚠️ <b>New Issue</b> to 🦑<a href=\"{$payload->issue->html_url}\">{$payload->repository->full_name}#{$payload->issue->number}</a> by <a href=\"{$payload->issue->user->html_url}\">@{$payload->issue->user->login}</a>\n\n";

$message .= "📢 <b>{$payload->issue->title}</b>\n";

$message .= require __DIR__ . '/../../shared/partials/github/_assignees.php';

$message .= require __DIR__ . '/../../shared/partials/github/_body.php';

echo $message;
