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
    SettingValue,
    forms\SettingForm
};

/**
 * Description of SettingService
 *
 * @author Koperdog <koperdog@github.com>
 */
class SettingService {
    private $settingRepository;
    private $domainRepository;
    
    public function __construct(SettingRepository $setting, DomainRepository $domain)
    {
        $this->settingRepository = $setting;
        $this->domainRepository  = $domain;
    }
    
    public function create(SettingForm $form, $status = Setting::STATUS['CUSTOM']): bool
    {
        return $this->settingRepository->create($form, $status);
    }
    
    public function saveMultiple(array $settings, array $data, int $domain_id = null, int $language_id = null): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $success = $this->settingRepository->saveAll($settings, $data, $domain_id, $language_id);
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
            $this->settingRepository->save($setting);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    public function delete(Setting $setting): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $setting->unlinkAll('values', true);
            $this->settingRepository->delete($setting);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
}