<?php

namespace koperdog\yii2sitemanager\models;

use Yii;

/**
 * This is the model class for table "{{%language}}".
 *
 * @property int $id
 * @property string $code
 * @property string $code_local
 * @property string $name
 * @property int $status
 * @property int $is_default
 */
class Language extends \yii\db\ActiveRecord
{
    const STATUS = ['INACTIVE' => 0, 'ACTIVE' => 1];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%language}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'code_local', 'name', 'status', 'is_default'], 'required'],
            [['status'], 'integer'],
            [['status'], 'default', 'value' => self::STATUS['ACTIVE']],
            [['is_default'], 'boolean'],
            [['is_default'], 'default', 'value' => false],
            [['code'], 'string', 'max' => 2],
            [['code_local'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 100],
            [['code', 'code_local'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sitemanager', 'ID'),
            'code' => Yii::t('sitemanager', 'Code'),
            'code_local' => Yii::t('sitemanager', 'Code Local'),
            'name' => Yii::t('sitemanager', 'Name'),
            'status' => Yii::t('sitemanager', 'Status'),
            'is_default' => Yii::t('sitemanager', 'Is default'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettings()
    {
        return $this->hasMany(SettingValue::className(), ['language_id' => 'id']);
    }
}
