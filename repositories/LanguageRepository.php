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

use koperdog\yii2settings\models\Language;

/**
 * Repository for Language model
 * 
 * Repository for Language model, implements repository design
 *
 * @author Koperdog <koperdog@github.com>
 * @version 1.0
 */
class LanguageRepository {
    
    /**
     * Gets all languages
     * 
     * @return array|null
     * @throws \DomainException
     */
    public function getAll(): ?array
    {
        if(!$models = Language::findAll()){
            throw new \DomainException();
        }
        return $models;
    }
    
    /**
     * Gets language by id
     * 
     * @param int $id
     * @return Language
     * @throws \DomainException
     */
    public function get(int $id): Language
    {
        if(!$model = Language::findOne($id)){
            throw new \DomainException();
        }
        
        return $model;
    }
    
    /**
     * Saves language
     * 
     * @param Language $setting
     * @return bool
     * @throws \RuntimeException
     */
    public function save(Language $setting): bool
    {
        if(!$setting->save()){
            throw new \RuntimeException();
        }
        return true;
    }
}
