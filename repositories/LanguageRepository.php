<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace koperdog\yii2settings\repositories;

use koperdog\yii2settings\models\Language;

/**
 * Description of SettingRepository
 *
 * @author Koperdog <koperdog@github.com>
 */
class LanguageRepository {
    
    public function getAll(): ?array
    {
        if(!$models = Language::findAll()){
            throw new \DomainException();
        }
        return $models;
    }
    
    public function get(int $id): Language
    {
        if(!$model = Language::findOne($id)){
            throw new \DomainException();
        }
        
        return $model;
    }
    
    public function save(Language $setting): bool
    {
        if(!$setting->save()){
            throw new \RuntimeException();
        }
        return true;
    }
}
