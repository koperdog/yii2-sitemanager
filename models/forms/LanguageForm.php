<?php

namespace koperdog\yii2sitemanager\models\forms;

use Yii;
use yii\base\Model;

/**
 * This is the model class
 *
 * @property int $id
 * @property string $code
 * @property string $code_local
 * @property string $name
 * @property int $status
 * @property int $is_default
 */
class LanguageForm extends Model
{
    const ACTIVE = 1;
    
    public $code;
    public $code_local;
    public $name;
    public $status;
    public $is_default;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'code_local', 'name', 'status', 'is_default'], 'required'],
            [['status'], 'integer'],
            [['status'], 'default', 'value' => self::ACTIVE],
            [['is_default'], 'boolean'],
            [['is_default'], 'default', 'value' => false],
            [['code'], 'string', 'max' => 2],
            [['code_local'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 100],
            [
                ['code', 'code_local'], 
                'unique', 
                'targetClass' => 'koperdog\yii2sitemanager\models\Language', 
                'message' => 'This name has already been taken.'
            ],
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
}
