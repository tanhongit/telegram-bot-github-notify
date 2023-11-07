<?php

namespace CSlant\TelegramGitNotifierApp\Services;

use CSlant\TelegramGitNotifier\Bot;
use CSlant\TelegramGitNotifier\Constants\SettingConstant;
use CSlant\TelegramGitNotifier\Exceptions\InvalidViewTemplateException;
use CSlant\TelegramGitNotifier\Exceptions\MessageIsEmptyException;
use CSlant\TelegramGitNotifierApp\Traits\Markup;

class CallbackService
{
    use Markup;

    private Bot $bot;

    public function __construct(Bot $bot)
    {
        $this->bot = $bot;
    }

    /**
     * Answer the back button
     *
     * @param string $callback
     *
     * @return void
     * @throws MessageIsEmptyException
     */
    public function answerBackButton(string $callback): void
    {
        $callback = str_replace(SettingConstant::SETTING_BACK, '', $callback);

        switch ($callback) {
            case 'settings':
                $view = view('tools.settings');
                $markup = $this->bot->settingMarkup();

                break;
            case 'settings.custom_events.github':
                $view = view('tools.custom_event', ['platform' => 'github']);
                $markup = $this->bot->eventMarkup();

                break;
            case 'settings.custom_events.gitlab':
                $view = view('tools.custom_event', ['platform' => 'gitlab']);
                $markup = $this->bot->eventMarkup(null, 'gitlab');

                break;
            case 'menu':
                $view = view('tools.menu');
                $markup = $this->menuMarkup($this->bot->telegram);

                break;
            default:
                $this->bot->answerCallbackQuery('Unknown callback');

                return;
        }

        $this->bot->editMessageText($view, [
            'reply_markup' => $markup,
        ]);
    }

    /**
     * @return void
     * @throws MessageIsEmptyException
     * @throws InvalidViewTemplateException
     */
    public function handle(): void
    {
        $callback = $this->bot->telegram->Callback_Data();

        if (str_contains($callback, SettingConstant::SETTING_CUSTOM_EVENTS)) {
            $this->bot->eventHandle($callback);

            return;
        }

        if (str_contains($callback, SettingConstant::SETTING_BACK)) {
            $this->answerBackButton($callback);

            return;
        }

        $callback = str_replace(SettingConstant::SETTING_PREFIX, '', $callback);

        $settings = $this->bot->setting->getSettings();
        if (array_key_exists($callback, $settings)
            && $this->bot->setting->updateSetting(
                $callback,
                !$settings[$callback]
            )
        ) {
            $this->bot->editMessageReplyMarkup([
                'reply_markup' => $this->bot->settingMarkup(),
            ]);
        } else {
            $this->bot->answerCallbackQuery('Something went wrong!');
        }
    }
}
