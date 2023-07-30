<?php

namespace TelegramGithubNotify\App\Services;

use TelegramGithubNotify\App\Models\Setting;

class SettingService extends AppService
{
    public Setting $setting;

    public array $settingConfig = [];

    public function __construct()
    {
        parent::__construct();
        $this->setting = new Setting();
        $this->settingConfig = $this->setting->getSettingConfig();
    }
    /**
     * @return void
     */
    public function settingHandle(): void
    {
        if ($this->settingConfig['is_notified']) {
            $notificationSetting = $this->telegram->buildInlineKeyBoardButton('🔕 Disable Notification', '', 'setting.is_notified');
        } else {
            $notificationSetting = $this->telegram->buildInlineKeyBoardButton('🔔 Enable Notification', '', 'setting.is_notified');
        }

        if ($this->settingConfig['all_events_notify']) {
            $eventSetting = $this->telegram->buildInlineKeyBoardButton('🔕 Disable All Events Notify', '', 'setting.all_events_notify');
        } else {
            $eventSetting = $this->telegram->buildInlineKeyBoardButton('🔔 Enable All Events Notify', '', 'setting.all_events_notify');
        }

        $keyboard = [
            [
                $notificationSetting,
            ], [
                $eventSetting,
                $this->telegram->buildInlineKeyBoardButton('Custom individual events', '', 'setting.custom_events'),
            ],
        ];

        $this->sendMessage(view('tools.settings'), ['reply_markup' => $keyboard]);
    }

    /**
     * @param string $callback
     * @return void
     */
    public function settingCallbackHandler(string $callback): void
    {
        if ($callback === 'setting.custom_events') {
            (new EventService())->eventHandle();
            return;
        }

        $this->updateSetting($callback, !$this->settingConfig[$callback]);
        $this->settingHandle();
    }

    /**
     * @param string $settingName
     * @param $settingValue
     * @return bool
     */
    public function updateSetting(string $settingName, $settingValue = null): bool
    {
        $keys = explode('.', $settingName);
        $lastKey = array_pop($keys);
        $nestedSettings = &$this->settingConfig;

        foreach ($keys as $key) {
            if (!isset($nestedSettings[$key]) || !is_array($nestedSettings[$key])) {
                return false;
            }
            $nestedSettings = &$nestedSettings[$key];
        }

        if (isset($nestedSettings[$lastKey])) {
            $nestedSettings[$lastKey] = $settingValue ?? !$nestedSettings[$lastKey];
            $this->saveSettingsToFile();
            return true;
        }

        return false;
    }

    /**
     * @return void
     */
    private function saveSettingsToFile(): void
    {
        $json = json_encode($this->settingConfig, JSON_PRETTY_PRINT);
        file_put_contents(Setting::SETTING_FILE, $json);
    }
}
