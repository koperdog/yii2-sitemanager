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
    
    public function copySettingsToDomain(int $domain_id): void
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
    
    public function deleteSettingsByDomain(int $domain_id): ?bool
    {
        return $this->setting->removeAllByDomain($domain_id);
    }
}