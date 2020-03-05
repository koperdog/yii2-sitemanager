<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $settings t2cms\sitemanager\models\Setting with aggignment models*/

$this->title = Yii::t('sitemanager', 'General Settings');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="settings-general">
    <div class="text-right">
        <div class="zone-section">
            <?= t2cms\sitemanager\widgets\local\LanguageList::widget();?>
        </div>
    </div>

    <?php $form = ActiveForm::begin(); ?>

        <?=$form->field($settings['_disconnected'], "[_disconnected]value")->checkbox(['label' => false])->label("Disconnected");?>

        <?=$form->field($settings['_site_name'], "[_site_name]value")->label("Site name");?>

        <?= Html::submitButton(Yii::t('sitemanager', 'Save'), ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end();?>
</div>