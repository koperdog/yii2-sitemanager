<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use koperdog\yii2sitemanager\models\Setting;

/* @var $this yii\web\View */
/* @var $model common\models\Domain */
/* @var $settings array koperdog\yii2sitemanager\models\Setting */

$this->title = Yii::t('settings', 'Settings of Domain: {name}', [
    'name' => $model->domain,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('settings', 'Domains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('settings', 'Update');

$this->registerJsVar('settings', $settings);

$this->registerJsVar('test', array_shift($settings)->getFieldTypes());
?>
<div class="domain-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="domain-form">
        <?php debug($settings);?>
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'domain')->textInput(['maxlength' => true]) ?>
        
        <div class="panel panel-default">
            <div class="panel-heading"><?=\Yii::t('settings', 'Settings');?></div>
            <div class="panel-body" id="settings_wr"></div>
        </div>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('settings', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        
    </div>

</div>
