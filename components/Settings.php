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
use koperdog\yii2sitemanager\repositories\read\{
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

        $this->loadToParams($this->loadCurrentSettings());
    }
    
    /**
     * gets setting by name
     * 
     * Gets setting by name, first for the domain, then for the main domain, then for the entire site
     * 
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        if(!$data = \Yii::$app->params[$name]){
            $data = $this->loadSetting($name);
        }
        
        return $data;
    }
    
    /**
     * Gets all settings
     * 
     * @return array|null
     */
    public function getAll(): ?array
    {
        return \Yii::$app->params;
    }
    
    public function clearCache(): void
    {
        $this->cache->delete(self::KEY_CACHE . "." . $this->domains->currentHost);
    }
    
    /**
     * Loads settings for the current domain
     * 
     * @return array
     */
    private function loadCurrentSettings(): array
    {
        $key = self::KEY_CACHE . "." . $this->domains->currentHost;
        $data = $this->cache->get($key);

        if ($data === false) {
            
            try{
                $data = $this->settingsRepository->getAllByDomain($this->domains->getCurrentId(),$this->languages->getCurrentId(), true);
            }
            catch(\DomainException $e){
                return [];
            }
            
            $this->cache->set($key, $data);
        }
        
        return (array)$data;
    }
    
    private function loadSetting(string $name): ?string
    {
        $key = self::KEY_CACHE . "." . $this->domains->currentHost . "." . $name;
        $data = $this->cache->get($key);
        
        if($data === false){
            try{
                $data = $this->settingsRepository->getByName($name, $this->domains->getCurrentId(), $this->languages->getCurrentId());
            }
            catch(\DomainException $e){
                $data = [];
            }
            
            $this->cache->set($key, $data);
        }
        
        \Yii::$app->params[$name] = $data['value']; 
        
        return \Yii::$app->params[$name];
    }
    
    private function loadToParams(array &$data): void
    {
        foreach($data as $key => $value){
            \Yii::$app->params[$key] = $value['value'];
        }
        
        unset($data);
    }
}