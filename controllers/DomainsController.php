<?php

namespace koperdog\yii2sitemanager\controllers;

use Yii;
use koperdog\yii2sitemanager\models\Domain;
use koperdog\yii2sitemanager\models\DomainSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use koperdog\yii2sitemanager\useCases\{
    DomainService, 
    SettingService
};
use koperdog\yii2sitemanager\repositories\{
    DomainRepository,
    SettingRepository
};

/**
 * DomainsController implements the CRUD actions for Domain model.
 */
class DomainsController extends Controller
{
    private $domainService;
    private $domainRepository;
    private $settingService;
    private $settingRepository;
    
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
        DomainService $domainService,
        DomainRepository $domainRepository,
        SettingService $settingService,
        SettingRepository $settingRepository,
        $config = []
    ) 
    {
        parent::__construct($id, $module, $config);
        $this->domainService           = $domainService;
        $this->domainRepository        = $domainRepository; 
        $this->settingService    = $settingService;
        $this->settingRepository = $settingRepository;
    }

    /**
     * Lists all Domain models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DomainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Domain model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Domain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Domain();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Domain model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model    = $this->findModel($id);
        $settings = $this->findDomainSettings($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if(
                $this->domainService->updateDomain($model->id, \Yii::$app->request->post()) &&
                $this->settingService->saveMultiple($settings, \Yii::$app->request->post())
            ){
                \Yii::$app->session->setFlash('success', \Yii::t('sitemanager', 'Success save'));
                return $this->refresh();
            }
            else{
                \Yii::$app->session->setFlash('error', \Yii::t('sitemanager/error', 'Error save'));
            }
        }
        
        return $this->render('update', [
            'model'    => $model,
            'settings' => $settings
        ]);
    }

    /**
     * Deletes an existing Domain model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    private function findDomainSettings($id)
    {
        try{
            $models = $this->settingRepository->getAllByDomain($id);
        } catch(\DomainException $e){
            throw new NotFoundHttpException(Yii::t('sitemanager', 'The requested page does not exist.'));
        }
        
        return $models;
    }

    /**
     * Finds the Domain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Domain the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        try{
            $model = $this->domainRepository->get($id);
        } catch(\DomainException $e){
            throw new NotFoundHttpException(Yii::t('sitemanager', 'The requested page does not exist.'));
        }
        
        return $model;
    }
}
