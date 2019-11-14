<?php

namespace koperdog\yii2settings\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use koperdog\yii2settings\useCases\DomainService;
use koperdog\yii2settings\repositories\DomainRepository;
use koperdog\yii2settings\repositories\SettingRepository;
use koperdog\yii2settings\models\Domain;

/**
 * DomainController implements the CRUD actions for Domain model.
 */
class DomainsController extends Controller
{
    
    private $service;
    
    private $domain;
    private $settings;
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
        DomainService $service,
        DomainRepository $domain,
        SettingRepository $settings,
        $config = []
    ) 
    {
        parent::__construct($id, $module, $config);
        $this->service  = $service;
        $this->domain   = $domain; 
        $this->settings = $settings;
    }

    /**
     * Lists all Domain models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $this->domain->find()
        ]);

        return $this->render('index', [
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
        $settings = $this->settings->getAllByDomain($id, $status);
        
        return $this->render('view', [
            'model'    => $this->findModel($id),
            'settings' => $settings
        ]);
    }

    /**
     * Creates a new Domain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new \koperdog\yii2settings\models\Domain();

        if ($form->load(Yii::$app->request->post())){
            if($this->service->createDomain(Yii::$app->request->post('Domain'))){
                \Yii::$app->session->setFlash('success', \Yii::t('app', 'Success save'));
            }
            else{
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error create'));
            }
            return $this->redirect(['/settings/domains']);
        }

        return $this->render('create', [
            'model' => $form,
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
        $form    = $this->findModel($id);
        $settings = $this->settings->getAllByDomain($id);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            
            if($this->service->updateDomain($form->id, \Yii::$app->request->post())){
                \Yii::$app->session->setFlash('success', \Yii::t('app', 'Success save'));
            }
            else{
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error create'));
            }
            return $this->refresh();
        }

        return $this->render('update', [
            'model'    => $form,
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
        $model = $this->findModel($id);
        
        if($this->service->deleteDomain($model)){
            \Yii::$app->session->setFlash('success', \Yii::t('app', 'Success delete'));
        }
        else{
            \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error delete'));
        }

        return $this->redirect(['index']);
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
        if (($model = Domain::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
