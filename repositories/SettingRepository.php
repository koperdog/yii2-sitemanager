<?php

/*
 * Copyright 2019 Koperdog <koperdog@github.com>.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace koperdog\yii2sitemanager\repositories;

use koperdog\yii2sitemanager\models\Setting;
use \yii\base\Model;

/**
 * Repository for Settings model
 * 
 * Repository for Settings model, implements repository design
 *
 * @author Koperdog <koperdog@github.com>
 * @version 1.0
 */
class SettingRepository {
    
    /**
     * Checks if exists Setting by name
     * 
     * @param string $name
     * @return bool
     */
    public function existSetting(string $name): bool
    {
        return Setting::find()->where(['name' => $name])->exists();
    }
    
    /**
     * Gets all settings
     * 
     * @return array|null
     * @throws \DomainException
     */
    public function getAll(): ?array
    {
        if(!$models = Setting::findAll()){
            throw new \DomainException();
        }
        return $models;
    }
    
    /**
     * Gets all settings by status
     * 
     * @return array|null
     * @throws \DomainException
     */
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
    
    /**
     * Gets all settings by domain id
     * 
     * @return array|null
     * @throws \DomainException
     */
    public function getAllByDomain(int $domain_id, int $status = null, int $lang_id = null): ?array
    {
        $models = Setting::find()
                ->where(['domain_id' => $domain_id])
                ->andFilterWhere(['status' => $status, 'lang_id' => $lang_id])
                ->indexBy('id')
                ->orderBy('status')
                ->all();
        
        if(!$models){
            throw new \DomainException();
        }
        
        return $models;
    }
    
    /**
     * Gets setting by id
     * 
     * @return array|null
     * @throws \DomainException
     */
    public function get(int $id): Setting
    {
        if(!$model = Setting::findOne($id)){
            throw new \DomainException();
        }
        
        return $model;
    }
    
    /**
     * Saves setting
     * 
     * @return array|null
     * @throws \DomainException
     */
    public function save(Setting $setting): bool
    {
        if(!$setting->save()){
            throw new \RuntimeException();
        }
        return true;
    }
    
    /**
     * Saves all settings
     * 
     * @return array|null
     * @throws \DomainException
     */
    public function saveAll(array $settings, array $data): bool
    {
        if (Model::loadMultiple($settings, $data) && Model::validateMultiple($settings)) {
            foreach ($settings as $setting) {
                $this->save($setting);
            }
        }
        
        return true;
    }
    
    /**
     * Removes all settings by domain id
     * 
     * @return array|null
     * @throws \DomainException
     */
    public function removeAllByDomain(int $domain_id): bool
    {
        if(!Setting::deleteAll(['domain_id' => $domain_id])){
            throw new \RuntimeException();
        }
        return true;
    }
}
