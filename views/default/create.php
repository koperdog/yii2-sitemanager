<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Domain */

$this->title = Yii::t('settings', 'Create Setting');
$this->params['breadcrumbs'][] = ['label' => Yii::t('settings', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="setting-form">

        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'required')->checkbox() ?>
            <?= $form->field($model, 'field_type')->dropDownList(
                    $model->getFieldTypes(),
                    [
                        'prompt' => \Yii::t('settings', 'Choose one field type')
                    ]) ?>
            <?= $form->field($model, 'value')->textarea(['placeholder' => \Yii::t('settings', 'Default value')]) ?>
        
            <div class="form-group">
                <?= Html::submitButton(Yii::t('settings', 'Submit'), ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
