<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\db\Query;
use kartik\select2\Select2;
use yii\web\JsExpression;

/** @var yii\web\View $this */
/** @var app\models\Location $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="location-form form-control">
<?php $title="";
    switch ($tip) {
        case 'exp_ai':
            $title="Export Adresa Incarcare";
            break;
           case 'exp_ad':
            $title="Export Adresa Descarcare";
            break;
               case 'imp_ai':
            $title="Import Adresa Incarcare";
            break;
               case 'imp_ad':
            $title="Import Adresa Descarcare";
            break;
        default:
            $title="Editare Adresa";
            break;
    }
?>
    <h4><?=$title?></h4> 
    <?php
   echo Select2::widget([
    'name' => 'address_id', // input name
    'value' => null,        // initial value
    'options' => ['placeholder' => 'Cauta o adresa...','id'=>'address_id','class'=>'select2'],
    'pluginOptions' => [
        'width' => '100%',
        'allowClear' => true,
        'minimumInputLength' => 2,
        'ajax' => [
            'url' => \yii\helpers\Url::to(['location/address-list']),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }'),
            'processResults' => new JsExpression('function(data) { return data; }'),
        ],
            'dropdownParent' => new \yii\web\JsExpression('$("#editAdreseModal")'),
    ],
]); 
    ?>
    <?php $form  = ActiveForm::begin(['id'=>'editAdreseForm', 'enableAjaxValidation' => false,
    'enableClientValidation' => true,])?>
    <input type="hidden" name="vid" id="vid" value="<?= $vid?>">
    <input type="hidden" name="tip" id="tip" value="<?= $tip?>">
    <input type="hidden" name="aid" id="aid" value="<?= $aid?>">
    <?= $form->field($model, 'company')->textInput(['maxlength' => true,'name'=>'company','id'=>'company']) ?>
    <?= $form->field($model, 'country')->textInput(['list' => 'countries','id'=>'country','name'=>'country']) ?>
    <datalist id="countries" >
       <?= $tariList?>
        </datalist>
    </datalist>
    <?= $form->field($model, 'region')->textInput(['maxlength' => true,'name'=>'region','id'=>'region']) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true,'name'=>'city','id'=>'city']) ?>

    <?= $form->field($model, 'address')->textArea(['maxlength' => true,'rows'=>2,'cols'=>10,'name'=>'address','id'=>'address']) ?>       
  <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Inchide</button>
          <button type="submit" class="btn btn-primary">Salveaza</button>
          <button type="reset" class="btn btn-warning">Reseteaza</button>
          <button type="button" class="btn btn-danger btnVehDelAdr">Sterge</button>
        </div>
    <?php ActiveForm::end(); ?>

</div>
<?php 
$this->registerJs("

    $('#address_id').on('select2:select', function(e) {
    var addressId = e.params.data.id;

    $.ajax({
        url: '/location/address-info',
        data: { id: addressId },
        dataType: 'json',
        success: function(data) {
            $('#company').val(data.company);
            $('#city').val(data.city);
            $('#address').val(data.address);
            $('#country').val(data.country);
            $('#region').val(data.region);
        }
    });
});

// Optional: clear fields when selection is cleared
$('#address_id').on('select2:clear', function() {
    $('#company').val('');
            $('#city').val('');
            $('#address').val('');
            $('#country').val('');
            $('#region').val('');
});

");
?>