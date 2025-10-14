<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Partner;

/** @var yii\web\View $this */
/** @var app\models\Invoice $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="invoice-form">

    <?php $form = ActiveForm::begin(); ?>

  <div class="payment-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'w-75 mx-auto p-4 bg-light rounded shadow-sm']]); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->errorSummary($model) ?>
        </div>
    </div>
    <div class="row">
          <div class="col-md-4">
            <?= $form->field($model, 'dateinvoiced')->input('date') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'duedate')->input('date') ?>
        </div>            
    </div>
    <div class="row">      
         <div class="col-md-4">
            <?= $form->field($model, 'nr_factura')->textInput(['maxlength' => true,'autofocus'=>true]) ?>
        </div> 
        <div class="col-md-4">
            <?php //echo $form->field($model, 'partener')->textInput(['maxlength' => true]) ?>
              <?= $form->field($model, 'partner_id')->widget(Select2::class,
    ['data'=>ArrayHelper::map(Partner::find()->all(),'id','name'),
    'options'=>['placeholder'=>'Selectati un partener...'],
    'pluginOptions'=>['allowClear'=>true]
],)->label('Partener') ?>
        </div>      
    </div>
    <?php if($moneda==='eur') { ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'valoare_eur')->textInput(['type' => 'number', 'step' => '0.01', 'maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'suma_achitata_eur')->textInput(['type' => 'number', 'step' => '0.01', 'maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'sold_eur')->textInput(['type' => 'number', 'step' => '0.01', 'maxlength' => true,'disabled'=>true]) ?>
        </div>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'valoare_ron')->textInput(['type' => 'number', 'step' => '0.01', 'maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'suma_achitata_ron')->textInput(['type' => 'number', 'step' => '0.01', 'maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'sold_ron')->textInput(['type' => 'number', 'step' => '0.01', 'maxlength' => true,'disabled'=>true]) ?>
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
    <?php if($moneda==='eur') {?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'diferenta')->textInput(['type' => 'number', 'step' => '0.01', 'maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'credit_note')->textarea(['rows' => 2]) ?>
        </div>
    </div>
    <?php }?>
    <?= $form->field($model,'moneda')->hiddenInput(['value'=>$moneda])->label(false)?>
    <div class="form-group">
        <?= Html::submitButton('Salveaza', ['class' => 'btn btn-success px-4']) ?>
          <?= Html::a('Renunta',['index?moneda='.$moneda], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
