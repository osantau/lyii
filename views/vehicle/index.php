<?php
use yii\helpers\Url;
use yii\helpers\Html;

// Register DataTables assets from CDN
$this->registerCssFile('https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css');
$this->registerJsFile('https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
<div class="site-index">
<h1>Camioane</h1>
<p>
        <?= Html::a('Adauga', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<table id="vehicleTable" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>          
            <th>#</th>  
            <th>Nr. Inmatriculare</th> 
            <th>Comanda Transport</th>
            <th>Data Incarcare</th>           
            <th>Data Descarcare</th>
            <th>Adresa Incarcare</th>
            <th>Adresa Descarcare</th>
            <th>Adresa Incarcare</th>
            <th>Adresa Descarcare</th>
            <th>Actions</th>
        </tr>
    </thead>
</table>

<?php


$this->registerJs("
    $('#vehicleTable').DataTable({        
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '" . Url::to(['vehicle/data']) . "',            
     columns: [  
        {data: 0, visible: false },         
        {data: null, 
        defaultContent: '', // Set default content to empty      
      render: function (data, type, row, meta) {
        // 'meta.row' is the zero-based index of the row
        return meta.row + 1;
      }},    
        {data: 1},
        {data: 2},
        {data: 3},
        {data: 4},
        {data: 5},
        {data: 6},
        {data: 7},
        {data: 8},
        {data: 9}

  ]        
    });
");
?>
</div>
