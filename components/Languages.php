<?php

/**
 * @link https://github.com/koperdog/yii2-treeview
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-sitemanager/blob/master/LICENSE
 */

namespace koperdog\yii2sitemanager\components;

use koperdog\yii2sitemanager\repositories\read\LanguageReadRepository;
use koperdog\yii2sitemanager\useCases\LanguageService;

/**
 * Component for work with Languages
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class Languages extends \yii\base\Component
{    
    /**
     * @var array Current|Default language
     */
    private static $current;
    
    /**
     * @var LanguageService Service (UseCases) of language
     */
    private $languageService;
    
    /**
     * @var LanguageReadRepository Repository for work with language model
     */
    private $languageRepository;
    
    public function __construct(LanguageService $service, LanguageReadRepository $repository)
    {
        parent::__construct();
        
        $this->languageService    = $service;
        $this->languageRepository = $repository;
        
        $this->getCurrent(\Yii::$app->language);
    }
    
    /**
     * Gets current language
     * 
     * @param string $code_local
     * @return array
     */
    public function getCurrent(string $code_local): array
    {
        if(self::$current === null){
            try{
                self::$current = $this->languageRepository->getByCodeLocal($code_local);
            } catch(\DomainException $e){
                self::$current = $this->getDefault();
            }
        }
        
        return self::$current;
    }
    
    /**
     * Gets id of current language
     * 
     * @return int
     */
    public function getCurrentId(): int
    {
        return self::$current['id'];
    }
    
    
    /**
     * Gets default langauge
     * 
     * @return array
     */
    public function getDefault(): array
    {
        return $this->languageRepository->getDefault();
    }
}
