<?php

namespace koperdog\yii2sitemanager\models;

use Yii;

/**
 * This is the model class for table "{{%setting_value}}".
 *
 * @property int $id
 * @property int $setting_id
 * @property int|null $domain_id
 * @property int|null $language_id
 * @property int $value
 */
class SettingValue extends \yii\db\ActiveRecord
{
    public $required;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting_value}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['setting_id'], 'required'],
            [['setting_id', 'domain_id', 'language_id'], 'integer'],
            [['value'], 'safe'],
            [['required'], 'checkRequired', 'when' => function($model){ return (bool)$model->required;}],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sitemanager', 'ID'),
            'setting_id' => Yii::t('sitemanager', 'Setting ID'),
            'domain_id' => Yii::t('sitemanager', 'Domain ID'),
            'language_id' => Yii::t('sitemanager', 'Lang ID'),
            'value' => Yii::t('sitemanager', 'Value'),
        ];
    }
    
    public function checkRequired()
    {
        if(!mb_strlen($this->value)){
            $this->addError('value', Yii::t('sitemanager', 'The field cannot be blank.'));
        }
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSetting()
    {
        return $this->hasOne(Setting::className(), ['id' => 'setting_id']);
    }
}
