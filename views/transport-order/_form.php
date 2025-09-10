<?php

use app\models\Partner;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\TransportOrder $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="transport-order-form">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->errorSummary($model) ?> 
        <div class="form-group">
    <?= $form->field($model, 'documentno')->textInput(['maxlength' => true,'autofocus'=>true,'class'=>'form-control w-25']) ?>
</div>
<div class="form-group w-25">
    <?= $form->field($model, 'dateordered')->widget(DatePicker::class,
    ['options'=>['placeholder'=>'Selectati o data...'],
        'pluginOptions'=>['autoclose'=>true,'format'=>'yyyy-mm-dd','todayHighlight' => true],
    ]) ?>
</div>
<div class="form-group w-25" >
    <?= $form->field($model, 'partner_id')->widget(Select2::class,
    ['data'=>ArrayHelper::map(Partner::find()->all(),'id','name'),
    'options'=>['placeholder'=>'Selectati un partener...'],
    'pluginOptions'=>['allowClear'=>true]
],) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
