<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'email:email',
            'password',
            ['attribute' => 'created_at', 'format' => ['datetime', 'php:d.m.Y H:i']],
            ['attribute' => 'updated_at', 'format' => ['datetime', 'php:d.m.Y H:i']],
            ['attribute' => 'is_admin', 'format:raw', 'value' => $model->isAdmin() ? 'Da' : 'Nu'],
            [
                'attribute' => 'created_by',
                'value' => $model->createdBy->username ?? null,
            ],
            [
                'attribute' => 'updated_by',
                'value' => $model->updatedBy->username ?? null,
            ],
        ],
    ]) ?>

</div>