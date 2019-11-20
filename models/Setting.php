<?php

namespace koperdog\yii2settings\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property int $required
 * @property int $status
 * @property int $domain_id
 * @property int $lang_id
 * @property int $field_type
 *
 * @property Language $lang
 * @property Domain $domain
 */
class Setting extends \yii\db\ActiveRecord
{
    
    const STATUS = ['GENERAL' => 0, 'MAIN' => 1, 'CUSTOM' => 2, 'MODULE' => 3];
    const FIELD_TYPE = ['text' => 1, 'textarea' => 2, 'checkbox' => 3, 'radio' => 4, 'select' => 5];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'required', 'field_type'], 'required'],
            [['value'], 'string'],
            [['required', 'status', 'domain_id', 'lang_id', 'field_type'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['status'], 'default', 'value' => self::STATUS['CUSTOM']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lang_id' => 'id']],
            [['domain_id'], 'exist', 'skipOnError' => true, 'targetClass' => Domain::className(), 'targetAttribute' => ['domain_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('settings', 'ID'),
            'name' => Yii::t('settings', 'Name'),
            'value' => Yii::t('settings', 'Value'),
            'required' => Yii::t('settings', 'Required'),
            'status' => Yii::t('settings', 'Status'),
            'domain_id' => Yii::t('settings', 'Domain ID'),
            'lang_id' => Yii::t('settings', 'Lang ID'),
            'field_type' => Yii::t('settings', 'Field Type'),
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
    public function getDomain()
    {
        return $this->hasOne(Domain::className(), ['id' => 'domain_id']);
    }
    
    /**
     * @return array
     */
    public function getFieldTypes(): array
    {
        return array_flip(self::FIELD_TYPE);
    }
}
