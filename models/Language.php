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
 */
class Language extends \yii\db\ActiveRecord
{
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
            'id' => Yii::t('sitemanager', 'ID'),
            'code' => Yii::t('sitemanager', 'Code'),
            'code_local' => Yii::t('sitemanager', 'Code Local'),
            'name' => Yii::t('sitemanager', 'Name'),
            'status' => Yii::t('sitemanager', 'Status'),
        ];
    }
}
