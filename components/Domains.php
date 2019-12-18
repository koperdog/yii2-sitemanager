<?php

/**
 * @link https://github.com/koperdog/yii2-treeview
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-sitemanager/blob/master/LICENSE
 */

namespace koperdog\yii2sitemanager\components;

use koperdog\yii2sitemanager\repositories\read\DomainReadRepository;
use koperdog\yii2sitemanager\useCases\DomainService;

/**
 * Component for work with domains
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class Domains extends \yii\base\Component
{
    /**
     * @var string Current domain, SERVER_HOST
     */
    public $currentHost;
    
    /**
     * @var array Current|Default langauge
     */
    private static $current;
    
    /**
     * @var DomainService Service (UseCases) for work with domains
     */
    private $domainService;
    
    /**
     * @var DomainReadRepository Repository for work with domains model
     */
    private $domainRepository;
    
    public function __construct(DomainService $service, DomainReadRepository $repository) {
        parent::__construct();
        
        $this->currentHost = \Yii::$app->getRequest()->serverName;
        
        $this->domainService    = $service;
        $this->domainRepository = $repository;
        
        $this->getDomain();
    }
    
    /**
     * Gets id of current domain
     * 
     * @return int
     */
    public function getCurrentId(): int
    {
        return self::$current['id'];
    }
    
    /**
     * Gets current domain
     * 
     * @return array|null
     */
    public function getDomain(): ?array
    {
        if(self::$current === null){
            try{
                self::$current = $this->domainRepository->getByDomain($this->currentHost);
            } catch(\DomainException $e){
                self::$current = $this->getDefault();
            }
        }
        return self::$current;
    }
    
    /**
     * Gets default domain
     * 
     * @return array
     */
    public function getDefault(): array
    {
        return $this->domainRepository->getDefault();
    }
}
