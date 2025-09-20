<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Location $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="location-view">

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
            'id',
            'countries_id',
            'states_id',
            'cities_id',
            'address',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
