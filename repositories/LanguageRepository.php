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

use \koperdog\yii2sitemanager\models\{
    Language, 
    LanguageSearch
};

/**
 * Repository for Language model
 * 
 * Repository for Language model, implements repository design
 *
 * @author Koperdog <koperdog@github.com>
 * @version 1.0
 */
class LanguageRepository 
{
    public function search(LanguageSearch $searchModel, array $query = [])
    {        
        return $searchModel->search($query);
    }
    
    public function exist(int $id): bool
    {
        return Language::find()->where(['id' => $id])->exists();
    }
    
    /**
     * Checks if exists Setting by name
     * 
     * @param string $name
     * @return bool
     */
    public function existSetting(string $name): bool
    {
        return Language::find()->where(['name' => $name])->exists();
    }
    
    public function getById(int $id): Language
    {
        if(!$model = Language::findOne($id)){
            throw new \DomainException("The language with id: {$id} does not exist");
        }
        
        return $model;
    }
    
    /**
     * Saves setting
     * 
     * @return array|null
     * @throws \DomainException
     */
    public function save(Language $language): bool
    {
        if(!$language->save()){
            throw new \RuntimeException();
        }
        return true;
    }
    
    public function delete(Language $language): bool
    {
        if(!$language->delete()){
            throw new RuntimeException();
        }
        
        return true;
    }
    
    public function getDefault(): Language
    {
        if(!$model = Language::find()->where(['is_default' => true])->one()){
            throw new \DomainException("The default language does not exist!");
        }
        
        return $model;
    }
    
    public static function getDefaultId(): ?int
    {
        $model = Language::find()->select('id')->where(['is_default' => true])->one();
        
        if(!$model){
            return null;
        }
        
        return $model->id;
    }
}
