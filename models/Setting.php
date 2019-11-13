<?php

namespace koperdog\yii2settings\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property int $autoload
 * @property int $type
 * @property int $status
 * @property int $site_id
 * @property int $lang_id
 * @property int $field_type
 *
 * @property DomainSetting[] $domainSettings
 * @property Language $lang
 * @property Domain $site
 */
class Setting extends \yii\db\ActiveRecord
{
    const STATUS = ['GENERAL' => 0, 'MAIN' => 1, 'CUSTOM' => 2];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'autoload', 'type', 'status', 'field_type'], 'required'],
            [['value'], 'string'],
            [['autoload', 'type', 'status', 'site_id', 'lang_id', 'field_type'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lang_id' => 'id']],
            [['site_id'], 'exist', 'skipOnError' => true, 'targetClass' => Domain::className(), 'targetAttribute' => ['site_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
            'autoload' => Yii::t('app', 'Autoload'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'site_id' => Yii::t('app', 'Site ID'),
            'lang_id' => Yii::t('app', 'Lang ID'),
            'field_type' => Yii::t('app', 'Field Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomainSettings()
    {
        return $this->hasMany(DomainSetting::className(), ['setting_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSite()
    {
        return $this->hasOne(Domain::className(), ['id' => 'site_id']);
    }
}
