<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
/** @var yii\web\View $this */
/** @var app\models\Location $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="location-form form-control w-50">

    <?php $form = ActiveForm::begin(); ?>
     <?= $form->errorSummary($model) ?>
    
<?= $form->field($model, 'countries_id')->widget(Select2::class, [
    'data' => \yii\helpers\ArrayHelper::map(\app\models\Countries::find()->where(['region_id'=>4])->orderBy('name')->all(), 'id', 'name'),
    'options' => ['id' => 'countries-id', 'placeholder' => 'Selectati o tara ...','label'=>'Tara'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

<?= $form->field($model, 'states_id')->widget(DepDrop::class, [
      'type' => DepDrop::TYPE_SELECT2, 
    'options' => ['id' => 'states-id'],
    'pluginOptions' => [
        'depends' => ['countries-id'], 
        'placeholder' => 'Selectati o regiune ...',
        'url' => Url::to(['/location/states']) // controller action to fetch cities
    ]
]); ?>


<?= $form->field($model, 'cities_id')->widget(DepDrop::class, [
      'type' => DepDrop::TYPE_SELECT2, 
    'options' => ['id' => 'cities-id'],
    'pluginOptions' => [
        'depends' => ['states-id'], 
        'placeholder' => 'Selectati localitate ...',
        'url' => Url::to(['/location/cities']) // controller action to fetch cities
    ]
]); ?> 

<?= $form->field($model, 'address')->textarea(['maxlength' => true,'rows'=>1,'cols'=>10]) ?>

  
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
   
 
    <?php ActiveForm::end(); ?>

</div>
