<?php

namespace koperdog\yii2settings\controllers;

use koperdog\yii2settings\useCases\Setting\SettingService;
use koperdog\yii2settings\repositories\SettingRepository;

class SettingsController extends \yii\web\Controller
{
    private $service;
    private $settings;
    
    public function __construct
    (
        $id, 
        $module, 
        SettingService $service,
        SettingRepository $settings,
        $config = []
    ) 
    {
        parent::__construct($id, $module, $config);
        $this->service  = $service;
        $this->settings = $settings; 
    }
    
    public function actionIndex()
    {
        $settings = $this->settings->getByStatus(Setting::STATUS['GENERAL']);
        
        if(\Yii::$app->request->post()){
            if($this->service->saveMultiplie(\Yii::$app->request->post())){
                \Yii::$app->session->setFlash('success', \Yii::t('app', 'Success save'));
            }
            else{
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error save'));
            }
        }
        
        return $this->render('index', [
            'settings' => $settings
        ]);
    }
}
