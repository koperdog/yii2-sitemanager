<?php

namespace koperdog\yii2settings;

/**
 * This is just an example.
 */
class SettingsForm extends \yii\base\Widget
{
    public static $html;
    
    public function run()
    {
        return self::$html;
    }
    
    public static function setField(array $setting, array $data): void
    {
        self::$data[$setting['name']] = ['field' => $setting, 'data' => $data];
    }
    
    public static function getField(string $name): ?array
    {
        return isset(self::$data[$name])? self::$data[$name] : null;
    }
}
