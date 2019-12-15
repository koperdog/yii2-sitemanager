<?php

namespace koperdog\yii2sitemanager\models\forms;

use yii\base\Model;

/**
 * Domain create form
 */
class DomainForm extends Model
{
    public $name;
    public $domain;
    public $is_default;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain', 'name'], 'required'],
            [['is_default'], 'boolean'],
            [['name'], 'string', 'max' => 100],
            [['is_default'], 'default', 'value' => false],
            ['domain', 'unique', 'targetClass' => 'koperdog\yii2sitemanager\models\Domain', 'message' => 'This domain has already been taken.'],
            [['domain'], 'string', 'max' => 255],
        ];
    }
}
