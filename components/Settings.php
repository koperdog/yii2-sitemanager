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

namespace koperdog\yii2sitemanager\components;

use koperdog\yii2sitemanager\models\Setting;
use koperdog\yii2sitemanager\readModels\{
    SettingReadRepository,
    DomainReadRepository,
    LanguageReadRepository
};

/**
 * Description of Settings
 *
 * @author Koperdog <koperdog@github.com>
 * @version 1.0
 * @todo Gets setting for the current language
 */
class Settings extends \yii\base\Component
{
    /**
     * key cache
     */
    const KEY_CACHE   = "kpg-settings";
    
    /**
     * default main domain
     */
    const MAIN_DOMAIN = "main";
    
    /**
     * Yii cache component
     *
     * @var type yii\caching\CacheInterface
     */
    private $cache;
    
    /**
     * All settings
     * 
     * @var type array
     */
    private $data       = [];
    
    /**
     * Model for read settings data
     * 
     * Model for read settings, implements repository design
     * 
     * @var type koperdog\yii2sitemanager\readModels\SettingReadRepository
     */
    private $settingsRepository;
    
    /**
     * Model for read domains data
     * 
     * Model for read domains, implements repository design
     * 
     * @var type koperdog\yii2sitemanager\readModels\DomainReadRepository
     */
    private $domainsRepository;
    
    /**
     * Model for read domain data
     * 
     * Model for read domain, implements repository design
     * 
     * @var type koperdog\yii2sitemanager\readModels\DomainReadRepository
     */
    private $domains;
    
    /**
     * Model for read languages data
     * 
     * Model for read languages, implements repository design
     * 
     * @var type koperdog\yii2sitemanager\readModels\LanguageReadRepository
     */
    private $languages;
    
    /**
     * Component constructor 
     * 
     * @param SettingReadRepository $settings
     * @param DomainReadRepository $domains
     * @param LanguageReadRepository $languages
     */
    public function __construct(Domains $domains, Languages $languages)
    {
        parent::__construct();
        
        $this->cache = \Yii::$app->cache;
        
        $this->domains   = $domains;
        $this->languages = $languages;
        
        $this->settingsRepository  = new SettingReadRepository();
        $this->domainsRepository   = new DomainReadRepository();

        $this->loadGeneralSettings();
        $this->loadMainDomainSettings();
        $this->loadCurrentSettings();
    }
    
    /**
     * gets setting by name
     * 
     * Gets setting by name, first for the domain, then for the main domain, then for the entire site
     * 
     * @param string $name
     * @return array|null
     */
    public function get(string $name): ?array
    {
        if(isset($this->data['domains'][$this->domains->getDomain()][$name])){
            $tmp = $this->data['domains'][$this->domains->getDomain()][$name];
        }
        else if(isset($this->data['domains'][self::MAIN_DOMAIN][$name])){
            $tmp = $this->data['domains'][self::MAIN_DOMAIN][$name];
        }
        else{
            $tmp = $this->data['general'][$name];
        }
        
        return $tmp;
    }
    
    /**
     * gets setting value by name
     * 
     * Gets setting value by name, first for the domain, then for the main domain, then for the entire site
     * 
     * @param string $name
     * @return string|null
     */
    public function getValue(string $name): ?string
    {        
        if(isset($this->data['domains'][$this->domains->getDomain()][$name]['value'])){
            $tmp = $this->data['domains'][$this->domains->getDomain()][$name]['value'];
        }
        else if(isset($this->data['domains'][self::MAIN_DOMAIN][$name]['value'])){
            $tmp = $this->data['domains'][self::MAIN_DOMAIN][$name]['value'];
        }
        else{
            $tmp = $this->data['general'][$name]['value'];
        }
        
        return $tmp;
    }
    
    /**
     * Gets all settings
     * 
     * @return array|null
     */
    public function getAll(): ?array
    {
        return $this->data;
    }
    
    /**
     * Gets general setting by name
     * 
     * @param type $name
     * @return string|null
     */
    public function getGeneral($name): ?string
    {
        return $this->data['general'][$name]['value'];
    }
    
    /**
     * Gets all settings for the current domain
     * 
     * @return array|null
     */
    public function getAllByDomain(): ?array
    {
        return $this->data['domains'][$this->domains->getDomain()];
    }
    
    /**
     * Loads general settings
     * 
     * @return void
     */
    private function loadGeneralSettings(): void
    {
        $key  = self::KEY_CACHE . "." . Setting::STATUS['GENERAL'];
        $data = $this->cache->get($key);

        if ($data === false) {
            $data = $this->settingsRepository->getAllByStatus(Setting::STATUS['GENERAL']);
            $this->cache->set($key, $data);
        }
        
        $this->data['general'] = $data;
    }
    
    /**
     * Loads settings for the main domain
     * 
     * @return void
     */
    private function loadMainDomainSettings(): void
    {
        $key = self::KEY_CACHE . "." . self::MAIN_DOMAIN;
        $data = $this->cache->get($key);

        if ($data === false) {
            $domain = $this->domainsRepository->getDefault();
            $data = $this->settingsRepository->getAllByDomain($domain['id']);
            $this->cache->set($key, $data);
        }
        
        $this->data['domains'][self::MAIN_DOMAIN] = $data;
    }
    
    /**
     * Loads settings for the current domain
     * 
     * @return void
     */
    private function loadCurrentSettings(): void
    {
        $key = self::KEY_CACHE . "." . $this->domains->getDomain();
        $data = $this->cache->get($key);

        if ($data === false) {
            
            try{
                $domain = $this->domainsRepository->getByDomain($this->domains->getDomain());
                $data = $this->settingsRepository->getAllByDomain($domain['id']);
            }
            catch(\DomainException $e){
                return;
            }
            
            $this->cache->set($key, $data);
        }
        
        $this->data['domains'][$this->domains->getDomain()] = $data;
    }
}
