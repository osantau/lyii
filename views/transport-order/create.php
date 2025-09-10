<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TransportOrder $model */

$this->title = 'Adauga Comanda';
// $this->params['breadcrumbs'][] = ['label' => 'Transport Orders', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="transport-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
