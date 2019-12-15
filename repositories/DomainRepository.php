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

use koperdog\yii2sitemanager\models\{
    Domain,
    DomainSearch
};

/**
 * Repository for Domain model
 * 
 * Repository for Domain model, implements repository design
 *
 * @author Koperdog <koperdog@github.com>
 * @version 1.0
 */
class DomainRepository 
{
    private static $default;
    
    public function search(DomainSearch $searchModel, array $query = [])
    {        
        return $searchModel->search($query);
    }
    
    public function exist(int $id): bool
    {
        return Domain::find()->where(['id' => $id])->exists();
    }
    
    /**
     * Checks if exists Setting by name
     * 
     * @param string $name
     * @return bool
     */
    public function existSetting(string $name): bool
    {
        return Domain::find()->where(['name' => $name])->exists();
    }
    
    public function getById(int $id): Domain
    {
        if(!$model = Domain::findOne($id)){
            throw new \DomainException("The domain with id: {$id} does not exist");
        }
        
        return $model;
    }
    
    /**
     * Saves setting
     * 
     * @return array|null
     * @throws \DomainException
     */
    public function save(Domain $domain): bool
    {
        if(!$domain->save()){
            throw new \RuntimeException();
        }
        return true;
    }
    
    public function delete(Domain $domain): bool
    {
        if(!$domain->delete()){
            throw new RuntimeException();
        }
        
        return true;
    }
    
    public function getDefault(): Domain
    {
        if(!$model = Domain::find()->where(['is_default' => true])->one()){
            throw new \DomainException("The default domain does not exist!");
        }
        
        return $model;
    }
    
    public static function getDefaultId(): ?int
    {
        if(!self::$default){
            self::$default = Domain::find()->select('id')->where(['is_default' => true])->one();
        }
        
        return self::$default['id'];
    }
}
