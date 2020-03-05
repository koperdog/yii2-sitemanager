<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model t2cms\sitemanager\models\Language */

$this->title = Yii::t('sitemanager', 'Update Language: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sitemanager', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="language-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
