<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $settings common\models\Setting with aggignment models*/
?>
<?php $form = ActiveForm::begin(); ?>
    <?php // debug($settings);?>


    <?=$form->field($settings['disconnected'], "[disconnected]value")->checkbox(['label' => false])->label("Disconnected");?>

    <?=$form->field($settings['main_page'], "[main_page]value")->dropDownList(["Главная страница", "Тестовая страница"])->label("Main page");?>

    <?= Html::submitButton(Yii::t('sitemanager', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end();?>