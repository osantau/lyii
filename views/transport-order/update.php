<?php

use yii\helpers\Html;


/** @var yii\web\View $this */
/** @var app\models\TransportOrder $model */

$this->title = 'Actualizare comanda: [ Nr. ' . $model->documentno.' din  '.$model->getFormatedDateOrdered().' ]';
// $this->params['breadcrumbs'][] = ['label' => 'Transport Orders', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="transport-order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
