<?php 
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
/** @var yii\web\View $this */
/** @var app\models\Vehicle $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="vehicle-form">

    <?php $form = ActiveForm::begin(['id'=>'update-form','enableAjaxValidation'=>true]); ?>

    <?= $form->field($model, 'info')->textarea(['rows'=>3, 'cols'=>10]) ?>    
    <?php ActiveForm::end(); ?>

</div>
