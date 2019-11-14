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
    
    public function getAllByDomain(int $domain_id, int $status = null, int $lang_id = null): ?array
    {
        $models = Setting::find()
                ->where(['domain_id' => $domain_id])
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
        return true;
    }
    
    public function saveAll(array $settings, array $data): bool
    {
        if (Model::loadMultiple($settings, $data) && Model::validateMultiple($settings)) {
            foreach ($settings as $setting) {
                $this->save($setting);
            }
        }
        
        return true;
    }
    
    public function removeAllByDomain(int $domain_id): bool
    {
        if(!Setting::deleteAll(['domain_id' => $domain_id])){
            throw new \RuntimeException();
        }
        return true;
    }
}
