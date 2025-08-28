<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Utilizatori';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
            // 'password_hash',
            // 'auth_key',
            ['attribute' => 'created_at', 'format' => ['datetime', 'php:d.m.Y H:i']],
            ['attribute' => 'updated_at', 'format' => ['datetime', 'php:d.m.Y H:i']],
            [
                'attribute' => 'is_admin',
                'value' => function ($model) {
                        return $model->is_admin ? 'Da' : 'Nu';
                    },
                'filter' => [1 => 'Admin', 0 => 'User'],
            ],
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
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>