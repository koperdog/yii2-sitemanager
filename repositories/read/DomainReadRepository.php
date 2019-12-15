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

namespace koperdog\yii2sitemanager\repositories\read;

use koperdog\yii2sitemanager\interfaces\ReadReposotory;
use koperdog\yii2sitemanager\models\Domain;

/**
 * Repository for Domain model
 * 
 * Repository for Domain model, implements repository design
 *
 * @author Koperdog <koperdog@github.com>
 * @version 1.0
 */
class DomainReadRepository implements ReadReposotory
{
   
    public function getById(int $id): array
    {
        if(!$model = Domain::find()->where(['id' => $id])->asArray()->one()){
            throw new \DomainException("The domain with id: {$id} does not exist");
        }
        
        return $model;
    }
    
    public function getByDomain(string $name): array
    {
        if(!$model = Domain::find()->where(['domain' => $name])->asArray()->one()){
            throw new \DomainException("The domain with name: {$name} does not exist!");
        }
        
        return $model;
    }
    
    public function getDefault(): array
    {
        if(!$model = Domain::find()->where(['is_default' => true])->asArray()->one()){
            throw new \DomainException("The default domain does not exist!");
        }
        
        return $model;
    }
    
    public function getAll(): ?array
    {
        return Domain::find()->asArray()->all();
    }
}
