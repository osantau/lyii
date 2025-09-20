<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Location $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="location-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'countries_id')->textInput() ?>

    <?= $form->field($model, 'states_id')->textInput() ?>

    <?= $form->field($model, 'cities_id')->textInput() ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
