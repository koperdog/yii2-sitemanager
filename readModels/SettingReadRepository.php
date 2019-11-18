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

namespace koperdog\yii2settings\readModels;

use koperdog\yii2settings\models\Setting;

/**
 * Repository for Setting model
 * 
 * Repository for Setting model, implements repository design
 * 
 * @author Koperdog <koperdog@github.com>
 * @version 1.0
 */
class SettingReadRepository {
    
    /**
     * Gets all settings
     * 
     * @return array|null
     * @throws \DomainException
     */
    public function getAll(): ?array
    {
        if(!$models = Setting::find()->asArray()->all()){
            throw new \DomainException();
        }
        return $models;
    }
    
    /**
     * Gets all settings by status
     * 
     * @param int $status
     * @return array|null
     * @throws \DomainException
     */
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
    
    /**
     * Gets all settings by domain
     * 
     * @param int $domain_id
     * @param int $status
     * @param int $lang_id
     * @return array|null
     * @throws \DomainException
     */
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
    
    /**
     * Gets setting by id
     * 
     * @param int $id
     * @return Setting
     * @throws \DomainException
     */
    public function get(int $id): Setting
    {
        if(!$model = Setting::find()->where(['id' => $id])->asArray()->one()){
            throw new \DomainException();
        }
        
        return $model;
    }
}
