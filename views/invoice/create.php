<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Invoice $model */

$this->title = 'Adauga Factura '. strtoupper($moneda);
$this->params['breadcrumbs'][] = ['label' => 'Facturi', 'url' => ['index?moneda='.$moneda]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'moneda'=>$moneda,
    ]) ?>

</div>
