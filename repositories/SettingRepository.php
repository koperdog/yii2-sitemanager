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

use \yii\db\ActiveRecord;
use koperdog\yii2sitemanager\models\
{
    Setting,
    SettingAssign,
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
        int $status    = Setting::STATUS['GENERAL'],
        int $domain_id = null,
        int $language_id   = null
    )
    {
        $defaultDomain = DomainRepository::getDefaultId();
        
        $model = SettingAssign::find()
                ->joinWith('setting')
                ->where(['status' => $status])
                ->andWhere(['or', ['domain_id' => $domain_id], ['domain_id' => $defaultDomain], ['domain_id' => null]])
                ->andWhere(['or', ['language_id' => $language_id], ['language_id' => null]])
                ->indexBy('setting.name')
                ->all();
        
        if(!$model){
            throw new \DomainException("Setting with status: {$status} does not exist");
        }
        
        return $model;
    }
    
    public function getAllByDomain(int $domain_id, int $language_id = null)
    {
        $defaultDomain = DomainRepository::getDefaultId();
        
        $model = SettingAssign::find()
                ->joinWith('setting')
                ->andWhere(['or', ['domain_id' => $domain_id], ['domain_id' => $defaultDomain], ['domain_id' => null]])
                ->andWhere(['or', ['language_id' => $language_id], ['language_id' => null]])
                ->indexBy('setting.name')
                ->all();
        
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
            
            $load = $data['SettingAssign'][$index];
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
    
    private function copySetting(ActiveRecord $setting, $domain_id, $language_id)
    {
        $newSetting = new SettingAssign();
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
        
        $settingAssign = new SettingAssign([
            'value'     => $form->value,
        ]);
        
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->save($setting);
            $settingAssign->link(self::RELATE_NAME, $setting);
            $transaction->commit();
        }catch(\RuntimeException $e){
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
}
