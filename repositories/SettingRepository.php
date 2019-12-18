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

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use koperdog\yii2sitemanager\models\
{
    Setting,
    SettingValue,
    forms\SettingForm
};

/**
 * Repository for Settings model
 * 
 * Repository for Settings model, implements repository design
 *
 * @author Koperdog <koperdog@github.com>
 * @version 1.0
 */
class SettingRepository 
{
    
    const RELATE_NAME = 'setting';
    
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
    
    public function getById(int $id): Setting
    {
        if(!$model = Setting::findOne($id)){
            throw new DomainException();
        }
        
        return $model;
    }
    
    public function getAllByStatus
    (
        int $status      = Setting::STATUS['GENERAL'],
        int $domain_id   = null,
        int $language_id = null
    )
    {        
        $model = $this->_get($domain_id, $language_id, $status)->joinWith('setting')->indexBy('setting.name')->all();
        
        if(!$model){
            throw new \DomainException("Setting with status: {$status} does not exist");
        }
        
        return $model;
    }
    
    public function getAllByDomain(int $domain_id, int $language_id = null)
    {
        $model = $this->_get($domain_id, $language_id)->indexBy('setting.name')->all();
        
        if(!$model){
            throw new \DomainException("Setting for domain id: {$domain_id} does not exist");
        }
        
        return $model;
    }
    
    /**
     * Saves setting
     * 
     * @return bool
     * @throws \DomainException
     */
    public function save(ActiveRecord $setting): bool
    {
        if(!$setting->save()){
            throw new \RuntimeException();
        }
        
        return true;
    }
    
    public function delete(ActiveRecord $setting): bool
    {
        if(!$setting->delete()){
            throw new RuntimeException();
        }
        
        return true;
    }
    
    /**
     * Saves all settings
     * 
     * @param array $settings
     * @param array $data
     * @return bool
     */
    public function saveAll(array $settings, array $data, $domain_id = null, $language_id = null): bool
    {
        foreach($settings as $index => $setting){
            
            $load = $data['SettingValue'][$index];
            $load['required'] = $setting->setting->required;
                        
            if($setting->load($load, '') && $setting->validate()){
                if(($setting->domain_id != $domain_id || $setting->language_id != $language_id)
                    && $setting->getDirtyAttributes())
                {
                    $this->copySetting($setting, $domain_id, $language_id);
                }
                else{
                    $this->save($setting);
                }
            }
            else{
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Generates the monster query for gets setting value
     * 
     * @param type $domain_id
     * @param type $language_id
     * @return \yii\db\ActiveQuery
     */
    private function _get($domain_id = null, $language_id = null, $status = null): \yii\db\ActiveQuery
    {
        $defaultDomain = DomainRepository::getDefaultId();
        
        $query = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->andFilterWhere(['setting.status' => $status]);
        
        if($language_id){
            $subquery = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['domain_id' => $domain_id, 'language_id' => null])
                ->andWhere(['NOT IN', 'setting_id', 
                (new \yii\db\Query)
                ->select('setting_id')
                ->from(SettingValue::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ])
                ->andFilterWhere(['setting.status' => $status]);
            
            $query->union($subquery);
        }
        
        if($domain_id != $defaultDomain && $domain_id){
            $subquery = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->andWhere(['NOT IN', 'setting_id', 
                (new \yii\db\Query)
                ->select('setting_id')
                ->from(SettingValue::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $domain_id, 'language_id' => null])
                ])
                ->andFilterWhere(['setting.status' => $status]);
            
            $query->union($subquery);
        }
        
        if($domain_id != $defaultDomain && $domain_id && $language_id){
            $subquery = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['domain_id' => $defaultDomain, 'language_id' => null])
                ->andWhere(['NOT IN', 'setting_id', 
                (new \yii\db\Query)
                ->select('setting_id')
                ->from(SettingValue::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $domain_id, 'language_id' => null])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ])
                ->andFilterWhere(['setting.status' => $status]);
            
            $query->union($subquery);
        }
        
        if($domain_id && $language_id){
            $subquery = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['domain_id' => null, 'language_id' => $language_id])
                ->andWhere(['NOT IN', 'setting_id', 
                (new \yii\db\Query)
                ->select('setting_id')
                ->from(SettingValue::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $domain_id, 'language_id' => null])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => null])
                ])
                ->andFilterWhere(['setting.status' => $status]);
            
            $query->union($subquery);
        }
        
        if($domain_id || $language_id){
            
            $exclude = (new \yii\db\Query)
                    ->select('setting_id')
                    ->from(SettingValue::tableName())
                    ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id]);
            
            if($domain_id) $exclude->orWhere(['domain_id' => $domain_id, 'language_id' => null]);
            
            $exclude->orWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => null]);
            
            if($language_id) $exclude->orWhere(['domain_id' => null, 'language_id' => $language_id]);
            
            $subquery = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['domain_id' => null, 'language_id' => null])
                ->andWhere(['NOT IN', 'setting_id', $exclude])
                ->andFilterWhere(['setting.status' => $status]);
            
            $query->union($subquery);
        }
        
        return $query;
    }
    
    private function copySetting(ActiveRecord $setting, $domain_id, $language_id)
    {
        $newSetting = new SettingValue();
        $newSetting->attributes = $setting->attributes;
        
        $newSetting->domain_id   = $domain_id;
        $newSetting->language_id = $language_id;
        
        return $this->save($newSetting);
    }
    
    public function create(SettingForm $form, $status = Setting::STATUS['CUSTOM']): bool
    {
        $setting = new Setting([
            'name'     => $form->name,
            'autoload' => $form->autoload,
            'required' => $form->required,
            'status'   => $status
        ]);
        
        $settingValue = new SettingValue([
            'value'     => $form->value,
        ]);
        
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->save($setting);
            $settingValue->link(self::RELATE_NAME, $setting);
            $transaction->commit();
        }catch(\RuntimeException $e){
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
}
