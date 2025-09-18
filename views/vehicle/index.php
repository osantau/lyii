<?php

use app\models\TransportOrder;
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
use kartik\editable\Editable;
use kartik\grid\EditableColumn;
use kartik\date\DatePicker;
use yii\grid\ActionColumn as GridActionColumn;
use yii\helpers\StringHelper;
use yii\web\JsExpression;

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
  <?php Pjax::begin(['id'=>'grid-pjax']); 

    ?>  
    <?php 
    $transport_orders = ArrayHelper::map(TransportOrder::find()->all(), 'id', 'documentno');
    $gridColumns=[
            ['class' => 'kartik\grid\SerialColumn'],

            // 'id',
          [
            'attribute'=> 'regno',
            'format'=>'raw',
             'filter' => Html::activeTextInput($searchModel, 'regno', ['class' => 'form-control']),
             'value' => function ($model) {
                return Html::a(
                    '<b>'.$model->regno.'</b>',
                    Url::to(['vehicle/info', 'id' => $model->id]), // action returning partial view
                    [
                        'id'=>'regno-'.$model->id,
                        'class' => 'custom-click regno-popover',
                        'data-id' => $model->id,
                        'data-pjax' => 0,
                        'style' => 'cursor:pointer; color:#0d6efd; text-decoration:underline;',
                        'data-bs-toggle' => 'popover',
                        'data-bs-trigger' => 'manual',
                        'data-bs-placement' => 'top',                        
                        'data-bs-content'=>"Se incarca...",
                        'data-bs-html'=>'true',
                        'data-url'=>Url::to(['vehicle/summary']),
                        
                    ]
                );
            },

          ],
         
        //   ['attribute'=>'status','value'=>function($model){return $model->getStatusName();}, 'filter' => \app\models\Vehicle::getStatusList(),],
             [
            'class' => EditableColumn::class,
            'attribute' => 'transport_order_id',
            'format' => 'raw',
            'value' => function($model) use ($transport_orders) {
                return $transport_orders[$model->transport_order_id] ?? '(not set)';
            },
            'editableOptions' => function($model, $key, $index) use ($transport_orders) {
                return [
                    'asPopover' => false, // popup editor
                    'inputType' => Editable::INPUT_WIDGET,
                    'widgetClass' => Select2::class,
                    'options' => [
                        // 'data' => $transport_orders, // data from Transport Order table
                        'id'=>'transport-order-id-'.$model->id,
                        'options' => ['placeholder' => 'Selectati o comanda...'],
                        'pluginOptions' => ['allowClear' => true,'minimumInputLength' => 0,
                           'ajax' => [
            'url' => Url::to(['transport-order/order-list']), // your controller action
            'dataType' => 'json',
            'delay' => 100,
            'data' => new JsExpression('function(params) { 
                return {}; 
            }'),
            'processResults' => new JsExpression('function(data) {
                return {results: data};
            }'),
        ],
                    ],
                        'pluginEvents'=>[
                            "change" => "function() {
                            var value = $(this).val();                            
                var row = $(this).closest('tr');
                if(value!='') {
                row.removeClass('table-light');
                row.removeClass('table-danger');
                row.addClass('table-success');
                
                } else{
                    row.removeClass('table-success');
                    row.addClass('table-light');
                }
                    
            }",
                        ],
                    ],
                    'formOptions' => [
                        'action' => ['vehicle/edit-order'], // your AJAX save action
                    ],
                ];
            },
            //'filter' => $transport_orders, // filter in grid header
            'enableSorting' => true, 
        ],

               [
            'class' => EditableColumn::class,
            'attribute' => 'start_date',
            'format' => ['date', 'php:d.m.Y'], // display format in Grid           
            'editableOptions' => function ($model, $key, $index) {
                return [
                    'header' => 'Data Incarcare',
                    'size' => 'md',
                    'placement'=>'top',
                    'inputType' => Editable::INPUT_WIDGET,
                    'widgetClass' => DatePicker::class,
                    'options' => [
                        'id'=>'start-date-'.$model->id,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',   // date format
                            'todayHighlight' => true,
                        ],
                         'pluginEvents'=>[
                            "changeDate" => "function(e) {
                            validateDates(e);
                        }",
                    ],
                    ],
                    'formOptions' => [
                        'action' => ['vehicle/edit-start-date'] // ajax controller action
                    ],
                ];
            },
        ],
               [
            'class' => EditableColumn::class, 
            'attribute' => 'end_date',
            'filterType' => GridView::FILTER_DATE,
            'filterWidgetOptions' => [
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                ],
            ],
            'format' => ['date', 'php:d.m.Y'], // display format in Grid             
            'editableOptions' => function ($model, $key, $index) {
                return [
                    'header' => 'Data Descarcare',
                    'size' => 'md',
                    'placement'=>'top',
                    'inputType' => Editable::INPUT_WIDGET,
                    'widgetClass' => DatePicker::class,
                    'options' => [
                        'id'=>'end-date-'.$model->id,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',   // date format
                            'todayHighlight' => true,
                        ],
                        'pluginEvents'=>[
                            "changeDate" => "function(e) {
                            validateDates(e);
                        }",
                    ],
                    ],
                    'formOptions' => [
                        'action' => ['vehicle/edit-end-date'] // ajax controller action
                    ],
                ];
            },
        ],
            [
            'class' => EditableColumn::class,
            'attribute' => 'exp_adr_start',   // your model attribute
            'editableOptions' => function ($model, $key, $index) {
                return [
                    'header' => 'Adresa Incarcare Export',
                    'size'   => 'md',
                     'asPopover' => true,
                     'placement'=>'top',
                    'inputType' => Editable::INPUT_TEXTAREA,
                    'options' => [
                        'id'=>'exp-adr-start-'.$model->id,
                        'rows' => 5,
                        'placeholder' => 'Introduceti Adresa Incarcare Export...',
                        'allowEmpty' => false,
                    ],
                    'formOptions' => [
                        'action' => ['vehicle/edit-exp-adr-start'], // controller action
                    ],
                ];
            },
            'value'=>function($model){return StringHelper::truncate($model->exp_adr_start, 30);},
            'format' => 'ntext', // so line breaks show properly in grid
        ],
            [
            'class' => EditableColumn::class,
            'attribute' => 'exp_adr_end',   // your model attribute
            'editableOptions' => function ($model, $key, $index) {
                return [
                    'header' => 'Adresa Descarcare Export',
                    'size'   => 'md',
                     'asPopover' => true,
                     'placement'=>'top',
                    'inputType' => Editable::INPUT_TEXTAREA,
                    'options' => [
                        'id'=>'exp-adr-end-'.$model->id,
                        'rows' => 5,
                        'placeholder' => 'Introduceti Adresa Descarcare Export...',
                        'allowEmpty' => false,
                    ],
                    'formOptions' => [
                        'action' => ['vehicle/edit-exp-adr-end'], // controller action
                    ],
                ];
            },
            'value'=>function($model){return StringHelper::truncate($model->exp_adr_end, 30);},
            'format' => 'ntext', // so line breaks show properly in grid
        ],
            [
            'class' => EditableColumn::class,
            'attribute' => 'imp_adr_start',   // your model attribute
            'editableOptions' => function ($model, $key, $index) {
                return [
                    'header' => 'Adresa Incarcare Import',
                    'size'   => 'md',
                     'asPopover' => true,
                     'placement'=>'top',
                    'inputType' => Editable::INPUT_TEXTAREA,
                    'options' => [
                        'id'=>'imp-adr-start-'.$model->id,
                        'rows' => 5,
                        'placeholder' => 'Introduceti Adresa Incarare Import...',
                        'allowEmpty' => false,
                    ],
                    'formOptions' => [
                        'action' => ['vehicle/edit-imp-adr-start'], // controller action
                    ],
                ];
            },
            'value'=>function($model){return StringHelper::truncate($model->imp_adr_start, 30);},
            'format' => 'ntext', // so line breaks show properly in grid
        ],
              [
            'class' => EditableColumn::class,
            'attribute' => 'imp_adr_end',   // your model attribute
            'editableOptions' => function ($model, $key, $index) {
                return [
                    'header' => 'Adresa Descarare Import',
                    'size'   => 'md',
                    'asPopover' => true,
                    'placement'=>'top',
                    'inputType' => Editable::INPUT_TEXTAREA,
                    'options' => [
                        'id'=>'imp-adr-end-'.$model->id,
                        'rows' => 5,
                        'placeholder' => 'Introduceti Adresa Descarcare Import...',
                        'allowEmpty' => false,
                    ],
                    'formOptions' => [
                        'action' => ['vehicle/edit-imp-adr-end'], // controller action
                    ],
                ];
            },
            'value'=>function($model){return StringHelper::truncate($model->imp_adr_end, 30);},
            'format' => 'ntext', // so line breaks show properly in grid
        ],
          [
            'class'=>ActionColumn::class,
            'template'=>'{custom}',
            'header'=>'',
            'buttons'=>[
                'custom' => function ($url, $model, $key) {                      
                    return Html::a('<i class="fa-solid fa-check"></i>', ['vehicle/finalize-order?id='.$model->id], [
                        'title' => 'Finalizeaza',                        
                        'data-method' => 'post',                        
                        'class'=>'btn btn-primary btn-sm btn-finalize',                           
                    ]);
                },
            ]
          ],
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
            'beforeHeader' => [
                [
                    'columns' => [
                        ['content' => '', 'options' => ['colspan' => 1,'class'=>'text-center text-white bg-primary font-weight-bold']],
                        ['content' => 'Detalii Transport', 'options' => ['colspan' => 4, 'class' => 'text-center text-white bg-primary font-weight-bold']],
                        ['content' => 'Export', 'options' => ['colspan' => 2, 'class'=> 'text-center text-white bg-primary font-weight-bold',
                        ]],
                        ['content' => 'Import', 'options' => ['colspan' => 2,'class'=>'text-center text-white bg-primary font-weight-bold']],
                        ['content' => '', 'options' => ['colspan' => 3,'class'=>'text-center text-white bg-primary font-weight-bold']],
                        
                    ],
                    'options' => ['class' => 'skip-export',
                      //'style' => 'border-bottom: 1px solid;'
                      ]
                ]
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
        'responsiveWrap' => false,
        'bordered' => true,        
        'columns' => $gridColumns,
          'rowOptions' => function($model, $key, $index, $grid) {
        /** @var $model \app\models\Post */
        if ($model->status == \app\models\Vehicle::STATUS_LIBER) {
            return ['class' => 'table-light']; // red background
        } elseif ($model->status == \app\models\Vehicle::STATUS_OCUPAT) {
            return ['class' => 'table-success']; // green background
        }elseif ($model->status == \app\models\Vehicle::STATUS_OPRIT) {
            return ['class' => 'table-danger']; // green background
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
function initPopovers() {
    document.querySelectorAll('[data-bs-toggle="popover"]').forEach(function (el) {
        new bootstrap.Popover(el);
    });
    document.querySelectorAll('.regno-popover').forEach(function(el) {
    // Correct: create Popover instance using Bootstrap 5 API
    const pop = new bootstrap.Popover(el);
    el._bsPopover = pop; // store instance on element

    el.addEventListener('mouseenter', function() {
        // Show popover initially
        pop.show();

        // Fetch fresh content every hover
        fetch(el.getAttribute('data-url') + '?id=' + el.getAttribute('data-id'))
            .then(response => response.text())
            .then(data => {
                // Correct way to access popover DOM in Bootstrap 5
                const tip = el._bsPopover._getTipElement(); // official internal method
                if (tip) {
                    const body = tip.querySelector('.popover-body');
                    if (body) body.innerHTML = data;
                }
            })
            .catch(err => console.error('Popover AJAX error:', err));
    });

    el.addEventListener('mouseleave', function() {
        pop.hide();
    });
});

}
function validateDates(e) {
    
    var startDateInput =$('#vehicle-0-start_date').val();
    var endDateInput = $('#vehicle-0-end_date').val();
    var startDate = Date.parse(startDateInput, 'yyyy-mm-dd');
    var endDate = Date.parse(endDateInput, 'yyyy-mm-dd');
                            
            if (startDate > endDate) {
                   alert('Atentie: Data Incarcare nu poate fi mai mare decat Data Descarcare.');
            } else if(endDate<startDate){
                alert('Atentie: Data Descarcare nu poate fi mai mica decat Data Incarcare.');                
            }
        
    
}

// Initialize on page load
initCustomClick();
initPopovers();
function showError(message) {
  let box = document.getElementById("errorBox");
  box.innerText = message;
  box.style.display = "block";
}
// Re-initialize after PJAX reload
jQuery(document).on('pjax:end', function() {
    initCustomClick();
    initPopovers();    
});
JS;
$this->registerJs($js);
$this->registerJs("var popoverTriggerList=[].slice.call(document.querySelectorAll('[data-bs-toggle=\"popover\"]'));popoverTriggerList.map(function(e){return new bootstrap.Popover(e)});");


?>
        <?php Pjax::end(); ?>

</div>
<div id="errorBox" class="alert alert-danger" style="display:none;"></div>
