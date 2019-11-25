<?php

namespace koperdog\yii2sitemanager\models;

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
 *
 * @property Language $lang
 * @property Domain $domain
 */
class Setting extends \yii\db\ActiveRecord
{
    
    const STATUS = ['GENERAL' => 0, 'MAIN' => 1, 'CUSTOM' => 2, 'MODULE' => 3];
    
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
            [['name', 'required'], 'required'],
            [['value'], 'string'],
            [['required', 'status', 'domain_id', 'lang_id'], 'integer'],
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
            'id' => Yii::t('sitemanager', 'ID'),
            'name' => Yii::t('sitemanager', 'Name'),
            'value' => Yii::t('sitemanager', 'Value'),
            'required' => Yii::t('sitemanager', 'Required'),
            'status' => Yii::t('sitemanager', 'Status'),
            'domain_id' => Yii::t('sitemanager', 'Domain ID'),
            'lang_id' => Yii::t('sitemanager', 'Lang ID'),
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
}
