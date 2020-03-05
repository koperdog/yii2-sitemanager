<?php

/**
 * @link https://github.com/koperdog/yii2-sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-sitemanager/blob/master/LICENSE
 */

namespace koperdog\yii2sitemanager\controllers;

use Yii;
use koperdog\yii2sitemanager\models\Setting;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use \koperdog\yii2sitemanager\repositories\SettingRepository;
use \koperdog\yii2sitemanager\useCases\SettingService;

/**
 * DefaultController implements the CRUD actions for Setting model.
 * 
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class DefaultController extends Controller
{
    private $settingRepository;
    private $settingService;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function __construct
    (
        $id, 
        $module,
        SettingRepository $repository,
        SettingService $service,
        $config = []
    ) 
    {
        parent::__construct($id, $module, $config);
        $this->settingRepository = $repository;
        $this->settingService    = $service;
    }

    /**
     * Lists all Setting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $language_id = \t2cms\sitemanager\components\Languages::getEditorLangaugeId();
        $domain_id   = null;
        
        $settings = $this->findModels(
                Setting::STATUS['GENERAL'],
                $domain_id,
                $language_id
                );
        
        if(\Yii::$app->request->post()){
            if($this->settingService->saveMultiple(
                    $settings, 
                    \Yii::$app->request->post(),
                    $domain_id,
                    $language_id)){
                \Yii::$app->session->setFlash('success', \Yii::t('sitemanager', 'Success save'));
                return $this->refresh();
            }
            else{
                \Yii::$app->session->setFlash('error', \Yii::t('sitemanager/error', 'Error save'));
            }
        }

        return $this->render('index', ['settings' => $settings]);
    }
    
    public function actionCreate()
    {
        $form = new \t2cms\sitemanager\models\forms\SettingForm();
        
        if($form->load(\Yii::$app->request->post()) && $form->validate()){
            if($this->settingService->create($form)){
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
        $model = $this->findModel($id);
        
        if($model->status != Setting::STATUS['CUSTOM']) throw new NotFoundHttpException(Yii::t('sitemanager', 'The requested page does not exist.'));
        
//        debug($model->generalValue);
        
        if(($model->load(\Yii::$app->request->post()) && $model->validate())
                && ($model->generalValue->load(\Yii::$app->request->post()) && $model->generalValue->validate())){
            if($this->settingService->update($model)){
                \Yii::$app->session->setFlash('success', \Yii::t('sitemanager', 'Success save'));
                $this->redirect(['/manager/domains/index']);
            }
            else{
                \Yii::$app->session->setFlash('error', \Yii::t('sitemanager/error', 'Error save'));
            }
        }
        
        return $this->render('update', ['model' => $model]);
    }
    
    public function actionDelete($id)
    {
        if(!\Yii::$app->request->isAjax) throw new ForbidenHttpException();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model  = $this->findModel($id);
        $result = $this->settingService->delete($model);
        
        return ['result' => $result];
    }
    
    private function findModel(int $id)
    {
        try{
            $model = $this->settingRepository->getById($id);
        } catch(\DomainException $e){
            throw new NotFoundHttpException(Yii::t('sitemanager', 'The requested page does not exist.'));
        }
        
        return $model;
    }
    
    private function findModels($status = Setting::STATUS['GENERAL'], $domain_id = null, $language_id = null)
    {
        try{
            $models = $this->settingRepository->getAllByStatus($status, $domain_id, $language_id);
        } catch(\DomainException $e){
            throw new NotFoundHttpException(Yii::t('sitemanager', 'The requested page does not exist.'));
        }
        
        return $models;
    }
}
