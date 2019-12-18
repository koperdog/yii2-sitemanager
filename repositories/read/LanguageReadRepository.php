<?php

/**
 * @link https://github.com/koperdog/yii2-treeview
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-sitemanager/blob/master/LICENSE
 */

namespace koperdog\yii2sitemanager\repositories\read;

use koperdog\yii2sitemanager\interfaces\ReadReposotory;
use koperdog\yii2sitemanager\models\Language;

/**
 * Repository for Language model
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class LanguageReadRepository implements ReadReposotory
{
   
    public function getById(int $id): array
    {
        if(!$model = Language::find()->where(['id' => $id])->asArray()->one()){
            throw new \DomainException("The language with id: {$id} does not exist");
        }
        
        return $model;
    }
    
    public function getDefault(): array
    {
        if(!$model = Language::find()->where(['is_default' => true])->asArray()->one()){
            throw new \DomainException("The default language does not exist!");
        }
        
        return $model;
    }
    
    public function getAll(): ?array
    {        
        return Language::find()->asArray()->all();
    }
    
    public function getByCodeLocal(string $code_local): array
    {
        if(!$model = Language::find()->where(['code_local' => $code_local])->asArray()->one()){
            throw new \DomainException("The language with code local: {$code_local} does not exist!");
        }
        
        return $model;
    }
}
