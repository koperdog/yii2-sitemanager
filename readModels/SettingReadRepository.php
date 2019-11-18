<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace koperdog\yii2settings\readModels;

use koperdog\yii2settings\models\Setting;
use \yii\base\Model;

/**
 * Description of SettingRepository
 *
 * @author Koperdog <koperdog@github.com>
 */
class SettingReadRepository {
    
    public function getAll(): ?array
    {
        if(!$models = Setting::find()->asArray()->all()){
            throw new \DomainException();
        }
        return $models;
    }
    
    public function getAllByStatus(int $status): ?array
    {
        $models = Setting::find()
                ->where(['status' => $status])
                ->indexBy('name')
                ->asArray()
                ->all();
        
        if(!$models){
            throw new \DomainException();
        }
        
        return $models;
    }
    
    public function getAllByDomain(int $domain_id, int $status = null, int $lang_id = null): ?array
    {
        $models = Setting::find()
                ->where(['domain_id' => $domain_id])
                ->andFilterWhere(['status' => $status, 'lang_id' => $lang_id])
                ->indexBy('name')
                ->asArray()
                ->all();
        
        if(!$models){
            throw new \DomainException();
        }
        
        return $models;
    }
    
    public function get(int $id): Setting
    {
        if(!$model = Setting::find()->where(['id' => $id])->asArray()->one()){
            throw new \DomainException();
        }
        
        return $model;
    }
}
