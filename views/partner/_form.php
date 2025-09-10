<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Partner $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="partner-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model) ?>
    <div class="form-group">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'autofocus'=>true,'class'=>'form-control w-25']) ?>
</div>
    <div class="form-group">
        <?= Html::submitButton('Salveaza', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
