<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel t2cms\sitemanager\models\DomainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sitemanager', 'Domains');
$this->params['breadcrumbs'][] = $this->title;

\t2cms\sitemanager\AssetBundle::register($this);
?>
<div class="domain-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="section-justify">
        <p>
            <?= Html::a(Yii::t('sitemanager', 'Create Domain'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <div class="zone-section">
            <?= t2cms\sitemanager\widgets\local\LanguageList::widget();?>
        </div>
    </div>

    <?php // Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'domain',
            [
                'attribute' => 'is_default',
                'label'     => 'Default',
                'format'    => 'raw',
                'filter'    => false,
                'headerOptions' => ['style' => 'width:100px'],
                'value'     => function($model, $key, $index){
                    $icon = Html::tag('span', '', ['class' => 'glyphicon glyphicon-star'.($model->is_default? '' : '-empty')]);
                    return Html::a(
                        $icon, 
                        ['make-default', 'id' => $model->id], 
                        [
                            'class' => 'make-default',
                            'data' => [
                                'confirm' => 'Are you sure you want to make default this item?',
                                'method' => 'post',
                            ],
                        ]
                    );
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'    => 'Actions',
                'template' => '{update} {delete}',
                'visibleButtons' => [
                    'update' => true,
                    'delete' => function ($model) { 
                        return !$model->is_default;
                    }
                ]
            ],
        ],
    ]); ?>

    <?php // Pjax::end(); ?>

</div>
