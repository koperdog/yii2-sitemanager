<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Domain */

$this->title = Yii::t('app', 'Settings of Domain: {name}', [
    'name' => $model->domain,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Domains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="domain-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="domain-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'domain')->textInput(['maxlength' => true]) ?>
        
        <div class="panel panel-default">
            <div class="panel-heading"><?=\Yii::t('app', 'Settings');?></div>
            <div class="panel-body">
                <?php foreach ($settings as $index => $setting):?>
                    <?=$form->field($setting, "[$index]value")->label($setting->name);?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
