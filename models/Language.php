<?php

namespace koperdog\yii2settings\models;

use Yii;

/**
 * This is the model class for table "language".
 *
 * @property int $id
 * @property string $code
 * @property string $code_local
 * @property string $name
 * @property int $status
 *
 * @property Setting[] $settings
 */
class Language extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'code_local', 'name', 'status'], 'required'],
            [['status'], 'integer'],
            [['code'], 'string', 'max' => 2],
            [['code_local'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 100],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'code_local' => Yii::t('app', 'Code Local'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettings()
    {
        return $this->hasMany(Setting::className(), ['lang_id' => 'id']);
    }
}
