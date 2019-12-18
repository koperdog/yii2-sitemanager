<?php

/**
 * @link https://github.com/koperdog/yii2-treeview
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-sitemanager/blob/master/LICENSE
 */

namespace koperdog\yii2sitemanager\repositories;

use yii\db\ActiveRecord;
use koperdog\yii2sitemanager\repositories\query\SettingValueQuery;
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
 * @author Koperdog <koperdog@dev.gmail.com>
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
        $model = SettingValueQuery::get($domain_id, $language_id, $status)->joinWith('setting')->indexBy('setting.name')->all();
        
        if(!$model){
            throw new \DomainException("Setting with status: {$status} does not exist");
        }
        
        return $model;
    }
    
    public function getAllByDomain(int $domain_id, int $language_id = null)
    {
        $model = SettingValueQuery::get($domain_id, $language_id)->indexBy('setting.name')->all();
        
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
