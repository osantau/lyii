<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\db\Query;
use kartik\select2\Select2;

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
        </div>
    <?php ActiveForm::end(); ?>

</div>
