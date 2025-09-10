<?php

use app\models\Vehicle;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\ActionColumn;
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

$this->title = 'Camioane';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php 
    $gridColumns=[
            ['class' => 'kartik\grid\SerialColumn'],

            // 'id',
          [
            'attribute'=> 'regno',
            'format'=>'raw',
             'value' => function ($model) {
                return Html::a(
                    '<b>'.$model->regno.'</b>',
                    Url::to(['vehicle/info', 'id' => $model->id]), // action returning partial view
                    [
                        'class' => 'custom-click',
                        'data-id' => $model->id,
                        'data-pjax' => 0,
                        'style' => 'cursor:pointer; color:#0d6efd; text-decoration:underline;',
                        'data-bs-toggle' => 'popover',
                        'data-bs-trigger' => 'hover focus',
                        'data-bs-placement' => 'top',                        
                        'data-bs-content'=>"Info: $model->info",
                    ]
                );
            },

          ],
          ['attribute'=>'status','value'=>function($model){return $model->getStatusName();}, 'filter' => \app\models\Vehicle::getStatusList(),],
          ['attribute' => 'created_at', 'format' => ['datetime', 'php:d.m.Y H:i']],
          // ['attribute' => 'updated_at', 'format' => ['datetime', 'php:d.m.Y H:i']],
              [
                'attribute' => 'createdByName','label'=>'Creat De',
                'value' => 'createdBy.username',
            ],
            // [
            //     'attribute' => 'updatedByName','label'=>'Actualizat De',
            //     'value' => 'updatedBy.username',
            // ],
          /*   [
                'header'=>'Actiuni',
                'class' => ActionColumn::class,
                'template'=>'{update} {delete}',
                 'contentOptions' => ['style' => 'width:50px; text-align:center;'],
                'buttons' => [
                'delete' => function ($url, $model, $key) {
                    return Html::a('<span style="color:red;"><i class="fa-solid fa-trash fa-xs"></i></span>', $url, [
                        'title' => 'Delete',
                        'data-confirm' => 'Sunteti sigur ca vreti sa stergeti <b>'.$model->regno.'</b> ?',
                        'data-method' => 'post',                        
                    ]);
                },
            ],
                'urlCreator' => function ($action, Vehicle $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
            ], */
        ];

    ?>
    <?php Pjax::begin(['id'=>'grid-pjax']); 
    /*
    $full_export =  
    ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'target' => ExportMenu::TARGET_BLANK, // open in new tab
    'fontAwesome' => true,
    'dropdownOptions' => [
        'label' => 'Full Export',
        'class' => 'btn btn-outline-secondary'
    ],
]);*/
    ?>     
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,    
        'toolbar' =>  [   
            ['content'=>Html::a('<i class="fas fa-plus"></i> Adauga', ['create'], [
                    'class' => 'btn btn-success',
                    'title' => 'Adauga'
                ]). Html::a('<i class="fas fa-repeat"></i>', ['/vehicle'], ['data-pjax'=>0,'class'=>'btn btn-outline-secondary', 'title'=>'Reset Grid'])
            ],             
        /* '{export}',     
        $full_export, */
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
          'rowOptions' => function($model, $key, $index, $grid) {
        /** @var $model \app\models\Post */
        if ($model->status == \app\models\Vehicle::STATUS_LIBER) {
            return ['class' => 'table-success']; // red background
        } elseif ($model->status == \app\models\Vehicle::STATUS_OCUPAT) {
            return ['class' => 'table-warning']; // green background
        }
        return [];
    },
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
    'title' => '<h4>Editare Info</h4>',
    'id' => 'modal',
    'size' => Modal::SIZE_LARGE,
]);

echo "<div id='modalContent'></div>"; 
Modal::end(); 
$js = <<<JS
function initCustomClick() {
    jQuery(document).off('click', '.custom-click').on('click', '.custom-click', function(e) {
        e.preventDefault();
        let url = jQuery(this).attr('href');
        let title = jQuery(this).text();

        jQuery('#modal').modal('show')
            .find('#modalContent')
            .load(url);

        jQuery('#modalTitle').text(title);
    });
}

// Initialize on page load
initCustomClick();

// Re-initialize after PJAX reload
jQuery(document).on('pjax:end', function() {
    initCustomClick();
});
JS;
$this->registerJs($js);
$this->registerJs("var popoverTriggerList=[].slice.call(document.querySelectorAll('[data-bs-toggle=\"popover\"]'));popoverTriggerList.map(function(e){return new bootstrap.Popover(e)});");


?>
        <?php Pjax::end(); ?>

</div>
