<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace koperdog\yii2sitemanager\useCases;

use koperdog\yii2sitemanager\repositories\LanguageRepository;
use \koperdog\yii2sitemanager\models\{
    Language, 
    forms\LanguageForm
};

/**
 * Description of SettingService
 *
 * @author Koperdog <koperdog@github.com>
 */
class LanguageService {
    private $languageRepository;
    
    public function __construct(LanguageRepository $language)
    {
        $this->languageRepository = $language;
    }
    
    public function update(Language $model): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->languageRepository->save($model);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    public function create(LanguageForm $form): bool
    {
        $language = new Language([
            'name'       => $form->name,
            'code'       => $form->code,
            'code_local' => $form->code_local,
            'status'     => $form->status,
            'is_default' => $form->is_default,
        ]);
        
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->languageRepository->save($language);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    public function delete(Language $model): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $model->unlinkAll('settings', true);
            $this->languageRepository->delete($model);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }
    
    public function makeDefault(Language $model): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $default = $this->languageRepository->getDefault();
            $default->is_default = false;
            
            $model->is_default   = true;
            $this->languageRepository->save($default);
            $this->languageRepository->save($model);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }
}
