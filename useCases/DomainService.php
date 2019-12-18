<?php

/**
 * @link https://github.com/koperdog/yii2-treeview
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-sitemanager/blob/master/LICENSE
 */

namespace koperdog\yii2sitemanager\useCases;

use koperdog\yii2sitemanager\repositories\{
    SettingRepository,
    DomainRepository
};
use \koperdog\yii2sitemanager\models\Domain;
use \koperdog\yii2sitemanager\models\forms\DomainForm;

/**
 * Service (UseCases) for domain model
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class DomainService {
    
    /**
     * @var SettingRepository repository of setting model 
     */
    private $settingRepository;
    
    /**
     * @var DomainRepository repository of domain model 
     */
    private $domainRepository;
    
    public function __construct(DomainRepository $domain, SettingRepository $setting)
    {
        $this->settingRepository = $setting;
        $this->domainRepository  = $domain;
    }
    
    /**
     * Updates domain
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateDomain(int $id, array $data): bool
    {
        $domain = $this->domainRepository->getById($id);
        $domain->load($data);
        
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->domainRepository->save($domain);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }
    
    /**
     * Creates domain
     * 
     * @param DomainForm $domain
     * @return Domain|null
     */
    public function create(DomainForm $domain): ?Domain
    {
        $newDomain = new Domain([
            'name'       => $domain->name,
            'domain'     => $domain->domain,
            'is_default' => $domain->is_default
        ]);
        
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->domainRepository->save($newDomain);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return null;
        }
        
        return $newDomain;
    }
    
    /**
     * Deletes domain
     * 
     * @param Domain $domain
     * @return bool
     */
    public function delete(Domain $domain): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $domain->unlinkAll('settings', true);
            $this->domainRepository->delete($domain);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }
    
    /**
     * Makes default domain
     * 
     * @param Domain $model
     * @return bool
     */
    public function makeDefault(Domain $model): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $default = $this->domainRepository->getDefault();
            $default->is_default = false;
            
            $model->is_default   = true;
            $this->domainRepository->save($default);
            $this->domainRepository->save($model);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }
}
