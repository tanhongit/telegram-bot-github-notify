<?php
/**
 * @var $payload mixed
 */

$message = "👷‍♂️🛠️ <b>New Pull Request</b> - <a href=\"{$payload->pull_request->html_url}\">{$payload->repository->full_name}#{$payload->pull_request->number}</a> create by <a href=\"{$payload->pull_request->user->html_url}\">@{$payload->pull_request->user->login}</a>\n\n";

$message .= "🛠 <b>{$payload->pull_request->title}</b> \n\n";

$message .= require __DIR__ . '/../../shared/partials/_assignee.php';

$message .= require __DIR__ . '/partials/_reviewers.php';

require __DIR__ . '/../../shared/partials/_body.php';

echo $message;
