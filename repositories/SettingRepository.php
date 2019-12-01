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
class SettingRepository {
    
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
    
    public function getAllByStatus
    (
        int $status    = Setting::STATUS['GENERAL'],
        int $domain_id = null,
        int $lang_id   = null
    )
    {
        $model =  Setting::find()
                ->joinWith('assign assign')
                ->where(['status' => $status])
                ->andFilterWhere(['assign.domain_id' => $domain_id, 'assign.lang_id' => $lang_id])
                ->indexBy('name')
                ->all();
        
        if(!$model){
            throw new DomainException("Setting with status: {$status} does not exist");
        }
        
        return $model;
    }
    
    public function getAllByDomain(int $domain_id, int $lang_id = null)
    {
        $model =  Setting::find()
                ->joinWith('assign assign')
                ->where(['assign.domain_id' => $domain_id])
                ->andFilterWhere(['assign.lang_id' => $lang_id])
                ->indexBy('name')
                ->all();
        
        if(!$model){
            throw new DomainException("Setting for domain id: {$domain_id} does not exist");
        }
        
        return $model;
    }
    
    /**
     * Saves setting
     * 
     * @return array|null
     * @throws \DomainException
     */
    public function save(\yii\db\ActiveRecord $setting): bool
    {
        if(!$setting->save()){
            throw new \RuntimeException();
        }
        return true;
    }
    
    /**
     * Saves all settings
     * 
     * @return array|null
     * @throws \DomainException
     */
    public function saveAll(array $settings, array $data): bool
    {
        foreach($settings as $index => $setting){
            
            $load = $data['SettingAssign'][$index];
            $load['required'] = $setting->required;
            
            if($setting->assign->load($load, '') && $setting->assign->validate()){
                $this->save($setting->assign);
            }
            else{
                return false;
            }
        }
        
        return true;
    }
    
    public function create(SettingForm $form, int $domain_id, $status = Setting::STATUS['CUSTOM']): bool
    {
        $setting = new Setting([
            'name'     => $form->name,
            'autoload' => $form->autoload,
            'required' => $form->required,
            'status'   => $status
        ]);
        
        $settingAssign = new SettingAssign([
            'value'     => $form->value,
            'domain_id' => $domain_id
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
