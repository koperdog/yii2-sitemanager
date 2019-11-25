<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace koperdog\yii2sitemanager\useCases;

use koperdog\yii2sitemanager\repositories\{
    SettingRepository,
    DomainRepository,
    LanguageRepository
};

use \koperdog\yii2sitemanager\models\Domain;

/**
 * Description of SettingService
 *
 * @author Koperdog <koperdog@github.com>
 */
class DomainService {
    private $setting;
    private $domain;
    private $language;
    private $settingService;
    
    public function __construct(DomainRepository $domain, SettingRepository $setting, LanguageRepository $language, SettingService $settingService)
    {
        $this->setting         = $setting;
        $this->domain          = $domain;
        $this->language        = $language;
        $this->settingService = $settingService;
    }
    
    public function createDomain(array $form): bool
    {
        if($this->domain->existByDomain($form['domain'])){
            throw new \DomainException("Domain with such an address exists");
        }
        
        $domain = new Domain([
            'domain' => $form['domain'],
        ]);
        
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->domain->save($domain);
            $this->settingService->copyAllToDomain($domain->id);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }
    
    public function updateDomain(int $id, array $data): bool
    {
        $domain = $this->domain->get($id);
        $domain->load($data);
        
        $settings = $this->setting->getAllByDomain($id);
        
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->domain->save($domain);
            $this->settingService->saveMultiple($settings, $data);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }
    
    public function deleteDomain(Domain $domain): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->settingService->deleteAllByDomain($domain->id);
            $this->domain->remove($domain);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }
}
