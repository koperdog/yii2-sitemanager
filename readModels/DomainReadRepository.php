<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace koperdog\yii2settings\readModels;

use koperdog\yii2settings\models\Domain;

/**
 * Description of SettingRepository
 *
 * @author Koperdog <koperdog@github.com>
 */
class DomainReadRepository {
    
    public function existByDomain(string $domain): bool
    {
        return Domain::find()->where(['domain' => $domain])->exists();
    }
    
    public function getAll(): array
    {
        if(!$models = Domain::find()->asArray()->all()){
            throw new \DomainException();
        }
        return $models;
    }
    
    public function get(int $id): array
    {
        if(!$model = Domain::find()->where(['id' => $id])->asArray()->one()){
            throw new \DomainException();
        }
        
        return $model;
    }
    
    public function getMain(): array
    {
        if(!$model = Domain::find()->where(['main' => Domain::MAIN])->asArray()->one()){
            throw new \DomainException();
        }
        
        return $model;
    }
    
    public function find(): ?\yii\db\ActiveQueryInterface
    {
        return Domain::find();
    }
    
    public function getByDomain(string $domain): array
    {
        if(!$model = Domain::find()->where(['domain' => $domain])->asArray()->one()){
            throw new \DomainException();
        }
        
        return $model;
    }
}
