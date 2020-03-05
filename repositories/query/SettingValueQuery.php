<?php

/**
 * @link https://github.com/koperdog/yii2-sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-sitemanager/blob/master/LICENSE
 */

namespace koperdog\yii2sitemanager\repositories\query;

use koperdog\yii2sitemanager\models\SettingValue;
use koperdog\yii2sitemanager\repositories\DomainRepository;

/**
 * Description of SettingValueQuery
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class SettingValueQuery {
    
    /**
     * Generates the monster query for gets setting value
     * 
     * @param type $domain_id
     * @param type $language_id
     * @return \yii\db\ActiveQuery
     */
    public static function get($domain_id = null, $language_id = null, $status = null, $autoload = null): \yii\db\ActiveQuery
    {
        $defaultDomain = DomainRepository::getDefaultId();
        
        $query = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->andFilterWhere(['setting.status' => $status, 'setting.autoload' => $autoload]);
        
        if($language_id){
            $subquery = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['domain_id' => $domain_id, 'language_id' => null])
                ->andWhere(['NOT IN', 'setting_id', 
                (new \yii\db\Query)
                ->select('setting_id')
                ->from(SettingValue::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ])
                ->andFilterWhere(['setting.status' => $status, 'setting.autoload' => $autoload]);
            
            $query->union($subquery);
        }
        
        if($domain_id != $defaultDomain && $domain_id){
            $subquery = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->andWhere(['NOT IN', 'setting_id', 
                (new \yii\db\Query)
                ->select('setting_id')
                ->from(SettingValue::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $domain_id, 'language_id' => null])
                ])
                ->andFilterWhere(['setting.status' => $status, 'setting.autoload' => $autoload]);
            
            $query->union($subquery);
        }
        
        if($domain_id != $defaultDomain && $domain_id && $language_id){
            $subquery = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['domain_id' => $defaultDomain, 'language_id' => null])
                ->andWhere(['NOT IN', 'setting_id', 
                (new \yii\db\Query)
                ->select('setting_id')
                ->from(SettingValue::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $domain_id, 'language_id' => null])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ])
                ->andFilterWhere(['setting.status' => $status, 'setting.autoload' => $autoload]);
            
            $query->union($subquery);
        }
        
        if($domain_id && $language_id){
            $subquery = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['domain_id' => null, 'language_id' => $language_id])
                ->andWhere(['NOT IN', 'setting_id', 
                (new \yii\db\Query)
                ->select('setting_id')
                ->from(SettingValue::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $domain_id, 'language_id' => null])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => null])
                ])
                ->andFilterWhere(['setting.status' => $status, 'setting.autoload' => $autoload]);
            
            $query->union($subquery);
        }
        
        if($domain_id || $language_id){
            
            $exclude = (new \yii\db\Query)
                    ->select('setting_id')
                    ->from(SettingValue::tableName())
                    ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id]);
            
            if($domain_id) $exclude->orWhere(['domain_id' => $domain_id, 'language_id' => null]);
            
            $exclude->orWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => null]);
            
            if($language_id) $exclude->orWhere(['domain_id' => null, 'language_id' => $language_id]);
            
            $subquery = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['domain_id' => null, 'language_id' => null])
                ->andWhere(['NOT IN', 'setting_id', $exclude])
                ->andFilterWhere(['setting.status' => $status, 'setting.autoload' => $autoload]);
            
            $query->union($subquery);
        }
        
        return $query;
    }
    
    /**
     * Generates the monster query for gets setting value
     * 
     * @param type $domain_id
     * @param type $language_id
     * @return \yii\db\ActiveQuery
     */
    public static function getByName(string $name, $domain_id = null, $language_id = null): \yii\db\ActiveQuery
    {
        $defaultDomain = DomainRepository::getDefaultId();
        
        $query = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->andWhere(['setting.name' => $name]);
        
        if($language_id){
            $subquery = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['domain_id' => $domain_id, 'language_id' => null])
                ->andWhere(['NOT IN', 'setting_id', 
                (new \yii\db\Query)
                ->select('setting_id')
                ->from(SettingValue::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ])
                ->andWhere(['setting.name' => $name]);
            
            $query->union($subquery);
        }
        
        if($domain_id != $defaultDomain && $domain_id){
            $subquery = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->andWhere(['NOT IN', 'setting_id', 
                (new \yii\db\Query)
                ->select('setting_id')
                ->from(SettingValue::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $domain_id, 'language_id' => null])
                ])
                ->andWhere(['setting.name' => $name]);
            
            $query->union($subquery);
        }
        
        if($domain_id != $defaultDomain && $domain_id && $language_id){
            $subquery = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['domain_id' => $defaultDomain, 'language_id' => null])
                ->andWhere(['NOT IN', 'setting_id', 
                (new \yii\db\Query)
                ->select('setting_id')
                ->from(SettingValue::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $domain_id, 'language_id' => null])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ])
                ->andWhere(['setting.name' => $name]);
            
            $query->union($subquery);
        }
        
        if($domain_id && $language_id){
            $subquery = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['domain_id' => null, 'language_id' => $language_id])
                ->andWhere(['NOT IN', 'setting_id', 
                (new \yii\db\Query)
                ->select('setting_id')
                ->from(SettingValue::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $domain_id, 'language_id' => null])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => null])
                ])
                ->andWhere(['setting.name' => $name]);
            
            $query->union($subquery);
        }
        
        if($domain_id || $language_id){
            
            $exclude = (new \yii\db\Query)
                    ->select('setting_id')
                    ->from(SettingValue::tableName())
                    ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id]);
            
            if($domain_id) $exclude->orWhere(['domain_id' => $domain_id, 'language_id' => null]);
            
            $exclude->orWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => null]);
            
            if($language_id) $exclude->orWhere(['domain_id' => null, 'language_id' => $language_id]);
            
            $subquery = SettingValue::find()
                ->joinWith('setting')
                ->andWhere(['domain_id' => null, 'language_id' => null])
                ->andWhere(['NOT IN', 'setting_id', $exclude])
                ->andWhere(['setting.name' => $name]);
            
            $query->union($subquery);
        }
        
        return $query;
    }
}
