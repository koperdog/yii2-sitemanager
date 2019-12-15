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
use koperdog\yii2sitemanager\repositories\DomainRepository;
use koperdog\yii2sitemanager\models\
{
    Setting,
    SettingValue
};

/**
 * Repository for Settings model
 * 
 * Repository for Settings model, implements repository design
 *
 * @author Koperdog <koperdog@github.com>
 * @version 1.0
 */
class SettingReadRepository implements ReadReposotory
{

    public function getById(int $id): array
    {        
        return Setting::find()->where(['id' => $id])->asArray()->one();
    }
    
    public function getAllByStatus
    (
        int $status    = Setting::STATUS['GENERAL'],
        $domain_id     = null,
        $language_id   = null,
        $autoload      = null
    ): array
    {
        $defaultDomain = DomainRepository::getDefaultId();
        
        $model = SettingValue::find()
                ->joinWith('setting')
                ->where(['status' => $status])
                ->andWhere(['or', ['domain_id' => $domain_id], ['domain_id' => $defaultDomain], ['domain_id' => null]])
                ->andWhere(['or', ['language_id' => $language_id], ['language_id' => null]])
                ->andFilterWhere(['setting.autoload' => $autoload])
                ->indexBy('setting.name')
                ->groupBy('setting_id, id')
                ->asArray()
                ->all();
                
        return $model;
    }
    
    public function getAllByDomain(int $domain_id, int $language_id = null, $autoload = null): array
    {
        $defaultDomain = DomainRepository::getDefaultId();
        
        $model = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['or', ['domain_id' => $domain_id], ['domain_id' => $defaultDomain], ['domain_id' => null]])
                ->andWhere(['or', ['language_id' => $language_id], ['language_id' => null]])
                ->andFilterWhere(['setting.autoload' => $autoload])
                ->indexBy('setting.name')
                ->groupBy('setting_id, id')
                ->asArray()
                ->all();
        
        return $model;
    }
    
    public function getByName(string $name, $domain_id = null, $language_id = null): array
    {
        $defaultDomain = DomainRepository::getDefaultId();
        
        $model = SettingValue::find()
                ->joinWith('setting')
                ->where(['name' => $name])
                ->andWhere(['or', ['domain_id' => $domain_id], ['domain_id' => $defaultDomain], ['domain_id' => null]])
                ->andWhere(['or', ['language_id' => $language_id], ['language_id' => null]])
                ->indexBy('setting.name')
                ->asArray()
                ->one();
        
        return $model;
    }
    
    public function getAll(): ?array
    {
        return Setting::find()->asArray()->all();
    }
}
