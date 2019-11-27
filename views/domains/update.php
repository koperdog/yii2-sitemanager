<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Domain */
/* @var $settings array koperdog\yii2sitemanager\models\Setting */

$this->title = Yii::t('sitemanager', 'Settings of Domain: {name}', [
    'name' => $model->domain,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sitemanager', 'Domains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('sitemanager', 'Update');
?>
<div class="domain-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="domain-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'domain')->textInput(['maxlength' => true]) ?>
        <div class="panel panel-default">
            <div class="panel-heading"><?=\Yii::t('sitemanager', 'Settings');?></div>
            <div class="panel-body" id="settings_wr">
                
                <?=$form->field($settings['disconnected'], "[disconnected]value")->checkbox(['label' => false])->label("Disconnected");?>
                
            </div>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-heading"><?=\Yii::t('sitemanager', 'Custom Settings');?></div>
            <div class="panel-body" id="settings_wr">
                
                <?php foreach($settings as $index => $setting):?>
                <?php if($setting->status == \koperdog\yii2sitemanager\models\Setting::STATUS['CUSTOM']):?>
                
                <div class="custom-setting-wr">
                    <?=$form->field($setting, "[$index]value", ['options' => ['class' => ($setting->required? 'required' : '')]])->textarea()->label($index);?>
                    <div class="controls_wr">
                        <a href="<?= yii\helpers\Url::to(['default/update', 'id' => $setting->id]);?>"<i class="fa fa-gear"></i></a>
                        <a href="<?= yii\helpers\Url::to(['default/delete', 'id' => $setting->id]);?>"<i class="fa fa-times"></i></a>
                    </div>
                </div>
                <?php endif;?>
                <?php endforeach;?>
                
                <p>
                    <?= Html::a(Yii::t('sitemanager', 'Create Setting'), ['default/create'], ['class' => 'btn btn-success']) ?>
                </p>
            </div>
        </div>
        
        <div class="form-group">
            <?= Html::submitButton(Yii::t('sitemanager', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        
    </div>

</div>
