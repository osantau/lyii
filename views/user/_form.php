<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="user-form">
   
    <?php $form = ActiveForm::begin(); ?>
 <?= $form->errorSummary($model) ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => true,'autofocus'=>true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>  

    <?= $form->field($model, 'is_admin')->dropDownList(User::getAdminList(),['label'=>"Administrator?"] )?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
