<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Invoice $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="invoice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dateinvoiced')->textInput() ?>

    <?= $form->field($model, 'duedate')->textInput() ?>

    <?= $form->field($model, 'duedays')->textInput() ?>

    <?= $form->field($model, 'paymentdate')->textInput() ?>

    <?= $form->field($model, 'nr_factura')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'partener')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valoare_ron')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'suma_achitata_ron')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sold_ron')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valoare_eur')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'suma_achitata_eur')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sold_eur')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'diferenta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'moneda')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_customer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mentiuni')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'credit_note')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
