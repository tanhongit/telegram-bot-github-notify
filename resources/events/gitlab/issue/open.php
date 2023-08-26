<?php
/**
 * @var $payload mixed
 */

$message = "⚠️ <b>New Issue</b> to 🦊<a href=\"{$payload->object_attributes->url}\">{$payload->project->path_with_namespace}#{$payload->object_attributes->id}</a> created by <b>{$payload->user->name}</b>\n\n";

$message .= "📢 <b>{$payload->object_attributes->title}</b>\n";

$message .= require __DIR__ . '/../../shared/partials/gitlab/_assignees.php';

$message .= require __DIR__ . '/../../shared/partials/gitlab/_body.php';

echo $message;
