<?php

namespace koperdog\yii2sitemanager\models\forms;

use yii\base\Model;

/**
 * Domain create form
 */
class DomainForm extends Model
{
    public $domain;
    public $is_default;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain', 'is_default'], 'required'],
            [['is_default'], 'boolean'],
            [['is_default'], 'default', 'value' => false],
            ['domain', 'unique', 'targetClass' => 'koperdog\yii2sitemanager\models\Domain', 'message' => 'This domain has already been taken.'],
            [['domain'], 'string', 'max' => 255],
        ];
    }
}
