<?php

/**
 * @link https://github.com/koperdog/yii2-sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-sitemanager/blob/master/LICENSE
 */

namespace koperdog\yii2sitemanager\controllers;

use yii\web\Controller;
use yii\filters\AjaxFilter;
use koperdog\yii2sitemanager\repositories\{
    DomainRepository, 
    LanguageRepository
};

/**
 * CategoryController implements the CRUD actions for Category model.
 * 
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class AjaxController extends Controller
{
    private $languageRepository;
    private $domainRepository;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => AjaxFilter::className(),
            ],
        ];
    }
    
    public function __construct
    (
        $id, 
        $module,
        DomainRepository $domain,
        LanguageRepository $language,
        $config = []
    ) 
    {
        parent::__construct($id, $module, $config);
        $this->domainRepository   = $domain;
        $this->languageRepository = $language;
    }
    
    public function actionChangeDomain()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $domain_id = \Yii::$app->request->post('domain') > 0? \Yii::$app->request->post('domain') : null;
        
        if($domain_id === null || $this->existDomain($domain_id)){
            \Yii::$app->session->set('_domain', $domain_id);
            return $this->redirect(['/']);
        }
        
        return ['error' => true];
    }
    
    public function actionChangeLanguage()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $language_id = \Yii::$app->request->post('language') > 0? \Yii::$app->request->post('language') : null;
        
        if($language_id === null || $this->existLanguage($language_id)){
            \Yii::$app->session->set('_language', $language_id);
            return $this->redirect(['/']);
        }
        
        return ['error' => true];
    }
    
    private function existDomain(int $id): bool
    {
        if(!$this->domainRepository->exist($id)){
            throw new NotFoundHttpException("Domain with id: {$id} does not exist.");
        }
        
        return true;
    }
    
    private function existLanguage(int $id): bool
    {
        if(!$this->languageRepository->exist($id)){
            throw new NotFoundHttpException("Language with id: {$id} does not exist.");
        }
        
        return true;
    } 
}
