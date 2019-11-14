<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace koperdog\yii2settings\repositories;

use koperdog\yii2settings\models\Domain;

/**
 * Description of SettingRepository
 *
 * @author Koperdog <koperdog@github.com>
 */
class DomainRepository {
    
    public function existByDomain(string $domain): bool
    {
        return Domain::find()->where(['domain' => $domain])->exists();
    }
    
    public function getAll(): ?array
    {
        if(!$models = Domain::findAll()){
            throw new \DomainException();
        }
        return $models;
    }
    
    public function get(int $id): Domain
    {
        if(!$model = Domain::findOne($id)){
            throw new \DomainException();
        }
        
        return $model;
    }
    
    public function getMain(): Domain
    {
        if(!$model = Domain::findOne(['main' => Domain::MAIN])){
            throw new \DomainException();
        }
        
        return $model;
    }
    
    public function find(): ?\yii\db\ActiveQueryInterface
    {
        return Domain::find();
    }
    
    public function save(Domain $setting): bool
    {
        if(!$setting->save()){
            throw new \RuntimeException();
        }
        return true;
    }
    
    public function remove(Domain $setting): bool
    {
        if(!$setting->delete()){
            throw new \RuntimeException();
        }
        return true;
    }
}
