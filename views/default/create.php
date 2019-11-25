<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Domain */

$this->title = Yii::t('sitemanager', 'Create Setting');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sitemanager', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="setting-form">

        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'required')->checkbox() ?>
            <?= $form->field($model, 'autoload')->checkbox() ?>
            <?= $form->field($model, 'value')->textarea(['placeholder' => \Yii::t('sitemanager', 'Default value')]) ?>
        
            <div class="form-group">
                <?= Html::submitButton(Yii::t('sitemanager', 'Submit'), ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
