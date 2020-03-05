<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Domain */
/* @var $settings array t2cms\sitemanager\models\Setting */

$this->title = Yii::t('sitemanager', 'Settings of Domain: {name}', [
    'name' => $model->domain,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sitemanager', 'Domains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;

\t2cms\sitemanager\AssetBundle::register($this);

$this->registerJsVar('i18n', ['confirm' => \Yii::t('sitemanager', 'Are you sure?')]);
?>
<div class="domain-update">

    <div class="section-justify">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="zone-section">
            <?= t2cms\sitemanager\widgets\local\LanguageList::widget();?>
        </div>
    </div>

    <div class="domain-form">
        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
        <?= $form->field($model, 'name', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'domain', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>
        </div>
        
        <?php if(!empty($settings)):?>
        <div class="panel panel-default">
            <div class="panel-heading"><?=\Yii::t('sitemanager', 'Settings');?></div>
            <div class="panel-body" id="settings_wr">
                
                <?=$form->field($settings['disconnected'], "[disconnected]value")
                    ->checkbox(['label' => false])
                    ->label("Disconnected");?>

                <?=$form->field($settings['site_name'], "[site_name]value")
                    ->label("Site name");?>
                
            </div>
        </div>
        <?php endif;?>
        
        <div class="panel panel-default">
            <div class="panel-heading"><?=\Yii::t('sitemanager', 'Custom Settings');?></div>
            <div class="panel-body" id="settings_wr">
                <?php if(!empty($settings)):?>
                <?php foreach($settings as $index => $setting):?>
                <?php if($setting->setting->status == \t2cms\sitemanager\models\Setting::STATUS['CUSTOM']):?>
                
                <div class="custom-setting-wr">
                    <?=$form->field($setting, "[$index]value", ['options' => ['class' => ($setting->setting->required? 'required' : '')]])->textarea()->label($index);?>
                    <div class="controls_wr">
                        <a href="<?= yii\helpers\Url::to(['default/update', 'id' => $setting->setting->id]);?>">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-href="<?= yii\helpers\Url::to(['default/delete', 'id' => $setting->setting->id]);?>" class="setting-delete">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
                <?php endif;?>
                <?php endforeach;?>
                <?php endif;?>
                
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
