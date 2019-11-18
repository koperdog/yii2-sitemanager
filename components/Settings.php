<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace koperdog\yii2settings\components;

use koperdog\yii2settings\models\Setting;
use koperdog\yii2settings\readModels\{
    SettingReadRepository,
    DomainReadRepository,
    LanguageReadRepository
};

/**
 * Description of Settings
 *
 * @author Koperdog <koperdog@github.com>
 */
class Settings extends \yii\base\Component
{
    const KEY_CACHE   = "kpg-settings";
    const MAIN_DOMAIN = "main";
    
    private $cache;
    
    private $data       = [];
    
    private $settings;
    private $domains;
    private $languages;
 
    public $currentDomain = "";
    
    public function __construct(SettingReadRepository $settings, DomainReadRepository $domains, LanguageReadRepository $languages)
    {
        $this->cache = \Yii::$app->cache;
        
        $this->settings  = $settings;
        $this->domains   = $domains;
        $this->languages = $languages;
        
        $this->currentDomain = \Yii::$app->getRequest()->serverName;

        $this->loadGeneralSettings();
        $this->loadMainDomainSettings();
        $this->loadCurrentSettings();
    }
    
    public function get(string $name): ?array
    {
        if(isset($this->data['domains'][$this->currentDomain][$name])){
            $tmp = $this->data['domains'][$this->currentDomain][$name];
        }
        else if(isset($this->data['domains'][self::MAIN_DOMAIN][$name])){
            $tmp = $this->data['domains'][self::MAIN_DOMAIN][$name];
        }
        else{
            $tmp = $this->data['general'][$name];
        }
        
        return $tmp;
    }
    
    public function getValue(string $name): ?string
    {        
        if(isset($this->data['domains'][$this->currentDomain][$name]['value'])){
            $tmp = $this->data['domains'][$this->currentDomain][$name]['value'];
        }
        else if(isset($this->data['domains'][self::MAIN_DOMAIN][$name]['value'])){
            $tmp = $this->data['domains'][self::MAIN_DOMAIN][$name]['value'];
        }
        else{
            $tmp = $this->data['general'][$name]['value'];
        }
        
        return $tmp;
    }
    
    public function getAll(): ?array
    {
        return $this->data;
    }
    
    public function getGeneral($name): ?string
    {
        return $this->data['general'][$name]['value'];
    }
    
    public function getAllByDomain(): ?array
    {
        return $this->data['domains'][$this->currentDomain];
    }
    
    private function loadGeneralSettings(): void
    {
        $key  = self::KEY_CACHE . "." . Setting::STATUS['GENERAL'];
        $data = $this->cache->get($key);

        if ($data === false) {
            $data = $this->settings->getAllByStatus(Setting::STATUS['GENERAL']);
            $this->cache->set($key, $data);
        }
        
        $this->data['general'] = $data;
    }
    
    private function loadMainDomainSettings(): void
    {
        $key = self::KEY_CACHE . "." . self::MAIN_DOMAIN;
        $data = $this->cache->get($key);

        if ($data === false) {
            $domain = $this->domains->getMain();
            $data = $this->settings->getAllByDomain($domain['id']);
            $this->cache->set($key, $data);
        }
        
        $this->data['domains'][self::MAIN_DOMAIN] = $data;
    }
    
    private function loadCurrentSettings(): void
    {
        $key = self::KEY_CACHE . "." . $this->currentDomain;
        $data = $this->cache->get($key);

        if ($data === false) {
            
            try{
                $domain = $this->domains->getByDomain($this->currentDomain);
                $data = $this->settings->getAllByDomain($domain['id']);
            }
            catch(\DomainException $e){
                return;
            }
            
            $this->cache->set($key, $data);
        }
        
        $this->data['domains'][$this->currentDomain] = $data;
    }
}
