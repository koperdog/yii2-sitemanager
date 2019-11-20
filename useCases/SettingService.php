<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace koperdog\yii2settings\useCases;

use koperdog\yii2settings\repositories\{
    SettingRepository,
    DomainRepository,
    LanguageRepository
};
use \koperdog\yii2settings\models\Setting;

/**
 * Description of SettingService
 *
 * @author Koperdog <koperdog@github.com>
 */
class SettingService {
    private $setting;
    private $domain;
    private $language;
    
    public function __construct(SettingRepository $setting, DomainRepository $domain, LanguageRepository $language)
    {
        $this->setting  = $setting;
        $this->domain   = $domain;
        $this->language = $language;
    }
    
    public function saveMultiple(array $settings, array $data): bool
    {
        return $this->setting->saveAll($settings, $data);
    }
    
    public function copyAllToDomain(int $domain_id): void
    {
        $main_domain = $this->domain->getMain();
        $settings    = $this->setting->getAllByDomain($main_domain->id);
        
        foreach($settings as $setting){
            $new = new Setting();
            $new->attributes = $setting->attributes;
            $new->domain_id  = $domain_id;
            
            $this->setting->save($new);
        }
    }
    
    public function deleteAllByDomain(int $domain_id): ?bool
    {
        return $this->setting->removeAllByDomain($domain_id);
    }
    
    public function createSetting(Setting $form): bool
    {
        if($this->setting->existSetting($form->name)){
            throw new \DomainException("Setting already exists");
        }
        
        $setting = new Setting([
            'name'       => $form->name,
            'value'      => $form->value,
            'required'   => $form->required,
            'status'     => $form->status,
            'field_type' => $form->field_type
        ]);
        
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->copySettingToAllDomains($setting);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    private function copySettingToAllDomains(Setting $setting): void
    {
        $domains = $this->domain->getAll();
        foreach($domains as $domain){
            $copy = new Setting();
            $copy->attributes = $setting->attributes;
            $copy->domain_id  = $domain->id;
            
            $this->setting->save($copy);
        }
    }
}