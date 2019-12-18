<?php

/**
 * @link https://github.com/koperdog/yii2-treeview
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-sitemanager/blob/master/LICENSE
 */

namespace koperdog\yii2sitemanager\repositories;

use \koperdog\yii2sitemanager\models\{
    Language, 
    LanguageSearch
};

/**
 * Repository for Language model
 * 
 * Repository for Language model, implements repository design
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class LanguageRepository 
{
    public function search(LanguageSearch $searchModel, array $query = [])
    {        
        return $searchModel->search($query);
    }
    
    public function exist(int $id): bool
    {
        return Language::find()->where(['id' => $id])->exists();
    }
    
    /**
     * Checks if exists Setting by name
     * 
     * @param string $name
     * @return bool
     */
    public function existSetting(string $name): bool
    {
        return Language::find()->where(['name' => $name])->exists();
    }
    
    public function getById(int $id): Language
    {
        if(!$model = Language::findOne($id)){
            throw new \DomainException("The language with id: {$id} does not exist");
        }
        
        return $model;
    }
    
    /**
     * Saves setting
     * 
     * @return array|null
     * @throws \DomainException
     */
    public function save(Language $language): bool
    {
        if(!$language->save()){
            throw new \RuntimeException();
        }
        return true;
    }
    
    public function delete(Language $language): bool
    {
        if(!$language->delete()){
            throw new RuntimeException();
        }
        
        return true;
    }
    
    public function getDefault(): Language
    {
        if(!$model = Language::find()->where(['is_default' => true])->one()){
            throw new \DomainException("The default language does not exist!");
        }
        
        return $model;
    }
    
    public static function getDefaultId(): ?int
    {
        $model = Language::find()->select('id')->where(['is_default' => true])->one();
        
        if(!$model){
            return null;
        }
        
        return $model->id;
    }
}
