<?php

namespace koperdog\yii2sitemanager\models;

use Yii;

/**
 * This is the model class for table "domain".
 *
 * @property int $id
 * @property string $domain
 * @property int $main
 *
 * @property DomainSetting[] $domainSettings
 * @property Setting[] $settings
 */
class Domain extends \yii\db\ActiveRecord
{
    const MAIN = 1;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'domain';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain'], 'required'],
            [['main'], 'boolean'],
            [['main'], 'default', 'value' => 0], 
            [['domain'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('settings', 'ID'),
            'domain' => Yii::t('settings', 'Domain'),
            'main' => Yii::t('settings', 'Main'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomainSettings()
    {
        return $this->hasMany(DomainSetting::className(), ['domain_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettings()
    {
        return $this->hasMany(Setting::className(), ['domain_id' => 'id']);
    }
}
