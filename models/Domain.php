<?php

namespace koperdog\yii2sitemanager\models;

use Yii;

/**
 * This is the model class for table "{{%domain}}".
 *
 * @property int $id
 * @property string $name
 * @property string $domain
 * @property int $is_default
 */
class Domain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%domain}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain', 'name'], 'required'],
            [['is_default'], 'boolean'],
            [['is_default'], 'default', 'value' => false],
            [['name'], 'string', 'max' => 100],
            [['domain'], 'string', 'max' => 255],
            [['domain'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sitemanager', 'ID'),
            'name' => Yii::t('sitemanager', 'Name'),
            'domain' => Yii::t('sitemanager', 'Domain'),
            'is_default' => Yii::t('sitemanager', 'Is Default'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettings()
    {
        return $this->hasMany(SettingValue::className(), ['domain_id' => 'id']);
    }
}
