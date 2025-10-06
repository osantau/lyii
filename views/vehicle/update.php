<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Vehicle $model */

$this->title = 'Actualizare Camion: ' . $model->regno;
$this->params['breadcrumbs'][] = ['label' => 'Camioane', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->regno, 'url' => ['view', 'id' => $model->id]];
?>
<div class="vehicle-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
