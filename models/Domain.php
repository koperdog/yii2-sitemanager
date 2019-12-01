<?php

namespace koperdog\yii2sitemanager\models;

use Yii;

/**
 * This is the model class for table "{{%domain}}".
 *
 * @property int $id
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
            [['domain', 'is_default'], 'required'],
            [['is_default'], 'integer'],
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
            'domain' => Yii::t('sitemanager', 'Domain'),
            'is_default' => Yii::t('sitemanager', 'Is Default'),
        ];
    }
}
