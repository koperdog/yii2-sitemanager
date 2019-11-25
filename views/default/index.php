<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $settings common\models\Setting with aggignment models*/
?>
<p>
    <?= Html::a(Yii::t('sitemanager', 'Create Setting'), ['create'], ['class' => 'btn btn-success']) ?>
</p>
<?php $form = ActiveForm::begin(); ?>
    <?php koperdog\yii2sitemanager\widgets\SettingsForm::widget(); ?>
    <?= Html::submitButton(Yii::t('sitemanager', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end();?>