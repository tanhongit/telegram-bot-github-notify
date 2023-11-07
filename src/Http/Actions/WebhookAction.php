<?php

namespace CSlant\TelegramGitNotifierApp\Http\Actions;

use CSlant\TelegramGitNotifier\Exceptions\WebhookException;
use CSlant\TelegramGitNotifier\Webhook;

class WebhookAction
{
    protected string $token;

    protected Webhook $webhook;

    public function __construct()
    {
        $this->webhook = new Webhook();
        $this->webhook->setToken(config('telegram-git-notifier.bot.token'));
        $this->webhook->setUrl(config('telegram-git-notifier.app.url'));
    }

    /**
     * Set webhook for telegram bot
     *
     * @return false|string
     * @throws WebhookException
     */
    public function set(): false|string
    {
        return $this->webhook->setWebhook();
    }

    /**
     * Delete webhook for telegram bot
     *
     * @return false|string
     * @throws WebhookException
     */
    public function delete(): false|string
    {
        return $this->webhook->deleteWebHook();
    }

    /**
     * Get webhook update
     *
     * @return false|string
     * @throws WebhookException
     */
    public function getUpdates(): false|string
    {
        return $this->webhook->getUpdates();
    }
}
