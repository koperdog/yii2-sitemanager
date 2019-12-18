<?php

/**
 * @link https://github.com/koperdog/yii2-treeview
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-sitemanager/blob/master/LICENSE
 */

namespace koperdog\yii2sitemanager\components;

use koperdog\yii2sitemanager\repositories\read\{
    SettingReadRepository,
    DomainReadRepository,
    LanguageReadRepository
};

/**
 * Component for work with settings
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
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
     * @var yii\caching\CacheInterface Yii cache component
     */
    private $cache;
    
    /**
     * @var SettingReadRepository Model for read settings data
     */
    private $settingsRepository;
    
    /**
     * @var DomainReadRepository Repository for read domains data
     */
    private $domainsRepository;
    
    /**
     * @var components\Domains Component for work with domains
     */
    private $domains;
    
    /**
     * @var components\Languages Component for work with languages
     */
    private $languages;
    
    /**
     * Component constructor 
     * 
     * @param SettingReadRepository $settings
     * @param DomainReadRepository $domains
     * @param LanguageReadRepository $languages
     */
    public function __construct(Domains $domains, Languages $languages, \yii\caching\FileCache $cache)
    {
        parent::__construct();
        
        $this->cache = $cache;
        
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
    
    /**
     * Cleans cache of current host
     * 
     * @return void
     */
    public function flushCache(): void
    {
        $key = [self::KEY_CACHE, 'host' => $this->domains->currentHost];
        $this->cache->delete($key);
    }
    
    /**
     * Loads settings for the current domain and current language
     * 
     * @return array
     */
    private function loadCurrentSettings(): array
    {
        $key = [self::KEY_CACHE, 'host' => $this->domains->currentHost];
        $data = $this->cache->get($key);

        if (!$data) {
            
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
    
    /**
     * Gets setting which one does not have autoload
     * 
     * @param string $name
     * @return string|null
     */
    private function loadSetting(string $name): ?string
    {
        $key = [self::KEY_CACHE, 'host' => $this->domains->currentHost];
        $data = $this->cache->get($key);
        
        if(!$data[$name]){
            try{
                $data[$name] = $this->settingsRepository->getByName($name, $this->domains->getCurrentId(), $this->languages->getCurrentId());
            }
            catch(\DomainException $e){
                $data[$name] = [];
            }
            
            $this->cache->set($key, $data);
        }
        
        
        \Yii::$app->params[$name] = $data[$name]['value']; 
        
        return \Yii::$app->params[$name];
    }
    
    /**
     * Loads setting value to general app params
     * 
     * @param array $data
     * @return void
     */
    private function loadToParams(array &$data): void
    {
        foreach($data as $key => $value){
            \Yii::$app->params[$key] = $value['value'];
        }
        
        unset($data);
    }
}