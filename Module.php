<?php

namespace koperdog\yii2settings;

class Module extends \yii\base\Module
{
    const MODULE_NAME = "settings";
    
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'koperdog\yii2settings\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        
        $this->registerTranslations();
    }
    
    private function registerTranslations()
    {
        if (!isset(\Yii::$app->i18n->translations[self::MODULE_NAME . '*'])) {
            \Yii::$app->i18n->translations[self::MODULE_NAME . '*'] = [
                'class'    => \yii\i18n\PhpMessageSource::class,
                'basePath' => __DIR__ . '/messages',
                'fileMap'  => [
                    self::MODULE_NAME . "/error" => "error.php", 
                ],
            ];
        }
    }
}
