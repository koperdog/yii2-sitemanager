<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace koperdog\yii2sitemanager\useCases;

use koperdog\yii2sitemanager\repositories\{
    SettingRepository,
    DomainRepository
};
use \koperdog\yii2sitemanager\models\Domain;
use \koperdog\yii2sitemanager\models\forms\DomainForm;

/**
 * Description of SettingService
 *
 * @author Koperdog <koperdog@github.com>
 */
class DomainService {
    private $settingRepository;
    private $domainRepository;
    
    public function __construct(DomainRepository $domain, SettingRepository $setting)
    {
        $this->settingRepository = $setting;
        $this->domainRepository  = $domain;
    }
    
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
