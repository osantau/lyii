<?php

use app\models\Driver;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\DriverSerach $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Conducatori Auto';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Adauga', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'first_name',
            'last_name',
            'email:email',
            'phone',
            //'address',
            ['attribute' => 'created_at', 'format' => ['datetime', 'php:d.m.Y H:i']],
            ['attribute' => 'updated_at', 'format' => ['datetime', 'php:d.m.Y H:i']],
            [
                'attribute' => 'created_by',
                'value' => function ($model) {
                        return $model->createdBy->username ?? null;
                    },
            ],
            [
                'attribute' => 'updated_by',
                'value' => function ($model) {
                        return $model->updatedBy->username ?? null;
                    },
            ],
            [
                'class' => ActionColumn::class,
                'template'=>'{update} {delete}',
                  'buttons' => [
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash"></i>', $url, [
                        'title' => Yii::t('app', 'Delete'),
                        'data-confirm' => Yii::t('app', 'Sunteti sigur ca vreti sa stergeti '.$model->first_name.' - '.$model->last_name.'  ?'),
                        'data-method' => 'post',
                        'class' => 'btn btn-danger btn-sm', // your custom class
                    ]);
                },
            ],
                'urlCreator' => function ($action, Driver $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
