<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Driver $model */

$this->title = 'Actualizare: ' . $model->first_name.' - '.$model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Conducatori Auto', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
