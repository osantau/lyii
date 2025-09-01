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
<div class="row">
<div class="col-12">
 <div class="form-group">
<h1><?= Html::encode($this->title) ?></h1>
</div>
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
            'address',
            ['attribute' => 'created_at', 'format' => ['datetime', 'php:d.m.Y']],
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
                'contentOptions' => ['style' => 'width:50px; text-align:center;'],
                  'buttons' => [
                'delete' => function ($url, $model, $key) {
                    return Html::a('<span style="color:red;"><i class="fa-solid fa-trash fa-xs"></i></span>', $url, [
                        'title' => Yii::t('app', 'Delete'),
                        'data-confirm' => Yii::t('app', 'Sunteti sigur ca vreti sa stergeti '.$model->first_name.' - '.$model->last_name.'  ?'),
                        'data-method' => 'post',                        
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
</div>
