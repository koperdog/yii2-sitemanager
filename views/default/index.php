<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $settings common\models\Setting with aggignment models*/
?>
<p>
    <?= Html::a(Yii::t('settings', 'Create Setting'), ['create'], ['class' => 'btn btn-success']) ?>
</p>
<?php $form = ActiveForm::begin(); ?>
    <?php foreach ($settings as $index => $setting):?>
        <?=$form->field($setting, "[$index]value")->label($setting->name);?>
    <?php endforeach; ?>
    <?= Html::submitButton(Yii::t('settings', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end();?>