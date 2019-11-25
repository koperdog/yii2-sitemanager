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

namespace koperdog\yii2sitemanager\readModels;

use koperdog\yii2sitemanager\models\Domain;

/**
 * Repository for Domain model
 * 
 * Repository for Domain model, implements repository design
 *
 * @author Koperdog <koperdog@github.com>
 * @version 1.0
 */
class DomainReadRepository {
    
    /**
     * Checks if exists domain by name
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
     * @return array
     * @throws \DomainException
     */
    public function getAll(): array
    {
        if(!$models = Domain::find()->asArray()->all()){
            throw new \DomainException();
        }
        return $models;
    }
    
    /**
     * Gets domain by id
     * 
     * @param int $id
     * @return array
     * @throws \DomainException
     */
    public function get(int $id): array
    {
        if(!$model = Domain::find()->where(['id' => $id])->asArray()->one()){
            throw new \DomainException();
        }
        
        return $model;
    }
    
    /**
     * Gets main domain
     * 
     * @return array
     * @throws \DomainException
     */
    public function getDefault(): array
    {
        if(!$model = Domain::find()->where(['is_default' => Domain::MAIN])->asArray()->one()){
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
     * Gets domain by name
     * 
     * @param string $domain
     * @return array
     * @throws \DomainException
     */
    public function getByDomain(string $domain): array
    {
        if(!$model = Domain::find()->where(['domain' => $domain])->asArray()->one()){
            throw new \DomainException();
        }
        
        return $model;
    }
}
