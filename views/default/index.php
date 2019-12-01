<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $settings koperdog\yii2sitemanager\models\Setting with aggignment models*/

$this->title = Yii::t('sitemanager', 'General Settings');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(); ?>
    <?php // debug($settings['site_name']);?>


    <?=$form->field($settings['disconnected']->assign, "[disconnected]value")->checkbox(['label' => false])->label("Disconnected");?>
   
    <?=$form->field($settings['site_name']->assign, "[site_name]value")->label("Site name");?>

    <?=$form->field($settings['main_page']->assign, "[main_page]value")->dropDownList(["Главная страница", "Тестовая страница"])->label("Main page");?>

    <?= Html::submitButton(Yii::t('sitemanager', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end();?>