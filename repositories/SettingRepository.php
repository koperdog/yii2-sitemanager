<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace koperdog\yii2settings\repositories;

use koperdog\yii2settings\models\Setting;
use \yii\base\Model;

/**
 * Description of SettingRepository
 *
 * @author Koperdog <koperdog@github.com>
 */
class SettingRepository {
    
    public function getAll(): ?array
    {
        if(!$models = Setting::findAll()){
            throw new \DomainException();
        }
        return $models;
    }
    
    public function getAllByStatus(int $status): ?array
    {
        $models = Setting::find()
                ->where(['status' => $status])
                ->indexBy('id')
                ->all();
        
        if(!$models){
            throw new \DomainException();
        }
        
        return $models;
    }
    
    public function getAllBySite(int $site_id, int $status = null, int $lang_id = null): ?array
    {
        $models = Setting::find()
                ->where(['site_id' => $site_id])
                ->andFilterWhere(['status' => $status, 'lang_id' => $lang_id])
                ->indexBy('id')
                ->all();
        
        if(!$models){
            throw new \DomainException();
        }
        
        return $models;
    }
    
    public function get(int $id): Setting
    {
        if(!$model = Setting::findOne($id)){
            throw new \DomainException();
        }
        
        return $model;
    }
    
    public function save(Setting $setting): bool
    {
        if(!$setting->save()){
            throw new \RuntimeException();
        }
    }
    
    public function saveMultiple(array $settings, array $data)
    {
        if (Model::loadMultiple($settings, $data) && Model::validateMultiple($settings)) {
            foreach ($settings as $setting) {
                $this->save($setting);
            }
        }
        
        return true;
    }
}
