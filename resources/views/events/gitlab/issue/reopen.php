<?php
/**
 * @var $payload mixed
 */

$message = "⚠️ <b>Issue has been reopened</b> ⚠️ to 🦊<a href=\"{$payload->object_attributes->url}\">{$payload->project->path_with_namespace}#{$payload->object_attributes->id}</a> by <b>{$payload->user->name}</b>\n\n";

$message .= "📢 <b>{$payload->object_attributes->title}</b>\n";

$message .= require_once __DIR__ . '/../../shared/partials/gitlab/_assignees.php';

$message .= require_once __DIR__ . '/../../shared/partials/gitlab/_body.php';

echo $message;
