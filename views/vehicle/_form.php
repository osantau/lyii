<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Vehicle $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="vehicle-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'regno')->textInput(['maxlength' => true,'oninput'=>'this.value=this.value.toUpperCase()']) ?>

    <div class="form-group">
        <?= Html::submitButton('Salveaza', ['class' => 'btn btn-success']) ?>
          <?= Html::a('Renunta',['index'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
