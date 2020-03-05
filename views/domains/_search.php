<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model t2cms\sitemanager\models\DomainSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="domain-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>
    
    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'domain') ?>

    <?= $form->field($model, 'is_default') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('sitemanager', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('sitemanager', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
