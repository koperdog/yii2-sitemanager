<?php

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
 */
class DefaultController extends Controller
{
    private $repository;
    private $service;
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
        $this->repository = $repository;
        $this->service    = $service;
    }

    /**
     * Lists all Setting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $settings = $this->findModels(Setting::STATUS['GENERAL']);
        
        if(\Yii::$app->request->post()){
            if($this->service->saveMultiple($settings, \Yii::$app->request->post())){
                \Yii::$app->session->setFlash('success', \Yii::t('sitemanager', 'Success save'));
            }
            else{
                \Yii::$app->session->setFlash('error', \Yii::t('sitemanager/error', 'Error save'));
            }
        }

        return $this->render('index', ['settings' => $settings]);
    }
    
    public function actionCreate()
    {
        $form = new \koperdog\yii2sitemanager\models\forms\SettingForm();
        
        if($form->load(\Yii::$app->request->post()) && $form->validate()){
            if($this->service->create($form)){
                \Yii::$app->session->setFlash('success', \Yii::t('sitemanager', 'Success save'));
                $this->redirect(['/manager/domains/index']);
            }
            else{
                \Yii::$app->session->setFlash('error', \Yii::t('sitemanager/error', 'Error save'));
            }
        }
        
        return $this->render('create', ['model' => $form]);
    }
    
    private function findModels($status = Setting::STATUS['GENERAL'], $domain_id = null, $lang_id = null)
    {
        try{
            $models = $this->repository->getAllByStatus($status, $domain_id, $lang_id);
        } catch(\DomainException $e){
            throw new NotFoundHttpException(Yii::t('sitemanager', 'The requested page does not exist.'));
        }
        
        return $models;
    }
}
