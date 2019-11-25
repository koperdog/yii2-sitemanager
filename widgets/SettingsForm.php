<?php

namespace koperdog\yii2sitemanager\widgets;

/**
 * This is just an example.
 */
class SettingsForm extends \yii\base\Widget
{
    private static $html;
    
    private static $template = '<div class="field_group">{input}';
    
    public function init(array $options = [])
    {
        parent::init();
    }
    
    public function run()
    {
//        $html = "";
//        
//        foreach(self::$html as $key => $value){
//            $html .= str_replace("{input}", $value, self::$template);
//            $html .= "\n";
//        }
//        
//        return $html;
    }
    
    public static function addField(string $key, string $html): void
    {
        self::$data[$key] = $html;
    }
    
    public static function getField(string $name): ?array
    {
        return isset(self::$data[$name])? self::$data[$name] : null;
    }
}
