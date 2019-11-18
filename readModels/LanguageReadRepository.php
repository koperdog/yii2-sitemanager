<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace koperdog\yii2settings\readModels;

use koperdog\yii2settings\models\Language;

/**
 * Description of SettingRepository
 *
 * @author Koperdog <koperdog@github.com>
 */
class LanguageReadRepository {
    
    public function getAll(): ?array
    {
        if(!$models = Language::find()->asArray()->all()){
            throw new \DomainException();
        }
        return $models;
    }
    
    public function get(int $id): ?array
    {
        if(!$model = Language::find()->where(['id' => $id])->one()){
            throw new \DomainException();
        }
        
        return $model;
    }
}
