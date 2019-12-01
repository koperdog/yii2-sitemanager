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

/**
 * Description of SettingService
 *
 * @author Koperdog <koperdog@github.com>
 */
class DomainService {
    private $setting;
    private $domain;
    
    public function __construct(DomainRepository $domain, SettingRepository $setting)
    {
        $this->setting         = $setting;
        $this->domain          = $domain;
    }
    
    public function updateDomain(int $id, array $data): bool
    {
        $domain = $this->domain->get($id);
        $domain->load($data);
        
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->domain->save($domain);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }
}
