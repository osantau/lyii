<?php

use app\models\Vehicle;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use \kartik\grid\GridView;
use \kartik\export\ExportMenu;
use yii\widgets\Pjax;
use kartik\icons\Icon;
use kartik\select2\Select2;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\Modal;

Icon::map($this, Icon::FAB);
Icon::map($this, Icon::FAS);
/** @var yii\web\View $this */
/** @var app\models\VehicleSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Autovehicule';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php 
    $gridColumns=[
            ['class' => 'kartik\grid\SerialColumn'],

            // 'id',
            'regno',
          ['attribute' => 'created_at', 'format' => ['datetime', 'php:d.m.Y H:i']],
          ['attribute' => 'updated_at', 'format' => ['datetime', 'php:d.m.Y H:i']],
              [
                'attribute' => 'createdByName','label'=>'Creat De',
                'value' => 'createdBy.username',
            ],
            // [
            //     'attribute' => 'updatedByName','label'=>'Actualizat De',
            //     'value' => 'updatedBy.username',
            // ],
             [
                'class' => ActionColumn::class,
                'template'=>'{update} {delete}',
                 'contentOptions' => ['style' => 'width:50px; text-align:center;'],
                'buttons' => [
                'delete' => function ($url, $model, $key) {
                    return Html::a('<span style="color:red;"><i class="fa-solid fa-trash fa-xs"></i></span>', $url, [
                        'title' => 'Sterge',
                        'data-confirm' => 'Sunteti sigur ca vreti sa stergeti <b>'.$model->regno.'</b> ?',
                        'data-method' => 'post',                        
                    ]);
                },
            ],
                'urlCreator' => function ($action, Vehicle $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
            ],
        ];

    ?>
    <?php Pjax::begin(); ?>
    <?php $full_export =  
    ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'target' => ExportMenu::TARGET_BLANK, // open in new tab
    'fontAwesome' => true,
    'dropdownOptions' => [
        'label' => 'Full Export',
        'class' => 'btn btn-outline-secondary'
    ],
]);
    ?>     
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,    
        'toolbar' =>  [   
            ['content'=>
            Html::button('<i class="fas fa-plus"></i> Test Modal', [
                    'value' => Url::to(['vehicle/create']),
                    'class' => 'btn btn-success',
                    'id' => 'modalButton'
                ])
            .Html::a('<i class="fas fa-plus"></i> Adauga', ['create'], [
                    'class' => 'btn btn-success',
                    'title' => 'Adauga'
                ]). Html::a('<i class="fas fa-repeat"></i>', ['/vehicle'], ['data-pjax'=>0,'class'=>'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],             
        '{export}',     
        $full_export,
        // '{toggleData}'         
            ],
        'export' => [true],
        'exportConfig' => [
                 GridView::CSV => [
            'label' => 'CSV',
            'filename' => 'My_CSV_Export',
        ],
        GridView::EXCEL => [
            'label' => 'Excel',
            'filename' => 'My_Excel_Export',
        ],
               
        ],
                              
        'pjax' => true, 
        'responsive'=>true,
        'bordered' => true,        
        'columns' => $gridColumns,
        'panel' => [
        'type' => GridView::TYPE_PRIMARY,  
        'pager' => [                        // Custom pagination options
        'firstPageLabel' => Icon::show('angle-double-left') . ' First',
        'lastPageLabel'  => 'Last ' . Icon::show('angle-double-right'),
        'prevPageLabel'  => Icon::show('angle-left'),
        'nextPageLabel'  => Icon::show('angle-right'),
        'maxButtonCount' => 10,
        'class' => \yii\bootstrap5\LinkPager::class, // Optional: use Bootstrap 5 pager
    ],      
    ],
    ]); ?>
    <?php
Modal::begin([
    'title' => '<h4>Adauga</h4>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);

echo "<div id='modalContent'></div>"; 

Modal::end(); 
$this->registerJs("
    $('#modalButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
");

?>
        <?php Pjax::end(); ?>

</div>
