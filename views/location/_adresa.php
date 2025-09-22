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
    <?php $form = ActiveForm::begin(['id'=>'editAdreseForm']); ?>
    <input type="hidden" name="vid" id="vid" value="<?= $vid?>">
    <input type="hidden" name="tip" id="tip" value="<?= $tip?>">
    <input type="hidden" name="aid" id="aid" value="<?= $aid?>">
    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'countries_id')->widget(Select2::class, [
    'data' => \yii\helpers\ArrayHelper::map((new Query())
    ->select(['id','name'])
    ->from('countries_eu')  
    ->orderBy('name')->all(), 'id', 'name'),
    'options' => ['placeholder' => 'Selectati o tara ...','label'=>'Tara'],
    'pluginOptions' => [
        'allowClear' => true,
           'minimumResultsForSearch' => 'Infinity',
    ],
]); ?>
    
    <?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textArea(['maxlength' => true,'rows'=>2,'cols'=>10]) ?>   

    <?php ActiveForm::end(); ?>

</div>
