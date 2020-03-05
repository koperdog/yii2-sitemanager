<?php

/**
 * @link https://github.com/koperdog/yii2-sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-sitemanager/blob/master/LICENSE
 */

namespace koperdog\yii2sitemanager\repositories;

use koperdog\yii2sitemanager\models\{
    Domain,
    DomainSearch
};

/**
 * Repository for Domain model
 * 
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class DomainRepository 
{
    private static $default;
    
    public function search(DomainSearch $searchModel, array $query = [])
    {        
        return $searchModel->search($query);
    }
    
    public function exist(int $id): bool
    {
        return Domain::find()->where(['id' => $id])->exists();
    }
    
    /**
     * Checks if exists Setting by name
     * 
     * @param string $name
     * @return bool
     */
    public function existSetting(string $name): bool
    {
        return Domain::find()->where(['name' => $name])->exists();
    }
    
    public function getById(int $id): Domain
    {
        if(!$model = Domain::findOne($id)){
            throw new \DomainException("The domain with id: {$id} does not exist");
        }
        
        return $model;
    }
    
    /**
     * Saves setting
     * 
     * @return array|null
     * @throws \DomainException
     */
    public function save(Domain $domain): bool
    {
        if(!$domain->save()){
            throw new \RuntimeException();
        }
        return true;
    }
    
    public function delete(Domain $domain): bool
    {
        if(!$domain->delete()){
            throw new RuntimeException();
        }
        
        return true;
    }
    
    public function getDefault(): Domain
    {
        if(!$model = Domain::find()->where(['is_default' => true])->one()){
            throw new \DomainException("The default domain does not exist!");
        }
        
        return $model;
    }
    
    public static function getDefaultId(): ?int
    {
        if(!self::$default){
            self::$default = Domain::find()->select('id')->where(['is_default' => true])->one();
        }
        
        return self::$default['id'];
    }
}
