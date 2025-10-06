<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PaymentSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="payment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'is_receipt') ?>

    <?= $form->field($model, 'dateinvoiced') ?>

    <?= $form->field($model, 'duedate') ?>

    <?= $form->field($model, 'nr_cmd_trs') ?>

    <?php // echo $form->field($model, 'nr_factura') ?>

    <?php // echo $form->field($model, 'partener') ?>

    <?php // echo $form->field($model, 'valoare_ron') ?>

    <?php // echo $form->field($model, 'suma_achitata_ron') ?>

    <?php // echo $form->field($model, 'sold_ron') ?>

    <?php // echo $form->field($model, 'valoare_eur') ?>

    <?php // echo $form->field($model, 'suma_achitata_eur') ?>

    <?php // echo $form->field($model, 'sold_eur') ?>

    <?php // echo $form->field($model, 'ron') ?>

    <?php // echo $form->field($model, 'eur') ?>

    <?php // echo $form->field($model, 'paymentdate') ?>

    <?php // echo $form->field($model, 'bank') ?>

    <?php // echo $form->field($model, 'mentiuni') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
