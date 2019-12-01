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
use \koperdog\yii2sitemanager\models\{
    Setting,
    SettingAssign,
    forms\SettingForm
};

/**
 * Description of SettingService
 *
 * @author Koperdog <koperdog@github.com>
 */
class SettingService {
    private $setting;
    private $domain;
    
    public function __construct(SettingRepository $setting, DomainRepository $domain)
    {
        $this->setting = $setting;
        $this->domain  = $domain;
    }
    
    public function create(SettingForm $form, $status = Setting::STATUS['CUSTOM']): bool
    {
        $domain = $this->domain->getDefault();
        return $this->setting->create($form, $domain->id, $status);
    }
    
    public function saveMultiple(array $settings, array $data): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $success = $this->setting->saveAll($settings, $data);
            $transaction->commit();
        }catch(\RuntimeException $e){
            $transaction->rollBack();
            return false;
        }
        
        return $success;
    }
    
    public function save(Setting $setting): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->setting->save($setting);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
}