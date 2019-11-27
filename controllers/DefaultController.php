<?php

namespace koperdog\yii2sitemanager\controllers;

use koperdog\yii2sitemanager\useCases\SettingService;
use koperdog\yii2sitemanager\repositories\SettingRepository;
use \koperdog\yii2sitemanager\models\Setting;

class DefaultController extends \yii\web\Controller
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
        $settings = $this->settings->getAllByStatus(Setting::STATUS['GENERAL']);
        
        if(\Yii::$app->request->post()){
            if($this->service->saveMultiple($settings, \Yii::$app->request->post())){
                \Yii::$app->session->setFlash('success', \Yii::t('sitemanager', 'Success save'));
            }
            else{
                \Yii::$app->session->setFlash('error', \Yii::t('sitemanager/error', 'Error save'));
            }
        }
        
        return $this->render('index', [
            'settings' => $settings
        ]);
    }
    
    public function actionCreate()
    {
        $form = new Setting();
        
        if($form->load(\Yii::$app->request->post()) && $form->validate()){
            if($this->service->createSetting($form)){
                \Yii::$app->session->setFlash('success', \Yii::t('sitemanager', 'Success save'));
                $this->redirect(['/manager/domains/index']);
            }
            else{
                \Yii::$app->session->setFlash('error', \Yii::t('sitemanager/error', 'Error save'));
            }
        }
        
        return $this->render('create', ['model' => $form]);
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findSetting($id);
        
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($this->settings->save($model)){
                \Yii::$app->session->setFlash('success', \Yii::t('sitemanager', 'Success save'));
                return $this->refresh();
            }
            else{
                \Yii::$app->session->setFlash('error', \Yii::t('sitemanager/error', 'Error save'));
            }
        }
        
        return $this->render('update', ['model' => $model]);
    }
    
    public function actionDelete($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $model = $this->findSetting($id);
        
        if(\Yii::$app->request->isAjax){
            $success = $this->service->delete($id);
            return $success;
        }
        
        throw new \yii\web\ForbiddenHttpException("not ajax");
    }
    
    private function findSetting($id)
    {
        try{
            $model = $this->settings->get($id);
        } catch(\DomainException $e){
            throw new \yii\web\NotFoundHttpException("Setting not found");
        }
        
        return $model;
    }
}
