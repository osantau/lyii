<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Vehicle $model */

$this->title = 'Actualizare Autovehicul: ' . $model->regno;
$this->params['breadcrumbs'][] = ['label' => 'Autovehicule', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->regno, 'url' => ['view', 'id' => $model->id]];
?>
<div class="vehicle-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
