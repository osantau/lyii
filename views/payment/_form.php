<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Payment $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="payment-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'w-75 mx-auto p-4 bg-light rounded shadow-sm']]); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->errorSummary($model) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'nr_factura')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'dateinvoiced')->input('date') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'duedate')->input('date') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'nr_cmd_trs')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'partener')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'bank')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'valoare_ron')->textInput(['type' => 'number', 'step' => '0.01', 'maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'suma_achitata_ron')->textInput(['type' => 'number', 'step' => '0.01', 'maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'sold_ron')->textInput(['type' => 'number', 'step' => '0.01', 'maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'valoare_eur')->textInput(['type' => 'number', 'step' => '0.01', 'maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'suma_achitata_eur')->textInput(['type' => 'number', 'step' => '0.01', 'maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'sold_eur')->textInput(['type' => 'number', 'step' => '0.01', 'maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'paymentdate')->input('date') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'mentiuni')->textarea(['rows' => 2]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Salveaza', ['class' => 'btn btn-success px-4']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>