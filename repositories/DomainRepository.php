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

namespace koperdog\yii2settings\repositories;

use koperdog\yii2settings\models\Domain;

/**
 * Repository for Domain model
 * 
 * Repository for Domain model, implements repository design
 *
 * @author Koperdog <koperdog@github.com>
 * @version 1.0
 */
class DomainRepository {
    
    /**
     * Checks if exists Domain by name
     * 
     * @param string $domain
     * @return bool
     */
    public function existByDomain(string $domain): bool
    {
        return Domain::find()->where(['domain' => $domain])->exists();
    }
    
    /**
     * Gets all domains
     * 
     * @return array|null
     * @throws \DomainException
     */
    public function getAll(): ?array
    {
        if(!$models = Domain::find()->all()){
            throw new \DomainException();
        }
        return $models;
    }
    
    /**
     * Gets domain by id
     * 
     * @param int $id
     * @return Domain
     * @throws \DomainException
     */
    public function get(int $id): Domain
    {
        if(!$model = Domain::findOne($id)){
            throw new \DomainException();
        }
        
        return $model;
    }
    
    /**
     * Gets main domain
     * 
     * @return Domain
     * @throws \DomainException
     */
    public function getMain(): Domain
    {
        if(!$model = Domain::findOne(['main' => Domain::MAIN])){
            throw new \DomainException();
        }
        
        return $model;
    }
    
    /**
     * Looking for a domain
     * 
     * @return \yii\db\ActiveQueryInterface|null
     */
    public function find(): ?\yii\db\ActiveQueryInterface
    {
        return Domain::find();
    }
    
    /**
     * Saves domain
     * 
     * @param Domain $setting
     * @return bool
     * @throws \RuntimeException
     */
    public function save(Domain $setting): bool
    {
        if(!$setting->save()){
            throw new \RuntimeException();
        }
        return true;
    }
    
    /**
     * Removes domain
     * 
     * @param Domain $setting
     * @return bool
     * @throws \RuntimeException
     */
    public function remove(Domain $setting): bool
    {
        if(!$setting->delete()){
            throw new \RuntimeException();
        }
        return true;
    }
    
    /**
     * Gets domain by name
     * 
     * @param string $domain
     * @return Domain
     * @throws \DomainException
     */
    public function getByDomain(string $domain): Domain
    {
        if(!$model = Domain::find()->where(['domain' => $domain])->one()){
            throw new \DomainException();
        }
        
        return $model;
    }
}
