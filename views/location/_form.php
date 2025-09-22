<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\db\Query;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\Location $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="location-form form-control w-50">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'countries_id')->widget(Select2::class, [
    'data' => \yii\helpers\ArrayHelper::map((new Query())
    ->select(['id','name'])
    ->from('countries_eu')  
    ->orderBy('name')->all(), 'id', 'name'),
    'options' => ['id' => 'countries-id', 'placeholder' => 'Selectati o tara ...','label'=>'Tara'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>
    
    <?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
