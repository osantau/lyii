<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Payment $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="payment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'is_receipt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dateinvoiced')->textInput() ?>

    <?= $form->field($model, 'duedate')->textInput() ?>

    <?= $form->field($model, 'nr_cmd_trs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nr_factura')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'partener')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valoare_ron')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'suma_achitata_ron')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sold_ron')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valoare_eur')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'suma_achitata_eur')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sold_eur')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ron')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'eur')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paymentdate')->textInput() ?>

    <?= $form->field($model, 'bank')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mentiuni')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
